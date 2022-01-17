<?php

namespace App\Http\Controllers;

use App\Http\Resources\Article\ArticleList;
use App\Http\Resources\Article\ArticleRSSCollection;
use App\Http\Resources\Rss\ArticleFeedResource;
use App\Models\Article;

class RSSFeedController extends Controller
{
    public function articles()
    {
        $articles = Article::where([ 'isPublished' => true ])->limit(50)->get();
        return response()->view('rss.articles', [
            'articles' => $articles
        ])->header('Content-Type', 'application/xml');
    }
}