<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\Bookmark\BookmarkCollection;
use App\Http\Resources\TagResource;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\Vote\VoteSummeryCollection;
use App\TechDiary\Markdown\TDMarkdown;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $md = new TDMarkdown($this->body);

        return array_merge([
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'url' => env('CLIENT_BASE_URL').'/'.$this->user->username.'/'.$this->slug,
            'thumbnail' => $this->thumbnail,
            'body' => [
                'html' => $md->toHTML(),
                'markdown' => $this->body ?: '',
            ],
            'votes' => new VoteSummeryCollection($this->reactions),
            'bookmarked_users' => new BookmarkCollection($this->reactions),
            'comments_count' => $this->comments_count,
            'excerpt' => $this->excerpt,
            'isPublished' => $this->isPublished,
            'isApproved' => $this->isPublished,
            'tags' => TagResource::collection($this->tags),
            'user' => new UserListResource($this->user),
            'seo' => $this->getMetaJSON('seo'),
            'settings' => $this->getMetaJSON('settings'),
            'created_at' => $this->created_at,
        ]);
    }
}
