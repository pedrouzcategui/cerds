<?php

require_once "./utils.php";

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    session_destroy();
}

header("Location: signin.php");
exit();
