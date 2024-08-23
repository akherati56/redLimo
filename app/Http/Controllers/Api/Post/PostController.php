<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostReqeust;
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
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $id = $request->user()->id;
        $validated = $request->validated();

        $post = Post::create([
            'title' => $validated['title'],
            'text' => $validated['text'],
            'user_id' => $id,
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
     * Update the specified resource in storage.
     */
    public function update(UpdatePostReqeust $request, Post $post)
    {
        $validate = $request->validated();

        $post->update([
            'title' => $validate['title'],
            'text' => $validate['text'],
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
