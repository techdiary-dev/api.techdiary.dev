<?php

namespace App\Http\Resources\Article;

use Durlecode\EJSParser\Parser;
use App\Http\Resources\TagResource;
use App\Http\Resources\User\UserListResource;
use App\TechDiary\Reaction\Resources\ReactionCollection;
use Illuminate\Http\Resources\Json\JsonResource;

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

        $blocks = [
            "time" => now(),
            "version" => "2.16.1",
            "blocks" => $this->body
        ];

        return array_merge(parent::toArray($request), [
//            "body_html" => Parser::parse(json_encode($blocks))->toHtml(),
            'tags' => TagResource::collection($this->tags),
            'user' => new UserListResource($this->user),
            'reactions' => new ReactionCollection($this->reactions),
        ]);
    }
}
