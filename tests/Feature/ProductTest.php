<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_user_can_view_a_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        //Endpoint to be tested
        $response = $this->get('/api/v1/product/' . $product->uuid);

        $this->assertNotNull($product->title);
        $this->assertNotNull($product->slug);
        $this->assertNotNull($product->price);
        $this->assertNotNull($product->description);
        $this->assertNotNull($product->category_id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => 1,
                'data' => [
                        'uuid' => $product->uuid,
                        'title' => $product->title,
                        'slug' => $product->slug,
                        'price' => $product->price,
                        'category_uuid' => $product->category_uuid,
                        'description' => $product->description,
                        'created_at' => ($product->created_at)->toDateTimeString(),
                        'updated_at' => ($product->updated_at)->toDateTimeString()
                ],
                'error' => null,
                'errors' => [],
                'extra' => []
            ]);
    }

    public function test_guest_user_can_view_products()
    {
        $this->withoutExceptionHandling();

        $category = Category::factory()->create();
        $products = Product::factory(2)->create(['category_id' => $category->id]);

        //Endpoint to be tested
        $response = $this->get('/api/v1/products');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $products->first()->uuid,
                        'title' => $products->first()->title,
                        'slug' => $products->first()->slug,
                        'created_at' => ($products->first()->created_at)->toDateTimeString(),
                        'updated_at' => ($products->first()->updated_at)->toDateTimeString()
                    ],
                    [
                        'uuid' => $products->last()->uuid,
                        'title' => $products->last()->title,
                        'slug' => $products->last()->slug,
                        'created_at' => ($products->last()->created_at)->toDateTimeString(),
                        'updated_at' => ($products->first()->updated_at)->toDateTimeString()
                    ],
                ]
            ]);
    }
}
