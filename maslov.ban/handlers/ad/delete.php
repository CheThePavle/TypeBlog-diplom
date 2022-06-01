<?php
    require_once '../../vendor/db.php';
    require_once '../../vendor/functions.php';

    if (isset($_SESSION['id_role']) && $_SESSION['id_role'] == 2) {
        $idAd = validate($_POST['idAd']);

        //$db->make();

        $_SESSION['msg'] = 'Объявление типо удалено) + надо будет удалить все связанные данные с этим объявление и + картинки почистить';
        header("Location: ".$_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }

