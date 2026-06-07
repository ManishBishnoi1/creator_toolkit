<?php

namespace App\Core\Services\Instagram;

use App\Core\Exceptions\ToolExecutionException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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
        if (file_exists($mp4File) && file_exists($jsonFile)) {
            $jsonData = json_decode(file_get_contents($jsonFile), true);
            if ($jsonData) {
                return $this->formatScraperResult($reelId, $jsonData);
            }
        }

        // 3. Prepare yt-dlp command
        $usePython = config('tools.instagram.ytdlp_use_python', true);

        if ($usePython) {
            $command = [
                'python',
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
                throw new ProcessFailedException($process);
            }

            if (!file_exists($jsonFile)) {
                throw new ToolExecutionException("Scraper failed to create metadata file.", 500);
            }

            $jsonData = json_decode(file_get_contents($jsonFile), true);

            if (json_last_error() !== JSON_ERROR_NONE || empty($jsonData)) {
                throw new ToolExecutionException("Failed to decode JSON response from local metadata.", 500);
            }

            // Map and return standard scraper interface
            return $this->formatScraperResult($reelId, $jsonData);

        } catch (\Exception $e) {
            $errorOutput = $process->getErrorOutput();
            $reason = !empty($errorOutput) ? trim($errorOutput) : $e->getMessage();
            throw ToolExecutionException::failedToScrape($url, $reason);
        }
    }

    /**
     * Format the scraper metadata and check local directories for media files.
     */
    protected function formatScraperResult(string $reelId, array $data): array
    {
        $storageDir = storage_path('app/public/reels');
        $thumbnailUrl = '';

        // Dynamically find thumbnail with correct extension
        foreach (['jpg', 'jpeg', 'webp', 'png'] as $ext) {
            if (file_exists("{$storageDir}/{$reelId}.{$ext}")) {
                $thumbnailUrl = asset("storage/reels/{$reelId}.{$ext}");
                break;
            }
        }

        // Fallback to original CDN thumbnail if local file not found
        if (empty($thumbnailUrl)) {
            $thumbnailUrl = $data['thumbnail'] ?? '';
        }

        // Generate download URL using the dedicated download route
        $videoUrl = route('tools.download-video', ['id' => $reelId]);

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
