<?php

require_once "../utils.php";
require_once "./Student.php";
// Receive shit from post
$student_id = $_GET['student_id'];
Utils::prettyDump($student_id);

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$student = Student::update($student_id, $first_name, $last_name, $email, $phone);

header("Location: ./");
