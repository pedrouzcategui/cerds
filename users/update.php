<?php

require_once "../utils.php";
require_once "./User.php";

// Receive data from POST request
$user_id = $_GET['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];

// Update user
User::update($user_id, $username, $email, $password, $phone);

// Redirect to the users list or another appropriate page
header("Location: ./");
