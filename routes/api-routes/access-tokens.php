<?php

use App\Http\Controllers\AccessTokenController;

Route::group(['prefix' => 'tokens'], function () {
    Route::post('token-by-secret', [AccessTokenController::class, 'createTokenUsingSecret']);

    Route::get('', [AccessTokenController::class, 'tokenList'])
        ->middleware('auth:sanctum');

    Route::post('', [AccessTokenController::class, 'createToken'])
        ->middleware('auth:sanctum');

    Route::delete('current', [AccessTokenController::class, 'deleteCurrentToken'])
        ->middleware('auth:sanctum');

    Route::delete('{token}', [AccessTokenController::class, 'deleteToken'])
        ->middleware('auth:sanctum');
});
