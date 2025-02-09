<?php

require_once "./utils.php";
// require_once "./logs/Log.php";

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // Log::create($user_id, "logged out of the system");
    session_destroy();
}

header("Location: signin.php");
exit();
