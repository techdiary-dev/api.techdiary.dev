<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
}
