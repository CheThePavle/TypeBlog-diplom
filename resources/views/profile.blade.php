@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Профиль пользователя ({{ $getUser['login'] }})</title>
    <meta name='description' content='Профиль пользователя на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='профиль, пользователь, жалоба, посты' />
    <link rel='stylesheet' href='{{ asset('styles/pages/profile.css') }}'>
    <script src='{{ asset('js/pages/profile.js') }}'></script>
    <link rel='stylesheet' href='{{ asset('styles/components/postLoader.css') }}'>
@endsection

@section('content')
    <div class="tab-pane active" id="tab1">
        <div class="bg_shapka_lk">
            <br><br>
            <div class="prfole_block">
                <div class="ava_block">
                    <div class="block_ava_img">
                        <img class="ava_img" src="{{ $getUser['img_url'] }}" alt="avatar">
                    </div>
                    <input id="btn-auth" type="submit" class="btn btn-danger complaint_profile_btn" value="Пожаловаться">
                </div>
                <div class="info_user">
                    <br><br>
                    <h2>{{ $getUser['login'] }}</h2>
                    <p>Статус: {{ $getUser['name'] }}</p>
                    <p>{{ $getUser['about'] }}</p>
                </div>
            </div>
            <div class="modal modal_complaint" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Жалоба на пользователя</h5>
                        </div>
                        <form id="formComplaint">
                            <div class="modal-body">
                                <textarea class="form-control" maxlength="200" id="body_complaint" name="body_complaint" rows="1" placeholder="Что случилось?"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary send_complaint">Отправить</button>
                                <button type="button" class="btn btn-secondary closed_complaint" data-dismiss="modal">Отмена</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg_shapka2_lk"></div>
        <div>
            <h1 style="margin-top: 30px">Публичные посты</h1>
            <hr>
            <div class="posts"></div>
            <div class="msg"></div>

            <x-post-loader/>

        </div>
    </div>
@endsection
