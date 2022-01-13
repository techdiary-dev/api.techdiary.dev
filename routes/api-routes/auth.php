<?php

use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('signed-login', [AuthController::class, 'signedLogin'])
        ->name('signedLogin')
        ->middleware('signed');

    Route::post('login-spark', function (){
        return response()->json([
            'message' => 'login-spark'
        ]);
    });
});