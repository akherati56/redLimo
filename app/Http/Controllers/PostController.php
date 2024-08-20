<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function post(Request $request)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ]);

        // Create a new post
        $post = new Post;
        $post->title = $validatedData['title'];
        $post->body = $validatedData['text'];
        $post->user_id = auth()->id(); // Assuming the user is authenticated

        $post->save();

        return ['success! '];
    }

    public function show(Post $request)
    {
        $posts = Post::orderBy('created_at', 'desc')->with([
            'comments' => function ($query) {
                $query->take(2);
            }
        ])->paginate(10);

        return $posts;
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Return the edit view with the post data
        return view('posts.edit', compact('post'));
    }

    public function delete(Post $request)
    {

    }
}
