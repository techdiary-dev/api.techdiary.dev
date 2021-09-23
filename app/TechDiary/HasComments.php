<?php

namespace App\TechDiary;

use App\Models\Comment;

trait HasComments
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
