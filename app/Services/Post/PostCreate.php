<?php

namespace App\Services;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostCreate extends PostService
{
    public function createPost(StorePostRequest $request)
    {

        $id = $request->user()->id;
        $validated = $request->validated();

        $post = Post::create([
            'title' => $validated['title'],
            'text' => $validated['text'],
            'user_id' => $id,
        ]); 

        return $post
    }
}
