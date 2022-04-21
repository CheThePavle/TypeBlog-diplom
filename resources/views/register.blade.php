@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Регистрация</title>
    <meta name='description' content='Регистрация на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='регистрация, аккаунт' />
    <link rel='stylesheet' href='{{ asset('styles/pages/register.css') }}'>
    <script src='{{ asset('js/pages/register.js') }}'></script>
@endsection

@section('content')
    <h1 class="text-center">Регистрация</h1>

    <form id="formReg">
        <div class="controls">
            <div class="row stage1">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="login">Логин <span class="required">*</span></label>
                        <input maxlength="25" id="login" type="text" name="login" class="form-control" placeholder="Придумайте логин *" required="required">
                        <div class="errorLogin"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Электронная почта <span class="required">*</span></label>
                        <input maxlength="100" id="email" type="text" name="email" class="form-control" placeholder="Ваша эл. почта *" required="required">
                        <div class="errorEmail"></div>
                    </div>
                </div>
            </div>

            <div class="row stage1">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Пароль <span class="required">*</span></label>
                        <div class="passwordBlock">
                            <input maxlength="32" id="password" type="password" name="password" class="form-control" placeholder="Придумайте пароль *" required="required">
                            <i class="fas fa-eye-slash eyePassword eye1"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password2">Повторите пароль <span class="required">*</span></label>
                        <div class="passwordBlock">
                            <input maxlength="32" id="password2" type="password" name="password2" class="form-control" placeholder="Введите еще раз ваш пароль *" required="required">
                            <i class="fas fa-eye-slash eyePassword eye2"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="errorPassword"></div>

            <div class="row">
                <div class="col-md-12 stage1">
                    <div class="form-group">
                        <label for="about">О себе</label>
                        <textarea maxlength="1000" id="about" name="about" class="form-control" placeholder="Кратко о себе" rows="4"></textarea>
                    </div>
                </div>

                <div class="form-check stage1" style="margin-left: 15px">
                    <input class="form-check-input" name="checkbox" type="checkbox" value="true" required="required" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault" style="cursor: pointer">
                        Принять <a target="_blank" href="{{ asset('documents/agreement.pdf')}}">пользовательское соглашение</a>
                    </label>
                </div>

                <div class="verifyEmail"></div>

                <div class="col-md-12">
                    <input type="submit" class="btn btn-success btn-send stage2" value="Зарегистрироваться">
                </div>
            </div>
        </div>

        <br>
        <div class="msg"></div>
    </form>
@endsection
