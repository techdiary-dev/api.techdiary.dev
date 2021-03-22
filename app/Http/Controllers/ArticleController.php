<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\ArticleReactionRequest;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleDetails;
use App\Http\Resources\Article\ArticleList;
use App\Models\Article;
use App\Scoping\Scopes\ArticlesByTagName;
use App\Scoping\Scopes\UserScope;
use App\TechDiary\Reaction\Resources\ReactionCollection;

class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'destroy', 'update', 'myArticles']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return ArticleCollection
     */
    public function index()
    {
        $articles = Article::where([
            'isPublished' => true,
            'isApproved' => true
        ])->with(['tags', 'user', 'reactions'])->latest()->withScopes($this->scopes());

        return new ArticleCollection($articles->paginate(request()->query('limit', 10)));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateArticleRequest $request)
    {
        $article = auth()->user()->articles()->create($request->except('tags'));

        $article->isApproved = true;

        if ($request->tags) {
            $tags = collect($request->tags)->pluck('id');
            $article->tags()->sync($tags);
        }

        return response()->json([
            'message' => 'Article saved successfully',
            'data' => $article
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Article $article
     * @return ArticleDetails
     */
    public function show(Article $article)
    {
        return new ArticleDetails($article->load(['tags', 'user', 'comments', 'reactions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {

        $this->authorize('update', $article);

        $article->update($request->all());

        if ($request->tags) {
            $tags = collect($request->tags)->pluck('id');
            $article->tags()->sync($tags);
        }

        return response()->json([
            'message' => 'Article updated successfully',
            'data' => $article
        ]);
    }

    /**
     * Article React
     * @param ArticleReactionRequest $request
     * @param Article $article
     * @return array
     */
    public function reaction(ArticleReactionRequest $request, Article $article)
    {
        $article->react($request->reaction_type);
        $reactions = $article->reactions()->get();
        if ($reactions->isNotEmpty()) {
            $reactions = new ReactionCollection($reactions);
        } else {
            $reactions = null;
        }

        return [
            "reactions" => $reactions
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();
        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }

    public function myBookmarks()
    {
        $article_ids = auth()->guard('sanctum')->user()?->reactions()->where('type', 'BOOKMARK')->where('ReactionAble_type', Article::class)->select('ReactionAble_id')->get()->pluck('ReactionAble_id');
        if ($article_ids) {

            $articles = Article::with('user')->whereIn('id', $article_ids)->latest()->paginate();
            return ArticleList::collection($articles);
        } else {
            abort(401, "Unauthorized activity");
        }
    }

    public function myArticles()
    {
        $articles = auth()->user()->articles()->with('user')->latest()->paginate();
        return ArticleList::collection($articles);
    }

    protected function scopes()
    {
        return [
            'user' => new UserScope(),
            'tag' => new ArticlesByTagName(),
        ];
    }
}
