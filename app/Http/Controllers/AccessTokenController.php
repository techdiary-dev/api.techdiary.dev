<?php

namespace App\Http\Controllers;

use App\Http\Resources\TokenResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AccessTokenController extends Controller
{

    /**
     * Create personal access token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createToken(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5']
        ]);

        $token = auth()->user()->createToken($request->name);

        return response()->json([
           'message' => 'Access token generated',
           'token' => $token->plainTextToken
        ]);
    }


    public function deleteToken($tokenId)
    {
        $token = auth()->user()->tokens()->where('id', $tokenId)->firstOrFail();
        $token->delete();
        return response()->json([
            'message' => 'deleted'
        ]);
    }

    /**
     * Current user's token list
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function tokenList()
    {
        return TokenResource::collection(auth()->user()->tokens);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCurrentToken()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Your current access token removed'
        ]);
    }
}