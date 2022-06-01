<?php
    require_once '../vendor/db.php';
    require_once '../vendor/functions.php'; // return validate()

    $last_name = validate($_POST['last_name']);
    $first_name = validate($_POST['first_name']);
    $phone = validate(preg_replace("/[^0-9]/", '', $_POST['phone']));
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $password2 = validate($_POST['password2']);

    $_SESSION['reg_last_name'] = $last_name;
    $_SESSION['reg_first_name'] = $first_name;
    $_SESSION['reg_phone'] = $phone;
    $_SESSION['reg_email'] = $email;

    if ($password != $password2) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        $_SESSION['error'] = 'Пароли не совпадают';
        exit();
    }

    $uniqPhone = $db->query("SELECT phone FROM `user` WHERE phone = ?", [$phone]);
    if (count($uniqPhone) > 0) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        $_SESSION['phone'] = 'Такой телефон уже занят';
    }
    $uniqEmail = $db->query("SELECT email FROM `user` WHERE email = ?", [$email]);
    if (count($uniqEmail) > 0) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        $_SESSION['email'] = 'Такой email уже занят';
    }

    $checkReg = $db->make("INSERT INTO `user` (`id_role`, `last_name`, `first_name`, `phone`, `email`, `password`) 
        VALUES (?, ?, ?, ?, ?, ?)", [
            1,
            $last_name,
            $first_name,
            $phone,
            $email,
            password_hash($password, PASSWORD_DEFAULT)
        ]);

    if (!$checkReg) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        $_SESSION['error'] = 'Не удалось зарегистрироваться';
        exit();
    }

    header("Location: /login");
    $_SESSION['msg'] = 'Успешная регистрация';
