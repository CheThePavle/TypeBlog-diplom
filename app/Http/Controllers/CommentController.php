<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function createReply(Request $request) {
        $idPost = correct($request->idPost);
        $parent_comment = correct($request->parent_comment);
        $id_parent_comment = correct($request->idParentComment);
        $id_author = Auth::check() ? Auth::user()->id_user : false;

        if (!$id_author) {
            return result(409, "Только зарегистрированные пользователи могут отвечать на комментарии!");
        }
        if (!$idPost) {
            return result(409, "Ответный комментарий не может быть добавлен к этому комментарию у этого поста!");
        }
        if (!$id_parent_comment) {
            return result(409, "Ответный комментарий не может быть добавлен к не существующему комментарию!");
        }
        if (!$parent_comment || iconv_strlen($parent_comment) < 1) {
            return result(409, "Ответный комментарий не должен быть пустым!");
        }
        if (iconv_strlen($parent_comment) > 1000) {
            return result(409, "Ответный комментарий не может быть больше 1000 символов!");
        }

        DB::insert("INSERT INTO `comment` (`id_post`, `id_author`, `body_comment`, `id_parent_comment`, `updated_at`) VALUES (?, ?, ?, ?, ?);", [
            $idPost,
            $id_author,
            $parent_comment,
            $id_parent_comment,
            NULL
        ]);

        return result(200, "Ответный комментарий добавлен!");

    }

    public function change(Request $request) {
        $idComment = correct($request->idComment);
        $change_comment = correct($request->change_comment);
        $id_author = Auth::check() ? Auth::user()->id_user : false;

        if (!$id_author) {
            return result(409, "Только зарегистрированные пользователи могут изменять свой комментарий!");
        }
        if (!$idComment) {
            return result(409, "Не удалось изменить не существующий комментарий!");
        }
        if (!$change_comment || iconv_strlen($change_comment) < 1) {
            return result(409, "Измененный комментарий не должен быть пустым!");
        }
        if (iconv_strlen($change_comment) > 1000) {
            return result(409, "Измененный комментарий не может быть больше 1000 символов!");
        }

        $res = DB::update("UPDATE `comment` SET `id_author` = ?, `body_comment` = ? WHERE `comment`.`id_comment` = ?;", [
            $id_author,
            $change_comment,
            $idComment
        ]);

        if ($res) {
            return result(200, "Комментарий изменен!");
        } else {
            return result(409, "Что-то пошло не так, невозможно изменить комментарий!");
        }
    }

    public function create(Request $request) {
        $idPost = correct($request->idPost);
        $comment = correct($request->comment);
        $id_author = Auth::check() ? Auth::user()->id_user : false;

        if (!$id_author) {
            return result(409, "Только зарегистрированные пользователи могут добавлять комментарий!");
        }
        if (!$idPost) {
            return result(409, "Комментарий не может быть добавлен на этот пост!");
        }
        if (!$comment || iconv_strlen($comment) < 1) {
            return result(409, "Комментарий не должен быть пустым!");
        }
        if (iconv_strlen($comment) > 1000) {
            return result(409, "Комментарий не может быть больше 1000 символов!");
        }

        DB::insert("INSERT INTO `comment` (`id_post`, `id_author`, `body_comment`, `updated_at`) VALUES (?, ?, ?, ?);", [
            $idPost,
            $id_author,
            $comment,
            NULL,
        ]);

        return result(200, "Комментарий успешно добавлен!");
    }

    public function delete(Request $request) {
        $getIdComment = correct($request->idComment);

        if (Auth::check()) {
            if (Auth::user()->isModerOrAdmin()) {
                $res = DB::delete("DELETE FROM `comment` WHERE `comment`.`id_comment` = ?;", [$getIdComment]);
                if (!$res) {
                    return result(409, "Комментарий не удален");
                } else {
                    return result(200, "Комментарий удален");
                }
            } else {
                // для пользователя, который хочет удалить свой комментарий
                $check = DB::select("SELECT id_comment FROM comment WHERE id_author = ? AND id_comment = ?;", [Auth::user()->id_user, $getIdComment]);
                if (!$check) {
                    return result(409, "Комментарий не найден или у вас нет доступа к удалению этого комментария");
                }

                $res = DB::delete("DELETE FROM `comment` WHERE `comment`.`id_comment` = ?;", [$getIdComment]);
                if (!$res) {
                    return result(409, "Комментарий не удалось удалить");
                }
                return result(200, "Комментарий удален");
            }
        } else {
            return result(409, "Только зарегистрированные пользователи могут удалять комментарии!");
        }
    }

    public function dislike(Request $request) {
        $getIdComment = correct($request->idComment);
        $id_author = Auth::check() ? Auth::user()->id_user : false;

        if (!$id_author) {
            return result(409, "Только зарегистрированные пользователи могут ставить дизлайки на комментарии!");
        }
        if (!$getIdComment) {
            return result(409, "Этот комментарий не может быть оценен!");
        }

        if ($id_author) {
            $res = DB::select("SELECT * FROM comment_like WHERE id_comment = ? AND id_author = ?;", [$getIdComment, $id_author]);
            if ($res) {
                if (isset($res[0]['mark']) && $res[0]['mark'] == '0') {
                    $check = DB::update("UPDATE `comment_like` SET `id_comment` = ?, `id_author` = ?, `mark` = ? WHERE `comment_like`.`id_like` = ?;", [
                        $getIdComment,
                        $id_author,
                        NULL,
                        $res[0]['id_like']
                    ]);
                    if (!$check) {
                        return result(409, "Что-то пошло не так, невозможно отменить дизлайк!");
                    } else {
                        return result(200, "Дизлайк отменен");
                    }
                } elseif (isset($res[0]['mark']) && $res[0]['mark'] == '1') {
                    $check = DB::update("UPDATE `comment_like` SET `id_comment` = ?, `id_author` = ?, `mark` = ? WHERE `comment_like`.`id_like` = ?;", [
                        $getIdComment,
                        $id_author,
                        0,
                        $res[0]['id_like']
                    ]);
                    if (!$check) {
                        return result(409, "Что-то пошло не так, невозможно поставить вместо лайка дизлайк!");
                    } else {
                        return result(200, "Лайк заменился дизлайком");
                    }
                } else {
                    $check = DB::update("UPDATE `comment_like` SET `id_comment` = ?, `id_author` = ?, `mark` = ? WHERE `comment_like`.`id_like` = ?;", [
                        $getIdComment,
                        $id_author,
                        0,
                        $res[0]['id_like']
                    ]);
                    if (!$check) {
                        return result(409, "Что-то пошло не так, невозможно поставить дизлайк!");
                    } else {
                        return result(200, "Дизлайк поставлен");
                    }
                }
            } else {
                $check = DB::insert("INSERT INTO `comment_like` (`id_comment`, `id_author`, `mark`) VALUES (?, ?, ?);", [
                    $getIdComment,
                    $id_author,
                    0
                ]);
                if (!$check) {
                    return result(409, "Что-то пошло не так, невозможно поставить дизлайк!");
                } else {
                    return result(200, "Дизлайк поставлен");
                }
            }
        } else {
            return result(409, "Для того, чтобы поставить дизлайк комментарию нужно авторизоваться!");
        }
    }

    public function like(Request $request) {
        $getIdComment = correct($request->idComment);
        $id_author = Auth::check() ? Auth::user()->id_user : false;

        if (!$id_author) {
            return result(409, "Только зарегистрированные пользователи могут ставить лайки на комментарии!");
        }
        if (!$getIdComment) {
            return result(409, "Этот комментарий не может быть оценен!");
        }

        if ($id_author) {
            $res = DB::select("SELECT * FROM comment_like WHERE id_comment = ? AND id_author = ?;", [$getIdComment, $id_author]);

            if ($res) {
                if (isset($res[0]['mark']) && $res[0]['mark'] == '1') {
                    $check = DB::update("UPDATE `comment_like` SET `id_comment` = ?, `id_author` = ?, `mark` = ? WHERE `comment_like`.`id_like` = ?;", [
                        $getIdComment,
                        $id_author,
                        NULL,
                        $res[0]['id_like']
                    ]);
                    if (!$check) {
                        return result(409, "Что-то пошло не так, невозможно отменить лайк!");
                    } else {
                        return result(200, "Лайк отменен");
                    }
                } elseif (isset($res[0]['mark']) && $res[0]['mark'] == '0') {
                    $check = DB::update("UPDATE `comment_like` SET `id_comment` = ?, `id_author` = ?, `mark` = ? WHERE `comment_like`.`id_like` = ?;", [
                        $getIdComment,
                        $id_author,
                        1,
                        $res[0]['id_like']
                    ]);
                    if (!$check) {
                        return result(409, "Что-то пошло не так, невозможно поставить вместо дизлайка лайк!");
                    } else {
                        return result(200, "Дизлайк заменился лайком");
                    }
                } else {
                    $check = DB::update("UPDATE `comment_like` SET `id_comment` = ?, `id_author` = ?, `mark` = ? WHERE `comment_like`.`id_like` = ?;", [
                        $getIdComment,
                        $id_author,
                        1,
                        $res[0]['id_like']
                    ]);
                    if (!$check) {
                        return result(409, "Что-то пошло не так, невозможно поставить лайк!");
                    } else {
                        return result(200, "Лайк поставлен");
                    }
                }
            } else {
                $check = DB::insert("INSERT INTO `comment_like` (`id_comment`, `id_author`, `mark`) VALUES (?, ?, ?);", [
                    $getIdComment,
                    $id_author,
                    1
                ]);
                if (!$check) {
                    return result(409, "Что-то пошло не так, невозможно поставить лайк!");
                } else {
                    return result(200, "Лайк поставлен");
                }
            }
        } else {
            return result(409, "Для того, чтобы поставить лайк комментарию нужно авторизоваться!");
        }
    }

    public function findByPostId(Request $request) {
        $idPost = correct($request->id);

        if (!$idPost) {
            return result(409, "Комментарии не могут загрузиться для этого поста!");
        }

        $res = DB::select("SELECT c.id_comment, c.id_author, c.body_comment, c.id_parent_comment, c.created_at, c.updated_at, u.folder, u.img_type, u.login, u.id_role
                            FROM comment as c JOIN post as p ON c.id_post = p.id_post JOIN user as u ON c.id_author = u.id_user
                            WHERE c.id_post = ? ORDER BY c.created_at DESC",[
            $idPost
        ]);

        $getLikes = [];
        $getYourLike = [];
        $getYourComment = [];
        $getDeleteComment = [];

        // оптимизировать ?
        foreach ($res as $el) {
            $get = DB::select("SELECT COUNT(cl.mark) as 'like' FROM comment_like as cl WHERE cl.id_comment = ? AND cl.mark = ?
                                UNION SELECT COUNT(cl.mark) FROM comment_like as cl WHERE cl.id_comment = ? AND cl.mark = ?;", [$el['id_comment'], 1, $el['id_comment'], 0]);
            $get = ($get[0]['like'] ?? 0) - ($get[1]['like'] ?? 0);
            array_push($getLikes, $get);

            if (Auth::check()) {
                $get = DB::select("SELECT mark FROM comment_like WHERE id_author = ? AND id_comment = ?;", [Auth::user()->id_user, $el['id_comment']]);
                if (isset($get[0]['mark']) && $get[0]['mark'] == '0') {
                    array_push($getYourLike, false);
                } elseif (isset($get[0]['mark']) && $get[0]['mark'] == '1') {
                    array_push($getYourLike, true);
                } else {
                    array_push($getYourLike, NULL);
                }

                $get = DB::select("SELECT id_comment FROM comment WHERE id_comment = ? AND id_author = ?;", [$el['id_comment'], Auth::user()->id_user]);
                if ($get) {
                    array_push($getYourComment, true);
                } else {
                    array_push($getYourComment, false);
                }

                if (Auth::user()->isModerOrAdmin()) {
                    array_push($getDeleteComment, true);
                }
            }

        }

        for ($i = 0; $i <  count($res); $i++) {
            $res[$i]['like'] = $getLikes[$i] ?? 0;
            $res[$i]['myLike'] = $getYourLike[$i] ?? null;
            $res[$i]['myComment'] = $getYourComment[$i] ?? false;
            $res[$i]['deleteComment'] = $getDeleteComment[$i] ?? false;

            //fixme
            $res[$i]['imgUrl'] = isset($res[$i]['folder']) || isset($res[$i]['img_type'])
                ? route('/') . '/storage/data/users/' . $res[$i]['folder']. '/avatar.' . $res[$i]['img_type']
                : route('/') . '/public/imgs/profile.png';
        }

        return result(200, "", $res);
    }
}
