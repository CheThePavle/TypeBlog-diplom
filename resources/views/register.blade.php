@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Регистрация</title>
    <meta name='description' content='Регистрация на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='регистрация, аккаунт' />
    <link rel='stylesheet' href='{{ asset('styles/pages/register.css') }}'>
    <script src='{{ asset('js/pages/register.js') }}'></script>
@endsection

@section('content')
{{--    <div id='stars'></div>--}}
{{--    <div id='stars2'></div>--}}
{{--    <div id='stars3'></div>--}}

    <form id="formReg">
        <h1 class="text-center">Регистрация</h1>

        <div class="row stage1">
            <div class="col-mb-12 col-lg-6 blockRegFields">
                <label class="labelReg" for="login">Логин <span class="required">*</span></label>
                <input maxlength="25" id="login" type="text" name="login" placeholder="Придумайте логин *" required="required">
                <div class="errorLogin blockRegFields"></div>
            </div>
            <div class="col-mb-12 col-lg-6 blockRegFields">
                <label class="labelReg" for="email">Электронная почта <span class="required">*</span></label>
                <input maxlength="100" id="email" type="text" name="email" placeholder="Ваша эл. почта *" required="required">
                <div class="errorEmail blockRegFields"></div>
            </div>
        </div>

        <div class="row stage1">
            <div class="col-mb-12 col-lg-6">
                <label class="labelReg" for="password">Пароль <span class="required">*</span></label>
                <div class="passwordBlock">
                    <input maxlength="32" id="password" type="password" name="password" placeholder="Придумайте пароль *" required="required">
                    <i class="fas fa-eye-slash eyePassword eye1"></i>
                </div>
            </div>
            <div class="col-mb-12 col-lg-6">
                <label class="labelReg" for="password2">Повторите пароль <span class="required">*</span></label>
                <div class="passwordBlock">
                    <input maxlength="32" id="password2" type="password" name="password2" placeholder="Введите еще раз ваш пароль *" required="required">
                    <i class="fas fa-eye-slash eyePassword eye2"></i>
                </div>
            </div>
        </div>
        <div class="errorPassword blockRegFields"></div>

        <div class="blockRegFields stage1">
            <label class="labelReg" for="about">О себе</label>
            <textarea maxlength="1000" id="about" name="about" placeholder="Кратко о себе" rows="4"></textarea>
        </div>

        <div class="blockRegFields stage1">
            <input name="checkbox" type="checkbox" required="required" id="checkbox">
            <label class="labelReg" for="checkbox" style="cursor: pointer">
                Принять <a target="_blank" href="{{ asset('documents/agreement.pdf')}}">пользовательское соглашение</a>
            </label>
        </div>

        <div class="verifyEmail"></div>

        <div class="blockRegFields msg"></div>

        <div class="blockRegFields">
            <button class="btn hoverBtn stage2">Зарегистрироваться</button>
        </div>
        <div class="blockRegFields text-center">
            <p>У вас есть аккаунт? <a href="#">Авторизация</a></p>
        </div>
    </form>

@endsection
