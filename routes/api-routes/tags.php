<?php

use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tags', TagController::class);
