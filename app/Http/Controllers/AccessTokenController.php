<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;

class AccessTokenController extends Controller
{
    /**
     * @throws AuthenticationException
     */
    public function createTokenByPassword(\Request $request)
    {
        if (!auth()->guard()->attempt($request->all()))
            throw new AuthenticationException('Invalid credential');

        return [
            'token' => Authentication::createToken(auth()->user())
        ];
    }

    public function deleteToken()
    {
        
    }

    public function tokenList()
    {

    }
}