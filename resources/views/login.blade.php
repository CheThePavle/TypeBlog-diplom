@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Авторизация</title>
    <meta name='description' content='Авторизация на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='авторизация, вход' />
    <link rel='stylesheet' href='{{ asset('styles/pages/login.css') }}'>
@endsection

@section('scripts')
    <script src='{{ asset('js/pages/login.js') }}'></script>
@endsection

@section('content')

    <form id="formAuth">
        <h1 class="text-center">Авторизация</h1>
        <div>
            <label class="labelAuth" for="login">Логин <span class="required">*</span></label>
            <input maxlength="25" id="login" type="text" name="login" placeholder="Ваш логин *" required="required">
            <div class="errorLogin"></div>
        </div>
        <div>
            <label class="labelAuth" for="password">Пароль <span class="required">*</span></label>
            <div class="passwordBlock">
                <input maxlength="32" id="password" type="password" name="password" placeholder="Ваш пароль *" required="required">
                <i class="fas fa-eye-slash eyePassword"></i>
            </div>
            <div class="errorPassword"></div>
        </div>

        {{--TODO время сессии--}}
        {{--            <div class="form-check">--}}
        {{--                <input class="form-check-input" name="checkbox" type="checkbox" value="true" id="flexCheckDefault">--}}
        {{--                <label class="form-check-label" for="flexCheckDefault" style="cursor: pointer">--}}
        {{--                    Запомнить меня--}}
        {{--                </label>--}}
        {{--            </div>--}}

        <div class="msg"></div>

        <div>
            <button id="btn-auth" class="btn hoverBtn">Войти</button>
        </div>
        <div class="text-center">
            <p>У вас нет аккаунта? <a href="{{ route('register') }}">Регистрация</a></p>
        </div>
    </form>



{{--    <h1 class="text-center">Вход</h1>--}}

{{--    <form id="formAuth">--}}
{{--        <div class="controls">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-6">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="login">Логин <span class="required">*</span></label>--}}
{{--                        <input maxlength="25" id="login" type="text" name="login" class="form-control" placeholder="Ваш логин *" required="required">--}}
{{--                        <div class="errorLogin"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row">--}}
{{--                <div class="col-md-6">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="password">Пароль <span class="required">*</span></label>--}}
{{--                        <div class="passwordBlock">--}}
{{--                            <input maxlength="32" id="password" type="password" name="password" class="form-control" placeholder="Ваш пароль *" required="required">--}}
{{--                            <i class="fas fa-eye-slash eyePassword"></i>--}}
{{--                        </div>--}}
{{--                        <div class="errorPassword"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <input id="btn-auth" type="submit" class="btn btn-success btn-send" value="Войти">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <br>--}}
{{--        <div class="msg"></div>--}}
{{--    </form>--}}
@endsection
