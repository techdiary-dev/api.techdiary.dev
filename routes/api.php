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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



/**
 * User endpoints
 * -
 */
Route::group(['prefix' => '/user'], function () {
    /**
     * Authenticated user
     */
//    Route::get('/', [UserController::class, 'me'])
//        ->middleware('auth:sanctum');

    /**
     * Authenticated user's bookmark
     */
    Route::get('bookmarks', [ArticleController::class, 'myBookmarks']);

    /**
     * Delete bookmark
     */
    Route::delete('bookmarks/{id}', [ArticleController::class, 'removeBookmark'])->middleware('auth:sanctum');

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

    //    Route::post('register', [AuthController::class, 'register']);
//    Route::post('login', [AuthController::class, 'login']);
//    Route::get('login/{service}', [AuthController::class, 'redirect']);
//    Route::get('login/{service}/callback', [AuthController::class, 'callback']);
//    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//    Route::get('my-tokens', [AuthController::class, 'myTokens'])->middleware('auth:sanctum');
//    Route::delete('revoke-token/{id}', [AuthController::class, 'revokeToken'])->middleware('auth:sanctum');
});


Route::get('articles-dump', function () {
    return \App\Models\Article::all();
});

Route::group(['prefix' => 'articles'], function () {
    Route::apiResource('', ArticleController::class, [
        'parameters' => [
            '' => 'article'
        ]
    ]);
    Route::post('/{article}/reaction', [ArticleController::class, 'reaction'])->middleware('auth:sanctum');
    Route::get('/{article}/comments', [\App\Http\Controllers\CommentController::class, 'index']);
    Route::post('/{article}/comments/', [\App\Http\Controllers\CommentController::class, 'store']);
    Route::patch('/{article}/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'update']);
    Route::delete('/{article}/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy']);
});

Route::apiResource('tags', TagController::class);
Route::get('my-articles', [ArticleController::class, 'myArticles']);
