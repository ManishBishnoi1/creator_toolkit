<?php

namespace Tests\Feature;

use App\Core\Services\Instagram\InstagramScraperService;
use Mockery\MockInterface;
use Tests\TestCase;

class FetchInstagramReelTest extends TestCase
{
    /**
     * Test successful download endpoint processing with mocked scraper service.
     */
    public function test_downloader_endpoint_returns_json_on_success(): void
    {
        $mockedResult = [
            'id' => 'C9xYzABC123',
            'type' => 'video',
            'title' => 'Test Instagram Reel Title',
            'video_url' => 'https://instagram.example.com/video.mp4',
            'thumbnail_url' => 'https://instagram.example.com/thumbnail.jpg',
            'duration' => 15.0,
            'owner' => [
                'username' => 'test_user',
                'full_name' => 'Test Creator',
            ]
        ];

        // Bind mock to Laravel container
        $this->mock(InstagramScraperService::class, function (MockInterface $mock) use ($mockedResult) {
            $mock->shouldReceive('scrape')
                ->once()
                ->with('https://www.instagram.com/reel/C9xYzABC123/')
                ->andReturn($mockedResult);
        });

        // Request POST to downloader route
        $response = $this->postJson(route('tools.instagram-reel'), [
            'url' => 'https://www.instagram.com/reel/C9xYzABC123/',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => $mockedResult,
            ]);
    }

    /**
     * Test validation failure on invalid Instagram links.
     */
    public function test_downloader_endpoint_validates_input_url(): void
    {
        $response = $this->postJson(route('tools.instagram-reel'), [
            'url' => 'invalid-link',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }
}
