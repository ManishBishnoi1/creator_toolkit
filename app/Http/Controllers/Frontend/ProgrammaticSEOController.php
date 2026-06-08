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
            'Instagram Reel Downloader - Reels Ab Instantly Save Karo Free!',
            'Best free Instagram Reel Downloader. Kisi bhi reel ko 1080p HD MP4 me download karo bina watermark ke. iPhone, Android aur Desktop sab par kaam karta hai.',
            ['instagram reels download karo', 'reels save karo free', 'reels downloader online', 'instagram reel downloader'],
            'Instagram Reels Downloader - HD Reels Free Me Save Karo',
            'Reels',
            [
                'Home' => '/',
                'Reels Downloader' => '/download-instagram-reels'
            ],
            [
                [
                    'question' => 'Is tool se Instagram Reels kaise download karein?',
                    'answer' => 'Instagram app ya website se reel ka URL copy karein, upar diye input box me paste karein, aur "Download Karo" button dabayein. Server video ko high quality me process karke seedha download link de deta hai.'
                ],
                [
                    'question' => 'Kya Reels download karna free hai?',
                    'answer' => 'Haan! Humara Instagram Reels Downloader 100% free hai. Koi registration nahi, koi payment nahi, aur koi extension install karne ki zaroorat nahi.'
                ],
                [
                    'question' => 'Kya iPhone se bhi Reels download kar sakte hain?',
                    'answer' => 'Bilkul! Safari browser me humari website kholein, copied reel link paste karein, aur seedha apne iPhone me save kar lein. Ek ekdum smooth experience!'
                ]
            ],
            [
                'intro' => 'Sabse fast Instagram Reels Downloader tool — unlimited reels ko directly apni mobile gallery ya desktop me HD MP4 me save karo, bina watermark aur bina kisi copyright logo ke.',
                'features_title' => 'Hamara Reels Downloader Kyun Choose Karein?',
                'features' => [
                    'Unlimited Free Downloads: Jitni chahein utni Reels save karein, koi limit nahi.',
                    'Highest Quality: Native 1080p resolution me crystal clear audio ke saath video download.',
                    'Sabhi Devices Support: iPhone, iPad, Android aur Windows PC sab par perfectly kaam karta hai.'
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
            'Instagram Story Downloader - Stories & Highlights Online Save Karo',
            'Instagram Stories aur Highlights ko free me online download karo. Private stories aur highlights ko high-quality MP4 ya photo me instantly save karo.',
            ['instagram story downloader', 'instagram story save karo', 'ig stories download', 'ig highlight downloader'],
            'Instagram Story Downloader - Stories 24 Ghante Se Pehle Save Karo!',
            'Story',
            [
                'Home' => '/',
                'Story Downloader' => '/instagram-story-downloader'
            ],
            [
                [
                    'question' => 'Instagram Stories kaise download karein?',
                    'answer' => 'Story ya highlight ka URL copy karein, humare search bar me paste karein, aur Download button click karein. Tool automatically media files parse karke download ready kar deta hai.'
                ],
                [
                    'question' => 'Kya story download karte waqt owner ko pata chalta hai?',
                    'answer' => 'Nahi! Humara tool independent proxy rotators ke through kaam karta hai. Aapka download completely anonymous rehta hai aur profile owner ko kabhi notify nahi hota.'
                ]
            ],
            [
                'intro' => 'Instagram Stories aur Highlights ko instantly download karein apne device me. 24 ghante me expire hone se pehle apne favorite creator ki updates save kar lo!',
                'features_title' => 'Top Story Saver Features',
                'features' => [
                    'Completely Anonymous: Profile owner ko bina notify kiye safe private download.',
                    'Highlight Downloads: Public profiles ke highlight clusters ko indefinitely download karein.',
                    'Dynamic Extractor: Story videos ko MP4 me aur static images ko JPG me save karta hai.'
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
            'Reel Downloader Without Watermark - Bina Watermark HD Reels Save Karo',
            'Instagram Reels bina watermark, username handle ya logo ke download karo. 1080p HD MP4 me crystal clear audio ke saath original video save karo.',
            ['reel downloader without watermark', 'bina watermark reels save', 'instagram reels no watermark download', 'ig reels no logo'],
            'Instagram Reels Downloader (Bina Watermark) - Clean HD Video Save Karo',
            'Reels',
            [
                'Home' => '/',
                'No Watermark Downloader' => '/download-reels-without-watermark'
            ],
            [
                [
                    'question' => 'Kya downloaded Reels me koi watermark hoga?',
                    'answer' => 'Bilkul nahi! Humara downloader CDN se original raw MP4 file extract karta hai. Output video me koi watermark, text handle ya logo screen nahi hota.'
                ]
            ],
            [
                'intro' => 'Original Instagram Reels bina kisi watermark, text overlay ya branding logo ke download karo. Content creators ke liye perfect tool jo YouTube Shorts ya TikTok ke liye content repurpose karna chahte hain.',
                'features_title' => 'Content Creators Ke Liye Key Benefits',
                'features' => [
                    'Zero Overlays: Username branding ke bina clean, original video source.',
                    'DASH Format Merging: High bitrate audio ke saath crystal clear 1080p video.',
                    'Instant Processing: Seconds me scrape, merge aur download-ready video.'
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
            'Instagram Video Downloader - IG Videos Online Save Karo Free',
            'Instagram feed videos aur posts ko free me online download karo. Kisi bhi public Instagram video ko directly high-quality MP4 me mobile ya desktop par convert karo.',
            ['instagram video downloader', 'instagram videos download karo', 'ig videos save karo', 'instagram to mp4 convert'],
            'Instagram Video Downloader - Feed Videos HD Me Save Karo',
            'Video',
            [
                'Home' => '/',
                'Video Downloader' => '/instagram-video-saver'
            ],
            [
                [
                    'question' => 'Kya long videos ya IGTV bhi download kar sakte hain?',
                    'answer' => 'Haan! Humara downloader standard posts, Reels aur purane IGTV video URLs sab support karta hai. Download karne ki koi length limit nahi hai.'
                ]
            ],
            [
                'intro' => 'Instagram feed posts aur video clips ko instantly save karo. Kisi bhi public Instagram video ko HD MP4 me convert karke offline ads-free enjoy karo.',
                'features_title' => 'Robust Instagram Video Downloader Features',
                'features' => [
                    'Fast MP4 Converter: Raw high bitrate video streams extract aur convert karta hai.',
                    'Unlimited Bandwidth: Cloud-hosted delivery se zero buffering guarantee.',
                    'No Registration: Site kholein, link paste karein aur download kar lein — simple!'
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
            'Instagram Photo Downloader - HD Photos aur Images Free Download',
            'Instagram photos, profile images aur post thumbnails ko high resolution me download karo. Sabse fast online tool jo Instagram photos ko JPG ya PNG me save karta hai.',
            ['instagram photo downloader', 'instagram photos download karo', 'ig photos save', 'ig image downloader'],
            'Instagram Photo Downloader - Original HD Photos Free Me Save Karo',
            'Photo',
            [
                'Home' => '/',
                'Photo Downloader' => '/instagram-photo-downloader'
            ],
            [
                [
                    'question' => 'Instagram se high-resolution photos kaise download karein?',
                    'answer' => 'Post ka link copy karein, humara input field me paste karein aur Download click karein. Tool automatically highest resolution source image (1080px tak) extract karke download ke liye ready kar deta hai.'
                ]
            ],
            [
                'intro' => 'Instagram se directly high-definition photos aur images download karo. Standard context menu blocks ko bypass karke original JPG source file extract karta hai.',
                'features_title' => 'HD Images Instantly Download Karo',
                'features' => [
                    'Original Resolution: 1080p source image ko scrape aur extract karta hai.',
                    'Fast JPG Extractor: Instagram blocks bypass karke directly photos download karta hai.',
                    'Secure Image Proxying: Browser CORS errors bypass karne ke liye CDNs securely proxy karta hai.'
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
            'Instagram Carousel Downloader - Album ke Saare Slides Save Karo',
            'Instagram Carousel posts me multiple photos ya videos ko online download karo. Slides, albums aur side-by-side posts ko high quality me free me save karo.',
            ['instagram carousel downloader', 'instagram album download', 'ig slides save karo', 'instagram multiple photos download'],
            'Instagram Carousel Downloader - Poora Album Ek Click Me Save Karo',
            'Highlights',
            [
                'Home' => '/',
                'Carousel Downloader' => '/instagram-carousel-downloader'
            ],
            [
                [
                    'question' => 'Ek Instagram Carousel post ke saare photos kaise save karein?',
                    'answer' => 'Carousel URL humara search bar me paste karein. Tool link parse karega, saare slide items extract karega aur album me har photo aur video ke liye individual download buttons show karega.'
                ]
            ],
            [
                'intro' => 'Instagram ke full album aur slide posts jisme multiple photos aur videos hain unhe download karo. Link ek baar paste karo aur har slide ko original HD quality me individually save karo.',
                'features_title' => 'Full Album Parsing Features',
                'features' => [
                    'Slide Separation: Single carousel ke andar saare photos aur videos alag kar deta hai.',
                    'Bulk Item Processing: Saare slides ki fast retrieval aur proxy rendering.',
                    'Multi-Format Support: Slide videos ko MP4 aur slide photos ko JPG me save karta hai.'
                ]
            ]
        );
    }
}
