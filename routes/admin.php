<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are prefixed with "/admin" and have the "web" middleware group applied.
|
*/

Route::get('/dashboard', function () {
    return 'Admin Dashboard';
})->name('dashboard');
