<?php

namespace App\Interface;
use App\Models\Post;

class EloquentPostRepository implements PostRepositoryInterface
{
    public function getAll(array $with = [])
    {
        return Post::with($with)->get();
    }

    public function getById($id, array $with = [])
    {
        return Post::with($with)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function update($id, array $data)
    {
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        return $post->delete();
    }
}
