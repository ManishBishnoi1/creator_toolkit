<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ToolController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\BlogController;

Route::get('/', function () {
    $recentPosts = collect();
    if (class_exists(\App\Models\Post::class)) {
        try {
            $recentPosts = \App\Models\Post::query()
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->limit(3)
                ->get();
        } catch (\Exception $e) {
            // Ignore if DB table is not yet migrated
        }
    }
    return view('welcome', compact('recentPosts'));
});

Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('pages.submit-contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('pages.terms');
Route::get('/dmca', [PageController::class, 'dmca'])->name('pages.dmca');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::post('/tools/instagram-reel', [ToolController::class, 'downloadReel'])->name('tools.instagram-reel')->middleware('throttle:10,1');
Route::post('/tools/ai-caption', [ToolController::class, 'generateCaption'])->name('tools.ai-caption')->middleware('throttle:10,1');

Route::get('/tools/proxy-image', [ToolController::class, 'proxyImage'])->name('tools.proxy-image');
Route::get('/tools/download-video/{id}', [ToolController::class, 'downloadVideo'])->name('tools.download-video');

Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('pages.sitemap');

// Programmatic SEO Keyword Landing Routes
use App\Http\Controllers\Frontend\ProgrammaticSEOController;

Route::get('/download-instagram-reels', [ProgrammaticSEOController::class, 'reels'])->name('seo.reels');
Route::get('/instagram-reel-downloader', [ProgrammaticSEOController::class, 'reels'])->name('seo.reels.alias');
Route::get('/instagram-story-downloader', [ProgrammaticSEOController::class, 'stories'])->name('seo.stories');
Route::get('/download-reels-without-watermark', [ProgrammaticSEOController::class, 'noWatermark'])->name('seo.no-watermark');
Route::get('/instagram-video-saver', [ProgrammaticSEOController::class, 'videos'])->name('seo.videos');
Route::get('/instagram-video-downloader', [ProgrammaticSEOController::class, 'videos'])->name('seo.videos.alias');
Route::get('/instagram-photo-downloader', [ProgrammaticSEOController::class, 'photos'])->name('seo.photos');
Route::get('/instagram-highlights-downloader', [ProgrammaticSEOController::class, 'highlights'])->name('seo.highlights');
Route::get('/instagram-carousel-downloader', [ProgrammaticSEOController::class, 'carousel'])->name('seo.carousel');
