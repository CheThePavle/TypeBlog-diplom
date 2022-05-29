@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Изменение пароля</title>
    <meta name='description' content='Изменение пароля на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='пароль, изменение, редактирование, смена' />
    <link rel='stylesheet' href='{{ asset('styles/pages/user/change/password.css') }}'>
@endsection

@section('scripts')
    <script src='{{ asset('js/pages/user/change/password.js') }}'></script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h1 class="text-center title">Изменить пароль</h1>

            <x-panel-lk />

            <form id="formChangePassword">
                <div>
                    <label class="labelPassword">Старый пароль <span class="required">*</span></label>
                    <div class="passwordBlock">
                        <input id="oldPassword" maxlength="32" type="password" name="oldPassword" placeholder="Введите свой старый пароль *" required="required">
                        <i class="fas fa-eye-slash eyePassword eye1"></i>
                    </div>
                </div>

                <div>
                    <label class="labelPassword">Новый пароль <span class="required">*</span></label>
                    <div class="passwordBlock">
                        <input id="newPassword" maxlength="32" type="password" name="newPassword" placeholder="Введите новый пароль *" required="required">
                        <i class="fas fa-eye-slash eyePassword eye2"></i>
                    </div>
                    <div class="errorNewPassword"></div>
                </div>

                <div>
                    <label class="labelPassword">Повторите новый пароль <span class="required">*</span></label>
                    <div class="passwordBlock">
                        <input id="newPassword2" maxlength="32" type="password" name="newPassword2" placeholder="Введите снова новый пароль *" required="required">
                        <i class="fas fa-eye-slash eyePassword eye3"></i>
                    </div>
                    <div class="errorNewPassword2"></div>
                </div>

                <div>
                    <button type="submit" class="btn hoverBtn btn-success btn_change_password"><span>Изменить</span></button>
                </div>
            </form>
            <br>
            <div class="msg"></div>
        </div>
    </div>

@endsection
