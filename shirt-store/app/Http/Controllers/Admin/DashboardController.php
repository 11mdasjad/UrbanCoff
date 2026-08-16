<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock_count' => Product::whereHas('variants', fn ($q) => $q->where('stock', '<=', 5))->count(),
        ];

        $recentOrders = Order::with('user')
            ->recent()
            ->take(10)
            ->get();

        $lowStockProducts = Product::with('variants')
            ->whereHas('variants', fn ($q) => $q->where('stock', '<=', 5))
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
