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
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */

    public function __construct()
    {
//        $this->middleware('auth:sanctum')->only(['store', 'destroy', 'update', 'myArticles']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return ArticleCollection
     * @throws \Exception
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
        $article = auth()
            ->user()
            ->articles()
            ->create($request->except('tags', 'seo', 'settings'));

        return $article;
//        $article->isApproved = true;

//        if ($request->tags) {
//            $tags = collect($request->tags)->pluck('id');
//            $article->tags()->sync($tags);
//        }
//
//        if ($request->seo) {
//            $article->setMetaJSON("seo", $request->only('seo.og_image', 'seo.seo_title', 'seo.seo_description', 'seo.disabled_comments')['seo']);
//        }
//
//        if ($request->settings)
//        {
//            $article->setMetaValue("settings.disabled_comments", $request->get('settings.disabled_comments'));
//        }
//
//        $article->save();
//
//        return response()->json([
//            'message' => 'Article saved successfully',
//            'data' => $article
//        ]);
    }


    public function spark(Request $request)
    {
        $article = auth()
            ->user()
            ->articles()
            ->create();

        $article->update(["slug" => $article->id]);

        return response()->json([
            "message" => "New diary generated",
            "uuid" => $article->id
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
        return new ArticleDetails($article->load(['tags', 'user', 'reactions', 'meta']));
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
        $article = auth()
            ->user()
            ->articles()
            ->create($request->except('tags', 'seo', 'settings'));

        $article->isApproved = true;

        if ($request->tags) {
            $tags = collect($request->tags)->pluck('id');
            $article->tags()->sync($tags);
        }

        if ($request->seo) {
            $article->setMetaJSON("seo", $request->only('seo.og_image', 'seo.seo_title', 'seo.seo_description', 'seo.disabled_comments')['seo']);
        }

        if ($request->settings)
        {
            $article->setMetaValue("disabled_comments",
                $request->only('settings.disabled_comments')['settings']['disabled_comments']
            );
        }


        $article->save();
        return response()->json([
            'message' => 'Article saved successfully'
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
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

    public function removeBookmark($articleId)
    {
        return auth()
            ->user()
            ->reactions()
            ->where('type', 'BOOKMARK')
            ->where('ReactionAble_type', Article::class)
            ->where('ReactionAble_id', $articleId)->delete();
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
