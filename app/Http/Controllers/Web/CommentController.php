<?php

namespace App\Http\Controllers\Web;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        dd($user);

        // dd($user);

        // dd($request);
        // $user = $request->user();
        // dd($user);

        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id', // parent_id is optional and must exist in comments table
            'text' => 'required|string|max:1000',

        ]);

        $comment = Comment::create([
            'post_id' => $validatedData['post_id'],
            'parent_id' => $validatedData['parent_id'] ?? null, // If parent_id is provided, it's a reply
            'text' => $validatedData['text'],
            'user_id' => $user->id,
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
