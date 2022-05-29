@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Личный кабинет</title>
    <meta name='description' content='Личный кабинет на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='лк, профиль, кабинет, личный' />
    <link rel='stylesheet' href='{{ asset('styles/pages/lk.css') }}'>
    <link rel='stylesheet' href='{{ asset('styles/components/postLoader.css') }}'>
@endsection

@section('scripts')
    <script src='{{ asset('js/pages/lk.js') }}'></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h1 class="text-center title">Личный кабинет</h1>

            <x-panel-lk />

            <div class="prfole_block">
                <div class="ava_block">
                    <div class="block_ava_img">
                        <img class="ava_img" src="{{ $getInfoUser[0]['img_url'] }}" alt="avatar">
                        <label class="label avaChange">
                            <i class="fas fa-image"></i>
                            <span class="title">Сменить аватар</span>
                            <form id="formAvatar">
                                <input id="uploadimage" type="FILE" name="image" class="href_avatar" accept=".jpg, .jpeg, .png, .gif">
                                <input type="submit" id="btn_uploadimage" hidden>
                            </form>
                        </label>
                    </div>
                    <div class="info_user">
                        <h3>{{ auth()->user()->login }}</h3>
                        <p>{{ auth()->user()->getRoleRus() }}</p>
                        <div class="change_info">
                            <p class="emailField"><i class="fa fa-envelope" aria-hidden="true"></i> {{ $getInfoUser[0]['email'] }}</p>
                            <p class="aboutField">{{ $getInfoUser[0]['about'] }}</p>
                        </div>
                    </div>
                    <div class="btnChange">
                        <button type="submit" class="btn hoverBtn change_profile_btn"><span>Редактировать</span></button>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="text-center titleMyPosts">Мои посты</h1>
        <div class="row posts justify-content-center"></div>
        <div class="msg"></div>

        <x-post-loader/>
    </div>
@endsection
