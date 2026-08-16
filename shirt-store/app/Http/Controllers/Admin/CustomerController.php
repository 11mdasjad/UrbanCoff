<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->latest()
            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        $user->load('orders.items', 'addresses');
        $orders = $user->orders()->recent()->paginate(10);

        return view('admin.customers.show', compact('user', 'orders'));
    }
}
