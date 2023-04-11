<?php

namespace App\Policies;

use App\Models\Series;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeriesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Article  $article
     * @return mixed
     */
    public function update(User $user, Series $series)
    {
        return $series->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Article  $article
     * @return mixed
     */
    public function delete(User $user, Series $series)
    {
        return $series->user_id == $user->id;
    }
}
