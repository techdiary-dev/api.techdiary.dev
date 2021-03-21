<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\User;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Routing\Controller;

class DashboardRootController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->basic();

        /**
         * Add widgets
         */
        // First Row
        Widget::add()->to('before_content')->type('div')->class('row')->content([
            $this->counterCardWidget('TOTAL ARTICLES', Article::count()),
            $this->counterCardWidget('PENDING ARTICLES', Article::where('isApproved', false)->count(), 'warning text-dark'),
            $this->counterCardWidget('TOTAL USERS', User::count(), 'info')
        ]);

        // Second Row
        Widget::add()->to('before_content')->type('div')->class('row')->content([
            $this->currentMonthStatesChart()
        ]);


        return view(backpack_view('dashboard'), $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(backpack_url('dashboard'));
    }

    public function basic()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
        $this->data['breadcrumbs'] = [
            trans('backpack::crud.admin') => backpack_url('dashboard'),
            trans('backpack::base.dashboard') => false,
        ];
    }


    /**
     * Counter card widget
     * @param $title
     * @param int $count
     * @param string $theme
     * @return mixed
     */
    protected function counterCardWidget($title, $count = 0, $theme = 'primary')
    {
        return Widget::make()
            ->type('progress')
            ->wrapper(['class' => 'col-sm-6 col-md-4'])
            ->class("card border-0 text-white bg-$theme")
            ->value($count)
            ->description($title);
    }

    protected function currentMonthStatesChart()
    {
        return [
            'type' => 'chart',
            'controller' => \App\Http\Controllers\Admin\Charts\LatestArticlesChartController::class,
            'wrapperClass' => 'col-md-12',
            'content' => [
                'header' => 'Current month states'
            ]
        ];
    }
}
