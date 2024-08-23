<?php

namespace App\Services;

use App\Http\Requests\StorePostRequest;
use App\Interface\PostRepositoryInterface;
use App\Models\Post;

class PostService
{

    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function listPosts(array $with = [])
    {
        return $this->postRepository->getAll($with);
    }

    public function getPost($id, array $with = [])
    {
        return $this->postRepository->getById($id, $with);
    }

    public function getAllPosts()
    {
        $posts = Post::orderBy('created_at', 'desc')->with([
            'user', // Eager load the user who created the post
            'comments' => function ($query) {
                $query->take(2) // Limit the comments to 2 per post
                    ->with('user'); // Eager load the user who made the comment
            }
        ])->paginate(10);

        // dd($posts);

        return $posts;
    }

    public function getPostById($id)
    {
        return Post::findOrFail($id);
    }

    public function createPost(StorePostRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate();

        return $this->postRepository->create($validatedData);
    }

    public function updatePost($id, StorePostRequest $request)
    {
        $validatedData = $request->validate();

        $post = Post::findOrFail($id);
        $post->update($validatedData);
        return $post;
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return $post;
    }


    public function getcomments($id)
    {

        $post = Post::find($id);

        $comments = $post->comments()
            ->whereNull('parent_id') // Only top-level comments
            ->orderBy('created_at', 'desc') // Order by creation date
            ->paginate(10); // Paginate comments

        // Manually fetch replies for each top-level comment
        foreach ($comments as $comment) {
            $comment->replies = $comment->replies()
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return response()->json([
            'post' => $post,
            'comments' => $comments
        ]);

    }
}

