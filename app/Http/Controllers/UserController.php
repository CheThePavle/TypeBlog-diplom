<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function showResetPassword(Request $request) {
        return view('user.reset.password');
    }

    public function resetPassword(Request $request) {
        $email = correct($request->email);

        $user = User::where('email', $email)
            ->first();
        if ($user) {
            $mailer = new MailerController();

            return redirect(url()->previous())
                ->with(['msg' => $mailer->resetPasswordEmail($user)]);
        } else {
            return redirect(url()->previous())
                ->with(['error' => 'Ваша почта не найдена']);
        }
    }

    public function setAvatar(Request $request) {
        if (Auth::check()) {
            $img = $request->file('image');
            if (!$img) {
                return result(409, "Изображение должно быть выбрано!");
            }
            if ($img->getSize() > 1000000) {
                return result(409, "Изображение не должно превышать 1 Мегабайта!");
            }

            switch ($img->extension()) {
                case 'jpg':
                case 'jpeg':
                    $typeImg = 'jpeg';
                    break;
                case 'png':
                    $typeImg = 'png';
                    break;
                case 'gif':
                    $typeImg = 'gif';
                    break;
                default:
                    return result(409, "Расширение изображения должно быть png, jpg или gif!");
            }

            $getFolder = DB::select("SELECT folder FROM user WHERE id_user = ?;", [Auth::user()->id_user]);
            $getFolder = $getFolder[0]['folder'];
            if ($getFolder) {
                $uniqUrl = $getFolder;
            } else {
                $uniqUrl = md5(uniqid(rand(), true));
            }

            $newDir = 'public/data/users/'.$uniqUrl;
            Storage::makeDirectory($newDir);

            $path = $img->storeAs($newDir, 'avatar.'.$typeImg);
            if (!$path) {
                Storage::deleteDirectory($newDir);
                return result(409, "Что-то пошло не так, изображение не было загружено на сервер!");
            }

            $id = Auth::user()->id_user;

            DB::update("UPDATE `user` SET `folder` = ?, `img_type` = ?, `updated_at` = ? WHERE `user`.`id_user` = ?;", [$uniqUrl, $typeImg, date("Y-m-d H:i:s"), $id]);

            return result(200, "Аватар успешно изменен");
        } else {
            return result(409, "Вы должно быть авторизованы, чтобы поменять аватарку!");
        }
    }

    public function blocked(Request $request) {
        $idUser = correct($request->id);

        if (Auth::check() && Auth::user()->isAdmin()) {
            if (!$idUser) {
                return result(409, "Что-то пошло не так, пользователь не указан!");
            }

            $check = DB::select("SELECT id_user FROM user WHERE id_user = ?;", [$idUser]);
            if (!$check) {
                return result(409, "Что-то пошло не так, пользователь не найден!");
            }

            $res = DB::update("UPDATE `user` SET `blocked` = ?, `updated_at` = ? WHERE `user`.`id_user` = ?;", [1, date("Y-m-d H:i:s"), $idUser]);
            if ($res) {
                return result(200, "Пользователь заблокирован!");
            }
            return result(409, "Что-то пошло не так, не удалось заблокировать пользователя!");
        } else {
            return result(409, "Нет доступа!");
        }
    }

    public function unblocked(Request $request) {
        $idUser = correct($request->id);

        if (Auth::check() && Auth::user()->isAdmin()) {
            if (!$idUser) {
                return result(409, "Что-то пошло не так, пользователь не указан!");
            }

            $check = DB::select("SELECT id_user FROM user WHERE id_user = ?;", [$idUser]);
            if (!$check) {
                return result(409, "Что-то пошло не так, пользователь не найден!");
            }

            $res = DB::update("UPDATE `user` SET `blocked` = ?, `updated_at` = ? WHERE `user`.`id_user` = ?;", [0, date("Y-m-d H:i:s"), $idUser]);
            if ($res) {
                return result(200, "Пользователь разблокирован!");
            }
            return result(409, "Что-то пошло не так, не удалось разблокировать пользователя!");
        } else {
            return result(409, "Нет доступа!");
        }
    }

    public function changeRoleById(Request $request) {
        $idUser = correct($request->idUser);
        $idRole = correct($request->idRole);

        if (Auth::check() && Auth::user()->isAdmin()) {
            if (!$idUser) {
                return result(409, "Пользователь не передан!");
            }
            if (!$idRole) {
                return result(409, "Роль не передана!");
            }

            $check = DB::select("SELECT id_user FROM user WHERE id_user = ?;", [$idUser]);
            if (!$check) {
                return result(409, "Пользователь не найден!");
            }

            $change = DB::update("UPDATE `user` SET `id_role` = ?, `updated_at` = ? WHERE `user`.`id_user` = ?", [
                $idRole,
                date("Y-m-d H:i:s"),
                $idUser
            ]);
            if (!$change) {
                return result(409, "Что-то полшло не так, поменять роль не удалось");
            }

            return result(200, "Роль изменена");
        } else {
            return result(409, "Нет доступа!");
        }
    }

    public function showList(Request $request) {
        if (!Auth::check() || !Auth::user()->isAdmin()) return to_route('login');

        $getList = DB::select("SELECT u.id_user, u.email, u.login, u.blocked, u.created_at, ur.id_role, ur.name
                                FROM user as u JOIN user_role as ur ON ur.id_role = u.id_role ORDER BY u.id_user DESC;");

        $getRole = DB::select("SELECT * FROM user_role;");

        $getList = arrayPaginate($getList, $request);

        return view('user.list', ['getList' => $getList, 'getRole' => $getRole]);
    }

    public function rejectedComplaint(Request $request) {
        $idComplaint = correct($request->id);

        if (!$idComplaint) {
            return result(409, "Что-то пошло не так, жалоба не передана!");
        }

        $check = DB::select("SELECT id_accused FROM user_complaint WHERE id_complaint = ?;", [$idComplaint]);
        if (!$check) {
            return result(409, "Что-то пошло не так, жалоба не найдена!");
        }

        $res = DB::select("SELECT id_complaint FROM user_complaint WHERE id_accused = ?;", [$check[0]['id_accused']]);
        if (!$res) {
            return result(409, "Что-то пошло не так, жалоба не найдена для этого пользователя!");
        }

        foreach ($res as $el) {
            DB::delete("DELETE FROM `user_complaint` WHERE `user_complaint`.`id_complaint` = ?;", [$el['id_complaint']]);
        }

        return result(200, "Жалоба(ы) отклонена(ы)!");
    }

    public function blockedComplaint(Request $request) {
        $idComplaint = correct($request->id);

        if (!$idComplaint) {
            return result(409, "Что-то пошло не так, жалоба не передана!");
        }

        $check = DB::select("SELECT id_accused FROM user_complaint WHERE id_complaint = ?;", [$idComplaint]);
        if (!$check) {
            return result(409, "Что-то пошло не так, жалоба не найдена!");
        }

        $res = DB::select("SELECT id_complaint FROM user_complaint WHERE id_accused = ?;", [$check[0]['id_accused']]);
        if (!$res) {
            return result(409, "Что-то пошло не так, жалоба не найдена для этого пользователя!");
        }

        foreach ($res as $el) {
            DB::delete("DELETE FROM `user_complaint` WHERE `user_complaint`.`id_complaint` = ?;", [$el['id_complaint']]);
        }

        $block = DB::update("UPDATE `user` SET `blocked` = ?, `updated_at` = ? WHERE `user`.`id_user` = ?;", [1 ,date("Y-m-d H:i:s"), $check[0]['id_accused']]);
        if ($block) {
            return result(200, "Пользователь заблокирован!");
        }

        return result(409, "Что-то пошло не так, не удалось заблокировать пользователя!");
    }

    public function showComplaint(Request $request) {
        if (!Auth::check() || !Auth::user()->isModerOrAdmin()) return to_route('login');

        $getComplaint = DB::select("SELECT uc.id_complaint, u1.id_user as 'id_witness', u1.login as 'witness', u2.id_user as 'id_accused', u2.login as 'accused', uc.body_complaint, uc.created_at
                                    FROM user as u1
                                    JOIN (user_complaint as uc
                                    JOIN user as u2
                                    ON u2.id_user = uc.id_accused)
                                    ON u1.id_user = uc.id_witness
                                    ORDER BY uc.id_complaint DESC;");

        $treeComplaint = [];
        foreach($getComplaint as $k => $v) {
            $treeComplaint[$v['accused']][]=$v;
        }

        $treeComplaint = arrayPaginate($treeComplaint, $request);

        return view('user.complaint', ['treeComplaint' => $treeComplaint]);
    }

    public function logout(Request $request) {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return to_route('login');
    }

    public function showChangePassword() {
        if (!Auth::check()) return to_route('login');

        return view('user.change.password');
    }

    public function changePassword(Request $request) {
        $idUser = Auth::check() ? Auth::user()->id_user : false;
        $oldPassword = correct($request->oldPassword);
        $newPassword = correct($request->newPassword);

        if (!$idUser) {
            return result(409, "Вы должны быть авторизованы, чтобы изменить пароль от аккаунта!");
        }
        if (!$oldPassword) {
            return result(409, "Укажите старый пароль!");
        }
        if (!$newPassword) {
            return result(409, "Укажите новый пароль!");
        }
        if (iconv_strlen($newPassword) < 6) {
            return result(409, "Новый пароль не может быть меньше 6 символов!");
        }
        if (iconv_strlen($newPassword) > 32) {
            return result(409, "Новый пароль не может быть больше 32 символов!");
        }

        $check = DB::select("SELECT password FROM user WHERE id_user = ?;", [$idUser]);
        if (!$check) {
            return result(409, "Пользователь не найден");
        }

        if (password_verify($oldPassword, $check[0]['password'])) {
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $change = DB::update("UPDATE `user` SET `password` = ?, `updated_at` = ? WHERE `user`.`id_user` = ?;", [$newPassword, date("Y-m-d H:i:s"), $idUser]);
            if (!$change) {
                return result(409, "Что-то пошло не так, пароль не изменен");
            }

            return result(200, "Пароль успешно изменен!");
        } else {
            return result(409, "Старый пароль неверный!");
        }
    }

    public function changeEmailAndAbout(Request $request) {
        $idUser = Auth::check() ? Auth::user()->id_user : false;
        $changeEmail = correct($request->changeEmail);
        $changeAbout = correct($request->changeAbout);

        if (!$idUser) {
            return result(409, "Пользователь должен быть авторизован!");
        }
        if (!$changeEmail) {
            return result(409, "Email должен быть указан!");
        }
        if (iconv_strlen($changeEmail) > 100) {
            return result(409, "Email не может быть больше 100 символов!");
        }
        if (iconv_strlen($changeAbout) > 1000) {
            return result(409, "О себе не может быть больше 1000 символов!");
        }

        $check = DB::select("SELECT id_user, email FROM user WHERE id_user = ?;", [$idUser]);
        if (!$check) {
            return result(409, "Пользователь не найден!");
        }

        if ($check[0]['email'] == $changeEmail) {
            $res = DB::update("UPDATE `user` SET `about` = ?, `updated_at` = ? WHERE `user`.`id_user` = ?;", [
                $changeAbout,
                date("Y-m-d H:i:s"),
                $idUser
            ]);
            if (!$res) {
                return result(409, "Не удалось изменить данные пользователя!");
            }
        } else {
            $checkEmail = DB::select("SELECT email FROM user WHERE email = ? AND id_user != ?;", [
                $changeEmail,
                $idUser
            ]);

            if (!$checkEmail) {
                $res = DB::update("UPDATE `user` SET `email` = ?, `about` = ?, `updated_at` = ? WHERE `user`.`id_user` = ?;", [
                    $changeEmail,
                    $changeAbout,
                    date("Y-m-d H:i:s"),
                    $idUser
                ]);
                if (!$res) {
                    return result(409, "Не удалось изменить данные пользователя!");
                }
            } else {
                return result(409, "Такой Email уже занят!");
            }
        }

        return result(200, "Данные успешно изменены!", [
            "email"=>$changeEmail,
            "about"=>$changeAbout
        ]);
    }

    public function complaint(Request $request) {
        $idUserAccused = correct($request->idUserAccused);
        $idUserWitness  = Auth::check() ? Auth::user()->id_user : false;
        $body_complaint = correct($request->body_complaint);

        if (!$idUserWitness) {
            return result(409, "Чтобы пожаловаться на пользователя нужно авторизоваться!");
        }
        if (!$body_complaint) {
            return result(409, "Жалоба не может быть пустой!");
        }
        if (iconv_strlen($body_complaint) > 200) {
            return result(409, "Жалоба не может быть больше 200 символов!");
        }
        if (!$idUserAccused) {
            return result(409, "Что-то пошло не так, обвиняемый пользователь не найден!");
        }
        if ($idUserAccused == $idUserWitness) {
            return result(409, "Жаловаться на самого себя нельзя :)");
        }

        $check = DB::select("SELECT id_complaint FROM user_complaint WHERE id_accused = ? AND id_witness = ?;", [
            $idUserAccused,
            $idUserWitness
        ]);

        if ($check) {
            return result(409, "Жалобу можно отправлять один раз на одного пользователя");
        }

        $res = DB::insert("INSERT INTO `user_complaint` (`id_accused`, `id_witness`, `body_complaint`, `created_at`) VALUES (?, ?, ?, ?);", [
            $idUserAccused,
            $idUserWitness,
            $body_complaint,
            date("Y-m-d H:i:s")
        ]);

        if ($res) {
            return result(200, "Жалоба успешно отправлена!");
        } else {
            return result(409, "Что-то пошло не так, жалоба не отправлена!");
        }
    }

    public function showLogin() {
        if (Auth::check()) return to_route('lk');
        return view('login');
    }

    public function genCaptcha() {
        $width = 120;
        $height = 60;
        $font_size = 17.5;
        $let_amount = 5;
        $fon_let_amount = 30;
        $path_fonts = public_path('styles/fonts/');

        $letters = array('a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','s','t','u','v','w','x','y','z','2','3','4','5','6','7','9');
        $colors = array('10','30','50','70','90','110','130','150','170','190','210');

        $src = imagecreatetruecolor($width,$height);
        $fon = imagecolorallocate($src,255,255,255);
        imagefill($src,0,0,$fon);

        $fonts = array();
        $dir=opendir($path_fonts);
        while($fontName = readdir($dir))
        {
            if($fontName != "." && $fontName != "..")
            {
                $fonts[] = $fontName;
            }
        }
        closedir($dir);

        for($i=0;$i<$fon_let_amount;$i++)
        {
            $color = imagecolorallocatealpha($src,rand(0,255),rand(0,255),rand(0,255),100);
            $font = $path_fonts.$fonts[rand(0,sizeof($fonts)-1)];
            $letter = $letters[rand(0,sizeof($letters)-1)];
            $size = rand($font_size-2,$font_size+2);
            imagettftext($src,$size,rand(0,45),rand($width*0.1,$width-$width*0.1),rand($height*0.2,$height),$color,$font,$letter);
        }

        for($i=0;$i<$let_amount;$i++)
        {
            $color = imagecolorallocatealpha($src,$colors[rand(0,sizeof($colors)-1)],$colors[rand(0,sizeof($colors)-1)],$colors[rand(0,sizeof($colors)-1)],rand(20,40));
            $font = $path_fonts.$fonts[rand(0,sizeof($fonts)-1)];
            $letter = $letters[rand(0,sizeof($letters)-1)];
            $size = rand($font_size*2.1-2,$font_size*2.1+2);
            $x = ($i+1)*$font_size + rand(4,7);
            $y = (($height*2)/3) + rand(0,5);
            $cod[] = $letter;
            imagettftext($src,$size,rand(0,15),$x,$y,$color,$font,$letter);
        }

        session(['captcha' => implode('',$cod)]);

        header ("Content-type: image/png");
        imagepng($src);
        imagedestroy($src);
    }

    public function showRegister() {
        if (Auth::check()) return to_route('lk');
        return view('register');
    }

    public function findLogin(Request $request) {
        $login = correct($request->login);

        $res = DB::select("SELECT `login` FROM `user` WHERE `login` = ?;", [$login]);
        if ($res) {
            return result(409, "Такой логин уже занят");
        }

        return result(200);
    }

    public function findEmail(Request $request) {
        $email = correct($request->email);

        $res = DB::select("SELECT `email` FROM `user` WHERE `email` = ?;", [$email]);
        if ($res) {
            return result(409, "Такой email уже занят");
        }

        return result(200);
    }

    public function auth(Request $request) {
        $login = correct($request->login);
        $password = correct($request->password);
//        $checkbox = correct($request->checkbox);

        if ($login && $password) {
            $res = DB::select("SELECT u.id_user, u.login, u.password, ur.code, ur.name, u.blocked FROM user as u JOIN user_role as ur ON ur.id_role = u.id_role WHERE u.login = ?;", [$login]);
            if (password_verify($password, isset($res[0]['password']) ? $res[0]['password'] : null)) {
                if ($res[0]['blocked'] == '1') {
                    return result(409, "Ваш аккаунт был заблокирован :(");
                }

                Auth::login(User::where('id_user', $res[0]['id_user'])->first());
                $request->session()->regenerate();


                return result(200, "Успешная авторизация!");
            } else {
                return result(409, "Неверный логин или пароль!");
            }
        } else {
            return result(409, "Введите логин и пароль!");
        }
    }

    public function create(Request $request) {
        $code = correct($request->code);

        if ($code != session('captcha')) {
            return result(409, "Капча не верная");
        }

        $login = correct($request->login);
        $email = correct($request->email);
        $password = correct($request->password);
        $password2 = correct($request->password2);
        $about = correct($request->about);
        $checkAccept = correct($request->checkbox);

        if (!$login) {
            return result(409, "Логин должен быть указан обязательно!");
        }
        if (iconv_strlen($login) < 5) {
            return result(409, "Логин не может быть меньше 5 символов!");
        }
        if (iconv_strlen($login) > 25) {
            return result(409, "Логин не может быть больше 25 символов!");
        }
        if (!$email) {
            return result(409, "Почта должна быть указана обязательно!");
        }
        if (iconv_strlen($email) > 100) {
            return result(409, "Почта не может быть больше 100 символов!");
        }
        if (!$password) {
            return result(409, "Пароль должен быть указан обязательно!");
        }
        if (iconv_strlen($password) < 6) {
            return result(409, "Пароль не может быть меньше 6 символов!");
        }
        if (iconv_strlen($password) > 32) {
            return result(409, "Пароль не может быть больше 32 символов!");
        }
        if ($password == $password2) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else {
            return result(409, "Пароли не совпадают!");
        }
        if (iconv_strlen($about) > 1000) {
            return result(409, "О себе не может быть больше 1000 символов!");
        }
        if (!$checkAccept) {
            return result(409, "Вы не согласились с пользовательским соглашением!");
        }

        $res = DB::insert("INSERT INTO `user` (`email`, `login`, `password`, `about`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?);",
            [
                $email,
                $login,
                $password,
                $about,
                date("Y-m-d H:i:s"),
                NULL
            ]);

        if (!$res) {
            return result(409, "Что-то пошло не так, невозможно зарегистрироваться!");
        }

        return result(200, "Успешная регистрация!");
    }
}
