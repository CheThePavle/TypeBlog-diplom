<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show($id) {
        $id = correct($id);
        $getUser = DB::select("SELECT u.login, u.about, ur.name, u.folder, u.img_type  FROM user as u JOIN user_role as ur ON ur.id_role = u.id_role WHERE u.id_user = ?;", [$id]);
        $getUser = $getUser[0] ?? null;

        if (!$getUser) {
            return to_route('error', ['number' => 404]);
        }

        //fixme
        $getUser['img_url'] = $getUser['folder'] && $getUser['img_type'] ? route('/') . '/storage/data/users/' . $getUser['folder'] . '/' . 'avatar.' . $getUser['img_type'] : '/public/imgs/profile.png';

        return view('profile', ['getUser' => $getUser]);
    }
}
