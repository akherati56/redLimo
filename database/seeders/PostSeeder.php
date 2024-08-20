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

        $user = User::factory()->create();

        $post = Post::create([
            'title' => 'title of post',
            'text' => 'some text',
            'user_id' => $user->id,
        ]);

        Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

    }
}
