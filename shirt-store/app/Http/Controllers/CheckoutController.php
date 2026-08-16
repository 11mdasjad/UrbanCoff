<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService
    ) {}

    public function index()
    {
        $cartData = $this->cartService->getTotals();

        if ($cartData['items']->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $user = Auth::user();
        $addresses = $user->addresses;
        $defaultAddress = $user->defaultAddress();

        return view('checkout.index', compact('cartData', 'user', 'addresses', 'defaultAddress'));
    }

    public function store(CheckoutRequest $request)
    {
        try {
            $order = $this->orderService->createOrder($request->validated());

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully! Your order number is ' . $order->order_number);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
