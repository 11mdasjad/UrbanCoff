@extends('layouts.admin')
@section('page_title', 'Dashboard')
@section('title', 'Admin Dashboard — Shirt Store')

@section('content')
<div class="space-y-8">
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted)] mb-1">Revenue</p>
            <p class="text-2xl font-bold text-[var(--color-dark)]">${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted)] mb-1">Orders</p>
            <p class="text-2xl font-bold text-[var(--color-dark)]">{{ $stats['total_orders'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted)] mb-1">Customers</p>
            <p class="text-2xl font-bold text-[var(--color-dark)]">{{ $stats['total_customers'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted)] mb-1">Products</p>
            <p class="text-2xl font-bold text-[var(--color-dark)]">{{ $stats['total_products'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-amber-600 mb-1">Pending</p>
            <p class="text-2xl font-bold text-amber-600">{{ $stats['pending_orders'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-red-600 mb-1">Low Stock</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['low_stock_count'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Recent Orders --}}
        <div class="bg-white rounded-xl border border-[var(--color-border)] overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-[var(--color-border)]">
                <h3 class="font-sans font-semibold text-[var(--color-dark)]">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-xs text-[var(--color-brand-500)] hover:underline">View All</a>
            </div>
            @forelse($recentOrders as $order)
            <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-4 border-b border-[var(--color-border)] last:border-0 hover:bg-[var(--color-surface-alt)] transition-colors">
                <div>
                    <p class="text-sm font-medium text-[var(--color-dark)]">{{ $order->order_number }}</p>
                    <p class="text-xs text-[var(--color-muted)]">{{ $order->user?->name ?? $order->name }} · {{ $order->created_at->diffForHumans() }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-[var(--color-dark)]">${{ number_format($order->total, 2) }}</p>
                    <span class="badge-{{ $order->status_badge }} text-[10px] font-semibold px-2 py-0.5 rounded-full">{{ $order->status_label }}</span>
                </div>
            </a>
            @empty
            <p class="p-8 text-center text-sm text-[var(--color-muted)]">No orders yet.</p>
            @endforelse
        </div>

        {{-- Low Stock Products --}}
        <div class="bg-white rounded-xl border border-[var(--color-border)] overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-[var(--color-border)]">
                <h3 class="font-sans font-semibold text-[var(--color-dark)]">Low Stock Alert</h3>
                <a href="{{ route('admin.products.index') }}" class="text-xs text-[var(--color-brand-500)] hover:underline">View All</a>
            </div>
            @forelse($lowStockProducts as $product)
            <a href="{{ route('admin.products.edit', $product) }}" class="flex items-center gap-4 p-4 border-b border-[var(--color-border)] last:border-0 hover:bg-[var(--color-surface-alt)] transition-colors">
                <div class="w-10 h-10 rounded-lg overflow-hidden bg-[var(--color-surface-alt)] shrink-0">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-[var(--color-dark)] truncate">{{ $product->name }}</p>
                    <p class="text-xs text-[var(--color-muted)]">SKU: {{ $product->sku }}</p>
                </div>
                <span class="badge-danger text-xs font-bold px-2 py-1 rounded-full">{{ $product->total_stock }} left</span>
            </a>
            @empty
            <p class="p-8 text-center text-sm text-[var(--color-muted)]">All products are well stocked.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
