<?php
    require_once '../../vendor/db.php';
    require_once '../../vendor/functions.php';

    if (isset($_SESSION['id_role']) && $_SESSION['id_role'] == 2) {
        $idAd = validate($_POST['idAd']);

        $db->make("UPDATE `ad` SET `id_status_ad` = ? WHERE `ad`.`id_ad` = ?", [4, $idAd]);

        $_SESSION['msg'] = 'Объявление отклонено';
        header("Location: ".$_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }
