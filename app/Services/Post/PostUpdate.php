<?php

namespace App\Services\Post;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Services\PostService;

class PostUpdate extends PostService
{
    public function updatePost(StorePostRequest $request, Post $post)
    {
        $validate = $request->validated();

        $post->update([
            'title' => $validate['title'],
            'text' => $validate['text'],
        ]);
        return $post;
    }
}
