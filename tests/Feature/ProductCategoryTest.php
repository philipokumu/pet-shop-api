<?php

namespace Tests\Feature;

use App\Http\Resources\Pagination;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_user_can_view_a_product_category()
    {
        $this->withoutExceptionHandling();

        $category = Category::factory()->create();

        //Endpoint to be tested
        $response = $this->get('/api/v1/category/' . $category->uuid);

        $response->assertStatus(200)
            // ->assertJsonCount(2,'data')
            ->assertJson([
                'success' => 1,
                'data' => [
                        'uuid' => $category->uuid,
                        'title' => $category->title,
                        'slug' => $category->slug,
                        'created_at' => ($category->created_at)->toDateTimeString(),
                        'updated_at' => ($category->updated_at)->toDateTimeString()
                ],
                'error' => null,
                'errors' => [],
                'extra' => []
            ]);
    }

    public function test_guest_user_can_view_product_categories()
    {
        $this->withoutExceptionHandling();

        Category::factory(2)->create();

        //Endpoint to be tested
        $response = $this->get('/api/v1/categories');

        $categories = Category::paginate(10);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $categories->first()->uuid,
                        'title' => $categories->first()->title,
                        'slug' => $categories->first()->slug,
                        'created_at' => ($categories->first()->created_at)->toDateTimeString(),
                        'updated_at' => ($categories->first()->updated_at)->toDateTimeString()
                    ],
                    [
                        'uuid' => $categories->last()->uuid,
                        'title' => $categories->last()->title,
                        'slug' => $categories->last()->slug,
                        'created_at' => ($categories->last()->created_at)->toDateTimeString(),
                        'updated_at' => ($categories->first()->updated_at)->toDateTimeString()
                    ],
                ]
            ]);
    }
}
