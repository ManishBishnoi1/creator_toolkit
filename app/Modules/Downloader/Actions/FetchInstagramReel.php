<?php

namespace App\Modules\Downloader\Actions;

use App\Core\Exceptions\ToolExecutionException;
use App\Core\Services\Instagram\InstagramScraperService;
use Illuminate\Support\Facades\Log;

class FetchInstagramReel
{
    public function __construct(
        protected InstagramScraperService $scraperService
    ) {}

    /**
     * Execute the action to fetch/scrape a reel's details.
     *
     * @param string $url
     * @return array
     * @throws ToolExecutionException
     */
    public function execute(string $url): array
    {
        if (!filter_var($url, FILTER_VALIDATE_URL) || !str_contains($url, 'instagram.com')) {
            throw new ToolExecutionException('Invalid Instagram URL provided.', 422);
        }

        try {
            Log::info("Attempting to scrape Reel URL via yt-dlp service", ['url' => $url]);
            
            return $this->scraperService->scrape($url);
        } catch (\Exception $e) {
            throw ToolExecutionException::failedToScrape($url, $e->getMessage());
        }
    }
}
