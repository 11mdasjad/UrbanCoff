<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'variants'])->active();

        // Filter by category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->byCategory($category->id);
            }
        }

        // Filter by size
        if ($request->filled('size')) {
            $query->bySize($request->size);
        }

        // Filter by color
        if ($request->filled('color')) {
            $query->byColor($request->color);
        }

        // Filter by price range
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->priceBetween($request->min_price, $request->max_price);
        }

        // Filter by availability
        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        $query = match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'popular' => $query->orderBy('featured', 'desc')->orderBy('created_at', 'desc'),
            'name' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->ordered()->withCount('products')->get();

        // Get all available sizes and colors for filters
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $colors = ['White', 'Black', 'Blue', 'Navy', 'Grey', 'Green', 'Beige', 'Brown'];

        return view('shop.index', compact('products', 'categories', 'sizes', 'colors'));
    }
}
