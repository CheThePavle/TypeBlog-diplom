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

    <div class="container">
        <div class="row">
            <h1 class="text-center title">Профиль</h1>

            <div class="prfole_block">
                <div class="ava_block">
                    <div class="block_ava_img">
                        <img class="ava_img" src="{{ $getUser['img_url'] }}" alt="avatar">
                    </div>
                    <div class="info_user">
                        <h3>{{ $getUser['login'] }}</h3>
                        <p>{{ $getUser['name'] }}</p>
                        <div class="change_info">
                            <p class="aboutField">{{ $getUser['about'] }}</p>
                        </div>
                    </div>
                    <div class="btnChange">
                        <button id="btn-auth" type="submit" class="btn hoverBtn btn-danger complaint_profile_btn"><span>Пожаловаться</span></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h1 class="text-center titleMyPosts">Публичные посты</h1>
            <div class="col-lg-12">
                <div class="posts"></div>
                <div class="msg"></div>

                <x-post-loader/>
            </div>
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

@endsection
