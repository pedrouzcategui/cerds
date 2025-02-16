<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./Instructor.php";
require_once "../logs/Log.php";

checkAuth();

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$instructor = Instructor::create($first_name, $last_name, $email, $phone);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Nuevo instructor creado: " . $instructor->getId() . " - " . $instructor->getFullName());

header("Location: ./");
