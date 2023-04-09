<?php

namespace App\Http\Resources\Vote;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VoteSummeryCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $upvotes = $this->collection->where('type', 'UP_VOTE')->pluck('user_id');
        $downvotes = $this->collection->where('type', 'DOWN_VOTE')->pluck('user_id');

        return [
            'up_voters' => $upvotes,
            'down_voters' => $downvotes,
            'score' => $upvotes->count() - $downvotes->count(),
        ];
    }
}
