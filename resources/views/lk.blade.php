@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Личный кабинет</title>
    <meta name='description' content='Личный кабинет на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='лк, профиль, кабинет, личный' />
    <link rel='stylesheet' href='{{ asset('styles/pages/lk.css') }}'>
    <script src='{{ asset('js/pages/lk.js') }}'></script>
    <link rel='stylesheet' href='{{ asset('styles/components/postLoader.css') }}'>
@endsection

@section('content')
    <div class="tabbable">

        <x-panel-lk />

        <div class="tab-content">
            <div class="tab-pane active">
                <div class="bg_shapka_lk">
                    <br><br>
                    <div class="prfole_block">
                        <div class="ava_block">
                            <div class="block_ava_img">
                                <img class="ava_img" src="{{ $getInfoUser[0]['img_url'] }}" alt="avatar">
                                <label class="label" style="position: absolute">
                                    <i class="fas fa-image"></i>
                                    <span class="title">Сменить аватар</span>
                                    <form id="formAvatar">
                                        <input id="uploadimage" type="FILE" name="image" class="href_avatar" accept=".jpg, .jpeg, .png, .gif">
                                        <input type="submit" id="btn_uploadimage" hidden>
                                    </form>
                                </label>
                            </div>
                            <input type="submit" class="btn btn-primary change_profile_btn" value="Редактировать">
                        </div>
                        <div class="info_user">
                            <br><br>
                            <h2>{{ auth()->user()->login }}</h2>
                            <p>Статус: {{ auth()->user()->getRoleRus() }}</p>
                            <div class="change_info">
                                <p class="emailField">{{ $getInfoUser[0]['email'] }}</p>
                                <p class="aboutField">{{ $getInfoUser[0]['about'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg_shapka2_lk"></div>
                <div>
                    <h1 class="my_post_header">Мои посты</h1>
                    <hr>
                    <div class="posts"></div>
                    <div class="msg"></div>

                    <x-post-loader/>

                </div>
            </div>
        </div>
    </div>
@endsection
