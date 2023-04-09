<?php

namespace App\Http\Resources\Bookmark;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookmarkCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $bookmarks = $this->collection->where('type', 'BOOKMARK')->pluck('user_id');

        return $bookmarks;
    }
}
