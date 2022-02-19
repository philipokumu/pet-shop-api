<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_a_guest_user_can_create_a_customer_account()
    {
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
        User::factory()->create(['email'=>'james@bond.com', 'password' => Hash::make('password')]);

        $response = $this->post('/api/v1/user/login', [
            'email' => 'james@bond.com',
            'password' => 'password',
        ])->assertOk();

        $response->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
        ]);

    }


    public function test_a_user_can_logout()
    {
        $user = User::factory()->create(['email'=>'james@bond.com', 'password' => Hash::make('password')]);

         // Authenticate user
        $this->actingAs($user);

        $response = $this->get('/api/v1/user/logout')->assertStatus(200);

        $response->assertStatus(200);
    }

    /** FIELD VALIDATIONS */

    /** New user register validation */
    public function test_first_name_required_during_user_register()
    {
        // Test end point | register
        $response = $this->post('/api/v1/user/create', [
            'first_name' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('first_name', $responseString['errors']['meta']);
    }

    public function test_last_name_required_during_user_register()
    {
        // Test end point | register
        $response = $this->post('/api/v1/user/create', [
            'last_name' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('last_name', $responseString['errors']['meta']);
    }

    public function test_email_required_during_user_register()
    {
        // Test end point | register
        $response = $this->post('/api/v1/user/create', [
            'email' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('email', $responseString['errors']['meta']);
    }

    public function test_password_required_during_user_register()
    {
        // Test end point | register
        $response = $this->post('/api/v1/user/create', [
            'password' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('password', $responseString['errors']['meta']);
    }

    public function test_password_confirmation_required_during_user_register()
    {
        // Test end point | register
        $response = $this->post('/api/v1/user/create', [
            'password_confirmation' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('password_confirmation', $responseString['errors']['meta']);
    }

    public function test_address_required_during_user_register()
    {
        // Test end point | register
        $response = $this->post('/api/v1/user/create', [
            'address' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('address', $responseString['errors']['meta']);
    }

    public function test_phone_number_required_during_user_register()
    {
        // Test end point | register
        $response = $this->post('/api/v1/user/create', [
            'phone_number' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('phone_number', $responseString['errors']['meta']);
    }


    public function test_password_is_confirmed_during_user_register()
    {
        // Test end point | register
        $response = $this->post('/api/v1/user/create', [
            'password' => '123456789',
            'password_confirmation' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('password', $responseString['errors']['meta']);
    }


    /** Authenticate user validation */
    public function test_email_required_during_user_login()
    {
        // Test end point | login
        $response = $this->post('/api/v1/user/login', [
            'email' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('email', $responseString['errors']['meta']);
    }

    public function test_password_required_during_user_login()
    {
        // Test end point | login
        $response = $this->post('/api/v1/user/login', [
            'password' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('password', $responseString['errors']['meta']);
    }
}
