<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerController extends Controller
{
    public function resetPasswordEmail($user) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer();

        try {
            $mail->SMTPDebug = 0;
            $mail->CharSet = 'utf-8';
            $mail->isSMTP();
            $mail->Host = env('RP_MAILER_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('RP_MAILER_EMAIL');
            $mail->Password = env('RP_MAILER_PASSWORD');
            $mail->SMTPSecure = env('RP_MAILER_SMTPSECURE');
            $mail->Port = env('RP_MAILER_PORT');

            $mail->setFrom(env('RP_MAILER_EMAIL'));
            $mail->addAddress($user->email);
            $mail->isHTML(true);

            $mail->Subject = env('RP_MAILER_HEADER');

            $newPassword = Str::random();
            $mail->Body = "Ваш новый пароль - $newPassword <br> Вы можете поменять его в личном кабинете";

            if(!$mail->send()) {
                return "Невозможно отправить письмо на вашу почту";
            } else {
                $user->changePassword($newPassword);
                return "На вашу почту был отправлен новый пароль";
            }
        } catch (Exception $e) {
            return "Невозможно отправить письмо (что-то пошло не так или почта не найдена)";
        }
    }
}
