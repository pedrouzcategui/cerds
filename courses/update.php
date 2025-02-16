<?php

session_start();

require_once "../middleware.php";
require_once "../logs/Log.php";
require_once "../utils.php";
require_once "./Course.php";

checkAuth();

$course_id = $_GET['course_id'];
$course_name = $_POST['name'];
$course_description = $_POST['description'];
$course_instructor_id = $_POST['instructor_id'];
$lab_id = $_POST['lab_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$course_status = $_POST['status'];

$course = Course::update($course_id, $course_instructor_id, $lab_id, $course_name, $course_description, $start_date, $end_date, $course_status);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Edito el curso: " . $course->getId() . " - " . $course->getName());

header("Location: ./");
