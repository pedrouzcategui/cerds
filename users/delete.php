<?php

require_once "../utils.php";
require_once "./User.php";

$user_id = $_GET['user_id'];
User::delete($user_id);

header("Location: ./");
