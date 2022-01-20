<?php


use App\Http\Controllers\SeriesController;

Route::group(['prefix' => 'series'], function (){
   Route::get('/{series}', [SeriesController::class,'show']);

    Route::post('/{series}', [SeriesController::class,'store'])
        ->middleware('auth:sanctum');

   Route::put('/{series}', [SeriesController::class,'update'])
       ->middleware('auth:sanctum');

   Route::delete('/{series}', [SeriesController::class, 'destroy'])
       ->middleware('auth:sanctum');
});