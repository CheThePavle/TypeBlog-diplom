<?php
    require_once '../vendor/db.php';
    require_once '../vendor/functions.php'; // return validate()

    if (!isset($_SESSION['id_user'])) {
        $_SESSION['favorite'] = 'Чтобы добавить в изобранное нужно авторизоваться';
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }

    $idAd = validate($_POST['idAd']);

    $check = $db->query("SELECT * FROM `ad_favorite` WHERE id_ad = ? AND id_user = ?", [$idAd, $_SESSION['id_user']]);
    if (count($check) > 0) {
        $db->make("DELETE FROM ad_favorite WHERE id_ad = ? AND id_user = ?", [$idAd, $_SESSION['id_user']]);
        $_SESSION['favorite'] = 'Убрано из избранного';
    } else {
        $db->make("INSERT INTO `ad_favorite` (`id_ad`, `id_user`) VALUES (?, ?)", [$idAd, $_SESSION['id_user']]);
        $_SESSION['favorite'] = 'Добавлено в избранное';
    }

    header("Location: ".$_SERVER['HTTP_REFERER']);