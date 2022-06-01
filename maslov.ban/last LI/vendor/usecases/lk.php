<?php
    if (isset($_GET['favorite'])) {
        $ads = $db->query("SELECT a.id_ad, a.title_ad, i.url_img, id_creator_ad, JSON_EXTRACT(body_ad, '$.price')*1 as price FROM ad_favorite as f JOIN ad as a ON f.id_ad = a.id_ad 
        JOIN img as i ON a.id_img_ad = i.id_img WHERE f.id_user = ? ORDER BY f.created_at_favorite DESC;", [$_SESSION['id_user']]);
    } elseif (isset($_GET['completed'])) {
        $ads = $db->query("SELECT a.id_ad, a.title_ad, i.url_img, id_creator_ad, JSON_EXTRACT(body_ad, '$.price')*1 as price FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN ad_status as s ON a.id_status_ad = s.id_status
        WHERE a.id_creator_ad = ? AND a.id_status_ad = ? ORDER BY a.id_ad DESC;", [$_SESSION['id_user'], 5]);
    } elseif (isset($_GET['rejected'])) {
        $ads = $db->query("SELECT a.id_ad, a.title_ad, i.url_img, id_creator_ad, JSON_EXTRACT(body_ad, '$.price')*1 as price FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN ad_status as s ON a.id_status_ad = s.id_status
        WHERE a.id_creator_ad = ? AND a.id_status_ad = ? ORDER BY a.id_ad DESC;", [$_SESSION['id_user'], 4]);
    } elseif (isset($_GET['published'])) {
        $ads = $db->query("SELECT a.id_ad, a.title_ad, i.url_img, id_creator_ad, JSON_EXTRACT(body_ad, '$.price')*1 as price FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN ad_status as s ON a.id_status_ad = s.id_status
        WHERE a.id_creator_ad = ? AND a.id_status_ad = ? ORDER BY a.id_ad DESC;", [$_SESSION['id_user'], 2]);
    } elseif (isset($_GET['send'])) {
        $ads = $db->query("SELECT a.id_ad, a.title_ad, i.url_img, id_creator_ad, JSON_EXTRACT(body_ad, '$.price')*1 as price FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN ad_status as s ON a.id_status_ad = s.id_status
        WHERE a.id_creator_ad = ? AND a.id_status_ad = ? ORDER BY a.id_ad DESC;", [$_SESSION['id_user'], 1]);
    } else {
        $ads = $db->query("SELECT a.id_ad, a.title_ad, i.url_img, s.name_status, id_creator_ad, JSON_EXTRACT(body_ad, '$.price')*1 as price FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN ad_status as s ON a.id_status_ad = s.id_status
        WHERE a.id_creator_ad = ? ORDER BY a.id_ad DESC;", [$_SESSION['id_user']]);
    }

    $props['ads'] = $ads;

    $ava = $db->query("SELECT url_img FROM img WHERE id_img = ?", [$_SESSION['id_avatar']]);
    if (isset($ava[0]['url_img'])) {
        $ava = $ava[0]['url_img'];
    } else {
        $ava = '/public/img/user.png';
    }
    $props['urlAva'] = $ava;

