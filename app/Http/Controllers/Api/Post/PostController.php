<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostReqeust;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\Post\PostGetAllPostsWithUserAndComments;
use App\Services\Post\PostCreate;
use App\Services\Post\PostDelete;
use App\Services\Post\PostGetById;
use App\Services\Post\PostGetCommnetsWithReplies;
use App\Services\Post\PostUpdate;

class PostController extends Controller
{
    protected $postService;
    protected $postCreate;
    protected $postUpdate;
    protected $postDelete;
    protected $postGetAllPostsWithUserAndComments;
    protected $postGetById;


    public function __construct(
        PostCreate $postCreate,
        PostUpdate $postUpdate,
        PostDelete $postDelete,
        PostGetAllPostsWithUserAndComments $postGetAllPostsWithUserAndComments,
        PostGetById $postGetById,
    ) {
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
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $this->postUpdate->updatePost($request, $post);
        return response()->json(['post updated! ']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = $this->postDelete->deletePost($id);
        return response()->json(['post deleted ' . $delete]);
    }

}
