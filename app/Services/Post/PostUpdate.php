<?php

namespace App\Services;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostUpdate extends PostService
{
    public function updatePost($id, StorePostRequest $request)
    {
        $validatedData = $request->validate();

        $post = Post::findOrFail($id);
        $post->update($validatedData);
        return $post;
    }
}
