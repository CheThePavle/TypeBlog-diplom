<?php
    $ads = $db->query("SELECT * FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN user as u ON a.id_creator_ad = u.id_user
        WHERE a.id_status_ad = ? ORDER BY a.id_ad DESC;", [1]);

    foreach ($ads as &$ad) {
        $ad['body_ad'] = json_decode($ad['body_ad'], true);
    }

    $props['ads'] = $ads;
