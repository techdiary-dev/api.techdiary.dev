<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentController extends Controller
{
    public function index(Article $article)
    {
        $perPage = 10;
        $page = request()->query('page', 1);
        $comments = $article->nestedComments($page, $perPage);
        return new LengthAwarePaginator($comments, $article->comments->where('parent_id', null)->count(), $perPage, $page);
    }

    public function store(Article $article, CommentRequest $request)
    {
        $article->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->guard('sanctum')->id(),
            'parent_id' => $request->parent_id
        ]);

        return response()->json([
           'message' => 'Comment created successfully'
        ]);
    }

    public function update(Article $article, Comment $comment, CommentRequest $request)
    {
        if ($comment->user_id != auth()->guard('sanctum')->id()) {
            return response('Unauthorized activity', 401);
        }
        $comment->update(['body' => $request->body]);
        return response()->noContent();
    }

    public function destroy(Article $article, Comment $comment)
    {
        if ($comment->user_id != auth()->guard('sanctum')->id()) {
            return response('Unauthorized activity', 401);
        }
        $comment->delete();
        return response()->noContent();
    }
}
