@extends(backpack_view('blank'))

@php
    $userCount = \App\Models\User::count();
    $articleCount = \App\Models\Article::count();

 	// notice we use Widget::add() to add widgets to a certain group
	Widget::add()->to('before_content')->type('div')->class('row')->content([
		// notice we use Widget::make() to add widgets as content (not in a group)
		Widget::make()
			->type('progress')
			->class('card border-0 text-white bg-primary')
			->value($userCount)
			->description('Registered users.'),

	    Widget::make()
            ->type('progress')
            ->class('card border-0 text-white bg-success')
            ->value($articleCount)
            ->description('Total Articles.'),
	]);
	 $widgets['before_content'][] = [
	  'type' => 'div',
	  'class' => 'row',
	  'content' => [ // widgets
	        [
		        'type' => 'chart',
		        'wrapperClass' => 'col-md-12',
		        // 'class' => 'col-md-6',
		        'controller' => \App\Http\Controllers\Admin\Charts\LatestArticlesChartController::class,
				'content' => [
				    'header' => 'Current month states', // optional
				    // 'body' => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>', // optional
		    	]
	    	],
		  	[
		        'type' => 'chart',
		        'wrapperClass' => 'col-md-6',
		        // 'class' => 'col-md-6',
		        'controller' => \App\Http\Controllers\Admin\Charts\LatestUserChartController::class,
				'content' => [
				    'header' => 'New Users Past 7 Days', // optional
				    // 'body' => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>', // optional

		    	]
	    	],
        ]
];

@endphp
