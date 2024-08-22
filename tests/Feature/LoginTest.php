<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

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

        dd($response);

        // Assert that the login is successful and returns an API token
        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);

        // Extract the token from the response
        $token = $response->json('token');

        // Use the token to authenticate a subsequent request
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->get('/api/post');

        // Assert that the authenticated request is successful
        // $response->assertStatus(200)
        //     ->assertJson([
        //         'email' => $user->email,
        //     ]);
    }
}
