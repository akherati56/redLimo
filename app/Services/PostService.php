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
        ])->paginate(10);

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

