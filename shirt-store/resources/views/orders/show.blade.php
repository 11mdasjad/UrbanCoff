@extends('layouts.app')
@section('title', 'Order ' . $order->order_number . ' — URBANCOFF')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm text-[var(--color-muted)] hover:text-[var(--color-dark)] mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Orders
    </a>

    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-serif font-bold text-[var(--color-dark)]">{{ $order->order_number }}</h1>
            <p class="text-sm text-[var(--color-muted)] mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
        </div>
        <span class="badge-{{ $order->status_badge }} text-sm font-semibold px-4 py-1.5 rounded-full">{{ $order->status_label }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Items --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] overflow-hidden">
                <div class="p-4 border-b border-[var(--color-border)]">
                    <h2 class="font-sans font-semibold text-[var(--color-dark)]">Order Items</h2>
                </div>
                @foreach($order->items as $item)
                <div class="p-4 flex gap-4 border-b border-[var(--color-border)] last:border-0">
                    @if($item->product)
                    <div class="w-16 h-20 rounded-lg overflow-hidden bg-[var(--color-surface-alt)] shrink-0">
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div class="flex-1">
                        <p class="text-sm font-medium text-[var(--color-dark)]">{{ $item->product_name }}</p>
                        <p class="text-xs text-[var(--color-muted)] mt-1">Size: {{ $item->size }} · Color: {{ $item->color }} · Qty: {{ $item->quantity }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-[var(--color-dark)]">₹{{ number_format($item->total, 2) }}</p>
                        <p class="text-xs text-[var(--color-muted)]">₹{{ number_format($item->price, 2) }} each</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            {{-- Summary --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-4">
                <h3 class="font-sans font-semibold text-[var(--color-dark)] mb-3">Summary</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-[var(--color-muted)]">Subtotal</span><span>₹{{ number_format($order->subtotal, 2) }}</span></div>
                    <div class="flex justify-between"><span class="text-[var(--color-muted)]">Shipping</span><span>{{ $order->shipping_cost > 0 ? '₹' . number_format($order->shipping_cost, 2) : 'Free' }}</span></div>
                    <div class="border-t pt-2 flex justify-between font-bold"><span>Total</span><span class="text-lg">₹{{ number_format($order->total, 2) }}</span></div>
                </div>
                <div class="mt-3 pt-3 border-t text-sm">
                    <p class="text-[var(--color-muted)]">Payment: <span class="font-medium text-[var(--color-dark)]">Cash on Delivery</span></p>
                </div>
            </div>

            {{-- Shipping --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-4">
                <h3 class="font-sans font-semibold text-[var(--color-dark)] mb-3">Shipping Address</h3>
                <div class="text-sm text-[var(--color-muted)] space-y-1">
                    <p class="font-medium text-[var(--color-dark)]">{{ $order->name }}</p>
                    <p>{{ $order->address_line_1 }}</p>
                    @if($order->address_line_2)<p>{{ $order->address_line_2 }}</p>@endif
                    <p>{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</p>
                    <p>{{ $order->country }}</p>
                    <p>{{ $order->phone }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
