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

Route::get("/", function () {
    return view("welcome");
});

/**
 * User endpoints
 * -
 */
Route::get("user", [UserController::class, "me"])->middleware("auth:sanctum");

Route::group(["prefix" => "users"], function () {
    /**
     * User list
     */
    Route::get("", [UserController::class, "users"]);

    /**
     * User details
     */
    Route::get("{username}", [UserController::class, "userDetails"]);
});

/**
 * Authentication
 */
Route::group(["prefix" => "auth"], function () {
    Route::post("oauth/signed-login", [AuthController::class, "oauthSignedLogin"])
        ->name("oauth-signed-login")
        ->middleware("signed");

    Route::get("oauth/{service}", [AuthController::class, "oauthRedirect"]);
    Route::get("oauth/{service}/callback", [AuthController::class, "oauthCallback"]);

    Route::post('login-spark', function (){
       return response()->json([
          'message' => 'login-spark'
       ]);
    });

    Route::get("articles", [ArticleController::class,"myArticles"])
        ->middleware("auth:sanctum");
});



include __DIR__ . '/api-routes/articles.php';
include __DIR__ . '/api-routes/comments.php';
include __DIR__ . '/api-routes/bookmarks.php';
include __DIR__ . '/api-routes/vote.php';
include __DIR__ . '/api-routes/files.php';
include __DIR__ . '/api-routes/tags.php';
include __DIR__ . '/api-routes/profile.php';