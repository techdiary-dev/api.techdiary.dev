<?php


namespace App\TechDiary\Reaction\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return $this->collection->groupBy('type')->map(function ($reaction) {
            return [
                'count' => count($reaction->pluck('user_id')),
                'reactors' => $reaction->pluck('user_id'),
            ];
        });
    }
}
