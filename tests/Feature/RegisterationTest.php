<?php
// tests/Feature/RegisterUserTest.php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function it_can_register_a_new_user()
    {
        // Define registration data
        $data = [
            'name' => 'ali',
            'email' => 'akherati@gmail.com',
            'bio' => 'bio',
            'phoneNumber' => '09157982447',
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
    }

    /** @test */
    public function it_fails_with_invalid_data()
    {
        // Define invalid registration data
        $data = [
            'email' => 'akherati@gmail.com',
            'bio' => 'bio',
            'phoneNumber' => '09157982447',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        // Make a POST request to the API endpoint
        $response = $this->postJson('/api/register', $data);

        // Assert the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert validation errors are returned
        $response->assertJsonValidationErrors(['name']);
    }
}

