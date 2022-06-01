<?php
    $marks = $db->query("SELECT * FROM object
        WHERE id_type_object = ?;", [1]);
    $models = $db->query("SELECT * FROM object
            WHERE id_type_object = ?;", [2]);

    $props['marks'] = $marks;
    $props['models'] = $models;

