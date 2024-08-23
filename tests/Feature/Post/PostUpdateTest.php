<?php
use App\Models\Post;
use App\Models\User;

test('update post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'title' => 'title',
        'text' => 'text',
    ]);

    $token = $user->createToken('Personal Access Token')->accessToken;

    $updateData = [
        'title' => 'title',
        'text' => 'text',
    ];

    $response = $this->withHeaders([
        'Authorization' => "Bearer $token",
    ])->patchJson('/api/post/' . $post->id, $updateData);

    $response->assertSee('post updated!');
});
