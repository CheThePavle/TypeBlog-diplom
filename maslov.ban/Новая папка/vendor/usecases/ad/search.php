<?php
    $idMark = isset($_GET["mark"]) ? validate($_GET["mark"]) : false;

    $s = isset($_GET["s"]) ? validate($_GET["s"]) : false;
    $order = isset($_GET["order"]) ? validate($_GET["order"]) : false;

    $priceStart = isset($_GET["priceStart"]) ? validate($_GET["priceStart"]) : false;
    $priceEnd = isset($_GET["priceEnd"]) ? validate($_GET["priceEnd"]) : false;

    $where = !$s && !$priceStart && !$priceEnd && !$idMark ? '' : 'WHERE';

    $sql = "";
    $params = [];

    if ($idMark) {
        $params = [$idMark];
        if ($priceStart || $priceEnd) {
            $sql = "SELECT a.id_ad, a.title_ad, i.url_img, JSON_EXTRACT(body_ad, '$.price')*1 as price
        FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN object as o ON a.id_mark_ad = o.id_object WHERE o.id_object = ? AND ";
        } else {
            $sql = "SELECT a.id_ad, a.title_ad, i.url_img, JSON_EXTRACT(body_ad, '$.price')*1 as price
        FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN object as o ON a.id_mark_ad = o.id_object WHERE o.id_object = ? ";
        }

    } else {
        $sql = "SELECT a.id_ad, a.title_ad, i.url_img, JSON_EXTRACT(body_ad, '$.price')*1 as price FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img $where ";
    }

    if ($priceStart && !$priceEnd) {
        $params[] = $priceStart;
        $sql = $sql."JSON_EXTRACT(body_ad, '$.price')*1 >= ?";
    } elseif (!$priceStart && $priceEnd) {
        $params[] = $priceEnd;
        $sql = $sql."JSON_EXTRACT(body_ad, '$.price')*1 <= ?";
    } elseif ($priceStart && $priceEnd) {
        $params[] = $priceStart;
        $params[] = $priceEnd;
        $sql = $sql."JSON_EXTRACT(body_ad, '$.price')*1 >= ? AND JSON_EXTRACT(body_ad, '$.price')*1 <= ?";
    }

    if ($s) {
        $s = '%'.$s.'%';
        $params[] = $s;
        if ($priceStart || $priceEnd) {
            $sql = $sql." AND a.title_ad LIKE ?";
        } else {
            $sql = $idMark ? $sql." AND a.title_ad LIKE ?" : $sql." a.title_ad LIKE ?";
        }
    }

    if ($order == '0' || $order == '1') {
        switch ($order) {
            case '0':
                $sql = $sql." ORDER BY a.id_ad DESC;";
                break;
            case '1':
                $sql = $sql." ORDER BY a.id_ad ASC;";
                break;
            default:
                $sql = $sql." ORDER BY a.id_ad DESC;";
        }

    }

    $ads = $db->query($sql, $params);
    $props['ads'] = $ads;
