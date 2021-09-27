<?php


namespace App\TechDiary\Reaction\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $summery = $this->collection->groupBy('type')->map(function ($reaction) {
            return [
                'count' => count($reaction->pluck('user_id')),
                'reactors' => $reaction->pluck('user_id'),
            ];
        });

        return [
            "summery" => $summery,
            "vote_score" => $this->collection->where('type', 'UP_VOTE')->count() - $this->collection->where('type', 'DOWN_VOTE')->count()
        ];
    }
}
