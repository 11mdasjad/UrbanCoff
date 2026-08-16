@extends('layouts.admin')
@section('page_title', 'Products')
@section('title', 'Products — Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="px-4 py-2 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] w-64">
            <select name="category" onchange="this.form.submit()" class="px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm bg-white">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-5 py-2.5 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)]">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Product
        </a>
    </div>

    <div class="bg-white rounded-xl border border-[var(--color-border)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[var(--color-surface-alt)] text-left">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Product</th>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Category</th>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Price</th>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Stock</th>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Status</th>
                        <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-border)]">
                    @forelse($products as $product)
                    <tr class="hover:bg-[var(--color-surface-alt)] transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-[var(--color-surface-alt)] shrink-0">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-medium text-[var(--color-dark)]">{{ Str::limit($product->name, 30) }}</p>
                                    <p class="text-xs text-[var(--color-muted)]">{{ $product->sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-[var(--color-muted)]">{{ $product->category->name }}</td>
                        <td class="px-4 py-3">
                            @if($product->is_on_sale)
                                <span class="font-medium">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="text-xs text-[var(--color-muted)] line-through ml-1">${{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="font-medium">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="{{ $product->total_stock > 10 ? 'text-green-600' : ($product->total_stock > 0 ? 'text-amber-600' : 'text-red-600') }} font-medium">
                                {{ $product->total_stock }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge-{{ $product->status ? 'success' : 'secondary' }} text-xs font-semibold px-2.5 py-1 rounded-full">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-[var(--color-brand-500)] hover:text-[var(--color-brand-700)] text-xs font-medium">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-12 text-center text-[var(--color-muted)]">No products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div>{{ $products->links() }}</div>
</div>
@endsection
