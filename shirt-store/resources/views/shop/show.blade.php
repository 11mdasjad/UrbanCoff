@extends('layouts.app')
@section('title', $product->name . ' — URBANCOFF')
@section('meta_description', $product->short_description ?? Str::limit($product->description, 160))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    {{-- Breadcrumb --}}
    <nav class="mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-[var(--color-muted)] hover:text-[var(--color-dark)]">Home</a>
        <span class="mx-2 text-[var(--color-muted)]">/</span>
        <a href="{{ route('shop') }}" class="text-[var(--color-muted)] hover:text-[var(--color-dark)]">Shop</a>
        <span class="mx-2 text-[var(--color-muted)]">/</span>
        <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="text-[var(--color-muted)] hover:text-[var(--color-dark)]">{{ $product->category->name }}</a>
        <span class="mx-2 text-[var(--color-muted)]">/</span>
        <span class="text-[var(--color-dark)] font-medium">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16" x-data="productPage()">
        {{-- Product Images --}}
        <div class="space-y-4">
            <div class="aspect-[3/4] rounded-xl overflow-hidden bg-[var(--color-surface-alt)]">
                <img :src="mainImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </div>
            @if($product->images->count())
            <div class="grid grid-cols-4 gap-3">
                <button @click="mainImage = '{{ $product->image_url }}'" class="aspect-square rounded-lg overflow-hidden bg-[var(--color-surface-alt)] border-2 transition-colors" :class="mainImage === '{{ $product->image_url }}' ? 'border-[var(--color-dark)]' : 'border-transparent hover:border-[var(--color-border)]'">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </button>
                @foreach($product->images as $img)
                <button @click="mainImage = '{{ $img->url }}'" class="aspect-square rounded-lg overflow-hidden bg-[var(--color-surface-alt)] border-2 transition-colors" :class="mainImage === '{{ $img->url }}' ? 'border-[var(--color-dark)]' : 'border-transparent hover:border-[var(--color-border)]'">
                    <img src="{{ $img->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div>
            <p class="text-[var(--color-brand-500)] text-xs font-semibold uppercase tracking-[0.15em] mb-2">{{ $product->category->name }}</p>
            <h1 class="text-2xl lg:text-3xl font-serif font-bold text-[var(--color-dark)] mb-4">{{ $product->name }}</h1>

            {{-- Price --}}
            <div class="flex items-center gap-3 mb-6">
                @if($product->is_on_sale)
                    <span class="text-2xl font-bold text-[var(--color-dark)]">₹{{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-lg text-[var(--color-muted)] line-through">₹{{ number_format($product->price, 2) }}</span>
                    <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">-{{ $product->discount_percent }}% OFF</span>
                @else
                    <span class="text-2xl font-bold text-[var(--color-dark)]">₹{{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <p class="text-[var(--color-muted)] text-sm leading-relaxed mb-8">{{ $product->short_description }}</p>

            <form action="{{ route('cart.add') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant_id" x-model="selectedVariantId">

                {{-- Color Selection --}}
                <div>
                    <label class="block text-sm font-semibold text-[var(--color-dark)] mb-3">Color: <span class="font-normal text-[var(--color-muted)]" x-text="selectedColor"></span></label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($product->available_colors as $color)
                            <button type="button" @click="selectColor('{{ $color }}')"
                                class="color-swatch w-10 h-10 rounded-full" :class="selectedColor === '{{ $color }}' ? 'selected' : ''"
                                style="background-color: {{ match(strtolower($color)) { 'white' => '#ffffff', 'black' => '#1a1a1a', 'blue' => '#3b82f6', 'navy' => '#1e3a5f', 'grey' => '#9ca3af', 'green' => '#16a34a', 'beige' => '#d4b896', 'brown' => '#8b5e3c', default => '#e5e7eb' } }}; border: 1px solid #e5e7eb;"
                                title="{{ $color }}">
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Size Selection --}}
                <div>
                    <label class="block text-sm font-semibold text-[var(--color-dark)] mb-3">Size: <span class="font-normal text-[var(--color-muted)]" x-text="selectedSize || 'Select a size'"></span></label>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="size in ['XS', 'S', 'M', 'L', 'XL', 'XXL']" :key="size">
                            <button type="button" 
                                @click="isSizeInStock(size) ? selectSize(size) : null"
                                :class="{
                                    'selected': selectedSize === size,
                                    'out-of-stock': !isSizeInStock(size)
                                }"
                                class="size-option w-14 h-10 flex items-center justify-center text-sm font-medium border border-[var(--color-border)] rounded-lg"
                                :disabled="!isSizeInStock(size)"
                                x-text="size">
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Stock Info --}}
                <div x-show="selectedVariantId">
                    <p class="text-sm" :class="currentStock > 5 ? 'text-green-600' : (currentStock > 0 ? 'text-amber-600' : 'text-red-600')">
                        <span x-show="currentStock > 5">✓ In Stock</span>
                        <span x-show="currentStock > 0 && currentStock <= 5">⚠ Only <span x-text="currentStock"></span> left</span>
                        <span x-show="currentStock <= 0">✕ Out of Stock</span>
                    </p>
                </div>

                {{-- Quantity --}}
                <div>
                    <label class="block text-sm font-semibold text-[var(--color-dark)] mb-3">Quantity</label>
                    <div class="flex items-center border border-[var(--color-border)] rounded-lg w-fit">
                        <button type="button" @click="quantity > 1 ? quantity-- : null" class="px-4 py-2.5 text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                        </button>
                        <input type="number" name="quantity" x-model="quantity" min="1" :max="currentStock" class="w-16 text-center text-sm font-medium border-x border-[var(--color-border)] py-2.5 focus:outline-none">
                        <button type="button" @click="quantity < currentStock ? quantity++ : null" class="px-4 py-2.5 text-[var(--color-muted)] hover:text-[var(--color-dark)] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit" :disabled="!selectedVariantId || currentStock <= 0"
                        class="flex-1 py-3.5 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)] transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                        Add to Cart
                    </button>
                </div>

                @if($errors->any())
                    <div class="text-red-500 text-sm">{{ $errors->first() }}</div>
                @endif
            </form>

            {{-- Product Details --}}
            <div class="mt-10 pt-8 border-t border-[var(--color-border)] space-y-6">
                <div>
                    <h3 class="font-sans text-sm font-semibold text-[var(--color-dark)] mb-2">Description</h3>
                    <p class="text-sm text-[var(--color-muted)] leading-relaxed">{{ $product->description }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    @if($product->material)
                    <div>
                        <span class="text-[var(--color-muted)]">Material</span>
                        <p class="font-medium text-[var(--color-dark)]">{{ $product->material }}</p>
                    </div>
                    @endif
                    @if($product->brand)
                    <div>
                        <span class="text-[var(--color-muted)]">Brand</span>
                        <p class="font-medium text-[var(--color-dark)]">{{ $product->brand }}</p>
                    </div>
                    @endif
                    <div>
                        <span class="text-[var(--color-muted)]">SKU</span>
                        <p class="font-medium text-[var(--color-dark)]">{{ $product->sku }}</p>
                    </div>
                    <div>
                        <span class="text-[var(--color-muted)]">Category</span>
                        <p class="font-medium text-[var(--color-dark)]">{{ $product->category->name }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                    <div class="flex items-center gap-3 p-3 bg-[var(--color-surface-alt)] rounded-lg">
                        <svg class="w-5 h-5 text-[var(--color-brand-500)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <div><p class="text-xs font-medium text-[var(--color-dark)]">Fast Shipping</p><p class="text-[10px] text-[var(--color-muted)]">2–5 business days</p></div>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-[var(--color-surface-alt)] rounded-lg">
                        <svg class="w-5 h-5 text-[var(--color-brand-500)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <div><p class="text-xs font-medium text-[var(--color-dark)]">Easy Returns</p><p class="text-[10px] text-[var(--color-muted)]">30-day returns</p></div>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-[var(--color-surface-alt)] rounded-lg">
                        <svg class="w-5 h-5 text-[var(--color-brand-500)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <div><p class="text-xs font-medium text-[var(--color-dark)]">Secure Payment</p><p class="text-[10px] text-[var(--color-muted)]">SSL encrypted</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Shirts --}}
    @if($relatedProducts->count())
    <section class="mt-20">
        <h2 class="text-2xl font-serif font-bold text-[var(--color-dark)] mb-8">You May Also Like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
                @include('components.product-card', ['product' => $related])
            @endforeach
        </div>
    </section>
    @endif
</div>

<script>
function productPage() {
    const variants = @json($product->variants);
    const availableColors = @json($product->available_colors);
    
    // Find initial available variant
    const firstInStock = variants.find(v => v.stock > 0) || variants[0];
    const initialColor = firstInStock ? firstInStock.color : (availableColors[0] || '');
    const initialSize = firstInStock ? firstInStock.size : '';
    const initialVariantId = firstInStock ? firstInStock.id : null;
    const initialStock = firstInStock ? firstInStock.stock : 0;

    return {
        mainImage: '{{ $product->image_url }}',
        selectedColor: initialColor,
        selectedSize: initialSize,
        selectedVariantId: initialVariantId,
        currentStock: initialStock,
        quantity: 1,
        isSizeInStock(size) {
            return variants.some(v => v.color === this.selectedColor && v.size === size && v.stock > 0);
        },
        selectColor(color) {
            this.selectedColor = color;
            if (!this.isSizeInStock(this.selectedSize)) {
                const availableForColor = variants.find(v => v.color === color && v.stock > 0);
                if (availableForColor) {
                    this.selectedSize = availableForColor.size;
                }
            }
            this.updateVariant();
        },
        selectSize(size) {
            this.selectedSize = size;
            this.updateVariant();
        },
        updateVariant() {
            if (this.selectedColor && this.selectedSize) {
                const variant = variants.find(v => v.color === this.selectedColor && v.size === this.selectedSize);
                if (variant) {
                    this.selectedVariantId = variant.id;
                    this.currentStock = variant.stock;
                    if (this.quantity > variant.stock) this.quantity = Math.max(1, variant.stock);
                } else {
                    this.selectedVariantId = null;
                    this.currentStock = 0;
                }
            }
        }
    };
}
</script>
@endsection
