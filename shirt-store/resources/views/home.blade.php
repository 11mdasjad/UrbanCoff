@extends('layouts.app')

@section('title', 'Shirt Store — Premium Shirts Crafted for Style')
@section('meta_description', 'Discover premium shirts crafted for confidence, comfort and everyday style. Shop formal, casual, party wear, denim, printed and linen shirts.')

@section('content')
    {{-- Hero Section --}}
    <section class="relative bg-[var(--color-dark)] overflow-hidden">
        {{-- Ambient Lighting Background Glows --}}
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-[var(--color-brand-500)]/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/3 -right-20 w-[30rem] h-[30rem] bg-[var(--color-brand-400)]/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 left-1/3 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                {{-- Left Content --}}
                <div class="lg:col-span-6 xl:col-span-7 animate-fade-in z-10">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm mb-6">
                        <span class="w-2 h-2 rounded-full bg-[var(--color-brand-400)] animate-pulse"></span>
                        <span class="text-[var(--color-brand-400)] text-xs font-semibold uppercase tracking-[0.2em]">New Season Collection</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl xl:text-6xl font-serif font-bold text-white leading-[1.12] mb-6">
                        SHIRTS THAT DEFINE YOUR <span class="text-transparent bg-clip-text bg-gradient-to-r from-[var(--color-brand-300)] via-[var(--color-brand-400)] to-[#e8c88a]">STYLE</span>
                    </h1>

                    <p class="text-base sm:text-lg text-gray-300 mb-8 max-w-xl leading-relaxed font-light">
                        Engineered with bespoke Egyptian cotton and tailored cuts for unmatched comfort, timeless sophistication, and everyday confidence.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 mb-10">
                        <a href="{{ route('shop') }}" class="inline-flex items-center px-8 py-4 bg-[var(--color-brand-500)] text-white text-sm font-semibold rounded-xl hover:bg-[var(--color-brand-600)] shadow-lg shadow-[var(--color-brand-500)]/25 hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                            Shop Collection
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('shop', ['category' => 'formal-shirts']) }}" class="inline-flex items-center px-7 py-4 border border-white/20 text-white text-sm font-semibold rounded-xl hover:bg-white/10 backdrop-blur-sm transition-all duration-300">
                            Explore Formal
                        </a>
                    </div>

                    {{-- Trust Indicators --}}
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-white/10 max-w-lg">
                        <div>
                            <p class="text-xl sm:text-2xl font-serif font-bold text-white">100%</p>
                            <p class="text-xs text-gray-400 mt-0.5">Organic Cotton</p>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl font-serif font-bold text-white">4.9/5</p>
                            <p class="text-xs text-gray-400 mt-0.5">Customer Rating</p>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl font-serif font-bold text-white">20K+</p>
                            <p class="text-xs text-gray-400 mt-0.5">Shirts Delivered</p>
                        </div>
                    </div>
                </div>

                {{-- Right 3D Visual Showcase --}}
                <div class="lg:col-span-6 xl:col-span-5 relative flex items-center justify-center">
                    {{-- Glowing Backdrop Ring --}}
                    <div class="absolute w-72 h-72 sm:w-96 sm:h-96 rounded-full border border-[var(--color-brand-400)]/30 animate-pulse pointer-events-none"></div>
                    <div class="absolute w-60 h-60 sm:w-80 sm:h-80 rounded-full bg-gradient-to-tr from-[var(--color-brand-500)]/20 to-blue-500/10 blur-2xl pointer-events-none"></div>

                    {{-- 3D Floating Shirt Container --}}
                    <div class="relative animate-float-hero group w-full max-w-md">
                        <div class="relative overflow-hidden rounded-3xl p-1 bg-gradient-to-b from-white/20 via-white/5 to-transparent backdrop-blur-xl shadow-2xl">
                            <img src="{{ asset('images/hero-3d-shirt.jpg') }}" alt="3D Luxury Tailored Shirt" class="w-full h-auto rounded-[22px] object-cover shadow-inner transform group-hover:scale-105 transition-transform duration-700">
                        </div>

                        {{-- Floating Badge 1: Quality Tag (Top Left) --}}
                        <div class="absolute -top-4 -left-4 sm:-left-6 bg-white/10 backdrop-blur-md border border-white/20 text-white px-4 py-2.5 rounded-2xl shadow-xl animate-float-badge-1 flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[var(--color-brand-400)] to-[var(--color-brand-600)] flex items-center justify-center text-white shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Fabric</p>
                                <p class="text-xs font-semibold text-white">Egyptian Oxford</p>
                            </div>
                        </div>

                        {{-- Floating Badge 2: Handcrafted / Rating (Bottom Right) --}}
                        <div class="absolute -bottom-4 -right-4 sm:-right-6 bg-white/10 backdrop-blur-md border border-white/20 text-white px-4 py-3 rounded-2xl shadow-xl animate-float-badge-2 flex items-center gap-3">
                            <div class="flex -space-x-1">
                                <span class="text-amber-400 text-sm">★</span>
                                <span class="text-amber-400 text-sm">★</span>
                                <span class="text-amber-400 text-sm">★</span>
                                <span class="text-amber-400 text-sm">★</span>
                                <span class="text-amber-400 text-sm">★</span>
                            </div>
                            <div class="border-l border-white/20 pl-3">
                                <p class="text-xs font-bold text-white">Tailored Cut</p>
                                <p class="text-[10px] text-gray-400">Hand-finished</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Featured Shirts --}}
    @if($featuredProducts->count())
    <section class="py-20 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-[var(--color-brand-500)] text-sm font-semibold uppercase tracking-[0.15em] mb-2">Curated Selection</p>
                <h2 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--color-dark)]">Featured Shirts</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @foreach($featuredProducts as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('shop') }}" class="inline-flex items-center px-8 py-3 border-2 border-[var(--color-dark)] text-[var(--color-dark)] text-sm font-semibold rounded-lg hover:bg-[var(--color-dark)] hover:text-white transition-all duration-300">
                    View All Shirts
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- Shop By Style --}}
    <section class="py-20 lg:py-24 bg-[var(--color-surface-alt)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-[var(--color-brand-500)] text-sm font-semibold uppercase tracking-[0.15em] mb-2">Find Your Perfect Fit</p>
                <h2 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--color-dark)]">Shop By Style</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 lg:gap-6">
                @foreach($categories as $category)
                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="group relative overflow-hidden rounded-xl aspect-[3/4] bg-[var(--color-dark)]">
                    <img src="{{ $category->image }}" alt="{{ $category->name }}" class="absolute inset-0 w-full h-full object-cover opacity-70 group-hover:opacity-50 group-hover:scale-110 transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <h3 class="text-white font-serif text-lg font-semibold">{{ $category->name }}</h3>
                        <p class="text-white/70 text-xs mt-1">Shop Now →</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- New Arrivals --}}
    @if($newArrivals->count())
    <section class="py-20 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-[var(--color-brand-500)] text-sm font-semibold uppercase tracking-[0.15em] mb-2">Just Landed</p>
                <h2 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--color-dark)]">New Arrivals</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @foreach($newArrivals as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Promotional Banner --}}
    <section class="py-20 lg:py-24 bg-[var(--color-dark)] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-[var(--color-brand-400)] text-sm font-semibold uppercase tracking-[0.2em] mb-4">Limited Time Offer</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold mb-4">UP TO 30% OFF SELECTED SHIRTS</h2>
            <p class="text-gray-400 text-lg mb-8 max-w-xl mx-auto">Elevate your wardrobe with our premium collection at extraordinary prices. Don't miss out on these exclusive deals.</p>
            <a href="{{ route('shop', ['sort' => 'price_low']) }}" class="inline-flex items-center px-8 py-3.5 bg-[var(--color-brand-500)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-brand-600)] transition-all duration-300">
                Shop Sale
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>

    {{-- Why Choose Us --}}
    <section class="py-20 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--color-dark)]">Why Choose Us</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[var(--color-brand-100)] flex items-center justify-center group-hover:bg-[var(--color-brand-400)] transition-colors duration-300">
                        <svg class="w-7 h-7 text-[var(--color-brand-600)] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <h3 class="font-sans font-semibold text-[var(--color-dark)] mb-2">Premium Quality</h3>
                    <p class="text-sm text-[var(--color-muted)]">Every shirt is crafted from the finest fabrics sourced globally.</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[var(--color-brand-100)] flex items-center justify-center group-hover:bg-[var(--color-brand-400)] transition-colors duration-300">
                        <svg class="w-7 h-7 text-[var(--color-brand-600)] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-sans font-semibold text-[var(--color-dark)] mb-2">Fast Delivery</h3>
                    <p class="text-sm text-[var(--color-muted)]">Free shipping on orders over $100. Express delivery available.</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[var(--color-brand-100)] flex items-center justify-center group-hover:bg-[var(--color-brand-400)] transition-colors duration-300">
                        <svg class="w-7 h-7 text-[var(--color-brand-600)] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <h3 class="font-sans font-semibold text-[var(--color-dark)] mb-2">Easy Returns</h3>
                    <p class="text-sm text-[var(--color-muted)]">30-day hassle-free returns on all orders. No questions asked.</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[var(--color-brand-100)] flex items-center justify-center group-hover:bg-[var(--color-brand-400)] transition-colors duration-300">
                        <svg class="w-7 h-7 text-[var(--color-brand-600)] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="font-sans font-semibold text-[var(--color-dark)] mb-2">Secure Checkout</h3>
                    <p class="text-sm text-[var(--color-muted)]">Your data is protected with industry-standard encryption.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
