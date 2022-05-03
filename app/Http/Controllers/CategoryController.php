<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function show(Request $request) {
        if (!Auth::check() || !Auth::user()->isAdmin()) return to_route('login');

        $getList = DB::select("SELECT * FROM category ORDER BY id_category DESC;");

        $getList = arrayPaginate($getList, $request);

        return view('category.list', ['getList' => $getList]);
    }

    public function change(Request $request) {
        $idCategory = correct($request->id);
        $changeCategory = correct($request->change_category);

        if (Auth::check() && Auth::user()->isAdmin()) {
            if (!$idCategory) {
                return result(409, "Категория не была передана!");
            }
            if (!$changeCategory) {
                return result(409, "Категория не может быть пустой!");
            }
            if (iconv_strlen($changeCategory) > 30) {
                return result(409, "Категория не может быть больше 30 символов!");
            }

            $res = DB::update("UPDATE `category` SET `name_category` = ? WHERE `category`.`id_category` = ?;", [
                $changeCategory,
                $idCategory
            ]);
            if (!$res) {
                return result(409, "Категория не изменена!");
            }
            return result(200, "Категория изменена!");
        } else {
            return result(409, "Извините нет доступа.");
        }

    }

    public function create(Request $request) {
        if (Auth::check() && Auth::user()->isAdmin()) {
            $nameCategory = correct($request->name_category);

            $res = DB::insert("INSERT INTO `category` (`name_category`) VALUES (?);", [$nameCategory]);
            if (!$res) {
                return result(409, "INSERT INTO `category` (`id_category`, `name_category`) VALUES ($nameCategory);");
            }

            return result(200, "Категория успешно добавлена");
        } else {
            return result(409, "Извините нет доступа.");
        }
    }

    public function delete(Request $request) {
        if (Auth::check() && Auth::user()->isAdmin()) {
            $idCategory = correct($request->id);

            $checkEmpty = DB::select("SELECT id_post FROM post WHERE id_category = ?;", [$idCategory]);
            if ($checkEmpty) {
                $idPost = $checkEmpty[0]['id_post'];
                return result(409, "Эта категория уже используется в посте с id - $idPost (уберите её сначала у поста)");
            }

            $res = DB::delete("DELETE FROM `category` WHERE `category`.`id_category` = ?;", [$idCategory]);
            if (!$res) {
                return result(409, "Не удалось удалить категорию");
            }

            return result(200, "Категория успешно удалена");
        } else {
            return result(409, "Извините нет доступа.");
        }
    }
}
