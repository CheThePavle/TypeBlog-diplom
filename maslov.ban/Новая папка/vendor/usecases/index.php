<?php
    $ads = $db->query("SELECT a.id_ad, a.title_ad, i.url_img, JSON_EXTRACT(body_ad, '$.price')*1 as price FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img WHERE a.id_status_ad = ?;", [2]);
    $props['ads'] = $ads;
