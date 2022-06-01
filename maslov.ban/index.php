<?php
    require_once 'vendor/db.php';
    require_once 'vendor/functions.php';

    $url = (isset($_GET['q'])) ? $_GET['q'] : '';
    $url = rtrim($url, '/');
    $urls = explode('/', $url);

    $props = [];

//    echo '<pre>';
//    print_r($props['ads']);
//    echo '</pre>';

    if ($urls[0] === '' && sizeof($urls) === 1){
        require_once 'vendor/usecases/index.php';

        $props['styleAndScript'] = "
            <title>Бесплатные объявления</title>
            ";
        include_once 'pages/index.php';
        exit();
    }

    if ($urls[0] === 'register' && sizeof($urls) === 1){
        if (isset($_SESSION['id_user'])) {
            header("Location: /lk");
            exit();
        }

        $props['styleAndScript'] = "
            <title>Регистрация</title>
                ";
        include_once 'pages/register.php';
        exit();
    }

    if ($urls[0] === 'login' && sizeof($urls) === 1){
        if (isset($_SESSION['id_user'])) {
            header("Location: /lk");
            exit();
        }

        $props['styleAndScript'] = "
            <title>Авторизация</title>
                    ";
        include_once 'pages/login.php';
        exit();
    }

    if ($urls[0] === 'lk' && sizeof($urls) === 1){
        if (!isset($_SESSION['id_user'])) {
            header("Location: /login");
            exit();
        }

        require_once 'vendor/usecases/lk.php';

        $props['styleAndScript'] = "
            <title>Личный кабинет</title>
                        ";
        include_once 'pages/lk.php';
        exit();
    }

    if ($urls[0] === 'ad' && $urls[1] === 'add' && sizeof($urls) === 2){
        if (!isset($_SESSION['id_user'])) {
            header("Location: /login");
            exit();
        }

        require_once 'vendor/usecases/ad/add.php';

        $props['styleAndScript'] = "
            <script async src='/public/js/jquery.min.js'></script>
            <script async src='/public/js/add.js'></script>
            <title>Добавление объявления</title>
                                    ";
        include_once 'pages/ad/add.php';
        exit();
    }

    if ($urls[0] === 'ad' && $urls[1] === 'list' && sizeof($urls) === 2){
        if (!isset($_SESSION['id_user'])) {
            header("Location: /login");
            exit();
        }
        if (isset($_SESSION['id_role']) && $_SESSION['id_role'] == 2) {
            require_once 'vendor/usecases/ad/list.php';

            $props['styleAndScript'] = "
                <title>Отправленные объявления</title>
                                        ";
            include_once 'pages/ad/list.php';
            exit();
        } else {
            header("Location: /lk");
            exit();
        }
    }

    if ($urls[0] === 'ad' && $urls[1] === 'search' && sizeof($urls) === 2){
        require_once 'vendor/usecases/ad/search.php';

        $props['styleAndScript'] = "
            <title>Найденные объявления</title>
                                            ";
        include_once 'pages/ad/search.php';
        exit();
    }

    if ($urls[0] === 'ad' && sizeof($urls) === 2){
        require_once 'vendor/usecases/ad.php';

        $props['styleAndScript'] = "
            <title>Прсомотр объявления</title>
                            ";
        include_once 'pages/ad.php';
        exit();
    }

    http_response_code(404);
    include_once 'pages/404.php';