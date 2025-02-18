<?php

require_once "../utils.php";
require_once "../db.php";
require_once "../users/User.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = User::findByUsername($username);

    if ($user && $user->getPassword() === md5($password)) {
        $_SESSION['user_id'] = $user->getId();
        header("Location: ../dashboard");
        exit();
    } else {
        $_SESSION['error'] = "Usuario inválido o cláve invalida";
        header("Location: ../signin");
        exit();
    }
}
