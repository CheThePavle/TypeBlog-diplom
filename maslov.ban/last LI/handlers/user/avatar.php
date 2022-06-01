<?php
    require_once '../../vendor/db.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }

    $ava = $_FILES['ava'];
    $idUser = $_SESSION['id_user'];

    if ($ava['size'] > 5000000) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        $_SESSION['errorAva'] = 'Размер аватара превышает 5 МБ';
        exit();
    }

    switch ($ava['type']) {
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
            header("Location: ".$_SERVER['HTTP_REFERER']);
            $_SESSION['errorAva'] = 'Аватар должен быть в формате jpg, jpeg, png или gif';
            exit();
    }

    $newDir = '../../public/img/avatars';
    $uniq = md5(uniqid(rand(), true));
    if (!move_uploaded_file($ava['tmp_name'], $newDir.'/'.$uniq.'.'.$typeMainImg)) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        $_SESSION['errorAva'] = 'Что-то пошло не так, аватар не загружен';
        exit();
    }
    $url = '/public/img/avatars/'.$uniq.'.'.$typeMainImg;

    $checkAva = $db->query("SELECT id_avatar FROM `user` WHERE id_user = ?", [$idUser]);
    $checkAva = $checkAva[0];

    if (isset($checkAva['id_avatar'])) {
        $imgInfo = $db->query("SELECT url_img FROM img WHERE id_img = ?", [$checkAva['id_avatar']]);
        $imgInfo = $imgInfo[0];

        $path = '../..' . $imgInfo['url_img'];
        if (file_exists($path)) {
            unlink($path);
        }

        $db->make("UPDATE `img` SET `url_img` = ? WHERE `img`.`id_img` = ?;", [$url, $checkAva['id_avatar']]);
    } else {
        $db->make("INSERT INTO `img` (`url_img`) VALUES (?);", [$url]);
        $idLastImg = $db->query("SELECT id_img FROM `img` ORDER BY id_img DESC LIMIT 1");
        $idLastImg = $idLastImg[0]['id_img'];

        $db->make("UPDATE `user` SET `id_avatar` = ? WHERE `user`.`id_user` = ?" ,[
            $idLastImg,
            $idUser
        ]);
    }

    $getAva = $db->query("SELECT id_avatar FROM `user` WHERE id_user = ?", [$idUser]);
    $getAva = $getAva[0];
    $_SESSION['id_avatar'] = $getAva['id_avatar'];

    header("Location: ".$_SERVER['HTTP_REFERER']);
    $_SESSION['msgAva'] = 'Аватар изменен';

