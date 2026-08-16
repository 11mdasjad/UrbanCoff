<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;

class HomeController extends Controller
{
    public function index(CartService $cartService)
    {
        $featuredProducts = Product::with(['category', 'variants'])
            ->active()
            ->featured()
            ->inStock()
            ->take(8)
            ->get();

        $newArrivals = Product::with(['category', 'variants'])
            ->active()
            ->inStock()
            ->latest()
            ->take(4)
            ->get();

        $categories = Category::active()->ordered()->get();

        return view('home', compact('featuredProducts', 'newArrivals', 'categories'));
    }
}
