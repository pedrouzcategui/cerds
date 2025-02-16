<?php

require_once "../middleware.php";
require_once "../logs/Log.php";
require_once "../utils.php";
require_once "./Student.php";

checkAuth();

$student_id = $_GET['student_id'];

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$student = Student::update($student_id, $first_name, $last_name, $email, $phone);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Edito el estudiante con ID $student_id - " . $student->getFullName());

header("Location: ./");
