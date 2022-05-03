<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function isBase64($s){
        // Check if there are valid base64 characters
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;

        // Decode the string in strict mode and check the results
        $decoded = base64_decode($s, true);
        if(false === $decoded) return false;

        // Encode the string again
        if(base64_encode($decoded) != $s) return false;

        return true;
    }

    public function showChange($id) {
        if (!Auth::check() || !Auth::user()->isModerOrAdmin()) return to_route('login');

        $getCategory = DB::select("SELECT * FROM `category`;");

        $getId = correct($id);
        $getPostInfo = DB::select("SELECT p.heading, p.main_folder, p.main_img_type, p.description, c.id_category, c.name_category
                                    FROM post as p JOIN category as c ON c.id_category = p.id_category WHERE id_post = ?;", [$getId]);

        $getPostInfo = $getPostInfo[0];
        $getPostInfo['imgUrl'] = route('/') . '/storage/data/posts/' . $getPostInfo['main_folder'] . '/main_img.' . $getPostInfo['main_img_type'];

        return view('post.change', [
            'getCategory' => $getCategory,
            'getPostInfo' => $getPostInfo
        ]);
    }

    public function findBodyById(Request $request) {
        $idPost = correct($request->id);

        if (Auth::check() && Auth::user()->isModerOrAdmin()) {
            if (!$idPost) {
                return result(409, "Пост не передан!");
            }

            $res = DB::select("SELECT body FROM post WHERE id_post = ?;", [$idPost]);

            $res[0]['body'] = json_decode($res[0]['body'], true);
            foreach ($res[0]['body']['blocks'] as &$el) {
                if ($el['type'] == 'image') {
                    $url = $el['data']['url'];

                    if (mb_substr($url, 0, 4) != "http") {
                        $image = route('/') . $url;
                        $imageSize = getimagesize($image);
                        $imageData = base64_encode(file_get_contents($image));
                        $el['data']['url'] = "data:{$imageSize['mime']};base64,{$imageData}";
                    }
                }
            }

            return result(200, "", $res[0]['body']);
        } else {
            return result(409, "Нет доступа!");
        }
    }

    public function change(Request $request) {
        $idPost = correct($request->idPost);
        $heading = correct($request->heading);
        $description = correct($request->description);
        $category = correct($request->category);
        $body = json_decode($request->body, true);
        $img_main = $request->file('image');
        $tags = explode(",", $request->tags);

        if (Auth::check() && Auth::user()->isModerOrAdmin()) {
            if (!$idPost) {
                return result(409, "Пост не передан!");
            }
            if (!$heading) {
                return result(409, "Заголовок обязательное поле!");
            }
            if (iconv_strlen($heading) > 200) {
                return result(409, "Заголовок не может быть больше 200 символов!");
            }
            if (iconv_strlen($heading) < 6) {
                return result(409, "Заголовок не может быть меньше 6 символов!");
            }
            if (!$description) {
                return result(409, "Описание обязательное поле!");
            }
            if (iconv_strlen($description) > 1000) {
                return result(409, "Описание не может быть больше 1000 символов!");
            }
            if (iconv_strlen($description) < 20) {
                return result(409, "Описание не может быть меньше 20 символов!");
            }
            if (!$body["blocks"]) {
                return result(409, "Содержание должно быть заполнено!");
            }

            $res = DB::select("SELECT id_status, main_folder, main_img_type FROM post WHERE id_post = ?;", [$idPost]);
            if (!$res) {
                return result(409, "Пост не найден в базе данных");
            }
            if ($res[0]['id_status'] != '1' && Auth::user()->isModer()) {
                return result(409, "Извините, модератору доступно изменять только посты со статусом - Отправлен!");
            }

            if ($category) {
                $resCategory = DB::select("SELECT * FROM `category` WHERE id_category = ?;", [$category]);
                if (!$resCategory) {
                    return result(409, "Такой категории не существует!");
                }
            } else {
                return result(409, "Выберите категорию поста!");
            }

            $uniqUrl = md5(uniqid(rand(), true));
            $newDir = 'public/data/posts/'.$uniqUrl;
            Storage::makeDirectory($newDir);

            $typeMainImg = false;
            if (!$img_main) {
                Storage::move('public/data/posts/' . $res[0]['main_folder'] . '/main_img.' . $res[0]['main_img_type'], $newDir.'/main_img.'.$res[0]['main_img_type']);
//                copy('../../data/posts/' . $res[0]['main_folder'] . '/main_img.' . $res[0]['main_img_type'], $newDir.'/main_img.'.$res[0]['main_img_type']);
            } else {
                if ($img_main->getSize() > 5000000) {
                    return result(409, "Главное изображение не должно превышать 5 Мегабайт!");
                }
                switch ($img_main->extension()) {
                    case 'jpg':
                    case 'jpeg':
                        $typeMainImg = 'jpeg';
                        break;
                    case 'png':
                        $typeMainImg = 'png';
                        break;
                    case 'gif':
                        $typeMainImg = 'gif';
                        break;
                    default:
                        return result(409, "Расширение изображения должно быть png, jpg или gif!");
                }

                $path = $img_main->storeAs($newDir, 'main_img.'.$typeMainImg);
                if (!$path) {
                    Storage::deleteDirectory($newDir);
                    return result(409, "Что-то пошло не так главное изображение не было загружено на сервер!");
                }
            }

            foreach ($body["blocks"] as &$el) {
                if ($el["type"] == "image") {
                    $getUrlBase64 = explode(",", $el["data"]["url"]);
                    $getTypeImgBase64 = explode("/", $getUrlBase64[0]);
                    $getTypeEndImgBase64 = explode(";", $getTypeImgBase64[1]);

                    if ($getUrlBase64[0] === 'data:image/'.$getTypeEndImgBase64[0].';base64') {
                        if ($this->isBase64($getUrlBase64[1])) {
                            File::put(storage_path().'/app/'.$newDir.'/'.$el["id"].'.'.$getTypeEndImgBase64[0], file_get_contents($el["data"]["url"]));
                            $el['data']['url'] = '/storage/data/posts/'.$uniqUrl.'/'.$el["id"].'.'.$getTypeEndImgBase64[0];
                        } else {
                            return result(409, "Изображение не является base64!");
                        }
                    }
                }
            }

            $change = DB::update("UPDATE `post` SET `id_category` = ?, `heading` = ?, `description` = ?, `main_folder` = ?, `main_img_type` = ?, `body` = ?
                                    WHERE `post`.`id_post` = ?;",
                [
                    $category,
                    $heading,
                    $description,
                    $uniqUrl,
                    $typeMainImg ? $typeMainImg : $res[0]['main_img_type'],
                    json_encode($body),
                    $idPost
                ]);
            if (!$change) {
                Storage::deleteDirectory($newDir);
                return result(409, "Что-то пошло не так, невозможно изменить пост");
            }

            DB::delete("DELETE FROM `post_tag` WHERE `post_tag`.`id_post` = ?", [$idPost]);
            if ($tags) {
                if (count($tags) > 10) {
                    $n = array_keys($tags);
                    $count = array_search(9, $n);
                    $tags = array_slice($tags, 0, $count + 1, true);
                }
                foreach ($tags as $el) {
                    $resTag = DB::select("SELECT `id_tag`, `name_tag` FROM `tag` WHERE `name_tag` = ?;", [$el]);
                    if (!$resTag ) {
                        DB::insert("INSERT INTO `tag` (`name_tag`) VALUES (?);", [$el]);
                        $resTag = DB::select("SELECT `id_tag` FROM `tag` WHERE id_tag=(SELECT max(`id_tag`) FROM `tag`);");
                    }
                    DB::insert("INSERT INTO `post_tag` (`id_post`, `id_tag`) VALUES (?, ?);", [$idPost, $resTag[0]['id_tag']]);
                }
            }

            $oldDir = 'public/data/posts/'.$res[0]['main_folder'];
            Storage::deleteDirectory($oldDir);

            return result(200, "Пост был успешно изменен");
        } else {
            return result(409, "Нет доступа!");
        }
    }

    public function create(Request $request) {
        $id_creator = Auth::check() ? Auth::user()->id_user : false;
        $heading = correct($request->heading);
        $description = correct($request->description);
        $category = correct($request->category);
        $body = json_decode($request->body, true);
        $img_main = $request->file('image');
        $tags = explode(",", $request->tags);

        if (!$id_creator) {
            return result(409, "Вы должны быть авторизованы, чтобы создать пост!");
        }
        if (!$heading) {
            return result(409, "Заголовок обязательное поле!");
        }
        if (iconv_strlen($heading) > 200) {
            return result(409, "Заголовок не может быть больше 200 символов!");
        }
        if (iconv_strlen($heading) < 6) {
            return result(409, "Заголовок не может быть меньше 6 символов!");
        }
        if (!$description) {
            return result(409, "Описание обязательное поле!");
        }
        if (iconv_strlen($description) > 1000) {
            return result(409, "Описание не может быть больше 1000 символов!");
        }
        if (iconv_strlen($description) < 20) {
            return result(409, "Описание не может быть меньше 20 символов!");
        }
        if (!$body["blocks"]) {
            return result(409, "Содержание должно быть заполнено!");
        }
        if (!$img_main) {
            return result(409, "Главное изображение должно быть загружено!");
        }

        if ($category) {
            $resCategory = DB::select("SELECT * FROM `category` WHERE id_category = ?;", [$category]);
            if (!$resCategory) {
                return result(409, "Такой категории не существует!");
            }
        } else {
            return result(409, "Выберите категорию поста!");
        }

        if ($img_main->getSize() > 5000000) {
            return result(409, "Главное изображение не должно превышать 5 Мегабайт!");
        }
        switch ($img_main->extension()) {
            case 'jpg':
            case 'jpeg':
                $typeMainImg = 'jpeg';
                break;
            case 'png':
                $typeMainImg = 'png';
                break;
            case 'gif':
                $typeMainImg = 'gif';
                break;
            default:
                return result(409, "Расширение изображения должно быть png, jpg или gif!");
        }

        $uniqUrl = md5(uniqid(rand(), true));
        $newDir = 'public/data/posts/'.$uniqUrl;
        Storage::makeDirectory($newDir);

        $path = $img_main->storeAs($newDir, 'main_img.'.$typeMainImg);
        if (!$path) {
            Storage::deleteDirectory($newDir);
            return result(409, "Что-то пошло не так главное изображение не было загружено на сервер!");
        }

        //fixme
        $body['storage'] = 0;

        foreach ($body["blocks"] as &$el) {
            if ($el["type"] == "image") {
                $getUrlBase64 = explode(",", $el["data"]["url"]);
                $getTypeImgBase64 = explode("/", $getUrlBase64[0]);
                $getTypeEndImgBase64 = explode(";", $getTypeImgBase64[1]);

                if ($getUrlBase64[0] === 'data:image/'.$getTypeEndImgBase64[0].';base64') {
                    if ($this->isBase64($getUrlBase64[1])) {
                        File::put(storage_path().'/app/'.$newDir.'/'.$el["id"].'.'.$getTypeEndImgBase64[0], file_get_contents($el["data"]["url"]));
                        $el['data']['url'] = '/storage/data/posts/'.$uniqUrl.'/'.$el["id"].'.'.$getTypeEndImgBase64[0];
                    } else {
                        return result(409, "Изображение не является base64!");
                    }
                }
            }
        }

        $res = DB::insert("INSERT INTO `post` (`id_category`, `id_creator`, `heading`, `description`, `main_folder`, `main_img_type`, `body`, `id_status`, `updated_at`)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);",
            [
                $category,
                $id_creator,
                $heading,
                $description,
                $uniqUrl,
                $typeMainImg,
                json_encode($body),
                Auth::user()->isModerOrAdmin() ? 2 : 1,
                NULL
            ]);
        if (!$res) {
            Storage::deleteDirectory($newDir);
            return result(409, "Что-то пошло не так, невозможно создать пост!");
        }

        $getIdPost = DB::select("SELECT `id_post` FROM `post` WHERE id_post=(SELECT max(`id_post`) FROM `post` WHERE post.id_creator = ?);", [$id_creator]);

        if ($tags) {
            if (count($tags) > 10) {
                $n = array_keys($tags);
                $count = array_search(9, $n);
                $tags = array_slice($tags, 0, $count + 1, true);
            }
            foreach ($tags as $el) {
                $resTag = DB::select("SELECT `id_tag`, `name_tag`, `public_tag` FROM `tag` WHERE `name_tag` = ?;", [$el]);
                if (isset($resTag[0]['public_tag']) && $resTag[0]['public_tag'] == '0') {
                    if (Auth::user()->isModerOrAdmin()) {
                        DB::update("UPDATE `tag` SET `public_tag` = ? WHERE `id_tag`.`id_user` = ?;", [1, $resTag[0]['id_tag']]);
                    }
                }
                if (!$resTag) {
                    if (Auth::user()->isModerOrAdmin()) {
                        DB::insert("INSERT INTO `tag` (`name_tag`, `public_tag`) VALUES (?, ?);", [$el, 1]);
                    } else {
                        DB::insert("INSERT INTO `tag` (`name_tag`) VALUES (?);", [$el]);
                    }
                    $resTag = DB::select("SELECT `id_tag` FROM `tag` WHERE id_tag=(SELECT max(`id_tag`) FROM `tag`);");
                }
                DB::insert("INSERT INTO `post_tag` (`id_post`, `id_tag`) VALUES (?, ?);", [$getIdPost[0]['id_post'], $resTag[0]['id_tag']]);
            }
        }

        if (Auth::user()->isModerOrAdmin()) {
            return result(200, "Пост был успешно опубликован");
        }
        return result(200, "Пост был отправлен на проверку");
    }

    public function showCreate() {
        if (!Auth::check()) return to_route('login');

        $getCategory = DB::select("SELECT * FROM `category`;");

        return view('post.create', ['getCategory' => $getCategory]);
    }

    public function delete(Request $request) {
        if (Auth::check() && Auth::user()->isAdmin()) {
            $idPost = correct($request->id);

            $mainFolder = DB::select("SELECT main_folder FROM post WHERE id_post = ?;", [$idPost]);
            if (!$mainFolder) {
                return result(409, "Не удалось найти пост");
            }
            $mainFolder = $mainFolder[0]['main_folder'];

            $res = DB::delete("DELETE FROM `post` WHERE `post`.`id_post` = ?;", [$idPost]);
            if (!$res) {
                return result(409, "Не удалось удалить пост");
            }

            Storage::deleteDirectory('public/data/posts/'.$mainFolder);

            return result(200, "Пост успешно удален");
        } else {
            return result(409, "Извините нет доступа.");
        }
    }

    public function rejected(Request $request) {
        if (Auth::check() && Auth::user()->isModerOrAdmin()) {
            $idPost = correct($request->id);

            $res = DB::update("UPDATE `post` SET `id_status` = ? WHERE `post`.`id_post` = ?;", [3, $idPost]);
            if ($res) {
                return result(200, "Пост успешно отклонен!");
            } else {
                return result(409, "Что-то пошло не так, пост не отклонен");
            }
        } else {
            return result(409, "Извините нет доступа.");
        }
    }

    public function published(Request $request) {
        if (Auth::check() && Auth::user()->isModerOrAdmin()) {
            $idPost = correct($request->id);

            $findTags = DB::select("SELECT * FROM `post_tag` WHERE id_post = ?;", [$idPost]);
            if ($findTags) {
                foreach ($findTags as $el) {
                    DB::update("UPDATE `tag` SET `public_tag` = ? WHERE `tag`.`id_tag` = ?;", [1 ,$el['id_tag']]);
                }
            }

            $res = DB::update("UPDATE `post` SET `id_status` = ? WHERE `post`.`id_post` = ?;", [2, $idPost]);
            if ($res) {
                return result(200, "Пост успешно опубликован!");
            } else {
                return result(409, "Что-то пошло не так, пост не опубликован");
            }
        } else {
            return result(409, "Извините нет доступа.");
        }
    }

    public function showList() {
        if (!Auth::check() || !Auth::user()->isModerOrAdmin()) return to_route('login');

        $getList = DB::select("SELECT p.id_post, p.id_creator, p.heading, p.created_at, u.id_user, u.login FROM post as p
                                JOIN user as u ON p.id_creator = u.id_user WHERE p.id_status = ? ORDER BY p.id_post DESC;", [1]);

        return view('post.list', ['getList' => $getList]);
    }

    public function showListAll() {
        if (!Auth::check() || !Auth::user()->isAdmin()) return to_route('login');

        $getList = DB::select("SELECT p.id_post, p.id_creator, p.heading, p.created_at, u.id_user, u.login, ps.name, ps.code
                                FROM post as p JOIN post_status as ps ON ps.id_status = p.id_status
                                JOIN user as u ON p.id_creator = u.id_user ORDER BY p.id_post DESC;");

        return view('post.list.all', ['getList' => $getList]);
    }

    public function searchPostAndUser(Request $request) {
        $get = correct($request->searchPostAndUser);
        $get = '%' . $get . '%';

        $res = DB::select("SELECT `id_post`, `heading` FROM `post` WHERE heading LIKE ? ORDER BY heading;", [$get]);

        if (!$res) {
            $res = DB::select("SELECT `id_user`, `login` FROM `user` WHERE login LIKE ? ORDER BY login;", [$get]);
        }

        return result(200, "", $res);
    }

    public function random() {
        $res = DB::select("SELECT id_post FROM post WHERE id_status = ? ORDER BY RAND() LIMIT 1;", [2]);
        return result(200, "", $res[0]['id_post']);
    }

    public function findById(Request $request) {
        $id = correct($request->id);

        if ($id) {
            $res = false;
            if (Auth::check() && Auth::user()->isModerOrAdmin()) {
                $res = DB::select("SELECT p.id_post, p.heading, u.login, p.created_at, p.main_folder, p.main_img_type, p.description, p.id_creator, p.body, c.id_category, c.name_category
                                    FROM post as p JOIN category as c ON c.id_category = p.id_category JOIN user as u ON u.id_user = p.id_creator WHERE p.id_post = ?;", [$id]);
            } else {
                $check = DB::select("SELECT id_creator FROM post WHERE id_post = ?;", [$id]);
                if (Auth::check()) {
                    if ($check[0]['id_creator'] == Auth::user()->id_user) {
                        $res = DB::select("SELECT p.id_post, p.heading, u.login, p.created_at, p.main_folder, p.main_img_type, p.description, p.id_creator, p.body, c.id_category, c.name_category
                                    FROM post as p JOIN category as c ON c.id_category = p.id_category JOIN user as u ON u.id_user = p.id_creator WHERE p.id_post = ?;", [$id]);
                    }
                } else {
                    $res = DB::select("SELECT p.id_post, p.heading, u.login, p.created_at, p.main_folder, p.main_img_type, p.description, p.id_creator, p.body, c.id_category, c.name_category
                                    FROM post as p JOIN category as c ON c.id_category = p.id_category JOIN user as u ON u.id_user = p.id_creator WHERE p.id_post = ? AND p.id_status = ?;", [$id, 2]);
                }
            }
//            if (!$res) {
//                return result(404, "Пост не найден");
//            }

            // оптимизировать
            $res[0]['tags'] = DB::select("SELECT t.id_tag, t.name_tag FROM tag as t JOIN post_tag as pt ON t.id_tag = pt.id_tag WHERE pt.id_post = ?;", [$id]);
            $get = DB::select("SELECT COUNT(cl.mark) as 'like' FROM post_like as cl WHERE cl.id_post = ? AND cl.mark = ?
                                UNION SELECT COUNT(cl.mark) FROM post_like as cl WHERE cl.id_post = ? AND cl.mark = ?;", [$id, 1, $id, 0]);
            $res[0]['likes'] = ($get[0]['like'] ?? 0) - ($get[1]['like'] ?? 0);
            $get = DB::select("SELECT COUNT(v.id_view) as `number` FROM view as v JOIN post as p ON p.id_post = v.id_post WHERE v.id_post = ?;", [$id]);
            $res[0]['views'] = $get[0]['number'];
            $get = DB::select("SELECT COUNT(v.id_view) as `number` FROM view as v JOIN post as p ON p.id_post = v.id_post WHERE v.id_post = ? AND v.created_at >= NOW() - INTERVAL 1 DAY;", [$id]);
            $res[0]['views_day'] = $get[0]['number'];
            $get = DB::select("SELECT COUNT(id_comment) as 'comments' FROM comment WHERE id_post = ?;", [$id]);
            $res[0]['comments_count'] = $get[0]['comments'];
            if (Auth::check()) {
                $get = DB::select("SELECT mark FROM post_like WHERE id_author = ? AND id_post = ?;", [Auth::user()->id_user ,$id]);
                if (isset($get[0]['mark']) && $get[0]['mark'] == '0') {
                    $getYourLike = false;
                } elseif (isset($get[0]['mark']) && $get[0]['mark'] == '1') {
                    $getYourLike = true;
                } else {
                    $getYourLike = NULL;
                }
                $res[0]['myLike'] = $getYourLike;
            }

            $getMainFolder = $res[0]['main_folder'];
            $getMainUmgType = $res[0]['main_img_type'];
            $res[0]['img_main_url'] = route('/') . '/storage/data/posts/' . $getMainFolder . '/main_img.' . $getMainUmgType;

            return result(200, "", $res);
        }

    }

    public function dislike(Request $request) {
        $getIdPost = correct($request->id);
        $id_author = Auth::check() ? Auth::user()->id_user : false;

        if (!$id_author) {
            return result(409, "Только зарегистрированные пользователи могут ставить дизлайк на пост!");
        }
        if (!$getIdPost) {
            return result(409, "Этот пост не может быть оценен!");
        }

        if ($id_author) {
            $res = DB::select("SELECT * FROM post_like WHERE id_post = ? AND id_author = ?;", [$getIdPost, $id_author]);

            if ($res) {
                if (isset($res[0]['mark']) && $res[0]['mark'] == '0') {
                    $check = DB::update("UPDATE `post_like` SET `id_post` = ?, `id_author` = ?, `mark` = ? WHERE `post_like`.`id_like` = ?;", [
                        $getIdPost,
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
                    $check = DB::update("UPDATE `post_like` SET `id_post` = ?, `id_author` = ?, `mark` = ? WHERE `post_like`.`id_like` = ?;", [
                        $getIdPost,
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
                    $check = DB::update("UPDATE `post_like` SET `id_post` = ?, `id_author` = ?, `mark` = ? WHERE `post_like`.`id_like` = ?;", [
                        $getIdPost,
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
                $check = DB::insert("INSERT INTO `post_like` (`id_post`, `id_author`, `mark`) VALUES (?, ?, ?);", [
                    $getIdPost,
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
            return result(409, "Для того, чтобы поставить дизлайк посту нужно авторизоваться!");
        }
    }

    public function like(Request $request) {
        $getIdPost = correct($request->id);
        $id_author = Auth::check() ? Auth::user()->id_user : false;

        if (!$id_author) {
            return result(409, "Только зарегистрированные пользователи могут поставить лайк на пост!");
        }
        if (!$getIdPost) {
            return result(409, "Этот пост не может быть оценен!");
        }

        if ($id_author) {
            $res = DB::select("SELECT * FROM post_like WHERE id_post = ? AND id_author = ?;", [$getIdPost, $id_author]);

            if ($res) {
                if (isset($res[0]['mark']) && $res[0]['mark'] == '1') {
                    $check = DB::update("UPDATE `post_like` SET `id_post` = ?, `id_author` = ?, `mark` = ? WHERE `post_like`.`id_like` = ?;", [
                        $getIdPost,
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
                    $check = DB::update("UPDATE `post_like` SET `id_post` = ?, `id_author` = ?, `mark` = ? WHERE `post_like`.`id_like` = ?;", [
                        $getIdPost,
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
                    $check = DB::update("UPDATE `post_like` SET `id_post` = ?, `id_author` = ?, `mark` = ? WHERE `post_like`.`id_like` = ?;", [
                        $getIdPost,
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
                $check = DB::insert("INSERT INTO `post_like` (`id_post`, `id_author`, `mark`) VALUES (?, ?, ?);", [
                    $getIdPost,
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
            return result(409, "Для того, чтобы поставить лайк посту нужно авторизоваться!");
        }

    }

    public function show($id) {
        $idPost = correct($id);

        $getInfoPost = Auth::check() && Auth::user()->isModerOrAdmin()
            ? DB::select("SELECT heading, description, main_folder, main_img_type, id_category FROM post WHERE id_post = ?;", [$idPost])
            : DB::select("SELECT heading, description, main_folder, main_img_type, id_category FROM post WHERE id_post = ? AND id_status = ?;", [$idPost, 2]);
        if ($getInfoPost) {
            $getTags = DB::select("SELECT t.name_tag FROM post_tag as pt JOIN tag as t ON t.id_tag = pt.id_tag WHERE pt.id_post = ?;", [$idPost]);
            $getInfoPost = $getInfoPost[0];
            $getTagsArry = [];
            foreach ($getTags as $el) {
                array_push($getTagsArry, $el['name_tag']);
            }

            $getTagsStr = implode(', ', $getTagsArry);
            $getUrl = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $getHeading = $getInfoPost['heading'];
            $getDescription = $getInfoPost['description'];
            $getMainFolder = $getInfoPost['main_folder'];
            $getMainUmgType = $getInfoPost['main_img_type'];
            $imgUrl = route('/') . '/storage/data/posts/' . $getMainFolder . '/main_img.' . $getMainUmgType;


            //TODO fixme учитывать ли просмотры с разных аккаунтов с одного ip ???

            $ip = $_SERVER['REMOTE_ADDR'];
//  возможно можно оптимизировать + добавить доп. проверки + попробовать без id_view сравнивать ip - адреса
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $getIdPost = correct($id);
                $idLooked = Auth::check() ? Auth::user()->id_user : NULL;
                $created_at = date("Y-m-d H:i:s");
                $checkView = true;

                // учет просмотров только для публичных постов
                $checkPublic = DB::select("SELECT id_post FROM post WHERE id_post = ? AND id_status = ?;", [$getIdPost, 2]);
                if ($checkPublic) {
                    if ($idLooked) {
                        // запрос нужен для учета просмотра - когда кто-то авторизован и постоянно меняет ip-просмотры или меняет аккаунта с одного ip не будут учитываться
                        $checkView = DB::select("SELECT `id_view`, `id_looked`, `id_post` FROM `view` WHERE id_view =
                                            (SELECT max(id_view) FROM `view` WHERE (id_looked = ? AND id_post = ?) OR (ip_address = INET_ATON(?) AND id_post = ?));",[
                            $idLooked,
                            $getIdPost,
                            $ip,
                            $getIdPost
                        ]);
                        if (count($checkView) > 0) {
                            DB::update("UPDATE `view` SET `id_looked` = ? WHERE `view`.`id_view` = ?;",[$idLooked, $checkView[0]['id_view'] ?? NULL]);
                        }
                    } else {
                        $checkView = DB::select("SELECT `id_post`, `ip_address` FROM `view` WHERE ip_address = INET_ATON(?) AND id_post = ?;",[$ip, $getIdPost]);
                    }

                    if (!$checkView) {
                        DB::insert("INSERT INTO `view` (`id_post`, `ip_address`, `id_looked`, `created_at`) VALUES (?, INET_ATON(?), ?, ?);", [
                            $getIdPost,
                            $ip,
                            $idLooked,
                            $created_at
                        ]);
                    }
                }
            }

            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $getIdPost = correct($id);
                $idLooked = Auth::check() ? Auth::user()->id_user : NULL;
                $created_at = date("Y-m-d H:i:s");
                $checkView = true;

                // учет просмотров только для публичных постов
                $checkPublic = DB::select("SELECT id_post FROM post WHERE id_post = ? AND id_status = ?;", [$getIdPost, 2]);
                if ($checkPublic) {
                    if ($idLooked) {
                        $checkView = DB::select("SELECT `id_view`, `id_looked`, `id_post` FROM `view` WHERE id_view =
                                            (SELECT max(id_view) FROM `view` WHERE (id_looked = ? AND id_post = ?) OR (ip_address = INET6_ATON(?) AND id_post = ?));",[
                            $idLooked,
                            $getIdPost,
                            $ip,
                            $getIdPost
                        ]);
                        if (count($checkView) > 0) {
                            DB::update("UPDATE `view` SET `id_looked` = ? WHERE `view`.`id_view` = ?;",[$idLooked, $checkView[0]['id_view'] ?? NULL]);
                        }
                    } else {
                        $checkView = DB::select("SELECT `id_post`, `ip_address` FROM `view` WHERE ip_address = INET6_ATON(?) AND id_post = ?;",[$ip, $getIdPost]);
                    }

                    if (!$checkView) {
                        DB::insert("INSERT INTO `view` (`id_post`, `ip_address`, `id_looked`, `created_at`) VALUES (?, INET6_ATON(?), ?, ?);", [
                            $getIdPost,
                            $ip,
                            $idLooked,
                            $created_at
                        ]);
                    }
                }
            }

            $category = DB::select("SELECT id_category, name_category FROM category WHERE id_category = ?", [$getInfoPost['id_category']]);
            $idCategory = $category[0]['id_category'];
            $category = $category[0]['name_category'];

            $getCategorys = DB::select("SELECT COUNT(c.id_category) as count, c.id_category, c.name_category FROM category as c JOIN post as p ON p.id_category = c.id_category WHERE p.id_status = ? GROUP BY c.id_category;", [2]);

            $getCountDefaultCategory = DB::select("SELECT COUNT(id_post) as count FROM `post` WHERE id_status = ?", [2]);
            $getCountDefaultCategory = $getCountDefaultCategory[0]['count'];

            $getDefaultCategory = DB::select("SELECT id_category, name_category FROM category WHERE id_category = ?", [1]);
            array_unshift($getCategorys, $getDefaultCategory[0]);

            $getTag = DB::select("SELECT * FROM `tag`WHERE public_tag = ?;", [1]);

            $getLastComments = DB::select("SELECT p.id_post, u.folder, u.img_type, u.login, p.heading, c.created_at FROM comment as c JOIN user as u ON c.id_author = u.id_user JOIN post as p ON c.id_post = p.id_post WHERE p.id_status = ? ORDER BY id_comment DESC LIMIT ?, ?", [2, 0, 3]);

            foreach ($getLastComments as &$comment) {
                $comment['img_url'] = isset($comment['folder']) && isset($comment['img_type'])
                    ? route('/') . '/storage/data/users/' . $comment['folder'] . '/' . 'avatar.' . $comment['img_type']
                    : route('/') . '/public/imgs/profile.png';
            }

            return view('post', [
                'getTagsStr' => $getTagsStr,
                'getUrl' => $getUrl,
                'getHeading' => $getHeading,
                'getDescription' => $getDescription,
                'category' => $category,
                'idCategory' => $idCategory,
                'imgUrl' => $imgUrl,
                'getCategorys' => $getCategorys,
                'getTag' => $getTag,
                'getCountDefaultCategory' => $getCountDefaultCategory,
                'getLastComments' => $getLastComments,
            ]);
        } else {
            return to_route('error', ['number' => 404]);
        }
    }

    public function search(Request $request) {
        $start = correct($request->start);
        $order = correct($request->order);
        $category = correct($request->category);
        $tag = $request->tag;
        $leftScob = $tag ? '(' : '';
        $rightScob = $tag && $category ? ')' : '';

        $params = [];
        $selectParams = 'p.id_post, p.id_category, p.id_creator, p.id_status, p.heading, p.description, p.main_folder, p.main_img_type, p.created_at, p.updated_at, c.name_category';
        $where = 'JOIN category as c ON p.id_category = c.id_category ';

        $whereOrTags = '';
        if ($tag) {
            $selectParams = 'DISTINCT ' . $selectParams;
            $where = $where . 'JOIN post_tag as pt ON pt.id_post = p.id_post ';
            $where = $where . "WHERE p.id_status = ? ";
            array_push($params, 2);
            if ($category) {
                if ($category != '1') {
                    $where = $where . "AND p.id_category = ? ";
                    array_push($params, $category);
                }
            }
            if ($category) {
                $whereOrTags = 'AND '.$leftScob;
            } else {
                $whereOrTags = 'WHERE ';
            }
            foreach ($tag as $el) {
                $whereOrTags = $whereOrTags . "pt.id_tag = ? OR ";
                array_push($params, $el);
            }
            $whereOrTags = substr($whereOrTags,0,-3);
        } else {
            $where = $where . "AND p.id_status = ? ";
            array_push($params, 2);
            if ($category) {
                if ($category != '1') {
                    $where = $where . "AND p.id_category = ? ";
                    array_push($params, $category);
                }
            }
        }

        $whereOrder = '';
        switch ($order) {
            case 1:
                $whereOrder = $whereOrder . 'ORDER BY p.id_post ASC';
                break;
            default:
                $whereOrder = $whereOrder . 'ORDER BY p.id_post DESC';
                break;
        }

        $count = 3; //fixme

        $res = DB::select("SELECT $selectParams FROM `post` as p $where $whereOrTags $rightScob $whereOrder LIMIT $start, $count;", $params);

        $getTags = [];
        $getNameUser = [];
        $getLikesPost = [];
        $getViews = [];
        $getViewsDay = [];
        $getReadPost = [];
        $getCommentsCount = [];

        foreach ($res as $el) {
            $get = DB::select("SELECT t.id_tag, t.name_tag FROM tag as t JOIN post_tag as pt ON t.id_tag = pt.id_tag WHERE pt.id_post = ?;", [$el['id_post']]);
            array_push($getTags, $get);

            $get = DB::select("SELECT DISTINCT u.login FROM user as u JOIN post as p ON p.id_creator = u.id_user WHERE p.id_creator = ?;", [$el['id_creator']]);
            array_push($getNameUser, $get[0]['login']);

            $get = DB::select("SELECT COUNT(cl.mark) as 'like' FROM post_like as cl WHERE cl.id_post = ? AND cl.mark = ?
                                UNION SELECT COUNT(cl.mark) FROM post_like as cl WHERE cl.id_post = ? AND cl.mark = ?;", [$el['id_post'], 1, $el['id_post'], 0]);
            $get = ($get[0]['like'] ?? 0) - ($get[1]['like'] ?? 0);
            array_push($getLikesPost, $get);

            $get = DB::select("SELECT COUNT(v.id_view) as `number` FROM view as v JOIN post as p ON p.id_post = v.id_post WHERE v.id_post = ?;", [$el['id_post']]);
            array_push($getViews, $get[0]['number']);

            $get = DB::select("SELECT COUNT(v.id_view) as `number` FROM view as v JOIN post as p ON p.id_post = v.id_post WHERE v.id_post = ? AND v.created_at >= NOW() - INTERVAL 1 DAY;", [$el['id_post']]);
            array_push($getViewsDay, $get[0]['number']);

            $get = DB::select("SELECT COUNT(id_comment) as 'comments' FROM comment WHERE id_post = ?;", [$el['id_post']]);
            array_push($getCommentsCount, $get[0]['comments']);

            if (Auth::check()) {
                $get = DB::select("SELECT `id_post`, `id_looked` FROM `view` WHERE id_looked = ? AND id_post = ?;", [Auth::user()->id_user, $el['id_post']]);

                if ($get) {
                    array_push($getReadPost, true);
                } else {
                    array_push($getReadPost, false);
                }
            } else {
                array_push($getReadPost, false);
            }
        }

        for ($i = 0; $i <  count($res); $i++) {
            $res[$i]['tags'] = $getTags[$i] ?? false;
            $res[$i]['user_login'] = $getNameUser[$i] ?? false;
            $res[$i]['likes'] = $getLikesPost[$i] ?? false;
            $res[$i]['views'] = $getViews[$i] ?? false;
            $res[$i]['views_day'] = $getViewsDay[$i] ?? false;
            $res[$i]['read_post'] = $getReadPost[$i] ?? false;
            $res[$i]['comments_count'] = $getCommentsCount[$i] ?? false;

            //fixme
            $res[$i]['img_url'] = route('/') . '/storage/data/posts/' . $res[$i]['main_folder']. '/main_img.' . $res[$i]['main_img_type'];
        }

        return result(200, '', $res);
    }

    public function searchProfile(Request $request) {
        $start = correct($request->start);
        $id_user = correct($request->id_user);

//        $params = [];

        if (!$id_user) {
            return result(409, "Пользователь не передан");
        }

        $count = 3; //fixme

        $res = DB::select("SELECT * FROM `post` as p JOIN category as c ON p.id_category = c.id_category
                            WHERE p.id_creator = ? AND p.id_status = ? ORDER BY p.id_post DESC LIMIT $start, $count;", [$id_user, 2]);

        $getTags = [];
        $getNameUser = [];
        $getLikesPost = [];
        $getViews = [];
        $getViewsDay = [];
        $getReadPost = [];
        $getCommentsCount = [];

        foreach ($res as $el) {
            $get = DB::select("SELECT t.id_tag, t.name_tag FROM tag as t JOIN post_tag as pt ON t.id_tag = pt.id_tag WHERE pt.id_post = ?;", [$el['id_post']]);
            array_push($getTags, $get);

            $get = DB::select("SELECT u.login FROM user as u JOIN post as p ON p.id_creator = u.id_user WHERE p.id_creator = ?;", [$el['id_creator']]);
            array_push($getNameUser, $get[0]['login']);

            $get = DB::select("SELECT COUNT(cl.mark) as 'like' FROM post_like as cl WHERE cl.id_post = ? AND cl.mark = ?
                                    UNION SELECT COUNT(cl.mark) FROM post_like as cl WHERE cl.id_post = ? AND cl.mark = ?;", [$el['id_post'], 1, $el['id_post'], 0]);
            $get = ($get[0]['like'] ?? 0) - ($get[1]['like'] ?? 0);
            array_push($getLikesPost, $get);

            $get = DB::select("SELECT COUNT(v.id_view) as `number` FROM view as v JOIN post as p ON p.id_post = v.id_post WHERE v.id_post = ?;", [$el['id_post']]);
            array_push($getViews, $get[0]['number']);

            $get = DB::select("SELECT COUNT(v.id_view) as `number` FROM view as v JOIN post as p ON p.id_post = v.id_post WHERE v.id_post = ? AND v.created_at >= NOW() - INTERVAL 1 DAY;", [$el['id_post']]);
            array_push($getViewsDay, $get[0]['number']);

            $get = DB::select("SELECT COUNT(id_comment) as 'comments' FROM comment WHERE id_post = ?;", [$el['id_post']]);
            array_push($getCommentsCount, $get[0]['comments']);

            if (Auth::check()) {
                $get = DB::select("SELECT `id_post`, `id_looked` FROM `view` WHERE id_looked = ? AND id_post = ?;", [Auth::user()->id_user, $el['id_post']]);

                if ($get) {
                    array_push($getReadPost, true);
                } else {
                    array_push($getReadPost, false);
                }
            } else {
                array_push($getReadPost, false);
            }
        }

        for ($i = 0; $i <  count($res); $i++) {
            $res[$i]['tags'] = $getTags[$i] ?? false;
            $res[$i]['user_login'] = $getNameUser[$i] ?? false;
            $res[$i]['likes'] = $getLikesPost[$i] ?? false;
            $res[$i]['views'] = $getViews[$i] ?? false;
            $res[$i]['views_day'] = $getViewsDay[$i] ?? false;
            $res[$i]['read_post'] = $getReadPost[$i] ?? false;
            $res[$i]['comments_count'] = $getCommentsCount[$i] ?? false;

            //fixme
            $res[$i]['img_url'] = route('/') . '/storage/data/posts/' . $res[$i]['main_folder']. '/main_img.' . $res[$i]['main_img_type'];
        }

        return result(200, "", $res);
    }

    public function searchLk(Request $request) {
        $start = correct($request->start);
        $lk = correct($request->lk);

        if ($lk) {
            $getIdUser = Auth::user()->id_user;
            if ($getIdUser) {
                $count = 4; //fixme

                $res = DB::select("SELECT * FROM `post` as p JOIN category as c ON p.id_category = c.id_category
                                    JOIN post_status as ps ON ps.id_status = p.id_status
                                    WHERE p.id_creator = ? ORDER BY p.id_post DESC LIMIT $start, $count;", [$getIdUser]);

                $getTags = [];
                $getNameUser = [];
                $getLikesPost = [];
                $getViews = [];
                $getViewsDay = [];
                $getReadPost = [];
                $getCommentsCount = [];

                foreach ($res as $el) {
                    $get = DB::select("SELECT t.id_tag, t.name_tag FROM tag as t JOIN post_tag as pt ON t.id_tag = pt.id_tag WHERE pt.id_post = ?;", [$el['id_post']]);
                    array_push($getTags, $get);

                    $get = DB::select("SELECT u.login FROM user as u JOIN post as p ON p.id_creator = u.id_user WHERE p.id_creator = ?;", [$el['id_creator']]);
                    array_push($getNameUser, $get[0]['login']);

                    $get = DB::select("SELECT COUNT(cl.mark) as 'like' FROM post_like as cl WHERE cl.id_post = ? AND cl.mark = ?
                                UNION SELECT COUNT(cl.mark) FROM post_like as cl WHERE cl.id_post = ? AND cl.mark = ?;", [$el['id_post'], 1, $el['id_post'], 0]);
                    $get = ($get[0]['like'] ?? 0) - ($get[1]['like'] ?? 0);
                    array_push($getLikesPost, $get);

                    $get = DB::select("SELECT COUNT(v.id_view) as `number` FROM view as v JOIN post as p ON p.id_post = v.id_post WHERE v.id_post = ?;", [$el['id_post']]);
                    array_push($getViews, $get[0]['number']);

                    $get = DB::select("SELECT COUNT(v.id_view) as `number` FROM view as v JOIN post as p ON p.id_post = v.id_post WHERE v.id_post = ? AND v.created_at >= NOW() - INTERVAL 1 DAY;", [$el['id_post']]);
                    array_push($getViewsDay, $get[0]['number']);

                    $get = DB::select("SELECT COUNT(id_comment) as 'comments' FROM comment WHERE id_post = ?;", [$el['id_post']]);
                    array_push($getCommentsCount, $get[0]['comments']);

                    if (Auth::check()) {
                        $get = DB::select("SELECT `id_post`, `id_looked` FROM `view` WHERE id_looked = ? AND id_post = ?;", [Auth::user()->id_user, $el['id_post']]);

                        if ($get) {
                            array_push($getReadPost, true);
                        } else {
                            array_push($getReadPost, false);
                        }
                    } else {
                        array_push($getReadPost, false);
                    }
                }

                for ($i = 0; $i <  count($res); $i++) {
                    $res[$i]['tags'] = $getTags[$i] ?? false;
                    $res[$i]['user_login'] = $getNameUser[$i] ?? false;
                    $res[$i]['likes'] = $getLikesPost[$i] ?? false;
                    $res[$i]['views'] = $getViews[$i] ?? false;
                    $res[$i]['views_day'] = $getViewsDay[$i] ?? false;
                    $res[$i]['read_post'] = $getReadPost[$i] ?? false;
                    $res[$i]['comments_count'] = $getCommentsCount[$i] ?? false;

                    //fixme
                    $res[$i]['img_url'] = route('/') . '/storage/data/posts/' . $res[$i]['main_folder']. '/main_img.' . $res[$i]['main_img_type'];
                }

                return result(200, "", $res);
            } else {
                return result(409, "Нет доступа!");
            }
        }
    }
}
