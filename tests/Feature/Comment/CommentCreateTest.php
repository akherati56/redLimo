<?php
use App\Models\User;

test('create comment', function () {
    $user = User::factory()->create();

    $token = $user->createToken('Personal Access Token')->accessToken;

    $data = [
        'parent_id' => '1',
        'text' => 'text',
        'post_id' => '1'
    ];

    $response = $this->withHeaders([
        'Authorization' => "Bearer $token",
    ])->postJson('/api/comments', $data);

    $response->assertSee('parent_id');
});
