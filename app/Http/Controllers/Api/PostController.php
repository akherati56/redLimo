<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $postService;


    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Post $request)
    {
        $posts = $this->postService->getAllPosts();

        // return PostResource::collection($posts)->additional([
        //     'meta' => [
        //         'current_page' => $posts->currentPage(),
        //         'per_page' => $posts->perPage(),
        //         'total' => $posts->total(),
        //         'total_pages' => $posts->lastPage(),
        //     ]
        // ]);


        // $posts = Post::orderBy('created_at', 'desc')->with([
        //     'user', // Eager load the user who created the post
        //     'comments' => function ($query) {
        //         $query->take(2) // Limit the comments to 2 per post
        //             ->with('user'); // Eager load the user who made the comment
        //     }
        // ])->paginate(10);

        return PostResource::collection($posts);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'text' => 'required|string|max:255',
        ];

        $post = Post::create([
            'title' => $request['title'],
            'text' => $request['text'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['post stored! ']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        $rules = [
            'title' => 'required|string|max:255',
            'text' => 'required|string|max:255',
        ];

        $post->update([
            'title' => $request['title'],
            'text' => $request['text'],
        ]);

        return response()->json(['post updated! ']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = $this->postService->deletePost($id);

        return response()->json(['post deleted ' . $delete]);
    }

    public function comments(string $id)
    {

        return $this->postService->getcomments($id);
    }
}
