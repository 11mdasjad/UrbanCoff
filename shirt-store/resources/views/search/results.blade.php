@extends('layouts.app')
@section('title', 'Search Results — URBANCOFF')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8">
        <h1 class="text-2xl font-serif font-bold text-[var(--color-dark)]">Search Results</h1>
        @if($query)<p class="text-sm text-[var(--color-muted)] mt-1">Showing results for "<strong>{{ $query }}</strong>"</p>@endif
    </div>

    <form action="{{ route('search') }}" method="GET" class="mb-8 flex max-w-xl">
        <input type="text" name="q" value="{{ $query }}" placeholder="Search shirts..." class="flex-1 px-4 py-2.5 border border-[var(--color-border)] rounded-l-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]">
        <button type="submit" class="px-6 py-2.5 bg-[var(--color-dark)] text-white text-sm font-medium rounded-r-lg hover:bg-[var(--color-dark-light)]">Search</button>
    </form>

    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->count())
        <p class="text-sm text-[var(--color-muted)] mb-6">{{ $products->total() }} {{ Str::plural('result', $products->total()) }} found</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="mt-10">{{ $products->links() }}</div>
    @elseif($query)
        <div class="text-center py-16 bg-white rounded-xl border border-[var(--color-border)]">
            <svg class="w-16 h-16 mx-auto text-[var(--color-border)] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <h2 class="font-serif text-xl text-[var(--color-dark)] mb-2">No shirts found</h2>
            <p class="text-[var(--color-muted)] text-sm mb-6">Try a different search term.</p>
            <a href="{{ route('shop') }}" class="inline-flex px-6 py-2.5 bg-[var(--color-dark)] text-white text-sm font-medium rounded-lg">Browse All Shirts</a>
        </div>
    @endif
</div>
@endsection
