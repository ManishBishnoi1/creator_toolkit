<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Creator Toolkit Configuration
    |--------------------------------------------------------------------------
    |
    | Define limits, credentials, and settings for each downloader and generator.
    |
    | Cache durations are defined in seconds. Rate limits are in requests per minute.
    |
    */

    'limits' => [
        'anonymous' => [
            'instagram_downloader' => 5, // Downloads per IP per day
            'ai_caption_generator' => 3, // Generations per IP per day
            'hashtag_generator' => 5,    // Generations per IP per day
        ],
        'premium' => [
            'instagram_downloader' => 1000,
            'ai_caption_generator' => 500,
            'hashtag_generator' => 1000,
        ],
    ],

    'instagram' => [
        'scraping_timeout' => env('INSTAGRAM_SCRAPING_TIMEOUT', 15),
        'proxy_rotation' => env('INSTAGRAM_PROXY_ROTATION', false),
        'cache_duration' => env('INSTAGRAM_CACHE_DURATION', 600), // 10 minutes cache
        'ytdlp_binary_path' => env('YTDLP_BINARY_PATH', base_path('bin/yt-dlp.exe')),
    ],

    'ai' => [
        'default_model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
        'max_tokens' => env('OPENAI_MAX_TOKENS', 500),
        'temperature' => env('OPENAI_TEMPERATURE', 0.7),
    ],

    'seo' => [
        'sitemap_auto_generate' => env('SEO_SITEMAP_AUTO_GENERATE', true),
        'meta_robots' => env('SEO_META_ROBOTS', 'index, follow'),
    ],

];
