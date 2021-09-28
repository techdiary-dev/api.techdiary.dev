<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentIndexRequest;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    protected $commendableModels = [
        'ARTICLE' => Article::class
    ];

    public function index(CommentIndexRequest $request)
    {
        $model = $this->commendableModels[$request->model_name]::find($request->model_id);

        $perPage = 10;
        $page = request()->query('page', 1);
        $comments = $model->nestedComments($page, $perPage) ?: [];

        return new LengthAwarePaginator(CommentResource::collection($comments), $model->comments->where('parent_id', null)->count(), $perPage, $page);
    }

    public function store(CommentStoreRequest $request)
    {
        Comment::create([
            'commentable_type' => $this->commendableModels[$request->model_name],
            'commentable_id' => $request->model_id,
            'body' => $request->body,
            'user_id' => auth()->guard('sanctum')->id(),
            'parent_id' => $request->parent_id
        ]);

        return response()->json([
           'message' => 'Comment created successfully'
        ]);
    }

    /**
     * Update comment
     * @param Comment $comment
     * @param CommentStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Comment $comment, Request $request)
    {
        $this->authorize('update', $comment);

        $request->validate([
           'body' => ['nullable']
        ]);

        $comment->update($request->only('body'));

        return response()->json([
           "message" => "Comment updated"
        ]);
    }

    public function destroy(Article $article, Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->noContent();
    }
}
