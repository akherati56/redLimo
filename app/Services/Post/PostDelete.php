<?php

namespace App\Services;
use App\Models\Post;
use Auth;

class PostDelete extends PostService
{
    public function deletePost($id)
    {
        $post = Post::findOrFail($id);

        dd(Auth::user()->can('delete', $post));

        $post->delete();
        return $post;
    }
}
