<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleDetails;
use App\Http\Resources\Article\AuthArticleList;
use App\Models\Article;
use App\Models\Comment;
use App\Scoping\Scopes\ArticleExcludeIdsScope;
use App\Scoping\Scopes\ArticlesByTagName;
use App\Scoping\Scopes\UserScope;
use App\TechDiary\Reaction\Model\Reaction;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ArticleCollection
     *
     * @throws \Exception
     */
    public function index()
    {
        $articles = Article::where([
            'is_published' => true,
            'is_approved' => true
        ])->with(['tags', 'user', 'reactions'])
            ->withCount('comments')->latest('published_at')->withScopes($this->scopes());

        return new ArticleCollection($articles->paginate(request()->query('limit', 10)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateArticleRequest $request)
    {
        $article = auth()
            ->user()
            ->articles()
            ->create(array_merge($request->except('tags', 'seo', 'settings'), [
                'is_approved' => true,
                'slug' => $this->getUniqueSlugUtil($request->title),
            ]));

        if ($request->tags) {
            $tags = collect($request->tags)->pluck('id');
            $article->tags()->sync($tags);
        }

        if ($request->seo) {
            $article->setMetaJSON('seo', $request->only('seo.og_image', 'seo.seo_title', 'seo.seo_description', 'seo.disabled_comments')['seo']);
        }

        if ($request->settings) {
            $article->setMetaValue('settings.disabled_comments', $request->get('settings.disabled_comments'));
        }

        $article->save();

        return response()->json([
            'message' => 'Article saved successfully',
            'data' => $article,
        ]);
    }

    public function getUniqueSlug(Request $request)
    {

        $request->validate([
            'slug' => 'required',
        ]);
        return response()->json(['slug' => $this->getUniqueSlugUtil($request->slug)]);
    }

    public function getUniqueSlugUtil(string $slug): string
    {
        $slugged = Str::slug($slug);
        $slugExists = Article::where('slug', $slugged)->first();
        if (!$slugExists) {
            return $slugged;
        }
        return $slugged . '-' . Str::random(5);
    }


    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return ArticleDetails
     */
    public function show(Article $article): ArticleDetails
    {
        return new ArticleDetails($article->load(['tags', 'user', 'reactions', 'meta']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateArticleRequest $request, Article $article): JsonResponse
    {
        $this->authorize('update', $article);

        $article->update($request->only('title', 'slug', 'thumbnail', 'body', 'is_published', 'excerpt'));

        if ($request->tags) {
            $tags = collect($request->tags)->pluck('id');
            $article->tags()->sync($tags);
        }

        if ($request->seo) {
            $article->setMetaJSON('seo', $request->only('seo.og_image', 'seo.seo_title', 'seo.seo_description', 'seo.canonical_url')['seo']);
        }

        if ($request->settings) {
            $article->setMetaJSON('settings', $request->only('settings.disabled_comments')['settings']);
        }

        $article->save();

        return response()->json([
            'message' => 'Article saved successfully',
            'article' => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->forceDeleteQuietly();

        return response()->json([
            'message' => 'Deleted successfully',
        ]);
    }

    public function archive(Article $article): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $article);
        $article->delete();

        return response()->json([
            'message' => 'Soft deleted successfully',
        ]);
    }

    public function myArticles(Request $request)
    {
        $published_count = auth()->user()->articles()->where('is_published', true)->count();
        $draft_count = auth()->user()->articles()->where('is_published', false)->count();
        $my_articles_ids = auth()->user()->articles()->pluck('id');


        $comments_count = Comment::where([
            'commentable_type' => Article::getModel()->getMorphClass(),
        ])->whereIn('commentable_id', $my_articles_ids)->count();

        $bookmark_count = Reaction::where([
            'ReactionAble_type' => Article::getModel()->getMorphClass(),
            'type' => 'BOOKMARK',
        ])->whereIn('ReactionAble_id', $my_articles_ids)->count();

        $reactions_count = Reaction::where([
            'ReactionAble_type' => Article::getModel()->getMorphClass(),
        ])
            ->whereIn('type', ['UP_VOTE', 'DOWN_VOTE'])
            ->whereIn('ReactionAble_id', $my_articles_ids)->count();

        $articles = auth()
            ->user()
            ->articles()
            ->where($request->only('isPublished'))
            ->latest()
            ->withCount('comments')
            ->paginate();

        return AuthArticleList::collection($articles)->additional([
            'meta' => [
                'counts' => [
                    'published' => $published_count,
                    'draft' => $draft_count,
                    'comments' => $comments_count,
                    'bookmarks' => $bookmark_count,
                    'reactions' => $reactions_count,
                ],
            ],
        ]);
    }

    public function myArchivedArticles(Request $request)
    {
        $articles = auth()
            ->user()
            ->articles()
            ->onlyTrashed()
            ->latest()
            ->withCount('comments')
            ->paginate();
        return AuthArticleList::collection($articles);
    }


    protected function scopes()
    {
        return [
            'user' => new UserScope(),
            'tag' => new ArticlesByTagName(),
            'excludeIds' => new ArticleExcludeIdsScope(),
        ];
    }
}
