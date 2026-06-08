<?php

namespace App\Core\Services;

class SEOService
{
    protected ?string $title = null;
    protected ?string $description = null;
    protected array $keywords = [];
    protected ?string $canonical = null;
    protected string $robots = 'index, follow';
    protected array $faq = [];
    protected array $breadcrumbs = [];
    protected ?string $ogImage = null;

    /**
     * Set the page meta title.
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set the page meta description.
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set target page keywords.
     */
    public function setKeywords(array $keywords): self
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * Set canonical URL.
     */
    public function setCanonical(?string $canonical): self
    {
        $this->canonical = $canonical;
        return $this;
    }

    /**
     * Set robots instructions.
     */
    public function setRobots(string $robots): self
    {
        $this->robots = $robots;
        return $this;
    }

    /**
     * Set FAQ schema list.
     */
    public function setFaq(array $faq): self
    {
        $this->faq = $faq;
        return $this;
    }

    /**
     * Set Breadcrumbs pathways.
     */
    public function setBreadcrumbs(array $breadcrumbs): self
    {
        $this->breadcrumbs = $breadcrumbs;
        return $this;
    }

    /**
     * Set custom OG Image.
     */
    public function setOgImage(?string $ogImage): self
    {
        $this->ogImage = $ogImage;
        return $this;
    }

    /**
     * Get compiled Title with fallback.
     */
    public function getTitle(): string
    {
        $appName = config('app.name', 'InstaReelDownload');
        if (empty($this->title)) {
            return 'Instagram Reel Downloader - Reels ab instantly save karo';
        }
        return $this->title . ' | ' . $appName;
    }

    /**
     * Get compiled Description with fallback.
     */
    public function getDescription(): string
    {
        if (empty($this->description)) {
            return 'Instagram Reels, videos, aur stories ko bina watermark ke HD quality me instantly save karo. Safe, fast, aur 100% free tool.';
        }
        return e($this->description);
    }

    /**
     * Get compiled keywords.
     */
    public function getKeywords(): string
    {
        $defaultKeywords = [
            'instagram reel downloader', 'download instagram reels', 'save instagram reels',
            'reel downloader without watermark', 'instagram video downloader', 'download reels online',
            'instagram story downloader', 'instagram photo downloader', 'instagram carousel downloader'
        ];
        $merged = array_unique(array_merge($this->keywords, $defaultKeywords));
        return implode(', ', $merged);
    }

    /**
     * Get Canonical URL.
     */
    public function getCanonical(): string
    {
        return $this->canonical ?? request()->url();
    }

    /**
     * Get robots rules.
     */
    public function getRobots(): string
    {
        return $this->robots;
    }

    /**
     * Get OpenGraph Image.
     */
    public function getOgImage(): string
    {
        return $this->ogImage ?? asset('images/logo.png');
    }

    /**
     * Compile and render all active JSON-LD schemas.
     */
    public function renderSchemas(): string
    {
        $schemas = [];

        // 1. Organization Schema
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name', 'InstaReelDownload'),
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
            'sameAs' => [
                'https://www.facebook.com/instareeldownload',
                'https://twitter.com/instareeldownload',
                'https://www.pinterest.com/instareeldownload'
            ]
        ];

        // 2. WebSite Schema
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('app.name', 'InstaReelDownload'),
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/') . '?q={search_term_string}',
                'query-input' => 'required name=search_term_string'
            ]
        ];

        // 3. Breadcrumbs Schema
        if (!empty($this->breadcrumbs)) {
            $items = [];
            $position = 1;
            foreach ($this->breadcrumbs as $name => $link) {
                $items[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => $name,
                    'item' => $link ? url($link) : request()->url()
                ];
            }
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => $items
            ];
        }

        // 4. FAQ Schema
        if (!empty($this->faq)) {
            $elements = [];
            foreach ($this->faq as $item) {
                if (!empty($item['question']) && !empty($item['answer'])) {
                    $elements[] = [
                        '@type' => 'Question',
                        'name' => $item['question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $item['answer']
                        ]
                    ];
                }
            }
            if (!empty($elements)) {
                $schemas[] = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => $elements
                ];
            }
        }

        $html = '';
        foreach ($schemas as $schema) {
            $html .= '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
        }

        return $html;
    }
}
