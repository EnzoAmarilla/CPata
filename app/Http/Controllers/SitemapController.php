<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::where('active', true)->get();
        
        return response()->view('sitemap', [
            'products' => $products
        ])->header('Content-Type', 'text/xml');
    }
