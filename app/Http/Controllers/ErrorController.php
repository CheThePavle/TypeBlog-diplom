<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function show($id) {
        $id = correct($id);

        if ($id == 404) {
            return view('errors.404');
        }

        return view('errors.error', ['number' => $id]);
    }
}
