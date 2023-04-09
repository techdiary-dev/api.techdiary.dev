<?php

use App\Http\Controllers\ProfileController;

Route::group(['prefix' => 'profile'], function () {
    Route::get('me', [ProfileController::class, 'me'])->middleware('auth:sanctum');
    Route::get('articles', [ProfileController::class, 'me'])->middleware('auth:sanctum');
    Route::get('list', [ProfileController::class, 'users']);
    Route::post('update', [ProfileController::class, 'updateProfile'])->middleware('auth:sanctum');
    Route::get('uuid/{user:id}', [ProfileController::class, 'profileDetails']);
    Route::get('username/{user:username}', [ProfileController::class, 'profileDetails']);
});
