<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private CartService $cartService
    ) {}

    /**
     * Create a new order from the current cart.
     */
    public function createOrder(array $data): Order
    {
        $cartData = $this->cartService->getTotals();

        if ($cartData['items']->isEmpty()) {
            throw new \Exception('Your cart is empty.');
        }

        return DB::transaction(function () use ($data, $cartData) {
            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => Order::STATUS_PENDING,
                'subtotal' => $cartData['subtotal'],
                'shipping_cost' => $cartData['shipping'],
                'total' => $cartData['total'],
                'payment_method' => $data['payment_method'] ?? 'cod',
                'payment_status' => 'pending',
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address_line_1' => $data['address_line_1'],
                'address_line_2' => $data['address_line_2'] ?? null,
                'city' => $data['city'],
                'state' => $data['state'],
                'postal_code' => $data['postal_code'],
                'country' => $data['country'] ?? 'India',
                'notes' => $data['notes'] ?? null,
            ]);

            // Create order items and decrement stock
            foreach ($cartData['items'] as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'size' => $cartItem->variant->size,
                    'color' => $cartItem->variant->color,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->effective_price,
                    'total' => $cartItem->quantity * $cartItem->product->effective_price,
                ]);

                // Decrement variant stock
                $variant = ProductVariant::find($cartItem->variant_id);
                if (!$variant || !$variant->decrementStock($cartItem->quantity)) {
                    throw new \Exception("Insufficient stock for {$cartItem->product->name} ({$cartItem->variant->size}/{$cartItem->variant->color}).");
                }
            }

            // Clear the cart
            $this->cartService->clear();

            return $order->load('items');
        });
    }
}
