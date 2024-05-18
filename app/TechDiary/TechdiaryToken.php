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
    public static function createTokenWithClientInformation(User $user, string $tokenName = 'token'): mixed
    {
        $agent = new Agent();
        $device_info = json_encode([
            'browser' => $agent->browser(),
            'platform/OS' => $agent->platform(),
            'device-type' => $agent->deviceType(),
        ]);

        $token = $user->createToken($tokenName);

        $user->tokens()->where('id', $token->accessToken->id)->update([
            'device_info' => $device_info,
        ]);

        return $token->plainTextToken;
    }
}
