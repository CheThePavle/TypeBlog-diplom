<?php
    function addWhere($where, $add, $and = true) {
        if ($where) {
            if ($and) $where .= " AND $add";
            else $where .= " OR $add";
        }
        else $where = $add;
        return $where;
    }

    $idMark = isset($_GET["mark"]) ? validate($_GET["mark"]) : false;

    $s = isset($_GET["s"]) ? validate($_GET["s"]) : false;

    $priceStart = isset($_GET["priceStart"]) ? validate($_GET["priceStart"]) : false;
    $priceEnd = isset($_GET["priceEnd"]) ? validate($_GET["priceEnd"]) : false;

    $runStart = isset($_GET["runStart"]) ? validate($_GET["runStart"]) : false;
    $runEnd = isset($_GET["runEnd"]) ? validate($_GET["runEnd"]) : false;

    $engineStart = isset($_GET["engineStart"]) ? validate($_GET["engineStart"]) : false;
    $engineEnd = isset($_GET["engineEnd"]) ? validate($_GET["engineEnd"]) : false;

    $yearStart = isset($_GET["yearStart"]) ? validate($_GET["yearStart"]) : false;
    $yearEnd = isset($_GET["yearEnd"]) ? validate($_GET["yearEnd"]) : false;

    $order = isset($_GET["order"]) ? validate($_GET["order"]) : false;

    $sql = "";
    $params = [2];
    $where = "";

    if ($idMark) {
        $params[] = $idMark;
        $where = addWhere($where, "o.id_object = ?");
    }

    if ($s) {
        $params[] = "%".$s."%";
        $where = addWhere($where, "a.title_ad LIKE ?");
    }

    if ($priceStart && !$priceEnd) {
        $params[] = $priceStart;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.price')*1 >= ?");
    }
    if ($priceEnd && !$priceStart) {
        $params[] = $priceEnd;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.price')*1 <= ?");
    }
    if ($priceStart && $priceEnd) {
        $params[] = $priceStart;
        $params[] = $priceEnd;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.price')*1 >= ? AND JSON_EXTRACT(body_ad, '$.price')*1 <= ?");
    }

    if ($runStart && !$runEnd) {
        $params[] = $runStart;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.run')*1 >= ?");
    }
    if ($runEnd && !$runStart) {
        $params[] = $runEnd;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.run')*1 <= ?");
    }
    if ($runStart && $runEnd) {
        $params[] = $runStart;
        $params[] = $runEnd;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.run')*1 >= ? AND JSON_EXTRACT(body_ad, '$.run')*1 <= ?");
    }

    if ($engineStart && !$engineEnd) {
        $params[] = $engineStart;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.engineCapacity')*1 >= ?");
    }
    if ($engineEnd && !$engineStart) {
        $params[] = $engineEnd;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.engineCapacity')*1 <= ?");
    }
    if ($engineStart && $engineEnd) {
        $params[] = $engineStart;
        $params[] = $engineEnd;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.engineCapacity')*1 >= ? AND JSON_EXTRACT(body_ad, '$.engineCapacity')*1 <= ?");
    }

    if ($yearStart && !$yearEnd) {
        $params[] = $yearStart;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.year')*1 >= ?");
    }
    if ($yearEnd && !$yearStart) {
        $params[] = $yearEnd;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.year')*1 <= ?");
    }
    if ($yearStart && $yearEnd) {
        $params[] = $yearStart;
        $params[] = $yearEnd;
        $where = addWhere($where, "JSON_EXTRACT(body_ad, '$.year')*1 >= ? AND JSON_EXTRACT(body_ad, '$.year')*1 <= ?");
    }

    if (!$idMark && !$s && !$priceStart && !$priceEnd && !$runStart && !$runEnd && !$engineStart && !$engineEnd && !$yearStart && !$yearEnd) {
        $sql = "SELECT a.id_ad, a.title_ad, i.url_img,
                    JSON_EXTRACT(body_ad, '$.price')*1 as price
                    FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN object as o ON a.id_mark_ad = o.id_object WHERE a.id_status_ad = ?";
    } else {
        $sql = "SELECT a.id_ad, a.title_ad, i.url_img,
                    JSON_EXTRACT(body_ad, '$.price')*1 as price
                    FROM ad as a JOIN img as i ON a.id_img_ad = i.id_img JOIN object as o ON a.id_mark_ad = o.id_object WHERE a.id_status_ad = ? AND";
    }

    if ($where) $sql .= " $where";

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


