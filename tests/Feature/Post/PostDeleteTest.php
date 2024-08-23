<?php
use App\Models\Post;
use App\Models\User;

test('delete post', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id,
        'title' => 'title',
        'text' => 'text',
    ]);

    $token = $user->createToken('Personal Access Token')->accessToken;

    $data = [
        'title' => 'title',
        'text' => 'text',
    ];

    $response = $this->withHeaders([
        'Authorization' => "Bearer $token",
    ])->deleteJson('/api/post/' . $post->id, $data);

    $response->assertSee('Post deleted');

});


