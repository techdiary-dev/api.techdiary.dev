<?php

namespace App\TechDiary;

use App\Models\User;
use Jenssegers\Agent\Agent;

class Authentication
{
    /**
     * Create token for a user
     *
     * @return mixed
     */
    public static function createToken(User $user)
    {
        $agent = new Agent();

        return $user->createToken(json_encode([
            'browser' => $agent->browser(),
            'platform/OS' => $agent->platform(),
            'device-type' => $agent->deviceType(),
        ]))->plainTextToken;
    }
}
