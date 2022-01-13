<?php

use App\Http\Controllers\OAuthController;

Route::group(["prefix" => "oauth"], function () {
    Route::get("{service}", [OAuthController::class, "redirect"]);
    Route::get("{service}/callback", [OAuthController::class, "callback"]);
});