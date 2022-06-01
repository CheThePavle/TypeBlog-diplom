<?php
    $ads = $db->query("SELECT * FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img WHERE a.id_status_ad = ?;", [2]);
    $props['ads'] = $ads;

    $marks = $db->query("SELECT * FROM object as o JOIN img as i ON o.id_img_object = i.id_img WHERE o.id_type_object = ?;", [1]);
    $props['marks'] = $marks;