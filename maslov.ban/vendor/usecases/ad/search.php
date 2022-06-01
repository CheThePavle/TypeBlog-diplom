<?php
    if (isset($_GET["s"])) {
        $s = validate($_GET["s"]);
        $s = '%' . $s . '%';
        $ads = $db->query("SELECT * FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img WHERE a.id_status_ad = ? AND a.title_ad LIKE ? 
        ORDER BY a.id_ad DESC;", [2, $s]);
    } else {
        $ads = $db->query("SELECT * FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img WHERE a.id_status_ad = ?
        ORDER BY a.id_ad DESC;", [2]);
    }

    $props['ads'] = $ads;

    $marks = $db->query("SELECT * FROM object as o JOIN img as i ON o.id_img_object = i.id_img WHERE o.id_type_object = ?;", [1]);
    $props['marks'] = $marks;
