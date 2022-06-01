<?php
    require_once '../../vendor/db.php';
    require_once '../../vendor/functions.php';

    $idAd = validate($_POST['idAd']);

    $ad = $db->query("SELECT id_ad, id_creator_ad, id_img_ad  FROM ad WHERE id_ad = ?", [$idAd]);
    if (count($ad) < 1) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }
    $ad = $ad[0];

    $author = false;
    if (isset($_SESSION['id_user'])) {
        if ($ad['id_creator_ad'] == $_SESSION['id_user']) {
            $author = true;
        }
    }


    if ((isset($_SESSION['id_role']) && $_SESSION['id_role'] == 2) || $author) {
        $mainImg = $db->query("SELECT *  FROM img WHERE id_img = ?", [$ad['id_img_ad']]);
        $mainImg = $mainImg[0];

        if (file_exists('../..'.$mainImg['url_img'])) {
            unlink('../..'.$mainImg['url_img']);
        }

        $imgs = $db->query("SELECT *  FROM img_ad as ia JOIN img as i ON ia.id_img = i.id_img WHERE ia.id_ad = ?", [$ad['id_ad']]);
        if (count($imgs) > 0) {
            foreach ($imgs as $img) {
                $db->make("DELETE FROM `img` WHERE `img`.`id_img` = ?", [$img['id_img']]);
                if (file_exists('../..'.$img['url_img'])) {
                    unlink('../..'.$img['url_img']);
                }
            }
        }

        $db->make("DELETE FROM `img_ad` WHERE `img_ad`.`id_img` = ?", [$ad['id_img_ad']]);
        $db->make("DELETE FROM `ad` WHERE `ad`.`id_ad` = ?", [$ad['id_ad']]);
        $db->make("DELETE FROM `img` WHERE `img`.`id_img` = ?", [$ad['id_img_ad']]);

        $_SESSION['msg'] = 'Объявление было успешно удалено';
        header("Location: ".$_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }

