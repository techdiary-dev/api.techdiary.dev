<?php

namespace App\Traits;

trait NestableComments
{
    public function getIdsFromRoot($grouped, $page, $perPage)
    {
        $root = $grouped->get(null)?->forPage($page, $perPage);

        return $this->buildIdNest($root, $grouped);
    }

    public function nestedComments($page = 1, $perPage = 10)
    {
        $comments = $this->comments();
        $grouped = $comments->get()->groupBy('parent_id');
        if ($grouped->isEmpty()) {
            return null;
        }

        $ids = $this->getIdsFromRoot($grouped, $page, $perPage);

        $grouped = $comments->whereIn('id', $ids)->with(['user' => function ($q) {
            $q->select('username', 'name', 'id', 'profilePhoto');
        }])->get()->groupBy('parent_id');

        $root = $grouped->get(null);

        return $this->buildNest($root, $grouped);
    }

    protected function buildIdNest($root, $grouped, &$ids = [])
    {
        foreach ($root as $comment) {
            $ids[] = $comment->id;
            if ($replies = $grouped->get($comment->id)) {
                $this->buildIdNest($replies, $grouped, $ids);
            }
        }

        return $ids;
    }

    protected function buildNest($comments, $groupComments)
    {
        return $comments->each(function ($comment) use ($groupComments) {
            if ($replies = $groupComments->get($comment->id)) {
                $comment->children = $replies;
                $this->buildNest($comment->children, $groupComments);
            } else {
                $comment->children = [];
            }
        });
    }
}
