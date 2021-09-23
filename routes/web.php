<?php

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

//$body = '
//## Lists
//
//```js
//console.log("heyyy")
//```
//';
//
//
//Route::get('/', function () use ($body) {
//    $config = [
//        'heading_permalink' => [
//            'html_class' => 'heading-permalink',
//            'id_prefix' => 'content',
//            'fragment_prefix' => 'content',
//            'insert' => 'before',
//            'min_heading_level' => 1,
//            'max_heading_level' => 6,
//            'title' => 'Permalink',
//            'symbol' => HeadingPermalinkRenderer::DEFAULT_SYMBOL
//        ],
//    ];
//    $converter = new CommonMarkConverter();
//    $converter->getEnvironment()->addExtension(new HeadingPermalinkExtension());
//    $converter->getEnvironment()->addExtension(new TableExtension());
//    $converter->getEnvironment()->addExtension(new TorchlightExtension);
//    return $converter->convertToHtml($body);
//});


//\Illuminate\Support\Facades\Broadcast::routes(['middleware' => ['auth:sanctum']]);
