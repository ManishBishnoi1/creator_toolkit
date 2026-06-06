<?php

namespace App\Core\Helpers;

class SEOHelper
{
    /**
     * Generate standard title tag content with fallback.
     */
    public static function title(?string $pageTitle = null): string
    {
        $appName = config('app.name', 'Creator Toolkit');

        if (empty($pageTitle)) {
            return $appName . ' - Premium Instagram Downloader, AI Captions & SEO Tools';
        }

        return $pageTitle . ' | ' . $appName;
    }

    /**
     * Generate standard description meta tag with fallback.
     */
    public static function description(?string $description = null): string
    {
        if (empty($description)) {
            return 'Free tools for content creators: Download Instagram Reels/Stories, generate engaging AI captions, discover viral hashtags, and optimize your social media posts.';
        }

        return e($description);
    }

    /**
     * Generate keywords tag.
     */
    public static function keywords(array $keywords = []): string
    {
        $defaultKeywords = ['instagram downloader', 'reels downloader', 'story downloader', 'ai caption generator', 'hashtag generator', 'creator tools'];
        
        $merged = array_unique(array_merge($keywords, $defaultKeywords));
        
        return implode(', ', $merged);
    }
}
