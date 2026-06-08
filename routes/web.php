<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ToolController;
use App\Http\Controllers\Frontend\PageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('pages.submit-contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('pages.terms');

Route::post('/tools/instagram-reel', [ToolController::class, 'downloadReel'])->name('tools.instagram-reel')->middleware('throttle:10,1');
Route::post('/tools/ai-caption', [ToolController::class, 'generateCaption'])->name('tools.ai-caption')->middleware('throttle:10,1');

Route::get('/tools/proxy-image', [ToolController::class, 'proxyImage'])->name('tools.proxy-image');
Route::get('/tools/download-video/{id}', [ToolController::class, 'downloadVideo'])->name('tools.download-video');

Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('pages.sitemap');
