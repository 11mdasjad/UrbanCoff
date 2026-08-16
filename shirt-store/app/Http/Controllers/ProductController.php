<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::with(['category', 'variants', 'images'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedProducts = Product::with(['category', 'variants'])
            ->active()
            ->inStock()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        // Group variants by color for the product page
        $variantsByColor = $product->variants->groupBy('color');
        $variantsBySize = $product->variants->groupBy('size');

        return view('shop.show', compact('product', 'relatedProducts', 'variantsByColor', 'variantsBySize'));
    }
}
