<?php
    //composer dump-auto

    function correct($data) {
        $data = trim($data);
        $data = preg_replace('/\s+/', ' ', $data);
        $data = strip_tags($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function result($status, $msg = "", $data = []){
        return response()->json([
            "status"=>$status,
            "result"=>[
                "msg"=>$msg,
                "data"=>$data
            ]
        ], $status);
    }

    // как в laravel 9
    function to_route($route, $params = []) {
        return redirect(route($route, $params));
    }
