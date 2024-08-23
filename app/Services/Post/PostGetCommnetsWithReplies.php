<?php

namespace App\Services\Post;
use App\Models\Post;
use App\Services\PostService;

class PostGetCommnetsWithReplies extends PostService
{
    public function getcomments($id)
    {
        $post = Post::find($id);

        $comments = $post->comments()
            ->whereNull('parent_id') // Only top-level comments
            ->orderBy('created_at', 'desc') // Order by creation date
            ->paginate(10); // Paginate comments

        // Manually fetch replies for each top-level comment
        foreach ($comments as $comment) {
            $comment->replies = $comment->replies()
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return response()->json([
            'post' => $post,
            'comments' => $comments
        ]);

    }

}
