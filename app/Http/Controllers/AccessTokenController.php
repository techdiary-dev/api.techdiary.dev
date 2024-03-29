<?php

namespace App\Http\Controllers;

use App\Http\Requests\Token\GenerateTokenRequest;
use App\Http\Resources\TokenResource;
use App\Models\User;
use App\Models\UserSocial;
use App\TechDiary\TechdiaryToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccessTokenController extends Controller
{
    public function createTokenUsingSecret(GenerateTokenRequest $request)
    {
        $social_user = UserSocial::where([
            ['service', $request->oauth_provider],
            ['service_uid', $request->oauth_uid],
        ])->first();

        if ($social_user) {
            $token = TechdiaryToken::createTokenWithClientInformation($social_user->user);

            return response()->json([
                'access_token' => $token,
            ]);
        }

        $username = strtolower(
            explode('@', $request->email)[0].
                Str::random(4)
        );

        $user = new User([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'profilePhoto' => $request->image,
        ]);
        $user->save();

        $user->socialProviders()->create([
            'service' => $request->oauth_provider,
            'service_uid' => $request->oauth_uid,
        ]);

        $token = TechdiaryToken::createTokenWithClientInformation($user);

        return response()->json([
            'access_token' => $token,
        ]);
    }

    /**
     * Create personal access token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createToken(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5'],
        ]);

        $token = auth()->user()->createToken($request->name);

        return response()->json([
            'message' => 'Access token generated',
            'token' => $token->plainTextToken,
        ]);
    }

    public function deleteToken($tokenId)
    {
        $token = auth()->user()->tokens()->where('id', $tokenId)->firstOrFail();
        $token->delete();

        return response()->json([
            'message' => 'deleted',
        ]);
    }

    /**
     * Current user's token list
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function tokenList()
    {
        return TokenResource::collection(auth()->user()->tokens);
    }
}
