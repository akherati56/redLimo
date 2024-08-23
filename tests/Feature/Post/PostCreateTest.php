<?php
use App\Models\User;

test('create post', function () {
    $user = User::factory()->create();

    $token = $user->createToken('Personal Access Token')->accessToken;

    $data = [
        'title' => 'title',
        'text' => 'text',
    ];

    $response = $this->withHeaders([
        'Authorization' => "Bearer $token",
    ])->postJson('/api/post', $data);

    $response->assertSee('post stored!');
});


