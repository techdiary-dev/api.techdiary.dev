<?php

use App\Http\Controllers\Auth\AccessTokenController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\PersonalAccessTokenController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('signed-login', [AuthController::class, 'signedLogin'])
        ->name('signedLogin')
        ->middleware('signed');

    Route::post('login-spark', function () {
        return response()->json([
            'message' => 'login-spark',
            'user' => auth()->user()
        ]);
    })->middleware('auth:sanctum');
});

Route::group(['prefix' => 'oauth'], function () {
    Route::get('{service}', [OAuthController::class, 'redirect']);
    Route::get('{service}/callback', [OAuthController::class, 'callback']);

    Route::post('token', [OAuthController::class, 'grantToken']);


    Route::post('token-by-credential', [OAuthController::class, 'createTokenUsingCredential']);
});



Route::group(['prefix' => 'personal-access-tokens'], function () {

    Route::get('', [PersonalAccessTokenController::class, 'tokenList'])
        ->middleware('auth:sanctum');

    Route::post('', [PersonalAccessTokenController::class, 'createToken'])
        ->middleware('auth:sanctum');

    Route::delete('current', [PersonalAccessTokenController::class, 'deleteCurrentToken'])
        ->middleware('auth:sanctum');

    Route::delete('{token}', [PersonalAccessTokenController::class, 'deleteToken'])
        ->middleware('auth:sanctum');
});
