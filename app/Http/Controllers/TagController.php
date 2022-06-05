<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function show(Request $request) {
        if (!Auth::check() || !Auth::user()->isAdmin()) return to_route('login');

        $getList = DB::select("SELECT * FROM tag ORDER BY id_tag DESC;");

        $getList = arrayPaginate($getList, $request);

        return view('tag.list', ['getList' => $getList]);
    }

    public function findByPostId(Request $request) {
        if (!Auth::check()) return result(409, "Нет доступа!");

        $idPost = correct($request->id);
        $infoPost = DB::select("SELECT id_status, id_creator FROM post WHERE id_post = ?;", [$idPost]);

        if ((Auth::user()->id_user == $infoPost[0]['id_creator'] && ($infoPost[0]['id_status'] == 3 || $infoPost[0]['id_status'] == 4)) || Auth::user()->isModerOrAdmin()) {
            $res = DB::select("SELECT t.name_tag FROM post_tag as pt JOIN tag as t ON t.id_tag = pt.id_tag WHERE pt.id_post = ?;", [$idPost]);

            return result(200, "", $res);
        } else {
            return result(409, "Нет доступа!");
        }
    }

    public function change(Request $request) {
        $idTag = correct($request->id);
        $changeTag = correct($request->change_tag);

        if (Auth::check() && Auth::user()->isAdmin()) {
            if (!$idTag) {
                return result(409, "Тег не был передан!");
            }
            if (!$changeTag) {
                return result(409, "Тег не может быть пустым!");
            }
            if (iconv_strlen($changeTag) > 25) {
                return result(409, "Тег не может быть больше 25 символов!");
            }

            $res = DB::update("UPDATE `tag` SET `name_tag` = ? WHERE `tag`.`id_tag` = ?;", [
                $changeTag,
                $idTag
            ]);
            if (!$res) {
                return result(409, "Тег не изменен!");
            }
            return result(200, "Тег изменен!");
        } else {
            return result(409, "Извините нет доступа.");
        }
    }

    public function delete(Request $request) {
        if (Auth::check() && Auth::user()->isAdmin()) {
            $idTag = correct($request->id);

            $checkEmpty = DB::select("SELECT * FROM post_tag WHERE id_tag = ?;", [$idTag]);
            if ($checkEmpty) {
                $idPost = $checkEmpty[0]['id_post'];
                return result(409, "Этот тег уже используется в посте с id - $idPost (удалите его сначала у поста)");
            }

            $res = DB::delete("DELETE FROM `tag` WHERE `tag`.`id_tag` = ?;", [$idTag]);
            if (!$res) {
                return result(409, "Не удалось удалить тег");
            }

            return result(200, "Тег успешно удален");
        } else {
            return result(409, "Извините нет доступа.");
        }
    }

    public function published(Request $request) {
        if (Auth::check() && Auth::user()->isAdmin()) {
            $idTag = correct($request->id);

            $res = DB::update("UPDATE `tag` SET `public_tag` = ? WHERE `tag`.`id_tag` = ?;", [1, $idTag]);
            if ($res) {
                return result(200, "Тег успешно опубликован!");
            } else {
                return result(409, "Что-то пошло не так, тег не опубликован");
            }
        } else {
            return result(409, "Извините нет доступа.");
        }
    }

    public function unpublished(Request $request) {
        if (Auth::check() && Auth::user()->isAdmin()) {
            $idTag = correct($request->id);

            $res = DB::update("UPDATE `tag` SET `public_tag` = ? WHERE `tag`.`id_tag` = ?;", [0, $idTag]);
            if ($res) {
                return result(200, "Тег успешно скрыт!");
            } else {
                return result(409, "Что-то пошло не так, тег не скрыт");
            }
        } else {
            return result(409, "Извините нет доступа.");
        }
    }
}
