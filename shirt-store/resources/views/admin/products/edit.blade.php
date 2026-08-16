@extends('layouts.admin')
@section('page_title', 'Edit Product')
@section('title', 'Edit ' . $product->name . ' — Admin')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-sm text-[var(--color-muted)] hover:text-[var(--color-dark)] mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Products
    </a>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="productForm()">
        @csrf @method('PUT')

        <div class="bg-white rounded-xl border border-[var(--color-border)] p-6 space-y-4">
            <h2 class="font-sans text-lg font-semibold text-[var(--color-dark)]">Basic Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Category *</label>
                    <select name="category_id" required class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm bg-white">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm">
                    @error('sku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Price *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Sale Price</label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Material</label>
                    <input type="text" name="material" value="{{ old('material', $product->material) }}" class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Short Description</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm">{{ old('description', $product->description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Product Image</label>
                    @if($product->image)
                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-[var(--color-surface-alt)] mb-2">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-[var(--color-muted)] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[var(--color-surface-alt)]">
                </div>
                <div class="flex items-center gap-6 pt-4">
                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }} class="rounded"> Active</label>
                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} class="rounded"> Featured</label>
                </div>
            </div>
        </div>

        {{-- Variants --}}
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-sans text-lg font-semibold text-[var(--color-dark)]">Variants</h2>
                <button type="button" @click="addVariant()" class="text-sm text-[var(--color-brand-500)] font-medium hover:underline">+ Add Variant</button>
            </div>
            <template x-for="(variant, index) in variants" :key="index">
                <div class="grid grid-cols-4 gap-3 mb-3 items-end">
                    <div>
                        <label class="block text-xs font-medium mb-1" x-show="index === 0">Size</label>
                        <select :name="'variants['+index+'][size]'" x-model="variant.size" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm bg-white">
                            @foreach($sizes as $s)<option value="{{ $s }}">{{ $s }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1" x-show="index === 0">Color</label>
                        <select :name="'variants['+index+'][color]'" x-model="variant.color" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm bg-white">
                            @foreach($colors as $c)<option value="{{ $c }}">{{ $c }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1" x-show="index === 0">Stock</label>
                        <input type="number" :name="'variants['+index+'][stock]'" x-model="variant.stock" min="0" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm">
                    </div>
                    <div>
                        <button type="button" @click="removeVariant(index)" class="px-3 py-2 text-red-500 hover:bg-red-50 rounded-lg text-sm" x-show="variants.length > 1">✕</button>
                    </div>
                </div>
            </template>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-8 py-3 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)]">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="px-8 py-3 border border-[var(--color-border)] text-[var(--color-muted)] text-sm font-medium rounded-lg hover:bg-[var(--color-surface-alt)]">Cancel</a>
        </div>
    </form>
</div>

<script>
function productForm() {
    return {
        variants: @json($product->variants->map(fn ($v) => ['size' => $v->size, 'color' => $v->color, 'stock' => $v->stock])),
        addVariant() { this.variants.push({ size: 'M', color: 'White', stock: 10 }); },
        removeVariant(index) { this.variants.splice(index, 1); }
    };
}
</script>
@endsection
