<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Models\Comment;
use App\Services\Comment\PostGetCommnetsWithReplies;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $postGetCommnetsWithReplies;

    public function __construct(
        PostGetCommnetsWithReplies $postGetCommnetsWithReplies,
    ) {
        $this->postGetCommnetsWithReplies = $postGetCommnetsWithReplies;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        return $this->postGetCommnetsWithReplies->getcomments($id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCommentRequest $request)
    {
        $id = $request->user()->id;
        $validated = $request->validated();

        $post = Comment::create([
            'text' => $validated['text'],
            'user_id' => $id,
            'post_id' => $validated['post_id'],
            'parent_id' => $validated['parent_id'],
        ]);

        return $post;
    }
}
