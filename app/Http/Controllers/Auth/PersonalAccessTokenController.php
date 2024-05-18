<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use Illuminate\Http\Request;

class PersonalAccessTokenController extends Controller
{
    /**
     * Create personal access token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createToken(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5'],
//            'expires_at' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $token = auth()->user()->createToken($request->name);

        return response()->json([
            'message' => 'Access token generated',
            'token' => $token->plainTextToken,
//            'expires_at' => $token->expires_at->toDateTimeString(),
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
