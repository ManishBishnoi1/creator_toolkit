<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ToolController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/tools/instagram-reel', [ToolController::class, 'downloadReel'])->name('tools.instagram-reel');
Route::post('/tools/ai-caption', [ToolController::class, 'generateCaption'])->name('tools.ai-caption');

Route::get('/tools/proxy-image', [ToolController::class, 'proxyImage'])->name('tools.proxy-image');
Route::get('/tools/stream-video', [ToolController::class, 'streamVideo'])->name('tools.stream-video');
