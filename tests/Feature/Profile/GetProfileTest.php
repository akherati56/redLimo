<?php
use App\Models\User;

test('get profile', function () {
    $user = User::factory()->create();

    $token = $user->createToken('Personal Access Token')->accessToken;

    $response = $this->withHeaders([
        'Authorization' => "Bearer $token",
    ])->get('/api/profile');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'name',
                'email',
                'bio',
                'phoneNumber',
            ],
        ]);

});
