<?php
use App\Models\User;

test('update profile', function () {
    $user = User::factory()->create();

    $token = $user->createToken('Personal Access Token')->accessToken;

    $updateData = [
        'name' => 'name2',
        'bio' => 'bio2',
        'email' => 'email@gmail.com',
    ];

    $response = $this->withHeaders([
        'Authorization' => "Bearer $token",
    ])->patchJson('/api/profile/update', $updateData);

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
