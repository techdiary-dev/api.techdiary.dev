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
    public function getWordsFromStr($length, $str)
    {
        $words = explode(' ', $str);
        $s = array_slice($words, 0, $length);

        return implode(' ', $s);
    }

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
            'url' => config('app.client_url').'/'.$this->user->username.'/'.$this->slug,
            'thumbnail' => $this->thumbnail ?? null,
            'body' => [
                'html' => $md->toHTML(),
                'markdown' => $this->body ?: '',
                'plainText' => $md->toPlainText(),
                'excerpt' => $this->getWordsFromStr(30, $md->toPlainText()),
            ],
            'votes' => new VoteSummeryCollection($this->reactions),
            'bookmarked_users' => new BookmarkCollection($this->reactions),
            'comments_count' => $this->comments_count,
            'excerpt' => $this->excerpt,
            'is_published' => $this->is_published,
            'is_approved' => $this->is_approved,
            'tags' => TagResource::collection($this->tags),
            'user' => new UserListResource($this->user),
            'seo' => $this->getMetaJSON('seo'),
            'settings' => $this->getMetaJSON('settings'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
    }
}
