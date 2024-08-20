<?php

namespace App\Services;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostService
{
    public function getAllPosts()
    {
        $posts = Post::orderBy('created_at', 'desc')->with([
            'comments' => function ($query) {
                $query->take(2);
            }
        ])->paginate(1);

        return $posts;
    }

    public function getPostById($id)
    {
        return Post::findOrFail($id);
    }

    public function createPost(StorePostRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate();

        return Post::create($validatedData);
    }

    public function updatePost($id, array $data)
    {
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return $post;
    }
}
