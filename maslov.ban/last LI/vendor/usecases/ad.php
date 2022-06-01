<?php
    $idAd = validate($urls[1]);
    $ad = $db->query("SELECT * FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN object as o ON a.id_mark_ad = o.id_object
        JOIN user as u ON a.id_creator_ad = u.id_user WHERE a.id_ad = ?;", [$idAd]);
    $ad = $ad[0];
    $ad['body_ad'] = json_decode($ad['body_ad'], true);

    $ad['imgs'] = $db->query("SELECT * FROM img_ad as ia JOIN img as i ON ia.id_img = i.id_img WHERE ia.id_ad = ?;", [$idAd]);;

    if (isset($_SESSION['id_user'])) {
        $checkFavorite = $db->query("SELECT * FROM `ad_favorite` WHERE id_ad = ? AND id_user = ?", [$idAd, $_SESSION['id_user']]);
        if (count($checkFavorite) > 0) {
            $ad['favorite'] = true;
        }
    } else {
        $ad['favorite'] = false;
    }

    $props['ad'] = $ad;

    $model = $db->query("SELECT name_object FROM object WHERE id_object = ?;", [$ad['body_ad']['idModel']]);
    $model = $model[0]['name_object'];
    $props['ad']['name_model'] = $model;

    $phoneFormat = strval($props['ad']['phone']);
    $props['ad']['phone'] = '+'.substr($phoneFormat, 0, 1).'('.substr($phoneFormat, 1, 3).')'.substr($phoneFormat, 4, 3).'-'.substr($phoneFormat, 7, 2).'-'.substr($phoneFormat, 9, 2);