<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_a_guest_user_can_create_a_customer_account()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/v1/user/create', [
            'first_name' => 'James',
            'last_name' => 'Bond',
            'email' => 'james@bond.com',
            'address' => 'LA Atlanta, 504',
            'phone_number' => '0720123456',
            'is_marketing' => 0,
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ]);

        $user = User::first();
        $userCount = User::all();

        // Assertions
        $this->assertCount(1, $userCount);
        $this->assertNotNull($user->uuid);
        $this->assertEquals('James', $user->first_name);
        $this->assertEquals('Bond', $user->last_name);
        $this->assertEquals('james@bond.com', $user->email);
        $this->assertEquals('LA Atlanta, 504', $user->address);
        $this->assertEquals('0720123456', $user->phone_number);
        $this->assertEquals(0, $user->is_marketing);

        $response->assertStatus(201)
            ->assertJson([
                'success' => 1,
                'data' => [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'address' => $user->address,
                    'is_marketing' => $user->is_marketing,
                    'avatar' => $user->avatar,
                    'created_at' => ($user->created_at)->toDateTimeString(),
                    'updated_at' => ($user->updated_at)->toDateTimeString(),
                ],
            ]);
    }


    public function test_a_user_with_customer_account_can_login()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create(['email'=>'james@bond.com']);

        $response = $this->post('/api/v1/user/login', [
            'email' => 'james@bond.com',
            'password' => 'password',
        ])->assertOk();

        $response->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
        ]);

    }
}
