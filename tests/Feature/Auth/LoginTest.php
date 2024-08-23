<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_and_receive_api_token()
    {
        $phoneNumber = '09157982447';

        // Define registration data
        $data = [
            'name' => 'ali',
            'email' => 'akherati@gmail.com',
            'bio' => 'bio',
            'phoneNumber' => $phoneNumber,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        // Make a POST request to the API endpoint
        $response = $this->postJson('/api/register', $data);

        // Assert the response status is 201 Created
        $response->assertStatus(200);

        // Assert that the user is in the database
        $this->assertDatabaseHas('users', [
            'email' => 'akherati@gmail.com',
        ]);

        $otp = Redis::get('otp:' . $phoneNumber);

        // Perform the login request
        $response = $this->postJson('/api/login', [
            'phoneNumber' => $phoneNumber,
            'otp' => $otp,
        ]);

        // Assert that the login is successful and returns an API token
        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);
    }
}
