<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./User.php";
require_once "../logs/Log.php";

checkAuth();

// Receive data from POST request
$user_id = $_GET['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];

// Update user
User::update($user_id, $username, $email, $password, $phone);

// Log the update
$admin_id = $_SESSION['user_id'];
Log::create($admin_id, "Actualizado el usuario con ID: " . $user_id . " - " . $username);

// Redirect to the users list or another appropriate page
header("Location: ./");
