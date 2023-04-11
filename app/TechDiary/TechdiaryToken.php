<?php

namespace App\TechDiary;

use App\Models\User;
use Jenssegers\Agent\Agent;

class TechdiaryToken
{
    /**
     * Create token for a user
     *
     * @param User $user
     * @return mixed
     */
    public static function createTokenWithClientInformation(User $user): mixed
    {
        $agent = new Agent();

        return $user->createToken(json_encode([
            'browser' => $agent->browser(),
            'platform/OS' => $agent->platform(),
            'device-type' => $agent->deviceType(),
        ]))->plainTextToken;
    }
}
