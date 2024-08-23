<?php
use App\Models\User;

test('get posts of user', function () {

    $user = User::factory()->create();

    $token = $user->createToken('Personal Access Token')->accessToken;

    $response = $this->withHeaders([
        'Authorization' => "Bearer $token",
    ])->get('/api/user/posts');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data',
        ]);
});





