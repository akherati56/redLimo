<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Comment;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->hasPosts(10, function (array $attributes, User $user) {
                return ['user_id' => $user->id];
            })
            ->create()
            ->each(function ($user) {
                $user->posts->each(function ($post) {
                    $post->comments()
                        ->saveMany(
                            \App\Models\Comment::factory()
                                ->count(4)
                                ->withReplies() // Create comments with replies
                                ->make()
                        );
                });
            });

    }
}
