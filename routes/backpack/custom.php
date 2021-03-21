<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    Route::get('dashboard', 'DashboardRootController@dashboard');
    Route::get('/', 'DashboardRootController@redirect');

    Route::crud('tag', 'TagCrudController');
    Route::crud('article', 'ArticleCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('usersocial', 'UserSocialCrudController');
    Route::crud('admin', 'AdminCrudController');


    /**
     * Chart api endpoints
     */
    Route::get('charts/latest-user', 'Charts\LatestUserChartController@response')->name('charts.latest-user.index');
    Route::get('charts/latest-articles', 'Charts\LatestArticlesChartController@response')->name('charts.latest-articles.index');
}); // this should be the absolute last line of this file
