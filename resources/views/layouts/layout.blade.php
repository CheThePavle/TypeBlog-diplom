<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/bootstrap/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/bootstrap/js/bootstrap.min.js') }}">
    <link rel="stylesheet" href="{{ asset('libs/FontAwesome6/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
    <link rel="shortcut icon" href="{{ asset('imgs/favicon.png') }}" type="image/x-icon">
    <script src="{{ asset('libs/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/loader.js') }}"></script>
    <script src="{{ asset('js/functions/normalizeSpace.js') }}"></script>
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

    <div class="navbar navbar-default" role="navigation" id="slide-nav" style="z-index: 999">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-toggle">
                    <span class="sr-only">Открыть меню</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="navbar-brand" href="/">TypeBlog</a>
            </div>

            <div id="slidemenu">
                <form class="navbar-form navbar-right">
                    <div class="form-group" id="block_search">
                        <input type="search" placeholder="Найти" class="form-control" id="searchPostAndUser" maxlength="50">
                        <ul class="resultSearch"></ul>
                    </div>
                </form>

                <ul class="nav navbar-nav">
                    <li class="{{ Route::is('/') ? 'active' : ''}}"><a href="{{ asset('/') }}">Все посты</a></li>
                    <li class="randomPost"><a href="#">Случайный пост</a></li>
                    @auth()
                        <li><a href="{{ route('lk') }}">Привет, {{ auth()->user()->login }}</a></li>
                        <li><a href="{{ route('logout') }}">Выход</a></li>
                    @endauth
                    @guest()
                        <li class="{{ Route::is('login') ? 'active' : ''}}"><a href="{{ route('login') }}">Вход</a></li>
                        <li class="{{ Route::is('register') ? 'active' : ''}}"><a href="{{ route('register') }}">Регистрация</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row" >
            <div class="col-lg-12">

                @yield('content')

            </div>
        </div>
    </div>

    <footer>
        <div class="footer-bottom">
            <div class="container footer_cont">
                <div class="row footer_row">
                    <p class="pull-left">Copyright ©2021-2022</p>
                    <p class="pull-right">Чикуров Павел</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
