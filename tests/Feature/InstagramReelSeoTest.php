<?php

namespace Tests\Feature;

use Tests\TestCase;

class InstagramReelSeoTest extends TestCase
{
    public function test_reel_landing_page_has_focused_metadata_and_helpful_content(): void
    {
        $response = $this->get('/download-instagram-reels');

        $response
            ->assertOk()
            ->assertSee('Instagram Reel Downloader - Download Reels in HD')
            ->assertSee('<link rel="canonical" href="http://localhost/download-instagram-reels">', false)
            ->assertSeeText('Which Instagram Reel links are supported?')
            ->assertSeeText('Download responsibly');
    }

    public function test_duplicate_downloader_aliases_redirect_to_canonical_pages(): void
    {
        $this->get('/instagram-reel-downloader')
            ->assertStatus(301)
            ->assertRedirect('/download-instagram-reels');

        $this->get('/instagram-video-downloader')
            ->assertStatus(301)
            ->assertRedirect('/instagram-video-saver');
    }

    public function test_sitemap_only_contains_canonical_downloader_urls(): void
    {
        $response = $this->get('/sitemap.xml');

        $response
            ->assertOk()
            ->assertSee('/download-instagram-reels')
            ->assertDontSee('/instagram-reel-downloader')
            ->assertDontSee('/instagram-video-downloader');
    }

    public function test_popunder_script_is_limited_to_the_home_and_reel_download_pages(): void
    {
        $this->get('/download-instagram-reels')
            ->assertOk()
            ->assertSee('elderlygoal.com/cmDD9.6Gb', false);

        $this->get('/instagram-story-downloader')
            ->assertOk()
            ->assertDontSee('elderlygoal.com/cmDD9.6Gb', false);

        $this->get('/')
            ->assertOk()
            ->assertSee('elderlygoal.com/cmDD9.6Gb', false);

        $this->get('/about')
            ->assertOk()
            ->assertDontSee('elderlygoal.com/cmDD9.6Gb', false);
    }
}
