<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/FontAwesome6/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
    <link rel="shortcut icon" href="{{ asset('imgs/favicon.png') }}" type="image/x-icon">
    <script src="{{ asset('libs/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/loader.js') }}"></script>
    <script src="{{ asset('js/functions/normalizeSpace.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('public/js/index.js') }}"></script>

    @yield('head')

</head>
<body>
    <div class="preloader">
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>

    <div class="notify"></div>

    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('/') }}">TypeBlog</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li><a class="nav-link {{ Route::is('/') ? 'active' : ''}}" href="{{ asset('/') }}">Все посты</a></li>
                            <li class="randomPost"><a class="nav-link" href="#">Случайный пост</a></li>
                            @auth()
                                <li><a class="nav-link" href="{{ route('lk') }}">Привет, {{ auth()->user()->login }}</a></li>
                                <li><a class="nav-link" href="{{ route('logout') }}">Выход</a></li>
                            @endauth
                            @guest()
                                <li><a class="nav-link {{ Route::is('login') ? 'active' : ''}}" href="{{ route('login') }}">Вход</a></li>
                                <li><a class="nav-link {{ Route::is('register') ? 'active' : ''}}" href="{{ route('register') }}">Регистрация</a></li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main>

        @yield('content')

    </main>

    <footer>
        <div class="container text-center">
            Copyright ©2022 All rights reserved | Сайт разработал Чикуров Павел, гр. ИС-18
        </div>
    </footer>
</body>
</html>
