<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = auth()->user()->comments()->create($validatedData);

        return response()->json($comment, 201);
    }

    public function show($id)
    {
        $comment = Comment::with('user', 'replies')->findOrFail($id);

        return response()->json($comment);
    }

}
