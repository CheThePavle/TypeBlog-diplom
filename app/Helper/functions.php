<?php
    //composer dump-auto

    use Illuminate\Pagination\LengthAwarePaginator;

    function arrayPaginate($array, $request, $perPage = 10)
    {
        $getPage = correct($request->page);

        $page = $getPage ? $getPage : 1;
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
    }

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
