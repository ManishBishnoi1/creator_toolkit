<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Core\Services\SEOService;
use Illuminate\View\View;

class ProgrammaticSEOController extends Controller
{
    public function __construct(
        protected SEOService $seoService
    ) {}

    /**
     * Helper to populate generic downloader landing pages.
     */
    protected function renderLanding(
        string $title,
        string $description,
        array $keywords,
        string $h1,
        string $activeTab,
        array $breadcrumbs,
        array $faqs,
        array $contentBlocks
    ): View {
        $this->seoService
            ->setTitle($title)
            ->setDescription($description)
            ->setKeywords($keywords)
            ->setFaq($faqs)
            ->setBreadcrumbs($breadcrumbs);

        return view('frontend.downloader-landing', compact(
            'h1',
            'activeTab',
            'contentBlocks',
            'faqs'
        ));
    }

    /**
     * /download-instagram-reels
     */
    public function reels(): View
    {
        return $this->renderLanding(
            'Instagram Reel Downloader - Save Reels Instantly for Free!',
            'Best free Instagram Reel Downloader. Save any reel in 1080p HD MP4 without watermarks. Works on iPhone, Android, and Desktop.',
            ['instagram reels downloader', 'save reels online', 'free reels saver', 'download ig reels'],
            'Instagram Reels Downloader - Save HD Reels for Free',
            'Reels',
            [
                'Home' => '/',
                'Reels Downloader' => '/download-instagram-reels'
            ],
            [
                [
                    'question' => 'How to download Instagram Reels using this tool?',
                    'answer' => 'Copy the reel URL from the Instagram app or website, paste it in the input box above, and click the "Download" button. The server processes the video in high quality and provides a direct download link.'
                ],
                [
                    'question' => 'Is it free to download Reels?',
                    'answer' => 'Yes! Our Instagram Reels Downloader is 100% free. No registration, no payment, and no extension installation required.'
                ],
                [
                    'question' => 'Can I download Reels on an iPhone?',
                    'answer' => 'Absolutely! Open our website in Safari browser, paste the copied reel link, and save it directly to your iPhone. A completely smooth experience!'
                ]
            ],
            [
                'intro' => 'The fastest Instagram Reels Downloader tool — save unlimited reels directly to your mobile gallery or desktop in HD MP4, without watermarks or brand logos.',
                'features_title' => 'Why Choose Our Reels Downloader?',
                'features' => [
                    'Unlimited Free Downloads: Save as many Reels as you want, with no limits.',
                    'Highest Quality: Download videos in native 1080p resolution with crystal clear audio.',
                    'All Devices Supported: Works perfectly on iPhone, iPad, Android, and Windows PC.'
                ]
            ]
        );
    }

    /**
     * /instagram-story-downloader
     */
    public function stories(): View
    {
        return $this->renderLanding(
            'Instagram Story Downloader - Save Stories & Highlights Online',
            'Download Instagram Stories and Highlights online for free. Instantly save active stories and highlights in high-quality MP4 or photo format.',
            ['instagram story downloader', 'save instagram story', 'ig stories downloader', 'ig highlight saver'],
            'Instagram Story Downloader - Save Stories before they expire!',
            'Story',
            [
                'Home' => '/',
                'Story Downloader' => '/instagram-story-downloader'
            ],
            [
                [
                    'question' => 'How to download Instagram Stories?',
                    'answer' => 'Copy the story or highlight URL, paste it into our search bar, and click the Download button. The tool automatically parses the media files and prepares them for download.'
                ],
                [
                    'question' => 'Will the profile owner know that I downloaded their story?',
                    'answer' => 'No! Our tool runs anonymously through secure proxy servers. Your downloads are completely private and the profile owner is never notified.'
                ]
            ],
            [
                'intro' => 'Download Instagram Stories and Highlights instantly to your device. Save your favorite creator\'s updates before they expire in 24 hours!',
                'features_title' => 'Top Story Saver Features',
                'features' => [
                    'Completely Anonymous: Safe and private download without notifying the profile owner.',
                    'Highlight Downloads: Download highlight clusters from public profiles indefinitely.',
                    'Dynamic Extractor: Saves story videos in MP4 and static images in JPG format.'
                ]
            ]
        );
    }

