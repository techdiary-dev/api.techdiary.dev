<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('fetch-url', function () {
    try {
        $res = \Illuminate\Support\Facades\Http::get('https://api.embedly.com/1/oembed', [
            'key' => '24a49378fc8a4c8bae846af46c472388',
            'url' => request()->query('url')
        ]);
        return response()->json([
            'success' => 1,
            'meta' => [
                "title" => $res->json('title'),
                "description" => $res->json('description'),
                "image" => [
                    "url" => $res->json('thumbnail_url')
                ]
            ]
        ]);
    } catch (Exception $e) {
        abort($e->getCode(), $e->getMessage());
    }
});


Route::group(['prefix' => '/user'], function () {
    Route::get('/', [UserController::class, 'me'])->middleware('auth:sanctum');
    Route::get('bookmarks', [ArticleController::class, 'myBookmarks']);
    Route::get('/{username}', [UserController::class, 'userDetails']);
});
Route::get('/users', [UserController::class, 'users']);

Route::group(['prefix' => 'articles'], function () {
    Route::apiResource('', ArticleController::class, [
        'parameters' => [
            '' => 'article'
        ]
    ]);
    Route::post('/{article}/reaction', [ArticleController::class, 'reaction'])->middleware('auth:sanctum');
    Route::get('/{article}/comments', [\App\Http\Controllers\CommentController::class, 'index']);
});

Route::apiResource('tags', TagController::class);
Route::get('my-articles', [ArticleController::class, 'myArticles']);


/**
 * Authentication
 */
Route::group(['prefix' => 'auth'], function () {
    Route::post('update-profile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
    Route::post('update-profile-basic-settings', [AuthController::class, 'updateBasicProfileSettings'])->middleware('auth:sanctum');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('login/{service}', [AuthController::class, 'redirect']);
    Route::get('login/{service}/callback', [AuthController::class, 'callback']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('my-tokens', [AuthController::class, 'myTokens'])->middleware('auth:sanctum');
    Route::delete('revoke-token/{id}', [AuthController::class, 'revokeToken'])->middleware('auth:sanctum');
});
