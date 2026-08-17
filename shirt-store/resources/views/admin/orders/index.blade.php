@extends('layouts.admin')
@section('page_title', 'Orders')
@section('title', 'Orders — Admin')

@section('content')
<div class="space-y-6">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order # or name..." class="px-4 py-2 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] w-64">
        <select name="status" onchange="this.form.submit()" class="px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm bg-white">
            <option value="">All Statuses</option>
            @foreach(\App\Models\Order::STATUSES as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </form>

    <div class="bg-white rounded-xl border border-[var(--color-border)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[var(--color-surface-alt)] text-left">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Order</th>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Customer</th>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Total</th>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Status</th>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Date</th>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-border)]">
                    @forelse($orders as $order)
                    <tr class="hover:bg-[var(--color-surface-alt)]">
                        <td class="px-4 py-3 font-medium text-[var(--color-dark)]">{{ $order->order_number }}</td>
                        <td class="px-4 py-3">
                            <p class="text-[var(--color-dark)]">{{ $order->name }}</p>
                            <p class="text-xs text-[var(--color-muted)]">{{ $order->email }}</p>
                        </td>
                        <td class="px-4 py-3 font-bold">₹{{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3"><span class="badge-{{ $order->status_badge }} text-xs font-semibold px-2.5 py-1 rounded-full">{{ $order->status_label }}</span></td>
                        <td class="px-4 py-3 text-[var(--color-muted)]">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-[var(--color-dark)] text-xs font-semibold hover:underline">View</a>
                                <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="text-[var(--color-brand-600)] text-xs font-medium hover:underline">Invoice</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-12 text-center text-[var(--color-muted)]">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div>{{ $orders->links() }}</div>
</div>
@endsection
