<?php

namespace App\Http\Controllers;

use App\Models\Article;

class RSSFeedController extends Controller
{
    public function articles()
    {
        $articles = Article::where(['isPublished' => true])->limit(50)->latest()->get();

        return response()->view('rss.articles', [
            'articles' => $articles,
        ])->header('Content-Type', 'application/xml');
    }
}
