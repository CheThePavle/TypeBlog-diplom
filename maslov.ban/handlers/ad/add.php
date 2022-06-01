<?php
    require_once '../../vendor/db.php';
    require_once '../../vendor/functions.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }

    $idMark = validate($_POST['mark']);
    $title_ad = validate($_POST['title_ad']);
    $description_ad = validate($_POST['description_ad']);

    $body = $_POST;
    unset($body['tab-group']); // fixme поменять на фронте, чтоб не приходил)
    unset($body['title_ad']);
    unset($body['description_ad']);
    unset($body['mark']);
    unset($body['model']);
    $body = array_filter($body, function($element) {
        return !empty($element);
    });
    $body = json_encode($body, JSON_UNESCAPED_UNICODE);

    // загрузка и проверка главного изображения
    $img = $_FILES['img'];
    if ($img['size'] > 5000000) {
        // ошибка
    }
    switch ($img['type']) {
        case 'image/jpeg':
        case 'image/pjpeg':
            $typeMainImg = 'jpeg';
            break;
        case 'image/png':
        case 'image/x-png':
            $typeMainImg = 'png';
            break;
        case 'image/gif':
            $typeMainImg = 'gif';
            break;
        default:
            // ошибка
    }

    $newDir = '../../public/img/adt';
    $uniq = md5(uniqid(rand(), true));
    if (!move_uploaded_file($img['tmp_name'], $newDir.'/'.$uniq.'.'.$typeMainImg)) {
        // ошибка
    }

    $url = '/public/img/adt/'.$uniq.'.'.$typeMainImg;
    $db->make("INSERT INTO `img` (`url_img`) VALUES (?);", [$url]);
    $idLastImg = $db->query("SELECT id_img FROM `img` ORDER BY id_img DESC LIMIT 1");
    $idLastImg = $idLastImg[0]['id_img'];

    $db->make("INSERT INTO `ad` (`id_creator_ad`, `id_status_ad`, `id_mark_ad`, `id_img_ad`, `title_ad`, `description_ad`, `body_ad`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)" ,[
        $_SESSION['id_user'],
        1,
        $idMark,
        $idLastImg,
        $title_ad,
        $description_ad,
        $body
    ]);
    $idLastAd = $db->query("SELECT id_ad FROM `ad` ORDER BY id_ad DESC LIMIT 1");
    $idLastAd = $idLastAd[0]['id_ad'];

    // загрузка и проверка доп. изображений
    $imgs = $_FILES['imgs'];
    $imgs = reArrayFiles($imgs);
    foreach ($imgs as $img) {
        if ($img['size'] > 5000000) {
            // ошибка
        }
        switch ($img['type']) {
            case 'image/jpeg':
            case 'image/pjpeg':
                $typeMainImg = 'jpeg';
                break;
            case 'image/png':
            case 'image/x-png':
                $typeMainImg = 'png';
                break;
            case 'image/gif':
                $typeMainImg = 'gif';
                break;
            default:
                // ошибка
        }

        $newDir = '../../public/img/adt';
        $uniq = md5(uniqid(rand(), true));
        if (!move_uploaded_file($img['tmp_name'], $newDir.'/'.$uniq.'.'.$typeMainImg)) {
            // ошибка
        }

        $url = '/public/img/adt/'.$uniq.'.'.$typeMainImg;
        $db->make("INSERT INTO `img` (`url_img`) VALUES (?);", [$url]);
        $idLastImg = $db->query("SELECT id_img FROM `img` ORDER BY id_img DESC LIMIT 1");
        $idLastImg = $idLastImg[0]['id_img'];

        $db->make("INSERT INTO `img_ad` (`id_img`, `id_ad`) VALUES (?, ?)" ,[
            $idLastImg,
            $idLastAd
        ]);
    }

    $_SESSION['msg'] = 'Объявление добавлено';
    header("Location: /lk");