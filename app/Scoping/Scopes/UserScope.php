<?php

namespace App\Scoping\Scopes;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class UserScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->whereHas('user', function ($builder) use ($value) {
            $builder->where('username', $value);
        });
    }
}
// api/themes?type=ghost
