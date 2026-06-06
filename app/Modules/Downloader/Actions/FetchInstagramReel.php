<?php

namespace App\Modules\Downloader\Actions;

use App\Core\Exceptions\ToolExecutionException;
use App\Modules\Downloader\Services\ScrapingProxyRotator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchInstagramReel
{
    public function __construct(
        protected ScrapingProxyRotator $proxyRotator
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

        // Simulating Instagram API scraping with rotating proxies.
        // In real execution, this would call private APIs or run Puppeteer/playwright,
        // or communicate with an external scraping provider.
        try {
            $proxy = $this->proxyRotator->getNextProxy();
            
            // Simulating API client request
            Log::info("Attempting to scrape Reel URL via proxy: {$proxy}", ['url' => $url]);
            
            // Dummy successful scraped payload:
            return [
                'id' => 'C9xYzABC123',
                'type' => 'video',
                'title' => 'Sample Instagram Reel Title',
                'video_url' => 'https://instagram.fsnc1-1.fna.fbcdn.net/v/t50.2886-16/sample.mp4',
                'thumbnail_url' => 'https://instagram.fsnc1-1.fna.fbcdn.net/v/t51.2885-15/sample.jpg',
                'duration' => 15.4,
                'owner' => [
                    'username' => 'creator_handle',
                    'full_name' => 'Popular Creator',
                ]
            ];
        } catch (\Exception $e) {
            throw ToolExecutionException::failedToScrape($url, $e->getMessage());
        }
    }
}
