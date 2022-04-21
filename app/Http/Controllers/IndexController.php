<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function show(Request $request) {
        $getCategory = DB::select("SELECT * FROM `category`;");
        $getTag = DB::select("SELECT * FROM `tag`WHERE public_tag = ?;", [1]);
        $order = $request->order;
        $category = $request->category;
        $tag = $request->tag;
        // request()->get('tag')
        // json_decode(json_encode($getCategory), true)

        return view('index', [
            'getCategory' => $getCategory,
            'getTag' => $getTag,
            'order' => $order,
            'category' => $category,
            'tag' => $tag,
        ]);
    }
}
