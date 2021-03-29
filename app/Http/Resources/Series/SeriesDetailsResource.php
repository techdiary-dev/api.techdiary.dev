<?php

namespace App\Http\Resources\Series;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class SeriesDetailsResource extends JsonResource
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
            'name' => $this->name,
            'cover' => $this->cover,
            'icon' => $this->icon,
            'description' => $this->description,
            'owner' => $this->user,
            'articles' => DB::table('article_series')->orderBy('series_order')->get()->groupBy('name')
        ];
    }
}
