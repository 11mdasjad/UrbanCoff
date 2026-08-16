<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $products = collect();

        if (strlen($query) >= 2) {
            $products = Product::with(['category', 'variants'])
                ->active()
                ->search($query)
                ->paginate(12)
                ->withQueryString();
        }

        return view('search.results', compact('products', 'query'));
    }
}
