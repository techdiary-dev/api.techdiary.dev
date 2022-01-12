<?php

use App\Http\Controllers\VoteController;

Route::group(["prefix" => "vote"], function () {
    Route::post("", VoteController::class)
        ->middleware("auth:sanctum");
});