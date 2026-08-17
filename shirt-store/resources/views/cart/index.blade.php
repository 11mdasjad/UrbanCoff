@extends('layouts.app')
@section('title', 'Shopping Cart — URBANCOFF')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <h1 class="text-2xl lg:text-3xl font-serif font-bold text-[var(--color-dark)] mb-8">Shopping Cart</h1>

    @if($items->count())
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Cart Items --}}
        <div class="lg:col-span-2 space-y-4">
            @foreach($items as $item)
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-4 sm:p-6 flex gap-4 sm:gap-6">
                <a href="{{ route('products.show', $item->product->slug) }}" class="w-24 h-28 sm:w-32 sm:h-36 rounded-lg overflow-hidden bg-[var(--color-surface-alt)] shrink-0">
                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                </a>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-sans text-sm font-medium text-[var(--color-dark)]">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-[var(--color-brand-500)]">{{ $item->product->name }}</a>
                            </h3>
                            <p class="text-xs text-[var(--color-muted)] mt-1">Size: {{ $item->variant->size }} · Color: {{ $item->variant->color }}</p>
                            <p class="text-sm font-bold text-[var(--color-dark)] mt-2">₹{{ number_format($item->product->effective_price, 2) }}</p>
                        </div>
                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-[var(--color-muted)] hover:text-red-500 transition-colors p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </form>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center border border-[var(--color-border)] rounded-lg">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                <button type="submit" class="px-3 py-1.5 text-[var(--color-muted)] hover:text-[var(--color-dark)]">−</button>
                            </form>
                            <span class="px-3 py-1.5 text-sm font-medium border-x border-[var(--color-border)]">{{ $item->quantity }}</span>
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ min($item->variant->stock, $item->quantity + 1) }}">
                                <button type="submit" class="px-3 py-1.5 text-[var(--color-muted)] hover:text-[var(--color-dark)]">+</button>
                            </form>
                        </div>
                        <p class="text-sm font-bold text-[var(--color-dark)]">₹{{ number_format($item->subtotal, 2) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Order Summary --}}
        <div>
            <div class="bg-white rounded-xl border border-[var(--color-border)] p-6 sticky top-24">
                <h2 class="font-sans text-lg font-semibold text-[var(--color-dark)] mb-4">Order Summary</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-[var(--color-muted)]">Subtotal ({{ $count }} items)</span><span class="font-medium">₹{{ number_format($subtotal, 2) }}</span></div>
                    <div class="flex justify-between">
                        <span class="text-[var(--color-muted)]">Shipping</span>
                        <span class="font-medium">{{ $free_shipping ? 'Free' : '₹' . number_format($shipping, 2) }}</span>
                    </div>
                    @if(!$free_shipping && $subtotal > 0)
                        <p class="text-xs text-[var(--color-brand-500)]">Add ₹{{ number_format(999 - $subtotal, 2) }} more for free shipping!</p>
                    @endif
                    <div class="border-t border-[var(--color-border)] pt-3 flex justify-between">
                        <span class="font-semibold text-[var(--color-dark)]">Total</span>
                        <span class="font-bold text-lg text-[var(--color-dark)]">₹{{ number_format($total, 2) }}</span>
                    </div>
                </div>

                @auth
                    <a href="{{ route('checkout.index') }}" class="block w-full text-center mt-6 py-3.5 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)] transition-colors shadow-sm">
                        Proceed to Checkout →
                    </a>
                @else
                    <div x-data="{ showLogin: false }" class="mt-6 space-y-3">
                        <a href="{{ route('checkout.index') }}" class="block w-full text-center py-3.5 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)] transition-colors shadow-sm">
                            Proceed to Checkout
                        </a>
                        <button type="button" @click="showLogin = !showLogin" class="block w-full text-center py-2.5 bg-[var(--color-surface-alt)] border border-[var(--color-border)] text-xs font-semibold text-[var(--color-dark)] rounded-lg hover:bg-white transition-colors">
                            <span x-text="showLogin ? 'Hide Quick Sign In' : 'Sign In with Existing Account'"></span>
                        </button>

                        {{-- Quick Login Form --}}
                        <div x-show="showLogin" x-transition class="p-4 bg-[var(--color-surface-alt)] rounded-lg border border-[var(--color-border)] text-left space-y-3">
                            <form method="POST" action="{{ route('login.store') }}" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-medium text-[var(--color-dark)] mb-1">Email</label>
                                    <input type="email" name="email" required placeholder="you@example.com" class="w-full px-3 py-2 text-xs border border-[var(--color-border)] rounded-md bg-white focus:outline-none focus:border-[var(--color-brand-400)]">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-[var(--color-dark)] mb-1">Password</label>
                                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-3 py-2 text-xs border border-[var(--color-border)] rounded-md bg-white focus:outline-none focus:border-[var(--color-brand-400)]">
                                </div>
                                <button type="submit" class="w-full py-2 bg-[var(--color-brand-500)] text-white text-xs font-semibold rounded-md hover:bg-[var(--color-brand-600)] transition-colors">
                                    Sign In & Continue
                                </button>
                            </form>
                        </div>
                        <p class="text-xs text-[var(--color-muted)] text-center">New to URBANCOFF? <a href="{{ route('register') }}" class="text-[var(--color-brand-600)] font-medium hover:underline">Create account</a></p>
                    </div>
                @endauth

                <a href="{{ route('shop') }}" class="block text-center text-sm text-[var(--color-muted)] hover:text-[var(--color-dark)] mt-4">← Continue Shopping</a>
            </div>
        </div>
    </div>
    @else
    {{-- Empty Cart --}}
    <div class="text-center py-20 bg-white rounded-xl border border-[var(--color-border)]">
        <svg class="w-20 h-20 mx-auto text-[var(--color-border)] mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        <h2 class="font-serif text-2xl text-[var(--color-dark)] mb-2">Your cart is empty</h2>
        <p class="text-[var(--color-muted)] text-sm mb-8">Looks like you haven't added any shirts yet.</p>
        <a href="{{ route('shop') }}" class="inline-flex px-8 py-3 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)] transition-colors">Start Shopping</a>
    </div>
    @endif
</div>
@endsection
