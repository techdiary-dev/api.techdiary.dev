<?php

use App\Http\Controllers\FileController;

Route::group(["prefix" => "files"], function () {
    Route::post("/", [FileController::class, "upload"])
        ->middleware("auth:sanctum");

    Route::delete("/", [FileController::class, "destroy"])
        ->middleware("auth:sanctum");
});