<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
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

        return PostResource::collection($posts)->additional([
            'meta' => [
                'current_page' => $posts->currentPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'total_pages' => $posts->lastPage(),
            ]
        ]);
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