    /**
     * /download-reels-without-watermark
     */
    public function noWatermark(): View
    {
        return $this->renderLanding(
            'Reel Downloader Without Watermark - Save HD Reels Clean',
            'Download Instagram Reels without watermarks, username handles, or logos. Save original videos in 1080p HD MP4 with crystal clear audio.',
            ['reel downloader without watermark', 'instagram reels no watermark', 'clean reels download', 'ig reels no logo'],
            'Instagram Reels Downloader (No Watermark) - Save Clean HD Video',
            'Reels',
            [
                'Home' => '/',
                'No Watermark Downloader' => '/download-reels-without-watermark'
            ],
            [
                [
                    'question' => 'Will the downloaded Reels contain any watermark?',
                    'answer' => 'Absolutely not! Our downloader extracts the raw MP4 source file directly from the CDN. The output video is clean without watermark, text overlays, or logo screens.'
                ]
            ],
            [
                'intro' => 'Download original Instagram Reels without any watermark, text overlay, or branding logo. Perfect for content creators who want to repurpose content for YouTube Shorts or TikTok.',
                'features_title' => 'Key Benefits for Content Creators',
                'features' => [
                    'Clean Source: Clean, original video source without username branding.',
                    'Crystal Clear Audio: Crystal clear 1080p video with high bitrate audio.',
                    'Instant Processing: Scrape, merge, and get download-ready videos in seconds.'
                ]
            ]
        );
    }

    /**
     * /instagram-video-saver
     */
    public function videos(): View
    {
        return $this->renderLanding(
            'Instagram Video Downloader - Save IG Videos Online for Free',
            'Download Instagram feed videos and posts online for free. Instantly convert any public Instagram video directly into high-quality MP4 on mobile or desktop.',
            ['instagram video downloader', 'save instagram videos', 'ig video downloader', 'instagram to mp4 converter'],
            'Instagram Video Downloader - Save Feed Videos in HD',
            'Video',
            [
                'Home' => '/',
                'Video Downloader' => '/instagram-video-saver'
            ],
            [
                [
                    'question' => 'Can I download long videos or IGTV content?',
                    'answer' => 'Yes! Our downloader supports standard posts, Reels, and IGTV video URLs. There is no length limit on video downloads.'
                ]
            ],
            [
                'intro' => 'Save Instagram feed posts and video clips instantly. Convert any public Instagram video into HD MP4 to enjoy offline without ads.',
                'features_title' => 'Instagram Video Downloader Features',
                'features' => [
                    'Fast MP4 Converter: Extracts and converts raw high-bitrate video streams.',
                    'Unlimited Bandwidth: Zero buffering guarantee with cloud-hosted delivery.',
                    'No Registration: Open the site, paste the link, and download — simple!'
                ]
            ]
        );
    }

    /**
     * /instagram-photo-downloader
     */
    public function photos(): View
    {
        return $this->renderLanding(
            'Instagram Photo Downloader - Save HD Photos & Images Free',
            'Download Instagram photos, profile images, and post thumbnails in high resolution. Fastest online tool to save Instagram photos in JPG or PNG format.',
            ['instagram photo downloader', 'save instagram photos', 'ig image downloader', 'download instagram pics'],
            'Instagram Photo Downloader - Save Original HD Photos for Free',
            'Photo',
            [
                'Home' => '/',
                'Photo Downloader' => '/instagram-photo-downloader'
            ],
            [
                [
                    'question' => 'How to download high-resolution photos from Instagram?',
                    'answer' => 'Copy the post link, paste it into our input field, and click Download. The tool automatically extracts the highest resolution source image (up to 1080px) and prepares it for download.'
                ]
            ],
            [
                'intro' => 'Download high-definition photos and images directly from Instagram. Bypasses standard right-click protection to extract original JPG source files.',
                'features_title' => 'Download HD Images Instantly',
                'features' => [
                    'Original Resolution: Scrapes and extracts the original 1080p source image.',
                    'Fast JPG Extractor: Bypasses Instagram blocks to download photos directly.',
                    'Secure Image Proxying: Securely proxies CDNs to bypass browser CORS errors.'
                ]
            ]
        );
    }

    /**
     * /instagram-carousel-downloader
     */
    public function carousel(): View
    {
        return $this->renderLanding(
            'Instagram Carousel Downloader - Save All Album Slides Online',
            'Download multiple photos or videos from Instagram Carousel posts online. Save slides, albums, and side-by-side posts in high quality for free.',
            ['instagram carousel downloader', 'save instagram album', 'ig carousel saver', 'download ig slides'],
            'Instagram Carousel Downloader - Save the Entire Album in One Click',
            'Highlights',
            [
                'Home' => '/',
                'Carousel Downloader' => '/instagram-carousel-downloader'
            ],
            [
                [
                    'question' => 'How to save all photos from an Instagram Carousel post?',
                    'answer' => 'Paste the Carousel URL in our search bar. The tool will parse the link, extract all slide items, and show individual download buttons for each photo and video in the album.'
                ]
            ],
            [
                'intro' => 'Download full albums and slide posts containing multiple photos and videos from Instagram. Paste the link once and save each slide individually in original HD quality.',
                'features_title' => 'Full Album Parsing Features',
                'features' => [
                    'Slide Separation: Separates all photos and videos within a single carousel.',
                    'Bulk Item Processing: Fast retrieval and proxy rendering of all slides.',
                    'Multi-Format Support: Saves slide videos in MP4 and slide photos in JPG.'
                ]
            ]
        );
    }
}
