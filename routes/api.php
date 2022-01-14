<?php
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
    return response()->json([
       'message' => 'TechDiary Backend is running...'
    ], 200);
});

include __DIR__ . '/api-routes/auth.php';
include __DIR__ . '/api-routes/access-tokens.php';
include __DIR__ . '/api-routes/oauth.php';
include __DIR__ . '/api-routes/profile.php';
include __DIR__ . '/api-routes/articles.php';
include __DIR__ . '/api-routes/comments.php';
include __DIR__ . '/api-routes/bookmarks.php';
include __DIR__ . '/api-routes/vote.php';
include __DIR__ . '/api-routes/files.php';
include __DIR__ . '/api-routes/tags.php';