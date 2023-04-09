<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'profilePhoto' => $this->profilePhoto,
            'social_links' => [
                'twitter' => $this->social_links && array_key_exists('twitter', $this->social_links) ? $this->social_links['twitter'] : null,
                'github' => $this->social_links && array_key_exists('github', $this->social_links) ? $this->social_links['github'] : null,
            ],
            //            'isOnline' => $this->isOnline(),
            'joined' => $this->created_at,
        ];
    }
}
