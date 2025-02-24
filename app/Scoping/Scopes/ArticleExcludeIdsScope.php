<?php

namespace App\Scoping\Scopes;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class ArticleExcludeIdsScope implements Scope
{
    public function apply(Builder $builder, $value)
    {

        if (is_null($value)) {
            return $builder;
        }

        if (! is_array($value)) {
            return $builder->whereNotIn('id', [$value]);
        } else {
            return $builder->whereNotIn('id', $value);
        }
    }
}
