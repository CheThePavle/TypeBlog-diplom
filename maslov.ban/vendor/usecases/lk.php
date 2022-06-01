<?php
    if (isset($_GET['favorite'])) {
        $ads = $db->query("SELECT * FROM ad_favorite as f JOIN ad as a ON f.id_ad = a.id_ad 
            JOIN img as i ON a.id_img_ad = i.id_img WHERE f.id_user = ? ORDER BY f.created_at_favorite DESC;", [$_SESSION['id_user']]);
    } elseif (isset($_GET['completed'])) {
        $ads = $db->query("SELECT a.id_ad, a.title_ad, i.url_img FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN ad_status as s ON a.id_status_ad = s.id_status
        WHERE a.id_creator_ad = ? AND a.id_status_ad = ? ORDER BY a.id_ad DESC;", [$_SESSION['id_user'], 5]);
    } else {
        $ads = $db->query("SELECT a.id_ad, a.title_ad, i.url_img, s.name_status FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN ad_status as s ON a.id_status_ad = s.id_status
        WHERE a.id_creator_ad = ? ORDER BY a.id_ad DESC;", [$_SESSION['id_user']]);
    }

    $props['ads'] = $ads;

