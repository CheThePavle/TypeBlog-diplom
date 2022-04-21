@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - 404 page not found</title>
    <meta name='description' content='Не найденная странциа на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='страница, пустая, 404' />
@endsection

@section('content')
    <div class="col-md-12 text-center">
        <h1 class="display-1 d-block">404</h1>
        <div class="mb-4 lead">Страница не найдена :(</div>
        <a href="{{ route('/') }}" class="btn btn-link">Вернуться на главную</a>
    </div>
@endsection
