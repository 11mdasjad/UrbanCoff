@extends('layouts.admin')
@section('page_title', $user->name)
@section('title', $user->name . ' — Admin')

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center text-sm text-[var(--color-muted)] hover:text-[var(--color-dark)]">← Back to Customers</a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-14 h-14 rounded-full bg-[var(--color-brand-100)] flex items-center justify-center text-[var(--color-brand-600)] text-xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div>
                    <h2 class="font-semibold text-[var(--color-dark)]">{{ $user->name }}</h2>
                    <p class="text-sm text-[var(--color-muted)]">{{ $user->email }}</p>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-[var(--color-muted)]">Phone</span><span>{{ $user->phone ?? '—' }}</span></div>
                <div class="flex justify-between"><span class="text-[var(--color-muted)]">Joined</span><span>{{ $user->created_at->format('M d, Y') }}</span></div>
                <div class="flex justify-between"><span class="text-[var(--color-muted)]">Total Orders</span><span class="font-bold">{{ $user->orders->count() }}</span></div>
            </div>

            @if($user->addresses->count())
            <div class="mt-4 pt-4 border-t border-[var(--color-border)]">
                <h3 class="font-semibold text-sm mb-2">Addresses</h3>
                @foreach($user->addresses as $addr)
                <p class="text-xs text-[var(--color-muted)] mb-2">{{ $addr->full_address }}</p>
                @endforeach
            </div>
            @endif
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-[var(--color-border)] overflow-hidden">
                <div class="p-4 border-b border-[var(--color-border)]"><h3 class="font-semibold">Orders</h3></div>
                @forelse($orders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-4 border-b last:border-0 border-[var(--color-border)] hover:bg-[var(--color-surface-alt)]">
                    <div>
                        <p class="text-sm font-medium">{{ $order->order_number }}</p>
                        <p class="text-xs text-[var(--color-muted)]">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold">${{ number_format($order->total, 2) }}</p>
                        <span class="badge-{{ $order->status_badge }} text-[10px] font-semibold px-2 py-0.5 rounded-full">{{ $order->status_label }}</span>
                    </div>
                </a>
                @empty
                <p class="p-8 text-center text-sm text-[var(--color-muted)]">No orders.</p>
                @endforelse
            </div>
            <div class="mt-4">{{ $orders->links() }}</div>
        </div>
    </div>
</div>
@endsection
