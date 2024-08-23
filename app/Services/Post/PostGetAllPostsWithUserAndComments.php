<?php

namespace App\Services\Post;
use App\Models\Post;
use App\Services\PostService;

class PostGetAllPostsWithUserAndComments extends PostService
{
    public function getAllPosts()
    {
        $posts = Post::orderBy('created_at', 'desc')->with([
            'user', // Eager load the user who created the post
            'comments' => function ($query) {
                $query->take(2) // Limit the comments to 2 per post
                    ->with('user'); // Eager load the user who made the comment
            }
        ])->paginate(10);

        return $posts;
    }
}
