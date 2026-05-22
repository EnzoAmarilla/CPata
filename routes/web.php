<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\HomePage;
use App\Http\Controllers\SitemapController;

Route::get('/', HomePage::class);
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders/{eventRequest}/print', function(\App\Models\EventRequest $eventRequest) {
        return view('admin.orders.print', compact('eventRequest'));
    })->name('admin.orders.print');
});
