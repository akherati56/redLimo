<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class LoginTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function user_can_login_and_receive_api_token()
    {
        $phoneNumber = '09157982447';
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
