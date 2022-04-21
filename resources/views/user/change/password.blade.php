@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Изменение пароля</title>
    <meta name='description' content='Изменение пароля на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='пароль, изменение, редактирование, смена' />
    <link rel='stylesheet' href='{{ asset('styles/pages/user/change/password.css') }}'>
    <script src='{{ asset('js/pages/user/change/password.js') }}'></script>
@endsection

@section('content')
    <div class="tabbable">

        <x-panel-lk />

        <div class="tab-content">
            <div class="tab-pane active">
                <form id="formChangePassword">
                    <div class="controls">
                        <div class="row">
                            <br>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Старый пароль <span class="required">*</span></label>
                                    <div class="passwordBlock">
                                        <input id="oldPassword" maxlength="32" type="password" name="oldPassword" class="form-control" placeholder="Введите свой старый пароль *" required="required">
                                        <i class="fas fa-eye-slash eyePassword eye1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Новый пароль <span class="required">*</span></label>
                                    <div class="passwordBlock">
                                        <input id="newPassword" maxlength="32" type="password" name="newPassword" class="form-control" placeholder="Введите новый пароль *" required="required">
                                        <i class="fas fa-eye-slash eyePassword eye2"></i>
                                    </div>
                                    <div class="errorNewPassword"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Повторите новый пароль <span class="required">*</span></label>
                                    <div class="passwordBlock">
                                        <input id="newPassword2" maxlength="32" type="password" name="newPassword2" class="form-control" placeholder="Введите снова новый пароль *" required="required">
                                        <i class="fas fa-eye-slash eyePassword eye3"></i>
                                    </div>
                                    <div class="errorNewPassword2"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <input type="submit" class="btn btn-success btn_change_password" value="Изменить">
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div class="msg"></div>
            </div>
        </div>
    </div>
@endsection
