<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\Vote\VoteSummeryCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthArticleList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'votes' => new VoteSummeryCollection($this->reactions),
            'comments_count' => $this->comments_count,
        ]);
    }
}
