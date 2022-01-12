<?php

use App\Http\Controllers\BookmarkController;

Route::group(["prefix" => "bookmarks"], function () {
    Route::get("", [BookmarkController::class, "getBookmarks"])->middleware(
        "auth:sanctum"
    );

    Route::post("", [BookmarkController::class, "doBookmark"])->middleware(
        "auth:sanctum"
    );
});