<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./User.php";
require_once "../logs/Log.php";

checkAuth();

// Receive data from POST request
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];

// Create new user
$created_user = User::create($username, $email, $password, $phone);

// Log the creation
$user_id = $_SESSION['user_id'];
Log::create($user_id, "Creado el usuario con ID: " . $created_user->getId() . " - " . $username);

// Redirect to the users list or another appropriate page
header("Location: ./");
