<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/**
 * User endpoints
 * -
 */
Route::group(['prefix' => '/user'], function () {
    /**
     * Authenticated user
     */
    Route::get('/', [UserController::class, 'me'])->middleware('auth:sanctum');

    /**
     * Authenticated user's bookmark
     */
    Route::get('bookmarks', [ArticleController::class, 'myBookmarks'])->middleware('auth:sanctum');

    /**
     * Delete bookmark
     */
    Route::delete('bookmarks/{id}', [ArticleController::class, 'removeBookmark'])
        ->middleware('auth:sanctum');

    /**
     * User details
     */
    Route::get('/{username}', [UserController::class, 'userDetails']);
});

/**
 * User list
 */
Route::get('/users', [UserController::class, 'users']);

/**
 * Authentication
 */
Route::group(['prefix' => 'auth'], function () {

    Route::post('oauth/signed-login', [AuthController::class, 'oauthSignedLogin'])
        ->name('oauth-signed-login')
        ->middleware('signed');

    Route::get('oauth/{service}', [AuthController::class, 'oauthRedirect']);
    Route::get('oauth/{service}/callback', [AuthController::class, 'oauthCallback']);


    Route::post('update-profile', [AuthController::class, 'updateProfile'])
        ->middleware('auth:sanctum');

    Route::post('update-profile-basic-settings', [AuthController::class, 'updateBasicProfileSettings'])
        ->middleware('auth:sanctum');


    Route::get('articles', [ArticleController::class, 'myArticles'])->middleware('auth:sanctum');

//    Route::post('register', [AuthController::class, 'register']);
//    Route::post('login', [AuthController::class, 'login']);
//    Route::get('login/{service}', [AuthController::class, 'redirect']);
//    Route::get('login/{service}/callback', [AuthController::class, 'callback']);
//    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//    Route::get('my-tokens', [AuthController::class, 'myTokens'])->middleware('auth:sanctum');
//    Route::delete('revoke-token/{id}', [AuthController::class, 'revokeToken'])->middleware('auth:sanctum');
});




Route::group(['prefix' => 'articles'], function () {
    Route::get('dump', function () {
        return \App\Models\Article::all();
    });

    Route::get('', [ArticleController::class, 'index']);
    Route::post('', [ArticleController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/uuid/{article:id}', [ArticleController::class, 'show']);
    Route::get('/slug/{article:slug}', [ArticleController::class, 'show']);
    Route::put('/uuid/{article:id}', [ArticleController::class, 'update'])->middleware('auth:sanctum');
    Route::put('/slug/{article:slug}', [ArticleController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/uuid/{article:id}', [ArticleController::class, 'destroy'])->middleware('auth:sanctum');

    /**
     * Generate a blank article
     */
    Route::post('spark', [ArticleController::class, 'spark'])
        ->middleware('auth:sanctum');

    Route::post('/{article:id}/vote', [ArticleController::class, 'vote'])
        ->middleware('auth:sanctum');

//    Route::get('/{article}/comments', [\App\Http\Controllers\CommentController::class, 'index']);
//    Route::post('/{article}/comments/', [\App\Http\Controllers\CommentController::class, 'store']);
//    Route::patch('/{article}/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'update']);
//    Route::delete('/{article}/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy']);
});



Route::group(['prefix' => 'files'], function () {
    Route::post('/', [\App\Http\Controllers\FileController::class, 'upload'])
        ->middleware('auth:sanctum');

    Route::delete('/', [\App\Http\Controllers\FileController::class, 'destroy'])
        ->middleware('auth:sanctum');
});

Route::apiResource('tags', TagController::class);

