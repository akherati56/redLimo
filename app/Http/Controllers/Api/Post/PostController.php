<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostReqeust;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostGetAllPostsWithUserAndComments;
use App\Services\PostCreate;
use App\Services\PostDelete;
use App\Services\PostGetById;
use App\Services\PostService;
use App\Services\PostUpdate;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $postService;
    protected $postCreate;
    protected $postUpdate;
    protected $postDelete;
    protected $postGetAllPostsWithUserAndComments;
    protected $postGetById;


    public function __construct(
        PostService $postService,
        PostCreate $postCreate,
        PostUpdate $postUpdate,
        PostDelete $postDelete,
        PostGetAllPostsWithUserAndComments $postGetAllPostsWithUserAndComments,
        PostGetById $postGetById
    ) {
        $this->postService = $postService;
        $this->postCreate = $postCreate;
        $this->postUpdate = $postUpdate;
        $this->postDelete = $postDelete;
        $this->postGetAllPostsWithUserAndComments = $postGetAllPostsWithUserAndComments;
        $this->postGetById = $postGetById;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Post $request)
    {
        $posts = $this->postGetAllPostsWithUserAndComments->getAllPosts();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $this->postCreate->createPost($request);
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
