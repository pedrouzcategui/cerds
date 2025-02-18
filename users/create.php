<?php

// require_once "../middleware.php";
require_once "../utils.php";
require_once "./User.php";
require_once "../logs/Log.php";

// checkAuth();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];

$created_user = User::create($username, $email, $password, $phone);

// $user_id = $_SESSION['user_id'];
// Log::create($user_id, "Creado el usuario con ID: " . $created_user->getId() . " - " . $username);

header("Location: ./");
