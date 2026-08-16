{{-- Product Card Component --}}
<div class="product-card bg-white rounded-xl overflow-hidden border border-[var(--color-border)]">
    <a href="{{ route('products.show', $product->slug) }}" class="block relative overflow-hidden aspect-[3/4] bg-[var(--color-surface-alt)]">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image w-full h-full object-cover" loading="lazy">
        @if($product->is_on_sale)
            <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">-{{ $product->discount_percent }}%</span>
        @endif
        @if($product->featured)
            <span class="absolute top-3 right-3 bg-[var(--color-brand-500)] text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">Featured</span>
        @endif
    </a>
    <div class="p-4">
        <p class="text-[10px] font-semibold uppercase tracking-wider text-[var(--color-brand-500)] mb-1">{{ $product->category->name ?? '' }}</p>
        <h3 class="font-sans text-sm font-medium text-[var(--color-dark)] mb-2 line-clamp-2">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-[var(--color-brand-500)] transition-colors">{{ $product->name }}</a>
        </h3>
        <div class="flex items-center gap-2 mb-3">
            @if($product->is_on_sale)
                <span class="text-base font-bold text-[var(--color-dark)]">${{ number_format($product->sale_price, 2) }}</span>
                <span class="text-sm text-[var(--color-muted)] line-through">${{ number_format($product->price, 2) }}</span>
            @else
                <span class="text-base font-bold text-[var(--color-dark)]">${{ number_format($product->price, 2) }}</span>
            @endif
        </div>
        {{-- Available Colors --}}
        @if($product->available_colors)
        <div class="flex items-center gap-1.5">
            @foreach(array_slice($product->available_colors, 0, 5) as $color)
                <span class="w-4 h-4 rounded-full border border-gray-200" style="background-color: {{ match(strtolower($color)) {
                    'white' => '#ffffff',
                    'black' => '#1a1a1a',
                    'blue' => '#3b82f6',
                    'navy' => '#1e3a5f',
                    'grey' => '#9ca3af',
                    'green' => '#16a34a',
                    'beige' => '#d4b896',
                    'brown' => '#8b5e3c',
                    default => '#e5e7eb',
                } }}" title="{{ $color }}"></span>
            @endforeach
            @if(count($product->available_colors) > 5)
                <span class="text-xs text-[var(--color-muted)]">+{{ count($product->available_colors) - 5 }}</span>
            @endif
        </div>
        @endif
    </div>
</div>
