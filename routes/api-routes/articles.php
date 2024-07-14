<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'articles'], function () {
    Route::get('', [ArticleController::class, 'index'])->middleware('throttle:60,120');

    Route::post('', [ArticleController::class, 'index'])
        ->middleware('auth:sanctum');

    Route::get('mine', [ArticleController::class, 'myArticles'])
        ->middleware('auth:sanctum');
    Route::get('/uuid/{article:id}', [ArticleController::class, 'show']);
    Route::get('/slug/{article:slug}', [ArticleController::class, 'show']);

    Route::patch('/uuid/{article:id}', [ArticleController::class, 'update'])
        ->middleware('auth:sanctum');

    Route::patch('/slug/{article:slug}', [ArticleController::class, 'update'])
        ->middleware('auth:sanctum');

    Route::delete('/uuid/{article:id}', [ArticleController::class, 'destroy'])
        ->middleware('auth:sanctum');

    /**
     * Generate a blank article
     */
    Route::post('spark', [ArticleController::class, 'spark'])
        ->middleware('auth:sanctum');
});
