<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bookmark\BookmarkListRequest;
use App\Http\Requests\Bookmark\BookmarkRequest;
use App\Http\Resources\Article\AuthArticleList;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\TechDiary\Reaction\Model\Reaction;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    protected $bookmarkableModels = [
        'ARTICLE' => Article::class,
        'COMMENT' => Comment::class,
        'TAG' => Tag::class,
    ];

    public function getBookmarks(BookmarkListRequest $request)
    {
        $model = $this->bookmarkableModels[$request->model_name];

        $bookmark_ids =  auth()->user()->reactions()
            ->where('ReactionAble_type', $model)
            ->where('type', 'BOOKMARK')
            ->get()->pluck('ReactionAble_id');
        return $model::whereIn('id', $bookmark_ids)->paginate();
    }


    public function doBookmark(BookmarkRequest $request)
    {
        $model = $this->bookmarkableModels[$request->model_name]::find($request->model_id);
        $bookmarked = $model->toggleReaction('BOOKMARK', auth()->user());

        return response()->json([
            'bookmarked' => $bookmarked
        ]);
    }
}
