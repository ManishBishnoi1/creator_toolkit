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
            'Instagram Reel Downloader - Download Reels in HD',
            'Download public Instagram Reels as MP4 files. Paste a Reel link to preview and save the video on iPhone, Android, or desktop—free and without signing up.',
            ['instagram reel downloader', 'download instagram reels', 'save instagram reels', 'instagram reels to mp4'],
            'Instagram Reel Downloader',
            'Reels',
            [
                'Home' => '/',
                'Reels Downloader' => '/download-instagram-reels'
            ],
            [
                [
                    'question' => 'How do I download an Instagram Reel?',
                    'answer' => 'Open a public Reel in Instagram, tap Share and copy its link. Paste the link into the downloader above, select Download, then save the MP4 file to your device.'
                ],
                [
                    'question' => 'Can this downloader save private Instagram Reels?',
                    'answer' => 'No. The downloader can only access public Reels that are available without signing in. It cannot bypass private accounts, deleted posts, or Instagram access restrictions.'
                ],
                [
                    'question' => 'Can I download Instagram Reels on iPhone or Android?',
                    'answer' => 'Yes. The downloader works in current mobile browsers. On iPhone, the file normally appears in Safari Downloads or the Files app; on Android, it normally appears in the Downloads folder.'
                ],
                [
                    'question' => 'What video quality will I receive?',
                    'answer' => 'The downloader selects the best video and audio streams Instagram makes available for that Reel and combines them into a downloadable file when necessary. Available resolution varies by the original upload.'
                ],
                [
                    'question' => 'Does the downloaded Reel have a watermark?',
                    'answer' => 'The tool downloads the media stream supplied by Instagram and does not add its own watermark. Any text, logo, or watermark already embedded by the creator remains in the video.'
                ]
            ],
            [
                'intro' => 'Save a public Instagram Reel for offline viewing in a few steps. The downloader reads the shared Reel URL, finds the best media streams Instagram exposes, and prepares a downloadable video without requiring an account on this site.',
                'features_title' => 'What the Reel downloader offers',
                'features' => [
                    'Best available quality: The tool selects the highest-quality video and audio streams available for the public Reel.',
                    'MP4 download: Save the processed video to a phone, tablet, Windows PC, Mac, or Chromebook.',
                    'No signup: Paste a supported public Reel URL without creating an account or installing an extension.'
                ],
                'steps_title' => 'How to download an Instagram Reel',
                'steps' => [
                    ['title' => 'Copy the Reel link', 'text' => 'Open the public Reel in the Instagram app or website, tap Share, and choose Copy link.'],
                    ['title' => 'Paste the URL', 'text' => 'Return to this page, paste the complete Instagram Reel URL into the field above, and select Download.'],
                    ['title' => 'Preview and save', 'text' => 'Wait while the Reel is processed, then use the download button to save the video file to your device.']
                ],
                'details' => [
                    [
                        'title' => 'Which Instagram Reel links are supported?',
                        'body' => 'Use a direct public link containing /reel/, such as instagram.com/reel/ABC123/. Links copied from the Instagram share menu can include tracking parameters; the downloader identifies the Reel from the URL. Private, deleted, age-restricted, or region-restricted media may not be available.'
                    ],
                    [
                        'title' => 'Download responsibly',
                        'body' => 'Only download videos you created or have permission to save. Copyright and the creator’s rights still apply after a file is downloaded. This service is independent and is not affiliated with or endorsed by Instagram or Meta.'
                    ]
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
     * /instagram-highlights-downloader
     */
    public function highlights(): View
    {
        return $this->renderLanding(
            'Instagram Highlights Downloader - Save Highlight Videos & Photos',
            'Download Instagram Highlights online for free. Save public highlight videos and photos in high quality without login on iPhone, Android, or desktop.',
            ['instagram highlights downloader', 'save instagram highlights', 'ig highlight downloader', 'download instagram highlights'],
            'Instagram Highlights Downloader - Save Highlights in HD',
            'Highlights',
            [
                'Home' => '/',
                'Highlights Downloader' => '/instagram-highlights-downloader'
            ],
            [
                [
                    'question' => 'How do I download Instagram Highlights?',
                    'answer' => 'Copy the highlight URL from a public Instagram profile, paste it into the downloader field, and click Download. The tool prepares available highlight photos and videos for saving.'
                ],
                [
                    'question' => 'Can I save Highlight videos and photos?',
                    'answer' => 'Yes. Public Instagram Highlights can include both videos and images, and the downloader supports saving available media in MP4 or JPG format.'
                ],
                [
                    'question' => 'Do I need to log in to download Highlights?',
                    'answer' => 'No. You can download public Instagram Highlights without sharing your Instagram username, password, or any account credentials.'
                ]
            ],
            [
                'intro' => 'Save Instagram Highlights from public profiles before they change or disappear. Download highlight videos and photos in high quality for offline viewing, archiving, or creator research.',
                'features_title' => 'Instagram Highlights Saver Features',
                'features' => [
                    'Video and Photo Support: Download available Highlight videos in MP4 and images in JPG.',
                    'No Login Required: Save public Highlight media without connecting your Instagram account.',
                    'Works on Every Device: Use the Highlights Downloader from mobile, tablet, or desktop browsers.'
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
