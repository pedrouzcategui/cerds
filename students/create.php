<?php

require_once "../middleware.php";
require_once "../logs/Log.php";
require_once "../utils.php";
require_once "./Student.php";

checkAuth();

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$student = Student::create($first_name, $last_name, $email, $phone);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Creo un nuevo estudiante: " . $student->getFullName());

header("Location: ./");
