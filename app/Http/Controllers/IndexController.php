<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function show(Request $request) {
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

        $getLastComments = DB::select("SELECT p.id_post, u.folder, u.img_type, u.login, p.heading, c.created_at FROM comment as c JOIN user as u ON c.id_author = u.id_user JOIN post as p ON c.id_post = p.id_post WHERE p.id_status = ? ORDER BY id_comment DESC LIMIT ?, ?", [2, 0, 3]);

        foreach ($getLastComments as &$comment) {
            $comment['img_url'] = isset($comment['folder']) && isset($comment['img_type'])
                ? route('/') . '/storage/data/users/' . $comment['folder'] . '/' . 'avatar.' . $comment['img_type']
                : route('/') . '/public/imgs/profile.png';
        }

        return view('index', [
            'getCategory' => $getCategory,
            'getTag' => $getTag,
            'order' => $order,
            'category' => $category,
            'getCountDefaultCategory' => $getCountDefaultCategory,
            'tag' => $tag,
            'getLastComments' => $getLastComments,
        ]);
    }
}
