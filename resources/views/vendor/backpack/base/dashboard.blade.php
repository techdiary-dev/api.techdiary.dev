@extends(backpack_view('blank'))

@php
    $userCount = \App\Models\User::count();
    $articleCount = \App\Models\Article::count();


    Widget::add()->to('before_content')->type('div')->class('row')->content([

    ]);

@endphp

@section('content')

@endsection


