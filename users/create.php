<?php

require_once "../utils.php";
require_once "./User.php";

// Receive data from POST request
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];

// Create new user
$user_id = User::create($username, $email, $password, $phone);

// Redirect to the users list or another appropriate page
header("Location: ./");
