<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TokenPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function delete(User $user, $token): bool
    {
        return $user->id === $token->tokenable_id;
    }
}