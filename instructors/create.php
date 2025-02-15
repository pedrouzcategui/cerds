<?php

session_start();

require_once "../utils.php";
require_once "./Instructor.php";
require_once "../logs/Log.php";

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$instructor = Instructor::create($first_name, $last_name, $email, $phone);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Created new instructor with ID: " . $instructor->getId());

header("Location: ./");
