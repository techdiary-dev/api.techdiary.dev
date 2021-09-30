<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Models\Article;
use App\Models\Comment;

class VoteController extends Controller
{
    protected $voteableModels = [
        'ARTICLE' => Article::class,
        'COMMENT' => Comment::class,
    ];

    public function __invoke(VoteRequest $request)
    {
        $model = $this->voteableModels[$request->model_name]::find($request->model_id);

        return response()->json([
            'message' => $model->vote($request->vote, auth()->user()),
        ]);
    }
}
