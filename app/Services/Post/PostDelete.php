<?php

namespace App\Services\Post;
use App\Models\Post;
use App\Services\PostService;
use Auth;

class PostDelete extends PostService
{
    public function deletePost($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::user()->can('delete', $post)) {
            $post->delete();
            return response()->json(['message' => 'Post deleted successfully.']);

        }
        return response()->json(['message' => 'You are not authorized to delete this post.'], 403);
    }
}
