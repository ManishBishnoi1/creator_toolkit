<?php

namespace App\Modules\Downloader\Actions;

use App\Core\Exceptions\ToolExecutionException;
use App\Modules\Downloader\Services\ScrapingProxyRotator;
use Illuminate\Support\Facades\Log;

class FetchInstagramStory
{
    public function __construct(
        protected ScrapingProxyRotator $proxyRotator
    ) {}

    /**
     * Execute the action to fetch/scrape a user's active stories.
     *
     * @param string $username
     * @return array
     * @throws ToolExecutionException
     */
    public function execute(string $username): array
    {
        $username = trim(ltrim($username, '@'));

        if (empty($username) || preg_match('/[^A-Za-z0-9._]/', $username)) {
            throw new ToolExecutionException('Invalid Instagram username provided.', 422);
        }

        try {
            $proxy = $this->proxyRotator->getNextProxy();
            Log::info("Attempting to scrape Stories for handle @{$username} via proxy: {$proxy}");

            // Dummy successful scraped payload showing active stories:
            return [
                'username' => $username,
                'stories' => [
                    [
                        'id' => 'story_101_abc',
                        'type' => 'image',
                        'media_url' => 'https://instagram.fsnc1-1.fna.fbcdn.net/v/t51.2885-15/story1.jpg',
                        'taken_at' => now()->subHours(2)->timestamp,
                    ],
                    [
                        'id' => 'story_102_def',
                        'type' => 'video',
                        'media_url' => 'https://instagram.fsnc1-1.fna.fbcdn.net/v/t50.2886-16/story2.mp4',
                        'taken_at' => now()->subHours(5)->timestamp,
                    ],
                ]
            ];
        } catch (\Exception $e) {
            throw ToolExecutionException::failedToScrape($username, $e->getMessage());
        }
    }
}
