<?php
    $models = $db->query("SELECT * FROM object
            WHERE id_type_object = ?;", [2]);

    $props['models'] = $models;

