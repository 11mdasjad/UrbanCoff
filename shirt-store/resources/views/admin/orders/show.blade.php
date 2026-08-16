@extends('layouts.admin')
@section('page_title', 'Order ' . $order->order_number)
@section('title', 'Order ' . $order->order_number . ' — Admin')

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm text-[var(--color-muted)] hover:text-[var(--color-dark)]">← Back to Orders</a>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-serif font-bold text-[var(--color-dark)]">{{ $order->order_number }}</h2>
            <p class="text-sm text-[var(--color-muted)]">{{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
        </div>
        {{-- Status Update --}}
        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-2">
            @csrf @method('PATCH')
            <select name="status" class="px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm bg-white">
                @foreach(\App\Models\Order::STATUSES as $status)
                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-[var(--color-dark)] text-white text-sm font-medium rounded-lg hover:bg-[var(--color-dark-light)]">Update</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Items --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] overflow-hidden">
                <div class="p-4 border-b border-[var(--color-border)]"><h3 class="font-semibold">Items</h3></div>
                @foreach($order->items as $item)
                <div class="p-4 flex gap-4 border-b last:border-0 border-[var(--color-border)]">
                    @if($item->product)<div class="w-12 h-14 rounded overflow-hidden bg-[var(--color-surface-alt)] shrink-0"><img src="{{ $item->product->image_url }}" class="w-full h-full object-cover"></div>@endif
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ $item->product_name }}</p>
                        <p class="text-xs text-[var(--color-muted)]">{{ $item->size }} / {{ $item->color }} × {{ $item->quantity }}</p>
                    </div>
                    <p class="text-sm font-bold">${{ number_format($item->total, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            {{-- Summary --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-4 space-y-2 text-sm">
                <h3 class="font-semibold mb-2">Summary</h3>
                <div class="flex justify-between"><span class="text-[var(--color-muted)]">Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
                <div class="flex justify-between"><span class="text-[var(--color-muted)]">Shipping</span><span>{{ $order->shipping_cost > 0 ? '$'.number_format($order->shipping_cost,2) : 'Free' }}</span></div>
                <div class="border-t pt-2 flex justify-between font-bold"><span>Total</span><span class="text-lg">${{ number_format($order->total, 2) }}</span></div>
                <p class="text-[var(--color-muted)] pt-1">Payment: {{ ucfirst($order->payment_method) === 'Cod' ? 'Cash on Delivery' : ucfirst($order->payment_method) }}</p>
            </div>

            {{-- Customer --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-4 text-sm">
                <h3 class="font-semibold mb-2">Customer</h3>
                <p class="font-medium">{{ $order->name }}</p>
                <p class="text-[var(--color-muted)]">{{ $order->email }}</p>
                <p class="text-[var(--color-muted)]">{{ $order->phone }}</p>
                @if($order->user)<a href="{{ route('admin.customers.show', $order->user) }}" class="text-[var(--color-brand-500)] text-xs hover:underline mt-1 inline-block">View Profile →</a>@endif
            </div>

            {{-- Address --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-4 text-sm">
                <h3 class="font-semibold mb-2">Shipping</h3>
                <p>{{ $order->address_line_1 }}</p>
                @if($order->address_line_2)<p>{{ $order->address_line_2 }}</p>@endif
                <p>{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</p>
                <p>{{ $order->country }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
