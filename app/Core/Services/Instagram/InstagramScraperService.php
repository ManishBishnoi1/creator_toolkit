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
        $usePython = config('tools.instagram.ytdlp_use_python', true);

        if ($usePython) {
            $command = [
                'python',
                '-m',
                'yt_dlp',
                '--dump-json',
                '--no-warnings',
                '--no-playlist',
                $url
            ];
        } else {
            $binary = config('tools.instagram.ytdlp_binary_path');
            if (!file_exists($binary)) {
                throw new ToolExecutionException("Scraping binary not found at [{$binary}]. Please verify configuration.", 500);
            }
            $command = [
                $binary,
                '--dump-json',
                '--no-warnings',
                '--no-playlist',
                $url
            ];
        }

        $tmpDir = storage_path('app/tmp');
        if (!file_exists($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        // Explicitly set TEMP/TMP env variables so PyInstaller or Python temp files unpack cleanly
        $process = new Process($command, null, [
            'TEMP' => $tmpDir,
            'TMP' => $tmpDir,
        ]);

        $process->setTimeout(config('tools.instagram.scraping_timeout', 30));

        try {
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output = $process->getOutput();
            $data = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
                throw new ToolExecutionException("Failed to decode JSON response from scraper.", 500);
            }

            // Map and return standard scraper interface
            return [
                'id' => $data['id'] ?? '',
                'type' => 'video',
                'title' => $data['description'] ?? $data['title'] ?? 'Instagram Reel',
                'video_url' => $data['url'] ?? '',
                'thumbnail_url' => $data['thumbnail'] ?? '',
                'duration' => $data['duration'] ?? 0,
                'owner' => [
                    'username' => $data['uploader'] ?? 'instagram_user',
                    'full_name' => $data['creator'] ?? $data['uploader'] ?? 'Instagram Creator',
                ]
            ];

        } catch (\Exception $e) {
            $errorOutput = $process->getErrorOutput();
            $reason = !empty($errorOutput) ? trim($errorOutput) : $e->getMessage();
            throw ToolExecutionException::failedToScrape($url, $reason);
        }
    }
}
