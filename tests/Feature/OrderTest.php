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
            'address' => [
                'billing' => 'West Grove',
                'shipping' => 'Amsterdam, West Grove, 412'
            ],
            'products' => [
                [
                    'uuid' => $product1->uuid,
                    'quantity' => 5,
                ],
                [
                'uuid' => $product2->uuid,
                'quantity' => 8,
                ],
            ]
        ]);

        $order_count = Order::all();
        $order = Order::first();

        // Assertions
        $this->assertCount(1, $order_count);
        $this->assertNotNull($order->uuid);
        $this->assertEquals($order->user_id, $user->id);
        $this->assertEquals($order->order_status_id, $order_status->id);
        $this->assertEquals($order->payment_id, $payment->id);
        $this->assertNotNull($order->address);
        $this->assertNotNull($order->amount);
        $this->assertNotNull($order->delivery_fee);

        $response->assertStatus(201)
        ->assertJson([
            'data' => [
                    'uuid' => $order->uuid,
            ],
            'error' => null,
            'errors' => [],
            'extra' => []
        ]);
    }


    /** FIELD VALIDATIONS */
    public function test_payment_uuid_required_when_creating_order()
    {
        $user = User::factory()->create();

        // Authenticate user
        $this->actingAs($user);

        // Test end point | register
        $response = $this->post('/api/v1/order/create', [
            'payment_uuid' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('payment_uuid', $responseString['errors']['meta']);
    }

    public function test_order_status_uuid_required_when_creating_order()
    {
        $user = User::factory()->create();

        // Authenticate user
        $this->actingAs($user);
        
        // Test end point | register
        $response = $this->post('/api/v1/order/create', [
            'order_status_uuid' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('order_status_uuid', $responseString['errors']['meta']);
    }

    public function test_address_required_when_creating_order()
    {
        $user = User::factory()->create();

        // Authenticate user
        $this->actingAs($user);
        
        // Test end point | register
        $response = $this->post('/api/v1/order/create', [
            'address' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('address', $responseString['errors']['meta']);
    }

    public function test_products_required_when_creating_order()
    {
        $user = User::factory()->create();

        // Authenticate user
        $this->actingAs($user);
        
        // Test end point | register
        $response = $this->post('/api/v1/order/create', [
            'products' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('products', $responseString['errors']['meta']);
    }
}
