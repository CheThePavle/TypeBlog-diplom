<?php
    $getUrl = $_SERVER['REQUEST_URI'];
    $getUrl = explode('?', $getUrl);
    $getUrl = isset($getUrl[0]) ? $getUrl[0] : '/';
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <script src="/public/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="/public/css/index.css">
    <?= $props['styleAndScript'] ?>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/public/img/logo.png" alt="logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $getUrl == '/' ? 'active' : '' ?>" href="/">Главная</a>
                    </li>
                    <?php
                        if (isset($_SESSION['id_user'])) {
                            $activeLk = $getUrl == '/lk' ? 'active' : '';
                            echo "
                                <li class='nav-item'>
                                    <a class='nav-link $activeLk' href='/lk'>Личный кабинет</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='/handlers/logout.php'>Выйти</a>
                                </li>
                            ";
                        } else {
                            $activeLogin = $getUrl == '/login' ? 'active' : '';
                            $activeRegister = $getUrl == '/register' ? 'active' : '';
                            echo "
                                <li class='nav-item'>
                                    <a class='nav-link $activeLogin' href='/login'>Вход</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link $activeRegister' href='/register'>Регистрация</a>
                                </li>
                            ";
                        }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link btn" href="/ad/add">Разместить объявление</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
