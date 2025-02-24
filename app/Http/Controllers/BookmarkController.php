<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bookmark\BookmarkListRequest;
use App\Http\Requests\Bookmark\BookmarkRequest;
use App\Http\Resources\Article\MinimalArticleResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\TechDiary\Reaction\Model\Reaction;

class BookmarkController extends Controller
{
    protected $bookmarkableModels = [
        'ARTICLE' => Article::class,
        'COMMENT' => Comment::class,
        'TAG' => Tag::class,
    ];

    public function getBookmarks(BookmarkListRequest $request)
    {
        $userId = $request->user()->id;
        $bookmarks = Reaction::where([
            'ReactionAble_type' => Article::getModel()->getMorphClass(),
            'type' => 'BOOKMARK',
            'user_id' => $userId
        ])->with('reactable');

        return response()->json($bookmarks->paginate(10));

//        $bookmark = Reaction::first();
//
//        return response()->json($bookmark->reactionable);



//        $bookmark_ids = auth()->user()->reactions()
//            ->where('ReactionAble_type', $model)
//            ->where('type', 'BOOKMARK')
//            ->get()->pluck('ReactionAble_id');
//
//        if ($request->model_name == 'ARTICLE') {
//            $filtered = $model::with('user:id,name,username,profilePhoto')
//                ->whereIn('id', $bookmark_ids)
//                ->paginate($request->get('limit', 30), ['id', 'title', 'slug', 'user_id']);
//            return MinimalArticleResource::collection($filtered);
//        } else {
//            return $model::whereIn('id', $bookmark_ids)->paginate();
//        }
    }

    public function doBookmark(BookmarkRequest $request)
    {
        $model = $this->bookmarkableModels[$request->model_name]::find($request->model_id);
        if (!$model) {
            abort(404, 'Item not found');
        }


        $bookmarked = $model->toggleReaction('BOOKMARK', auth()->user());

        return response()->json([
            'bookmarked' => $bookmarked,
        ]);
    }
}
