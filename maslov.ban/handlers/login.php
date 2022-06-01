<?php
    require_once '../vendor/db.php';
    require_once '../vendor/functions.php'; // return validate()

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    $check = $db->query("SELECT * FROM `user` WHERE email = ?", [
        $email
    ]);
    if (!$check) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        $_SESSION['error'] = 'Неверный email';
        exit();
    }

    if (!password_verify($password, $check[0]['password'])) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        $_SESSION['error'] = 'Неверный пароль';
        exit();
    }

    session_destroy();
    session_start();
    $_SESSION['id_user'] = $check[0]['id_user'];
    $_SESSION['id_role'] = $check[0]['id_role'];
    $_SESSION['last_name'] = $check[0]['last_name'];
    $_SESSION['first_name'] = $check[0]['first_name'];
    $_SESSION['phone'] = $check[0]['phone'];
    $_SESSION['email'] = $check[0]['email'];

    header("Location: /lk");
