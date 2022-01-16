<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\Bookmark\BookmarkCollection;
use App\Http\Resources\TagResource;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\Vote\VoteSummeryCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleList extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    // $this->reactionSummary()
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'url' => env('CLIENT_BASE_URL') . '/' . $this->user->username . '/' . $this->slug,
            'votes' => new VoteSummeryCollection($this->reactions),
            'bookmarked_users' => new BookmarkCollection($this->reactions),
            'comments_count' => $this->comments_count,
            'thumbnail' => $this->thumbnail,
            'tags' => TagResource::collection($this->tags),
            'excerpt' => $this->excerpt,
            'isPublished' => $this->isPublished,
            'user' => new UserListResource($this->user),
            'created_at' => $this->created_at
        ];
    }

}
