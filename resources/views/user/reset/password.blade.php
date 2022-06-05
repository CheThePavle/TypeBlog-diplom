@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Восстановление пароля</title>
    <meta name='description' content='Восстановление пароля на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='сброс, восстановление, пароль, аккаунт' />
    <link rel='stylesheet' href='{{ asset('styles/pages/user/reset/password.css') }}'>
@endsection

@section('content')

    <form id="formResetPassword" action="" method="post">
        @csrf
        @method("POST")
        <h1 class="text-center">Восстановление пароля</h1>
        <div>
            <label class="labelResetPassword" for="email">Email <span class="required">*</span></label>
            <input maxlength="255" id="email" type="email" name="email" placeholder="Ваша почта *" required="required">
            <div class="email"></div>
        </div>

        <div class="msg">
            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>

        <div>
            <button type="submit" class="btn hoverBtn">Восстановить пароль</button>
        </div>

        <div class="text-center">
            <p>Уже восстановили пароль? <a href="{{ route('login') }}">Авторизация</a></p>
        </div>
    </form>

@endsection
