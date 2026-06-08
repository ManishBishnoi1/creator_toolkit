<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClearReelsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reels:clear-cache {--minutes= : Only delete files older than this many minutes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear downloaded Instagram Reel files and their metadata from storage and Cloudinary if they are older than the specified duration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = storage_path('app/public/reels');

        if (!File::exists($directory)) {
            $this->info("Reels cache directory does not exist yet.");
            return Command::SUCCESS;
        }

        $minutes = $this->option('minutes');
        if ($minutes === null) {
            $minutes = (int) config('tools.instagram.cache_expiration_minutes', 10);
        } else {
            $minutes = (int) $minutes;
        }
        $thresholdTime = now()->subMinutes($minutes)->timestamp;

        $files = File::files($directory);
        $deletedLocalCount = 0;
        $deletedCloudinaryCount = 0;

        $cloudinaryCloud = config('tools.instagram.cloudinary_cloud_name');
        $cloudinaryKey = config('tools.instagram.cloudinary_api_key');
        $cloudinarySecret = config('tools.instagram.cloudinary_api_secret');
        $hasCloudinary = !empty($cloudinaryCloud) && !empty($cloudinaryKey) && !empty($cloudinarySecret);

        // Track processed reel IDs to avoid deleting duplicate files multiple times
        $processedReels = [];

        // 1. Process and delete files based on .info.json metadata (for Cloudinary cleanup)
        foreach ($files as $file) {
            if (str_ends_with($file->getFilename(), '.info.json')) {
                $mtime = $file->getMTime();
                if ($mtime <= $thresholdTime) {
                    $reelId = substr($file->getFilename(), 0, -10); // strip '.info.json'
                    $processedReels[] = $reelId;

                    // Parse JSON to check for Cloudinary public ID
                    try {
                        $content = json_decode(File::get($file->getPathname()), true);
                        if ($hasCloudinary && !empty($content['cloudinary_public_id'])) {
                            $publicId = $content['cloudinary_public_id'];
                            
                            // Call Cloudinary destroy API for video
                            $timestamp = time();
                            $destroyParams = [
                                'public_id' => $publicId,
                                'timestamp' => $timestamp,
                            ];
                            ksort($destroyParams);
                            $destroyParamString = http_build_query($destroyParams);
                            $destroySignature = sha1($destroyParamString . $cloudinarySecret);

                            $response = Http::post(
                                "https://api.cloudinary.com/v1_1/{$cloudinaryCloud}/video/destroy",
                                [
                                    'public_id' => $publicId,
                                    'timestamp' => $timestamp,
                                    'api_key' => $cloudinaryKey,
                                    'signature' => $destroySignature,
                                ]
                            );

                            if ($response->successful() && ($response->json()['result'] ?? '') === 'ok') {
                                $deletedCloudinaryCount++;
                            } else {
                                Log::error("Failed to delete video [{$publicId}] from Cloudinary: " . $response->body());
                            }
                        }

                        // Call Cloudinary destroy API for thumbnail image if it exists
                        if ($hasCloudinary && !empty($content['cloudinary_thumbnail_public_id'])) {
                            $thumbPublicId = $content['cloudinary_thumbnail_public_id'];
                            
                            $timestamp = time();
                            $destroyParams = [
                                'public_id' => $thumbPublicId,
                                'timestamp' => $timestamp,
                            ];
                            ksort($destroyParams);
                            $destroyParamString = http_build_query($destroyParams);
                            $destroySignature = sha1($destroyParamString . $cloudinarySecret);

                            $response = Http::post(
                                "https://api.cloudinary.com/v1_1/{$cloudinaryCloud}/image/destroy",
                                [
                                    'public_id' => $thumbPublicId,
                                    'timestamp' => $timestamp,
                                    'api_key' => $cloudinaryKey,
                                    'signature' => $destroySignature,
                                ]
                            );

                            if ($response->successful() && ($response->json()['result'] ?? '') === 'ok') {
                                $deletedCloudinaryCount++;
                            } else {
                                Log::error("Failed to delete thumbnail [{$thumbPublicId}] from Cloudinary: " . $response->body());
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Error reading JSON or deleting from Cloudinary for Reel [{$reelId}]: " . $e->getMessage());
                    }

                    // Delete all local files matching this reel ID
                    foreach (['mp4', 'info.json', 'jpg', 'jpeg', 'webp', 'png'] as $ext) {
                        $targetFile = "{$directory}/{$reelId}.{$ext}";
                        if (File::exists($targetFile)) {
                            File::delete($targetFile);
                            $deletedLocalCount++;
                        }
                    }
                }
            }
        }

        // 2. Cleanup any remaining orphan or temporary files older than threshold
        $files = File::files($directory);
        foreach ($files as $file) {
            if ($file->getFilename() === '.gitignore') {
                continue;
            }
            if ($file->getMTime() <= $thresholdTime) {
                File::delete($file->getPathname());
                $deletedLocalCount++;
            }
        }

        $this->info("Successfully cleaned cache: deleted {$deletedLocalCount} local files and {$deletedCloudinaryCount} files from Cloudinary.");
        return Command::SUCCESS;
    }
}
