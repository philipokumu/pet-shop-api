<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_an_order()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        // Authenticate user
        $this->actingAs($user);

        //Create category
        $category = Category::factory()->create();
        
        // Create 2 products
        $product1 = Product::factory()->create(['category_id' => $category->id]);
        $product2 = Product::factory()->create(['category_id' => $category->id]);

        // Create a payment
        $payment = Payment::factory()->create();

        // Create an order status
        $order_status = OrderStatus::factory()->create();

        //Endpoint to be tested
        $response = $this->post('/api/v1/order/create', [
            'order_status_uuid' => $order_status->uuid,
            'payment_uuid' => $payment->uuid,
            'address' => 'Amsterdam, West Grove, 412',
            'products' => [
                [
                    'product_uuid' => $product1->uuid,
                    'quantity' => 5,
                ],
                [
                    'product_uuid' => $product2->uuid,
                    'quantity' => 8,
                ],
            ],
        ]);

        $order_count = Order::all();
        $order = Order::first();

        // Assertions
        $this->assertCount(1, $order_count);
        $this->assertNotNull($order->uuid);
        $this->assertEquals($order->user_id, $user->id);
        $this->assertEquals($order->order_status_id, $order_status->id);
        $this->assertEquals($order->payment_id, $payment->id);
        $this->assertEquals($order->address, 'Amsterdam, West Grove, 412');
        $this->assertNotNull($order->amount);
        $this->assertNotNull($order->delivery_fee);

        $response->assertStatus(201)
        ->assertJson([
            'data' => [
                    'uuid' => $order->uuid,
                    'amount' => $order->amount,
                    'delivery_fee' => $order->delivery_fee,
                    'products' => $order->products,
                    'created_at' => ($order->created_at)->toDateTimeString(),
                    'updated_at' => ($order->updated_at)->toDateTimeString()
            ],
            'error' => null,
            'errors' => [],
            'extra' => []
        ]);
    }
}
