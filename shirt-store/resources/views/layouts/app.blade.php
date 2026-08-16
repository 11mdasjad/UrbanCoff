<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shirt Store — Premium Shirts')</title>
    <meta name="description" content="@yield('meta_description', 'Premium shirts crafted for confidence, comfort and everyday style. Shop formal, casual, party wear and more.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-[var(--color-surface)]">
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
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-[var(--color-border)]" x-data="{ mobileMenu: false, searchOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="font-serif text-xl lg:text-2xl font-bold tracking-tight text-[var(--color-dark)]">SHIRT</span>
                    <span class="font-serif text-xl lg:text-2xl font-light tracking-tight text-[var(--color-brand-500)]">STORE</span>
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

                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-[var(--color-brand-500)] text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>

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

    {{-- Footer --}}
    <footer class="bg-[var(--color-dark)] text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-serif text-xl font-bold">SHIRT</span>
                        <span class="font-serif text-xl font-light text-[var(--color-brand-400)]">STORE</span>
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
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} Shirt Store. All rights reserved.</p>
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
