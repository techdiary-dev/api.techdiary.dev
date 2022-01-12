<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::group(["prefix" => "profile"], function () {
    Route::get("me", [ProfileController::class, "me"])
        ->middleware("auth:sanctum");

    Route::post("update", [ProfileController::class, "updateProfile"])
        ->middleware("auth:sanctum");

    Route::post("update-basic", [ProfileController::class,"updateBasicProfileSettings"])
        ->middleware("auth:sanctum");
});