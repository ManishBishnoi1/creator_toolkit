<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Render About page.
     */
    public function about()
    {
        return view('frontend.about');
    }

    /**
     * Render Contact page.
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * Handle contact form submission.
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'message' => 'required|string|max:2000',
        ]);

        // In a real application, we might mail this, queue it, or store in database.
        // For local development, we return a success status message.
        return back()->with('success', 'Thank you! Your message has been received. We will get back to you shortly.');
    }

    /**
     * Render Privacy Policy page.
     */
    public function privacy()
    {
        return view('frontend.privacy');
    }

    /**
     * Render Terms of Service page.
     */
    public function terms()
    {
        return view('frontend.terms');
    }

    /**
     * Render DMCA Policy page.
     */
    public function dmca()
    {
        return view('frontend.dmca');
    }

    /**
     * Generate dynamic sitemap.xml.
     */
    public function sitemap()
    {
        $urls = [
            ['loc' => url('/'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => url('/blog'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => url('/about'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => url('/contact'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => url('/privacy'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => url('/terms'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => url('/dmca'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            // Programmatic SEO landing pages
            ['loc' => url('/download-instagram-reels'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => url('/instagram-story-downloader'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => url('/download-reels-without-watermark'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => url('/instagram-video-saver'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => url('/instagram-photo-downloader'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => url('/instagram-highlights-downloader'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => url('/instagram-carousel-downloader'), 'changefreq' => 'weekly', 'priority' => '0.9'],
        ];

        // If Post model exists, query them dynamically:
        if (class_exists(\App\Models\Post::class)) {
            try {
                $posts = \App\Models\Post::all();
                foreach ($posts as $post) {
                    $urls[] = [
                        'loc' => url('/blog/' . ($post->slug ?? $post->id)),
                        'changefreq' => 'weekly',
                        'priority' => '0.6',
                        'lastmod' => $post->updated_at ? $post->updated_at->toAtomString() : now()->toAtomString()
                    ];
                }
            } catch (\Exception $e) {
                // Ignore silently if table not migrated to prevent crashes
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . e($url['loc']) . '</loc>';
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $url['priority'] . '</priority>';
            if (!empty($url['lastmod'])) {
                $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            }
            $xml .= '</url>';
        }
        
        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
