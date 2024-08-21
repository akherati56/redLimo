<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id', // parent_id is optional and must exist in comments table
            'text' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'post_id' => $validatedData['post_id'],
            'parent_id' => $validatedData['parent_id'] ?? null, // If parent_id is provided, it's a reply
            'text' => $validatedData['text'],
        ]);

        return response()->json([
            'message' => 'Comment added successfully!',
            'comment' => $comment
        ], 201);
    }

    public function show($id)
    {
        $post = Post::with([
            'comments' => function ($query) {
                $query->whereNull('parent_id')
                    ->with('replies');
            }
        ])->findOrFail($id);

        return response()->json($post);
    }

}
