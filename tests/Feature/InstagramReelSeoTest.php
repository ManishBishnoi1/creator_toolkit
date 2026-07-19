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

    public function test_google_ad_code_is_not_loaded_on_the_downloader_pages(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertDontSee('pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', false);

        $this->get('/download-instagram-reels')
            ->assertOk()
            ->assertDontSee('pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', false);

        $this->get('/privacy')
            ->assertOk()
            ->assertSee('pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', false);
    }

}
