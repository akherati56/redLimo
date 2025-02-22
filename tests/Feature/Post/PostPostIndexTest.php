<?php
use App\Models\User;

test('show post indexs', function () {
    $user = User::factory()->create();

    $token = $user->createToken('Personal Access Token')->accessToken;

    $response = $this->withHeaders([
        'Authorization' => "Bearer $token",
    ])->get('/api/post');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data',
        ]);
});


