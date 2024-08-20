<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $postService;


    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }


    public function post(StorePostRequest $request)
    {
        $post = $this->postService->createPost($request);

        return response()->json($post, 201);
    }

    public function show(Post $request)
    {
        $posts = $this->postService->getAllPosts();
        return response()->json($posts);

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
