<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <script src="/public/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="/public/css/index.css">
    <link rel="icon" type="image/png" href="/public/img/logo.png">
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
                        <a class="nav-link <?= !isset($_GET['q']) ? 'active' : '' ?>" href="/">Главная</a>
                    </li>
                    <?php
                        if (isset($_SESSION['id_user'])) {
                            $activeLk = isset($_GET['q']) && $_GET['q'] == 'lk' ? 'active' : '';
                            echo "
                                <li class='nav-item'>
                                    <a class='nav-link $activeLk' href='/lk'>Личный кабинет</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='/handlers/logout.php'>Выйти</a>
                                </li>
                            ";
                        } else {
                            $activeLogin = isset($_GET['q']) && $_GET['q'] == 'login' ? 'active' : '';
                            $activeRegister = isset($_GET['q']) && $_GET['q'] == 'register' ? 'active' : '';
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
                    <li class="nav-item marksMenu">
                        <div class="row mt-5 text-center marks">
                            <?php
                                if (count($props['marks']) > 0) {
                                    foreach ($props['marks'] as $mark) {
                                        $id = $mark['id_object'];
                                        $name = $mark['name_object'];
                                        $url = $mark['url_img'];

                                        echo "
                                            <div class='col-sm-6 col-xl-3 mb-3 d-flex align-items-center justify-content-center'>
                                                <a href='/ad/search?mark=$id' class='markBtn'>
                                                    <img src='$url' alt='mark'>
                                                    <span>$name</span>
                                                </a>
                                            </div>
                                        ";
                                    }
                                }
                            ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
