<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


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
Route::get('user', [UserController::class, 'me'])->middleware('auth:sanctum');

Route::group(['prefix' => 'users'], function () {
    /**
     * User list
     */
    Route::get('', [UserController::class, 'users']);

    /**
     * User details
     */
    Route::get('{username}', [UserController::class, 'userDetails']);
});



/**
 * Authentication
 */
Route::group(['prefix' => 'auth'], function () {

    Route::post('oauth/signed-login', [AuthController::class, 'oauthSignedLogin'])
        ->name('oauth-signed-login')
        ->middleware('signed');

    Route::get('/login-spark', function (){
        return response()->json([
            'message' => 'Login success'
        ]);
    });

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

});

Route::group(['prefix' => 'bookmarks'], function (){
    Route::get('', [BookmarkController::class, 'getBookmarks'])
        ->middleware('auth:sanctum');

    Route::post('', [BookmarkController::class, 'doBookmark'])
        ->middleware('auth:sanctum');
});

Route::group(['prefix' => 'vote'], function (){
    Route::post('', \App\Http\Controllers\VoteController::class)->middleware('auth:sanctum');
});

Route::group(['prefix' => 'comments'], function (){
    Route::get('', [CommentController::class, 'index']);

    Route::post('', [CommentController::class, 'store'])
        ->middleware('auth:sanctum');

    Route::put('{comment:uuid}', [CommentController::class, 'update'])
        ->middleware('auth:sanctum');

    Route::delete('{comment:uuid}', [CommentController::class, 'destroy'])
        ->middleware('auth:sanctum');
});



Route::group(['prefix' => 'files'], function () {
    Route::post('/', [FileController::class, 'upload'])
        ->middleware('auth:sanctum');

    Route::delete('/', [FileController::class, 'destroy'])
        ->middleware('auth:sanctum');
});

Route::apiResource('tags', TagController::class);

