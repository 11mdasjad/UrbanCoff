@extends('layouts.app')
@section('title', 'Shop All Shirts — URBANCOFF')
@section('meta_description', 'Browse our complete collection of premium shirts. Filter by category, size, color, and price.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    {{-- Breadcrumb --}}
    <nav class="mb-6 text-sm">
        <a href="{{ route('home') }}" class="text-[var(--color-muted)] hover:text-[var(--color-dark)]">Home</a>
        <span class="mx-2 text-[var(--color-muted)]">/</span>
        <span class="text-[var(--color-dark)] font-medium">Shop</span>
        @if(request('category'))
            <span class="mx-2 text-[var(--color-muted)]">/</span>
            <span class="text-[var(--color-dark)] font-medium">{{ str_replace('-', ' ', ucwords(request('category'), '-')) }}</span>
        @endif
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Filters Sidebar --}}
        <aside class="lg:w-64 shrink-0" x-data="{ filtersOpen: false }">
            <button @click="filtersOpen = !filtersOpen" class="lg:hidden w-full flex items-center justify-between px-4 py-3 bg-white border border-[var(--color-border)] rounded-lg mb-4">
                <span class="text-sm font-medium">Filters</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
            </button>

            <form action="{{ route('shop') }}" method="GET" class="space-y-6" :class="{ 'hidden lg:block': !filtersOpen, 'block': filtersOpen }">
                @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif

                {{-- Categories --}}
                <div class="bg-white rounded-lg border border-[var(--color-border)] p-4">
                    <h3 class="font-sans text-sm font-semibold text-[var(--color-dark)] mb-3">Category</h3>
                    <div class="space-y-2">
                        <a href="{{ route('shop', request()->except('category', 'page')) }}" class="block text-sm {{ !request('category') ? 'text-[var(--color-brand-500)] font-medium' : 'text-[var(--color-muted)] hover:text-[var(--color-dark)]' }}">All Shirts</a>
                        @foreach($categories as $category)
                            <a href="{{ route('shop', array_merge(request()->except('page'), ['category' => $category->slug])) }}" class="flex items-center justify-between text-sm {{ request('category') === $category->slug ? 'text-[var(--color-brand-500)] font-medium' : 'text-[var(--color-muted)] hover:text-[var(--color-dark)]' }}">
                                {{ $category->name }}
                                <span class="text-xs text-[var(--color-muted)]">{{ $category->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Size --}}
                <div class="bg-white rounded-lg border border-[var(--color-border)] p-4">
                    <h3 class="font-sans text-sm font-semibold text-[var(--color-dark)] mb-3">Size</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($sizes as $size)
                            <a href="{{ route('shop', array_merge(request()->except('page'), ['size' => request('size') === $size ? null : $size])) }}" class="px-3 py-1.5 text-xs font-medium border rounded-md transition-colors {{ request('size') === $size ? 'bg-[var(--color-dark)] text-white border-[var(--color-dark)]' : 'border-[var(--color-border)] text-[var(--color-muted)] hover:border-[var(--color-dark)] hover:text-[var(--color-dark)]' }}">
                                {{ $size }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Color --}}
                <div class="bg-white rounded-lg border border-[var(--color-border)] p-4">
                    <h3 class="font-sans text-sm font-semibold text-[var(--color-dark)] mb-3">Color</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($colors as $color)
                            <a href="{{ route('shop', array_merge(request()->except('page'), ['color' => request('color') === $color ? null : $color])) }}" class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium border rounded-md transition-colors {{ request('color') === $color ? 'bg-[var(--color-dark)] text-white border-[var(--color-dark)]' : 'border-[var(--color-border)] text-[var(--color-muted)] hover:border-[var(--color-dark)]' }}" title="{{ $color }}">
                                <span class="w-3 h-3 rounded-full border border-gray-300" style="background-color: {{ match(strtolower($color)) { 'white' => '#fff', 'black' => '#1a1a1a', 'blue' => '#3b82f6', 'navy' => '#1e3a5f', 'grey' => '#9ca3af', 'green' => '#16a34a', 'beige' => '#d4b896', 'brown' => '#8b5e3c', default => '#e5e7eb' } }}"></span>
                                {{ $color }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Clear Filters --}}
                @if(request()->hasAny(['category', 'size', 'color', 'min_price', 'max_price', 'in_stock']))
                    <a href="{{ route('shop') }}" class="block text-center text-sm text-red-500 hover:text-red-700 font-medium">Clear All Filters</a>
                @endif
            </form>
        </aside>

        {{-- Products Grid --}}
        <div class="flex-1">
            {{-- Sorting & Count --}}
            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-[var(--color-muted)]">{{ $products->total() }} {{ Str::plural('shirt', $products->total()) }} found</p>
                <div class="flex items-center gap-2">
                    <label class="text-sm text-[var(--color-muted)]">Sort by:</label>
                    <select onchange="window.location.href=this.value" class="text-sm border border-[var(--color-border)] rounded-lg px-3 py-2 bg-white focus:outline-none focus:border-[var(--color-brand-400)]">
                        <option value="{{ route('shop', array_merge(request()->except('sort', 'page'), ['sort' => 'latest'])) }}" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="{{ route('shop', array_merge(request()->except('sort', 'page'), ['sort' => 'price_low'])) }}" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="{{ route('shop', array_merge(request()->except('sort', 'page'), ['sort' => 'price_high'])) }}" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="{{ route('shop', array_merge(request()->except('sort', 'page'), ['sort' => 'popular'])) }}" {{ request('sort') === 'popular' ? 'selected' : '' }}>Popular</option>
                    </select>
                </div>
            </div>

            @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-10">{{ $products->links() }}</div>
            @else
                <div class="text-center py-20 bg-white rounded-xl border border-[var(--color-border)]">
                    <svg class="w-16 h-16 mx-auto text-[var(--color-border)] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <h3 class="font-serif text-xl text-[var(--color-dark)] mb-2">No shirts found</h3>
                    <p class="text-[var(--color-muted)] text-sm mb-6">Try adjusting your filters or browse our full collection.</p>
                    <a href="{{ route('shop') }}" class="inline-flex px-6 py-2.5 bg-[var(--color-dark)] text-white text-sm font-medium rounded-lg hover:bg-[var(--color-dark-light)] transition-colors">View All Shirts</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
