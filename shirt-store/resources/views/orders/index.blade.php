@extends('layouts.app')
@section('title', 'My Orders — URBANCOFF')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <h1 class="text-2xl lg:text-3xl font-serif font-bold text-[var(--color-dark)] mb-8">My Orders</h1>

    @if($orders->count())
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-6 hover:border-[var(--color-brand-400)] transition-colors">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-3">
                <div>
                    <a href="{{ route('orders.show', $order) }}" class="text-sm font-bold text-[var(--color-dark)] hover:text-[var(--color-brand-600)] transition-colors">{{ $order->order_number }}</a>
                    <span class="text-xs text-[var(--color-muted)] ml-3">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="badge-{{ $order->status_badge }} text-xs font-semibold px-3 py-1 rounded-full">{{ $order->status_label }}</span>
                </div>
            </div>
            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                <span class="text-sm text-[var(--color-muted)]">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }} · <strong class="text-[var(--color-dark)]">₹{{ number_format($order->total, 2) }}</strong></span>
                <a href="{{ route('orders.show', $order) }}" class="text-xs font-semibold text-[var(--color-dark)] hover:underline">
                    View Details →
                </a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-8">{{ $orders->links() }}</div>
    @else
    <div class="text-center py-20 bg-white rounded-xl border border-[var(--color-border)]">
        <svg class="w-16 h-16 mx-auto text-[var(--color-border)] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <h2 class="font-serif text-xl text-[var(--color-dark)] mb-2">No orders yet</h2>
        <p class="text-[var(--color-muted)] text-sm mb-6">Start shopping to see your orders here.</p>
        <a href="{{ route('shop') }}" class="inline-flex px-8 py-3 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg">Shop Now</a>
    </div>
    @endif
</div>
@endsection
