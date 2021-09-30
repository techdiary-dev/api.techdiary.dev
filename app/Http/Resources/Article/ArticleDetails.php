<?php

namespace App\Http\Resources\Article;

<<<<<<< HEAD
use Durlecode\EJSParser\Parser;
=======
use App\Http\Resources\Bookmark\BookmarkCollection;
>>>>>>> ec70272a94f7bb352dc1b149ccebac8a4076d630
use App\Http\Resources\TagResource;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\Vote\VoteSummeryCollection;
use App\TechDiary\Reaction\Resources\ReactionCollection;
use App\TechDiary\TDMarkdown;
use Illuminate\Http\Resources\Json\JsonResource;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\Extension\Table\TableExtension;
use Torchlight\Commonmark\V2\TorchlightExtension;

class ArticleDetails extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

<<<<<<< HEAD
//        $blocks = [
//            "time" => now(),
//            "version" => "2.16.1",
//            "blocks" => $this->body
//        ];

        return array_merge(parent::toArray($request), [
//            "body_html" => Parser::parse(json_encode($blocks))->toHtml(),
=======
        $md = new TDMarkdown($this->body);

        return array_merge([
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'body' => [
                'html' => $md->toHTML(),
                "markdown" => $this->body ?: ""
            ],
            'votes' => new VoteSummeryCollection($this->reactions),
            'bookmarked_users' => new BookmarkCollection($this->reactions),
            'comments_count' => $this->comments_count,
            'excerpt' => $this->excerpt,
            'isPublished' => $this->isPublished,
            'isApproved' => $this->isPublished,
>>>>>>> ec70272a94f7bb352dc1b149ccebac8a4076d630
            'tags' => TagResource::collection($this->tags),
            'user' => new UserListResource($this->user),
            'seo' => $this->getMetaJSON('seo'),
            'settings' => [
                "disabled_comments" => $this->getMetaValue('disabled_comments'),
            ]
        ]);
    }
}
