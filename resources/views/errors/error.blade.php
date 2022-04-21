@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - {{ $number ?? 500 }} error</title>
    <meta name='description' content='Что-то пошло не так, ошибка на сайте - {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='{{ $number ?? 500 }}' />
@endsection

@section('content')
    <div class="col-md-12 text-center">
        <h1 class="display-1 d-block">{{ $number ?? 500 }} ошибка</h1>
        <div class="mb-4 lead">что-то пошло не так :(</div>
        <a href="{{ url()->previous() }}" class="btn btn-link">Вернуться назад</a>
    </div>
@endsection
