<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'profile'], function () {
    Route::get('me', [ProfileController::class, 'me'])->middleware('auth:sanctum');
    Route::get('articles', [ProfileController::class, 'me'])->middleware('auth:sanctum');
    Route::get('list', [ProfileController::class, 'users']);
    Route::patch('', [ProfileController::class, 'updateMyProfile'])->middleware('auth:sanctum');
    Route::get('uuid/{user:id}', [ProfileController::class, 'profileDetails']);
    Route::get('username/{user:username}', [ProfileController::class, 'profileDetails']);
    Route::post('unique-username', [ProfileController::class, 'getUniqueUsername'])->middleware('auth:sanctum');
    Route::post('public-unique-username', [ProfileController::class, 'getPublicUniqueUsername']);
});
