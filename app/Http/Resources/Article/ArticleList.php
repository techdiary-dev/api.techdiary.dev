<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\Bookmark\BookmarkCollection;
use App\Http\Resources\TagResource;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\Vote\VoteSummeryCollection;
use App\TechDiary\Markdown\TDMarkdown;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleList extends JsonResource
{
    function getWordsFromStr($length, $str)
    {
        $words = explode(' ', $str);
        $s = array_slice($words, 0, $length);
        return implode(' ', $s);
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    // $this->reactionSummary()
    public function toArray($request)
    {

        $md = new TDMarkdown($this->body);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'url' => config('app.client_url') . '/@' . $this->user->username . '/' . $this->slug,
            'votes' => new VoteSummeryCollection($this->reactions),
            'comments_count' => $this->comments_count,
            'bookmarked_users' => new BookmarkCollection($this->reactions),

            'thumbnail' => json_decode($this->thumbnail),
            'tags' => TagResource::collection($this->tags),
            'body' => [
//                'html' => $md->toHTML(),
//                'markdown' => $this->body ?: '',
                'plainText' => $md->toPlainText(),
                'excerpt' => $this->getWordsFromStr(60, $md->toPlainText()),
            ],
            'isPublished' => $this->isPublished,
            'user' => new UserListResource($this->user),
            'created_at' => $this->created_at,
        ];
    }
}
