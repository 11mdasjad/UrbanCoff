<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    public function index()
    {
        $cartData = $this->cartService->getTotals();
        return view('cart.index', $cartData);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        try {
            $this->cartService->add(
                $request->product_id,
                $request->variant_id,
                $request->quantity
            );

            return back()->with('success', 'Item added to cart!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:10',
        ]);

        try {
            $this->cartService->update($cartItem, $request->quantity);
            return back()->with('success', 'Cart updated.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove(CartItem $cartItem)
    {
        $this->cartService->remove($cartItem);
        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $this->cartService->clear();
        return back()->with('success', 'Cart cleared.');
    }
}
