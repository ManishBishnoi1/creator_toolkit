<?php

namespace App\Core\Services\Instagram;

use App\Core\Exceptions\ToolExecutionException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class InstagramScraperService
{
    /**
     * Scrape Instagram Reel details using the localized yt-dlp binary.
     *
     * @param string $url
     * @return array
     * @throws ToolExecutionException
     */
    public function scrape(string $url): array
    {
        // 1. Extract Reel ID from URL
        preg_match('/\/(reel|p|tv)\/([A-Za-z0-9_-]+)/', $url, $matches);
        $reelId = $matches[2] ?? null;

        if (!$reelId) {
            throw new ToolExecutionException("Could not extract a valid Reel ID from the provided URL.", 422);
        }

        $storageDir = storage_path('app/public/reels');
        if (!file_exists($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        $mp4File = "{$storageDir}/{$reelId}.mp4";
        $jsonFile = "{$storageDir}/{$reelId}.info.json";

        // 2. Check if cache exists
        if (file_exists($jsonFile)) {
            $jsonData = json_decode(file_get_contents($jsonFile), true);
            if ($jsonData) {
                $cloudinaryCloud = config('tools.instagram.cloudinary_cloud_name');
                $cloudinaryKey = config('tools.instagram.cloudinary_api_key');
                $cloudinarySecret = config('tools.instagram.cloudinary_api_secret');
                $useCloudinary = !empty($cloudinaryCloud) && !empty($cloudinaryKey) && !empty($cloudinarySecret);

                if ($useCloudinary && !empty($jsonData['cloudinary_url'])) {
                    return $this->formatScraperResult($reelId, $jsonData);
                }

                if (!$useCloudinary && file_exists($mp4File)) {
                    return $this->formatScraperResult($reelId, $jsonData);
                }
            }
        }

        // 3. Prepare yt-dlp command
        $usePython = config('tools.instagram.ytdlp_use_python', true);

        if ($usePython) {
            $pythonBinary = config('tools.instagram.python_binary', 'python');
            $command = [
                $pythonBinary,
                '-m',
                'yt_dlp',
            ];
        } else {
            $binary = config('tools.instagram.ytdlp_binary_path');
            if (!file_exists($binary)) {
                throw new ToolExecutionException("Scraping binary not found at [{$binary}]. Please verify configuration.", 500);
            }
            $command = [
                $binary,
            ];
        }

        $outputPath = "{$storageDir}/{$reelId}.%(ext)s";

        // Append yt-dlp download and metadata args
        $command = array_merge($command, [
            '--write-info-json',
            '--write-thumbnail',
            '-f',
            'bestvideo+bestaudio/best',
            '-o',
            $outputPath,
            $url
        ]);

        // Append proxy rotation settings if enabled
        if (config('tools.instagram.proxy_rotation', false)) {
            $rotator = app(\App\Modules\Downloader\Services\ScrapingProxyRotator::class);
            $proxy = $rotator->getNextProxy();
            if ($proxy) {
                $command[] = '--proxy';
                $command[] = $proxy;
            }
        }

        // Append explicit FFmpeg location if configured (useful if ffmpeg is not in web server PATH)
        $ffmpegPath = config('tools.instagram.ffmpeg_path');
        if (empty($ffmpegPath)) {
            if (DIRECTORY_SEPARATOR === '/') {
                if (file_exists('/usr/bin/ffmpeg')) {
                    $ffmpegPath = '/usr/bin/ffmpeg';
                } elseif (file_exists('/usr/local/bin/ffmpeg')) {
                    $ffmpegPath = '/usr/local/bin/ffmpeg';
                }
            }
        }

        if (!empty($ffmpegPath)) {
            $command[] = '--ffmpeg-location';
            $command[] = $ffmpegPath;
        }

        $tmpDir = storage_path('app/tmp');
        if (!file_exists($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        // Inherit parent environment variables (like SystemRoot and PATH) and merge custom TEMP/TMP.
        // This is crucial on Windows to ensure Python can load DLL dependencies (Winsock).
        $parentEnv = is_array(getenv()) ? getenv() : [];
        $env = array_merge($_SERVER, $parentEnv, [
            'TEMP' => $tmpDir,
            'TMP' => $tmpDir,
        ]);

        $process = new Process($command, null, $env);
        $process->setTimeout(config('tools.instagram.scraping_timeout', 120));

        try {
            $process->run();

            if (!$process->isSuccessful()) {
                $errorOutput = $process->getErrorOutput();
                $errStr = !empty($errorOutput) ? trim($errorOutput) : $process->getOutput();
                
                // Log the raw error output to Laravel logs for easy production diagnostics
                Log::error("Instagram scraping process failed on URL [{$url}]", [
                    'command' => $command,
                    'error' => $errStr,
                ]);

                if (stripos($errStr, 'no video') !== false || stripos($errStr, 'no video in this post') !== false) {
                    throw new ToolExecutionException("There is no video in this post. Our downloader only supports Instagram Reels, Videos, and Stories.", 422);
                }
                
                if (stripos($errStr, 'Private video') !== false || stripos($errStr, 'login') !== false) {
                    throw new ToolExecutionException("This Reel is private and cannot be downloaded without authentication.", 403);
                }
                
                if (stripos($errStr, '404') !== false || stripos($errStr, 'not found') !== false || stripos($errStr, 'does not exist') !== false) {
                    throw new ToolExecutionException("This Instagram Reel was deleted, or the URL is invalid.", 404);
                }
                
                if (stripos($errStr, '429') !== false || stripos($errStr, 'block') !== false || stripos($errStr, 'Too Many Requests') !== false) {
                    throw new ToolExecutionException("Instagram is temporarily blocking downloader requests. Please try again shortly.", 429);
                }
                
                throw new ToolExecutionException("Instagram scraping failed. Please check the URL and try again.", 400);
            }

            if (!file_exists($jsonFile)) {
                throw new ToolExecutionException("Scraper failed to create metadata file.", 500);
            }

            $jsonData = json_decode(file_get_contents($jsonFile), true);

            if (json_last_error() !== JSON_ERROR_NONE || empty($jsonData)) {
                throw new ToolExecutionException("Failed to decode JSON response from local metadata.", 500);
            }

            // Cloudinary Integration
            $cloudinaryCloud = config('tools.instagram.cloudinary_cloud_name');
            $cloudinaryKey = config('tools.instagram.cloudinary_api_key');
            $cloudinarySecret = config('tools.instagram.cloudinary_api_secret');
            $useCloudinary = !empty($cloudinaryCloud) && !empty($cloudinaryKey) && !empty($cloudinarySecret);

            if ($useCloudinary) {
                // 1. Upload Video
                if (file_exists($mp4File)) {
                    try {
                        $timestamp = time();
                        $params = [
                            'public_id' => $reelId,
                            'timestamp' => $timestamp,
                        ];
                        ksort($params);
                        $paramString = http_build_query($params);
                        $signature = sha1($paramString . $cloudinarySecret);

                        $response = \Illuminate\Support\Facades\Http::asMultipart()
                            ->attach('file', fopen($mp4File, 'r'), $reelId . '.mp4')
                            ->post(
                                "https://api.cloudinary.com/v1_1/{$cloudinaryCloud}/video/upload",
                                [
                                    'public_id' => $reelId,
                                    'timestamp' => $timestamp,
                                    'api_key' => $cloudinaryKey,
                                    'signature' => $signature,
                                ]
                            );

                        if ($response->successful()) {
                            $uploadData = $response->json();
                            $cloudinaryUrl = $uploadData['secure_url'] ?? '';
                            if (!empty($cloudinaryUrl)) {
                                $cloudinaryUrl = str_replace('/video/upload/', '/video/upload/fl_attachment/', $cloudinaryUrl);
                            }
                            
                            $jsonData['cloudinary_url'] = $cloudinaryUrl;
                            $jsonData['cloudinary_public_id'] = $uploadData['public_id'] ?? $reelId;
                            
                            // Immediately delete local MP4
                            if (file_exists($mp4File)) {
                                unlink($mp4File);
                            }
                        } else {
                            Log::error("Cloudinary video upload failed for Reel [{$reelId}]. Response: " . $response->body());
                        }
                    } catch (\Exception $e) {
                        Log::error("Cloudinary video upload exception for Reel [{$reelId}]: " . $e->getMessage());
                    }
                }

                // 2. Upload Thumbnail
                $localThumbnailFile = null;
                foreach (['jpg', 'jpeg', 'webp', 'png'] as $ext) {
                    $checkPath = "{$storageDir}/{$reelId}.{$ext}";
                    if (file_exists($checkPath)) {
                        $localThumbnailFile = $checkPath;
                        break;
                    }
                }

                if ($localThumbnailFile) {
                    try {
                        $timestamp = time();
                        $params = [
                            'public_id' => $reelId,
                            'timestamp' => $timestamp,
                        ];
                        ksort($params);
                        $paramString = http_build_query($params);
                        $signature = sha1($paramString . $cloudinarySecret);

                        $response = \Illuminate\Support\Facades\Http::asMultipart()
                            ->attach('file', fopen($localThumbnailFile, 'r'), basename($localThumbnailFile))
                            ->post(
                                "https://api.cloudinary.com/v1_1/{$cloudinaryCloud}/image/upload",
                                [
                                    'public_id' => $reelId,
                                    'timestamp' => $timestamp,
                                    'api_key' => $cloudinaryKey,
                                    'signature' => $signature,
                                ]
                            );

                        if ($response->successful()) {
                            $uploadData = $response->json();
                            $jsonData['cloudinary_thumbnail_url'] = $uploadData['secure_url'] ?? '';
                            $jsonData['cloudinary_thumbnail_public_id'] = $uploadData['public_id'] ?? $reelId;

                            // Immediately delete local thumbnail
                            if (file_exists($localThumbnailFile)) {
                                unlink($localThumbnailFile);
                            }
                        } else {
                            Log::error("Cloudinary thumbnail upload failed for Reel [{$reelId}]. Response: " . $response->body());
                        }
                    } catch (\Exception $e) {
                        Log::error("Cloudinary thumbnail upload exception for Reel [{$reelId}]: " . $e->getMessage());
                    }
                }

                // Rewrite JSON file with Cloudinary details
                file_put_contents($jsonFile, json_encode($jsonData));
            }

            // Map and return standard scraper interface
            return $this->formatScraperResult($reelId, $jsonData);

        } catch (ToolExecutionException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ToolExecutionException("Instagram scraping failed: " . $e->getMessage(), 500);
        }
    }

    /**
     * Format the scraper metadata and check local directories for media files.
     */
    protected function formatScraperResult(string $reelId, array $data): array
    {
        $storageDir = storage_path('app/public/reels');
        $thumbnailUrl = '';

        // Check for Cloudinary thumbnail URL or dynamically find local thumbnail
        if (!empty($data['cloudinary_thumbnail_url'])) {
            $thumbnailUrl = $data['cloudinary_thumbnail_url'];
        } else {
            foreach (['jpg', 'jpeg', 'webp', 'png'] as $ext) {
                if (file_exists("{$storageDir}/{$reelId}.{$ext}")) {
                    $thumbnailUrl = asset("storage/reels/{$reelId}.{$ext}");
                    break;
                }
            }
        }

        // Fallback to original CDN thumbnail if local file not found
        if (empty($thumbnailUrl)) {
            $thumbnailUrl = $data['thumbnail'] ?? '';
        }

        // Generate download URL using the dedicated download route or Cloudinary URL
        if (!empty($data['cloudinary_url'])) {
            $videoUrl = $data['cloudinary_url'];
        } else {
            $videoUrl = route('tools.download-video', ['id' => $reelId]);
        }

        return [
            'id' => $reelId,
            'type' => 'video',
            'title' => $data['description'] ?? $data['title'] ?? 'Instagram Reel',
            'video_url' => $videoUrl,
            'thumbnail_url' => $thumbnailUrl,
            'duration' => $data['duration'] ?? 0,
            'owner' => [
                'username' => $data['uploader'] ?? 'instagram_user',
                'full_name' => $data['creator'] ?? $data['uploader'] ?? 'Instagram Creator',
            ]
        ];
    }
}
