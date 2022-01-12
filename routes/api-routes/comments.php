<?php

use App\Http\Controllers\CommentController;

Route::group(["prefix" => "comments"], function () {
    Route::get("", [CommentController::class, "index"]);

    Route::post("", [CommentController::class, "store"])
        ->middleware("auth:sanctum");

    Route::put("{comment:uuid}", [CommentController::class, "update",])
        ->middleware("auth:sanctum");

    Route::delete("{comment:uuid}", [CommentController::class,"destroy"])
        ->middleware("auth:sanctum");
});