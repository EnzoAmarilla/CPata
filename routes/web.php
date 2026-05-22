<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\HomePage;
use App\Http\Controllers\SitemapController;

Route::get('/', HomePage::class);
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
