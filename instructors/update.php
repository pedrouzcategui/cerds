<?php

require_once "../utils.php";
require_once "./Instructor.php";

$instructor_id = $_GET['instructor_id'];

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$instructor = Instructor::update($instructor_id, $first_name, $last_name, $email, $phone);

header("Location: ./");
