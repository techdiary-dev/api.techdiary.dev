<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\TagResource;
use App\Http\Resources\User\UserListResource;
use App\TechDiary\TDMarkdown;
use App\TechDiary\Reaction\Resources\ReactionCollection;
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

        $md = new TDMarkdown($this->body);

        return array_merge([
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'body' => [
                'html' => $md->toHTML(),
                "markdown" => $this->body ?: ""
            ],
            'excerpt' => $this->excerpt,
            'isPublished' => $this->isPublished,
            'isApproved' => $this->isPublished,
            'tags' => TagResource::collection($this->tags),
            'user' => new UserListResource($this->user),
            'reactions' => new ReactionCollection($this->reactions),
            'seo' => $this->getMetaJSON('seo'),
            'settings' => [
                "disabled_comments" => $this->getMetaValue('disabled_comments'),
            ]
        ]);
    }
}
