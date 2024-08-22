<?php
use App\Models\User;

test('home', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->withSession(['banned' => false])
        ->get('/api/post');

    $response->dd();
});
