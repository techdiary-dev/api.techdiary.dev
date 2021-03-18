<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyTokensResource extends JsonResource
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
            'platform' => json_decode($this->name),
            'isCurrent' => auth()->user()->currentAccessToken()->id == $this->id,
            'last_used_at' => $this->last_used_at,
            'created_at' => $this->created_at
        ];
    }
}
