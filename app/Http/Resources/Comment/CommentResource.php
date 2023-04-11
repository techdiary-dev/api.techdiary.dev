<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Vote\VoteSummeryCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => $this->user,
            'created_at' => $this->created_at,
            'votes' => new VoteSummeryCollection($this->reactions),
            'children' => CommentResource::collection($this->children),
        ];
    }
}
