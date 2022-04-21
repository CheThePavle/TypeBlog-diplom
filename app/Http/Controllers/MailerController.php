<?php

namespace App\Http\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerController extends Controller
{
    public function verifyEmail($email, $login) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer();     // Passing `true` enables exceptions

        try {
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->CharSet = 'utf-8';
            $mail->isSMTP();
            $mail->Host = 'smtp.yandex.ru';           //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'typeblog@yandex.ru';   //  sender username
            $mail->Password = 'QwErTy123';       // sender password
            $mail->SMTPSecure = 'ssl';                  // encryption - ssl/tls
            $mail->Port = 465;                         // port - 587/465

            $mail->setFrom('typeblog@yandex.ru');
            $mail->addAddress($email);
            $mail->isHTML(true);

            $mail->Subject = "Код для подтверждения регистрации пользователя - $login";
//            $mail->AltBody = '';

            $code = mt_rand(10000, 99999);

            session(['verifyCode' => $code]);
            session(['attempts' => 4]);

            $mail->Body = "Ваш код $code";

            if(!$mail->send()) {
                session(['verifyCode' => false]);
                session(['attempts' => false]);
                return result(409, "Невозможно доставить письмо на вашу почту");
            } else {
                return result(200, "На вашу почту отправлен код подтверждения регистрации!");
            }
        } catch (Exception $e) {
            return result(409, "Невозможно отправить письмо (что-то пошло не так или почта не найдена)");
        }
    }
}
