<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'URBANCOFF — Premium Shirts')</title>
    <meta name="description" content="@yield('meta_description', 'Premium shirts crafted for confidence, comfort and everyday style. Shop formal, casual, party wear and more.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        brand: {
                            50: '#faf8f5',
                            100: '#f0ece5',
                            200: '#e0d5c5',
                            300: '#c9b99a',
                            400: '#c9a96e',
                            500: '#b8944e',
                            600: '#9a7a3e',
                            700: '#7d6234',
                            800: '#5e4a28',
                            900: '#3f321c',
                        },
                        surface: '#fafaf8',
                        'surface-alt': '#f5f3ef',
                        dark: '#1a1a1a',
                        'dark-light': '#2d2d2d',
                        muted: '#6b6b6b',
                        border: '#e8e5e0',
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
            --font-serif: 'Playfair Display', ui-serif, Georgia, serif;
            --color-brand-50: #faf8f5;
            --color-brand-100: #f0ece5;
            --color-brand-200: #e0d5c5;
            --color-brand-300: #c9b99a;
            --color-brand-400: #c9a96e;
            --color-brand-500: #b8944e;
            --color-brand-600: #9a7a3e;
            --color-brand-700: #7d6234;
            --color-brand-800: #5e4a28;
            --color-brand-900: #3f321c;
            --color-surface: #fafaf8;
            --color-surface-alt: #f5f3ef;
            --color-dark: #1a1a1a;
            --color-dark-light: #2d2d2d;
            --color-muted: #6b6b6b;
            --color-border: #e8e5e0;
        }
        .product-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08); }
        .product-card .product-image { transition: transform 0.6s ease; }
        .product-card:hover .product-image { transform: scale(1.05); }
        .toast { animation: slideDown 0.3s ease-out, fadeOut 0.3s ease-in 3.7s forwards; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-warning { background-color: #fef9c3; color: #854d0e; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-info { background-color: #dbeafe; color: #1e40af; }
        .badge-primary { background-color: #e0e7ff; color: #3730a3; }
        .badge-secondary { background-color: #f3f4f6; color: #374151; }
        .size-option { transition: all 0.2s ease; }
        .size-option:hover:not(.out-of-stock), .size-option.selected { border-color: var(--color-dark); background-color: var(--color-dark); color: white; }
        .size-option.out-of-stock { opacity: 0.3; cursor: not-allowed; text-decoration: line-through; }
        .color-swatch { transition: all 0.2s ease; border: 2px solid transparent; }
        .color-swatch:hover { transform: scale(1.15); }
        .color-swatch.selected { border-color: var(--color-dark); box-shadow: 0 0 0 2px white, 0 0 0 4px var(--color-dark); }
        .admin-sidebar-link { transition: all 0.2s ease; }
        .admin-sidebar-link:hover, .admin-sidebar-link.active { background-color: rgba(201, 169, 110, 0.1); color: var(--color-brand-600); }
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen flex flex-col bg-[var(--color-surface)]" x-data="{ mobileMenu: false, searchOpen: false, cartDrawer: {{ session('open_cart') ? 'true' : 'false' }} }">
    {{-- Toast Notifications --}}
    @if(session('success'))
        <div data-toast class="fixed top-4 right-4 z-[100] bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 toast max-w-md">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div data-toast class="fixed top-4 right-4 z-[100] bg-red-50 border border-red-200 text-red-800 px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 toast max-w-md">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-[var(--color-border)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/urbancoff-logo.png') }}" alt="URBANCOFF" class="h-9 w-9 object-contain rounded-lg shadow-sm">
                    <span class="font-sans text-xl lg:text-2xl font-extrabold tracking-tight text-[var(--color-dark)] group-hover:text-[var(--color-brand-600)] transition-colors">URBANCOFF</span>
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors {{ request()->routeIs('home') ? 'text-[var(--color-dark)]' : '' }}">Home</a>
                    <a href="{{ route('shop') }}" class="text-sm font-medium text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors {{ request()->routeIs('shop') ? 'text-[var(--color-dark)]' : '' }}">Shop</a>
                    <a href="{{ route('shop', ['category' => 'formal-shirts']) }}" class="text-sm font-medium text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors">Formal</a>
                    <a href="{{ route('shop', ['category' => 'casual-shirts']) }}" class="text-sm font-medium text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors">Casual</a>
                    <a href="{{ route('shop', ['category' => 'party-wear']) }}" class="text-sm font-medium text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors">Party Wear</a>
                </div>

                {{-- Right Icons --}}
                <div class="flex items-center gap-3 lg:gap-4">
                    {{-- Search --}}
                    <button @click="searchOpen = !searchOpen" class="p-2 text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>

                    {{-- User --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="p-2 text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-[var(--color-border)] py-2 z-50">
                            @auth
                                <div class="px-4 py-2 border-b border-[var(--color-border)]">
                                    <p class="text-sm font-medium text-[var(--color-dark)]">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-[var(--color-muted)]">{{ Auth::user()->email }}</p>
                                </div>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] hover:text-[var(--color-dark)]">Admin Dashboard</a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] hover:text-[var(--color-dark)]">My Profile</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] hover:text-[var(--color-dark)]">My Orders</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] hover:text-[var(--color-dark)]">Login</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] hover:text-[var(--color-dark)]">Register</a>
                            @endauth
                        </div>
                    </div>

                    {{-- Cart Button --}}
                    <button @click="cartDrawer = true" type="button" class="relative p-2 text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors" aria-label="Open Shopping Cart">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-[var(--color-brand-500)] text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full">{{ $cartCount }}</span>
                        @endif
                    </button>

                    {{-- Mobile Menu Toggle --}}
                    <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 text-[var(--color-muted)] hover:text-[var(--color-dark)]">
                        <svg x-show="!mobileMenu" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenu" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Search Bar --}}
            <div x-show="searchOpen" x-transition class="pb-4">
                <form action="{{ route('search') }}" method="GET" class="flex">
                    <input type="text" name="q" placeholder="Search shirts..." class="flex-1 px-4 py-2.5 bg-[var(--color-surface-alt)] border border-[var(--color-border)] rounded-l-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] transition-colors" value="{{ request('q') }}">
                    <button type="submit" class="px-5 py-2.5 bg-[var(--color-dark)] text-white rounded-r-lg text-sm font-medium hover:bg-[var(--color-dark-light)] transition-colors">Search</button>
                </form>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileMenu" x-transition class="lg:hidden pb-4 border-t border-[var(--color-border)] pt-4">
                <div class="flex flex-col gap-2">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] rounded-lg">Home</a>
                    <a href="{{ route('shop') }}" class="px-3 py-2 text-sm font-medium text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] rounded-lg">Shop All</a>
                    <a href="{{ route('shop', ['category' => 'formal-shirts']) }}" class="px-3 py-2 text-sm font-medium text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] rounded-lg">Formal</a>
                    <a href="{{ route('shop', ['category' => 'casual-shirts']) }}" class="px-3 py-2 text-sm font-medium text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] rounded-lg">Casual</a>
                    <a href="{{ route('shop', ['category' => 'party-wear']) }}" class="px-3 py-2 text-sm font-medium text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] rounded-lg">Party Wear</a>
                    <a href="{{ route('shop', ['category' => 'denim-shirts']) }}" class="px-3 py-2 text-sm font-medium text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] rounded-lg">Denim</a>
                    <a href="{{ route('shop', ['category' => 'linen-shirts']) }}" class="px-3 py-2 text-sm font-medium text-[var(--color-muted)] hover:bg-[var(--color-surface-alt)] rounded-lg">Linen</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Cart Slide-over Drawer --}}
    <div x-cloak x-show="cartDrawer" class="relative z-[100]" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div x-show="cartDrawer" 
             x-transition:enter="ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="cartDrawer = false" 
             class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div x-show="cartDrawer" 
                         x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                         x-transition:enter-start="translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="translate-x-full"
                         class="pointer-events-auto w-screen max-w-md bg-white shadow-2xl flex flex-col">
                        
                        {{-- Drawer Header --}}
                        <div class="px-6 py-5 border-b border-[var(--color-border)] flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[var(--color-brand-500)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <h2 class="font-serif text-lg font-bold text-[var(--color-dark)]">Shopping Bag ({{ $cartCount }})</h2>
                            </div>
                            <button @click="cartDrawer = false" type="button" class="p-2 text-[var(--color-muted)] hover:text-[var(--color-dark)] rounded-lg hover:bg-[var(--color-surface-alt)] transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- Free shipping progress bar --}}
                        @if(isset($cartDrawerSubtotal) && $cartDrawerSubtotal > 0)
                            <div class="px-6 py-3 bg-[var(--color-surface-alt)] border-b border-[var(--color-border)]">
                                @if($cartDrawerFreeShipping)
                                    <div class="flex items-center gap-2 text-xs font-semibold text-green-700">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span>Congratulations! You qualify for <strong>FREE Delivery</strong></span>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between text-xs text-[var(--color-muted)] mb-1.5">
                                        <span>Add <strong class="text-[var(--color-dark)]">₹{{ number_format(999 - $cartDrawerSubtotal, 2) }}</strong> more for FREE delivery</span>
                                        <span class="font-semibold text-[var(--color-dark)]">{{ min(100, round(($cartDrawerSubtotal / 999) * 100)) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-[var(--color-brand-500)] h-1.5 rounded-full transition-all duration-300" style="width: {{ min(100, ($cartDrawerSubtotal / 999) * 100) }}%"></div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Drawer Body --}}
                        <div class="flex-1 overflow-y-auto p-6 space-y-4">
                            @if(isset($cartDrawerItems) && $cartDrawerItems->count() > 0)
                                @foreach($cartDrawerItems as $item)
                                    <div class="flex gap-4 p-3 rounded-xl border border-[var(--color-border)] bg-white hover:border-[var(--color-brand-300)] transition-colors">
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="w-20 h-24 rounded-lg overflow-hidden bg-[var(--color-surface-alt)] shrink-0">
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        </a>
                                        <div class="flex-1 min-w-0 flex flex-col justify-between">
                                            <div>
                                                <div class="flex items-start justify-between gap-2">
                                                    <h3 class="font-sans text-xs font-semibold text-[var(--color-dark)] truncate">
                                                        <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-[var(--color-brand-500)]">{{ $item->product->name }}</a>
                                                    </h3>
                                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-[var(--color-muted)] hover:text-red-500 p-0.5 transition-colors" title="Remove item">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <p class="text-[11px] text-[var(--color-muted)] mt-0.5">{{ $item->variant->size }} · {{ $item->variant->color }}</p>
                                                <p class="text-xs font-bold text-[var(--color-dark)] mt-1">₹{{ number_format($item->product->effective_price, 2) }}</p>
                                            </div>

                                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-[var(--color-border)]">
                                                <div class="flex items-center border border-[var(--color-border)] rounded-md">
                                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                        <button type="submit" class="px-2 py-0.5 text-xs text-[var(--color-muted)] hover:text-[var(--color-dark)]">−</button>
                                                    </form>
                                                    <span class="px-2 py-0.5 text-xs font-medium border-x border-[var(--color-border)]">{{ $item->quantity }}</span>
                                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="quantity" value="{{ min($item->variant->stock, $item->quantity + 1) }}">
                                                        <button type="submit" class="px-2 py-0.5 text-xs text-[var(--color-muted)] hover:text-[var(--color-dark)]">+</button>
                                                    </form>
                                                </div>
                                                <p class="text-xs font-bold text-[var(--color-dark)]">₹{{ number_format($item->subtotal, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="py-16 text-center">
                                    <svg class="w-16 h-16 mx-auto text-[var(--color-border)] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <p class="font-serif text-lg font-bold text-[var(--color-dark)] mb-1">Your bag is empty</p>
                                    <p class="text-xs text-[var(--color-muted)] mb-6">Discover our newest luxury shirt arrivals</p>
                                    <a href="{{ route('shop') }}" @click="cartDrawer = false" class="inline-flex px-6 py-2.5 bg-[var(--color-dark)] text-white text-xs font-semibold rounded-lg hover:bg-[var(--color-dark-light)] transition-colors">
                                        Shop All Shirts
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Drawer Footer --}}
                        @if(isset($cartDrawerItems) && $cartDrawerItems->count() > 0)
                            <div class="p-6 border-t border-[var(--color-border)] bg-[var(--color-surface)] space-y-3">
                                <div class="flex justify-between text-xs text-[var(--color-muted)]">
                                    <span>Subtotal</span>
                                    <span class="font-medium text-[var(--color-dark)]">₹{{ number_format($cartDrawerSubtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-xs text-[var(--color-muted)]">
                                    <span>Shipping</span>
                                    <span class="font-medium text-[var(--color-dark)]">{{ $cartDrawerFreeShipping ? 'Free' : '₹' . number_format($cartDrawerShipping, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm font-bold text-[var(--color-dark)] pt-2 border-t border-[var(--color-border)]">
                                    <span>Estimated Total</span>
                                    <span>₹{{ number_format($cartDrawerTotal, 2) }}</span>
                                </div>

                                <div class="space-y-2 pt-2">
                                    <a href="{{ route('checkout.index') }}" class="block w-full py-3 bg-[var(--color-dark)] text-white text-center text-xs font-semibold uppercase tracking-wider rounded-lg hover:bg-[var(--color-dark-light)] transition-colors shadow-sm">
                                        Proceed to Checkout
                                    </a>
                                    <a href="{{ route('cart.index') }}" class="block w-full py-2.5 bg-white border border-[var(--color-border)] text-center text-xs font-semibold text-[var(--color-dark)] rounded-lg hover:bg-[var(--color-surface-alt)] transition-colors">
                                        View Full Cart Page
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-[var(--color-dark)] text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/urbancoff-logo.png') }}" alt="URBANCOFF" class="h-10 w-10 object-contain rounded-lg border border-gray-800">
                        <span class="font-sans text-xl font-extrabold tracking-tight text-white">URBANCOFF</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">Premium shirts crafted for confidence, comfort and everyday style. Every shirt tells a story of quality and elegance.</p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="font-sans text-sm font-semibold uppercase tracking-wider mb-4">Shop</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('shop') }}" class="text-sm text-gray-400 hover:text-white transition-colors">All Shirts</a></li>
                        <li><a href="{{ route('shop', ['category' => 'formal-shirts']) }}" class="text-sm text-gray-400 hover:text-white transition-colors">Formal Shirts</a></li>
                        <li><a href="{{ route('shop', ['category' => 'casual-shirts']) }}" class="text-sm text-gray-400 hover:text-white transition-colors">Casual Shirts</a></li>
                        <li><a href="{{ route('shop', ['category' => 'party-wear']) }}" class="text-sm text-gray-400 hover:text-white transition-colors">Party Wear</a></li>
                        <li><a href="{{ route('shop', ['category' => 'denim-shirts']) }}" class="text-sm text-gray-400 hover:text-white transition-colors">Denim Shirts</a></li>
                    </ul>
                </div>

                {{-- Customer --}}
                <div>
                    <h4 class="font-sans text-sm font-semibold uppercase tracking-wider mb-4">Account</h4>
                    <ul class="space-y-2">
                        @auth
                            <li><a href="{{ route('profile.edit') }}" class="text-sm text-gray-400 hover:text-white transition-colors">My Profile</a></li>
                            <li><a href="{{ route('orders.index') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Order History</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Register</a></li>
                        @endauth
                        <li><a href="{{ route('cart.index') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Shopping Cart</a></li>
                    </ul>
                </div>

                {{-- Newsletter --}}
                <div>
                    <h4 class="font-sans text-sm font-semibold uppercase tracking-wider mb-4">Stay Updated</h4>
                    <p class="text-sm text-gray-400 mb-4">Subscribe for exclusive offers and new arrivals.</p>
                    <form class="flex" onsubmit="event.preventDefault(); this.querySelector('button').textContent = 'Subscribed!'">
                        <input type="email" placeholder="Your email" class="flex-1 px-3 py-2 bg-white/10 border border-white/20 rounded-l-lg text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[var(--color-brand-400)]">
                        <button type="submit" class="px-4 py-2 bg-[var(--color-brand-500)] text-white rounded-r-lg text-sm font-medium hover:bg-[var(--color-brand-600)] transition-colors">Join</button>
                    </form>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} URBANCOFF. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <span class="text-xs text-gray-500">Premium Quality</span>
                    <span class="text-xs text-gray-500">•</span>
                    <span class="text-xs text-gray-500">Fast Delivery</span>
                    <span class="text-xs text-gray-500">•</span>
                    <span class="text-xs text-gray-500">Easy Returns</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
