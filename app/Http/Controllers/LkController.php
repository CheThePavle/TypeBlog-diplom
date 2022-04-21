<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LkController extends Controller
{
    public function show() {
        if (!Auth::check()) return to_route('login');

        $getInfoUser = DB::select("SELECT about, folder, img_type, email FROM user WHERE id_user = ?;", [Auth::user()->id_user]);

        $getInfoUser[0]['img_url'] = $getInfoUser[0]['folder'] && $getInfoUser[0]['img_type']
            ? route('/') . '/storage/data/users/' . $getInfoUser[0]['folder'] . '/' . 'avatar.' . $getInfoUser[0]['img_type']
            : route('/') . '/public/imgs/profile.png';

        return view('lk', ['getInfoUser' => $getInfoUser]);
    }
}
