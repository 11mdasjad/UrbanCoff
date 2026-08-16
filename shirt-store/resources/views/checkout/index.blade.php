@extends('layouts.app')
@section('title', 'Checkout — Shirt Store')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <h1 class="text-2xl lg:text-3xl font-serif font-bold text-[var(--color-dark)] mb-8">Checkout</h1>

    <form method="POST" action="{{ route('checkout.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        <div class="lg:col-span-2 space-y-6">
            {{-- Contact Info --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-6">
                <h2 class="font-sans text-lg font-semibold text-[var(--color-dark)] mb-4">Contact Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] @error('name') border-red-400 @enderror">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] @error('email') border-red-400 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Phone *</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                            class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] @error('phone') border-red-400 @enderror">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-6">
                <h2 class="font-sans text-lg font-semibold text-[var(--color-dark)] mb-4">Shipping Address</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Address Line 1 *</label>
                        <input type="text" name="address_line_1" value="{{ old('address_line_1', $defaultAddress?->address_line_1) }}" required
                            class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] @error('address_line_1') border-red-400 @enderror">
                        @error('address_line_1')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Address Line 2</label>
                        <input type="text" name="address_line_2" value="{{ old('address_line_2', $defaultAddress?->address_line_2) }}"
                            class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">City *</label>
                        <input type="text" name="city" value="{{ old('city', $defaultAddress?->city) }}" required
                            class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] @error('city') border-red-400 @enderror">
                        @error('city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">State *</label>
                        <input type="text" name="state" value="{{ old('state', $defaultAddress?->state) }}" required
                            class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] @error('state') border-red-400 @enderror">
                        @error('state')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Postal Code *</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $defaultAddress?->postal_code) }}" required
                            class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] @error('postal_code') border-red-400 @enderror">
                        @error('postal_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Country *</label>
                        <input type="text" name="country" value="{{ old('country', $defaultAddress?->country ?? 'India') }}" required
                            class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]">
                    </div>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-6">
                <h2 class="font-sans text-lg font-semibold text-[var(--color-dark)] mb-4">Payment Method</h2>
                <label class="flex items-center gap-3 p-4 border-2 border-[var(--color-dark)] rounded-lg cursor-pointer">
                    <input type="radio" name="payment_method" value="cod" checked class="text-[var(--color-brand-500)]">
                    <div>
                        <p class="text-sm font-medium text-[var(--color-dark)]">Cash on Delivery</p>
                        <p class="text-xs text-[var(--color-muted)]">Pay when your order arrives</p>
                    </div>
                </label>
            </div>

            {{-- Notes --}}
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-6">
                <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Order Notes (optional)</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]" placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
            </div>
        </div>

        {{-- Order Summary --}}
        <div>
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-6 sticky top-24">
                <h2 class="font-sans text-lg font-semibold text-[var(--color-dark)] mb-4">Order Summary</h2>
                <div class="space-y-4 mb-4">
                    @foreach($cartData['items'] as $item)
                    <div class="flex gap-3">
                        <div class="w-16 h-20 rounded-lg overflow-hidden bg-[var(--color-surface-alt)] shrink-0">
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-[var(--color-dark)] truncate">{{ $item->product->name }}</p>
                            <p class="text-xs text-[var(--color-muted)]">{{ $item->variant->size }} / {{ $item->variant->color }} × {{ $item->quantity }}</p>
                            <p class="text-sm font-bold text-[var(--color-dark)] mt-1">${{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="border-t border-[var(--color-border)] pt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-[var(--color-muted)]">Subtotal</span><span>${{ number_format($cartData['subtotal'], 2) }}</span></div>
                    <div class="flex justify-between"><span class="text-[var(--color-muted)]">Shipping</span><span>{{ $cartData['free_shipping'] ? 'Free' : '$' . number_format($cartData['shipping'], 2) }}</span></div>
                    <div class="border-t border-[var(--color-border)] pt-2 flex justify-between font-bold text-lg">
                        <span>Total</span><span>${{ number_format($cartData['total'], 2) }}</span>
                    </div>
                </div>
                <button type="submit" class="w-full mt-6 py-3.5 bg-[var(--color-brand-500)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-brand-600)] transition-colors">
                    Place Order — ${{ number_format($cartData['total'], 2) }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
