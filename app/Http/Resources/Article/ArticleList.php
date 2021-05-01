<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\User\UserListResource;
use App\TechDiary\Reaction\Resources\ReactionCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleList extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'reactions' => new ReactionCollection($this->reactions),
            'thumbnail' => $this->thumbnail,
            'tags' => $this->tags,
            'excerpt' => $this->excerpt,
            'is_published' => $this->isPublished,
            'user' => new UserListResource($this->user),
            'created_at' => $this->created_at
        ];
    }

}
