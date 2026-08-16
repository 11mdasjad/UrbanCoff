<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * Get all cart items for the current user/session.
     */
    public function getItems()
    {
        $query = CartItem::with(['product', 'variant']);

        if (Auth::check()) {
            return $query->where('user_id', Auth::id())->get();
        }

        return $query->where('session_id', session()->getId())
            ->whereNull('user_id')
            ->get();
    }

    /**
     * Add a product variant to cart.
     */
    public function add(int $productId, int $variantId, int $quantity = 1): CartItem
    {
        $variant = ProductVariant::findOrFail($variantId);

        // Check stock
        if ($variant->stock < $quantity) {
            throw new \Exception("Only {$variant->stock} items available in stock.");
        }

        $conditions = [
            'product_id' => $productId,
            'variant_id' => $variantId,
        ];

        if (Auth::check()) {
            $conditions['user_id'] = Auth::id();
        } else {
            $conditions['session_id'] = session()->getId();
        }

        $cartItem = CartItem::where($conditions)->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $quantity;
            if ($newQty > $variant->stock) {
                throw new \Exception("Cannot add more. Only {$variant->stock} items available.");
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            $cartItem = CartItem::create(array_merge($conditions, [
                'quantity' => $quantity,
            ]));
        }

        return $cartItem->load(['product', 'variant']);
    }

    /**
     * Update cart item quantity.
     */
    public function update(CartItem $cartItem, int $quantity): CartItem
    {
        if ($quantity <= 0) {
            $cartItem->delete();
            return $cartItem;
        }

        $variant = $cartItem->variant;
        if ($quantity > $variant->stock) {
            throw new \Exception("Only {$variant->stock} items available in stock.");
        }

        $cartItem->update(['quantity' => $quantity]);
        return $cartItem;
    }

    /**
     * Remove a cart item.
     */
    public function remove(CartItem $cartItem): void
    {
        $cartItem->delete();
    }

    /**
     * Clear entire cart.
     */
    public function clear(): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            CartItem::where('session_id', session()->getId())
                ->whereNull('user_id')
                ->delete();
        }
    }

    /**
     * Get cart totals.
     */
    public function getTotals(): array
    {
        $items = $this->getItems();
        $subtotal = $items->sum(fn ($item) => $item->quantity * $item->product->effective_price);
        $shipping = $subtotal > 0 ? ($subtotal >= 100 ? 0 : 9.99) : 0;
        $total = $subtotal + $shipping;

        return [
            'items' => $items,
            'count' => $items->sum('quantity'),
            'subtotal' => round($subtotal, 2),
            'shipping' => round($shipping, 2),
            'total' => round($total, 2),
            'free_shipping' => $subtotal >= 100,
        ];
    }

    /**
     * Get cart item count.
     */
    public function count(): int
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())->sum('quantity');
        }

        return CartItem::where('session_id', session()->getId())
            ->whereNull('user_id')
            ->sum('quantity');
    }
}
