<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->sentence,
            'post_id' => \App\Models\Post::factory(), // Link to a Post
            'parent_id' => null,
            'user_id' => \App\Models\User::factory(),
        ];
    }

    public function withReplies($count = 4)
    {
        return $this->afterCreating(function (Comment $comment) use ($count) {
            \App\Models\Comment::factory()->count($count)->create([
                'parent_id' => $comment->id,
                'post_id' => $comment->post_id, // Ensure replies are linked to the same post
            ]);
        });
    }

}

