<?php

use App\Http\Controllers\RSSFeedController;
use Illuminate\Support\Facades\Route;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\Extension\Table\TableExtension;
use Torchlight\Commonmark\V2\TorchlightExtension;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'rss'], function (){
    Route::get('articles', [RSSFeedController::class, 'articles']);
});
