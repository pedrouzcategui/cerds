<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./User.php";
require_once "../logs/Log.php";

checkAuth();

$user_id = $_GET['user_id'];

if ($user_id == $_SESSION['user_id']) {
    die("No puedes eliminar tu propio usuario");
} else {
    User::delete($user_id);
    Log::create($_SESSION['user_id'], "Eliminado el usuario con ID: " . $user_id);
    header("Location: ./");
}
