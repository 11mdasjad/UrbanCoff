<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderInvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_order_invoice(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-2026-000003',
            'status' => 'confirmed',
            'subtotal' => 120.00,
            'shipping_cost' => 0.00,
            'total' => 120.00,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'name' => 'Customer',
            'email' => $customer->email,
            'phone' => '1234567890',
            'address_line_1' => '456 Elm St',
            'city' => 'Los Angeles',
            'state' => 'CA',
            'postal_code' => '90001',
            'country' => 'United States',
        ]);

        $response = $this->actingAs($admin)->get("/admin/orders/{$order->id}/invoice");
        $response->assertStatus(200);
        $response->assertSee('INVOICE');
        $response->assertSee($order->order_number);
        $response->assertSee('URBANCOFF');
    }

    public function test_customer_cannot_view_admin_invoice(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-2026-000004',
            'status' => 'pending',
            'subtotal' => 50.00,
            'shipping_cost' => 0.00,
            'total' => 50.00,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'name' => 'User',
            'email' => $customer->email,
            'phone' => '1234567890',
            'address_line_1' => '123 Main St',
            'city' => 'New York',
            'state' => 'NY',
            'postal_code' => '10001',
            'country' => 'United States',
        ]);

        $response = $this->actingAs($customer)->get("/admin/orders/{$order->id}/invoice");
        $response->assertStatus(403);
    }
}
