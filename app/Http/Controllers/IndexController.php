<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function show(Request $request) {
        // последние 3 поста
        // SELECT * FROM `post` WHERE id_status = 2 ORDER BY id_post DESC LIMIT 0, 3


        // последние 3 комментария
        // SELECT * FROM comments as c JOIN post as p ON c.id_post = p.id_post WHERE p.id_status = 2 ORDER BY id_comment DESC LIMIT 0, 3

        $getCategory = DB::select("SELECT COUNT(c.id_category) as count, c.id_category, c.name_category FROM category as c JOIN post as p ON p.id_category = c.id_category WHERE p.id_status = ? GROUP BY c.id_category;", [2]);

        $getCountDefaultCategory = DB::select("SELECT COUNT(id_post) as count FROM `post` WHERE id_status = ?", [2]);
        $getCountDefaultCategory = $getCountDefaultCategory[0]['count'];

        $getDefaultCategory = DB::select("SELECT id_category, name_category FROM category WHERE id_category = ?", [1]);
        array_unshift($getCategory, $getDefaultCategory[0]);

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
            'getCountDefaultCategory' => $getCountDefaultCategory,
            'tag' => $tag,
        ]);
    }
}
