<?php

require_once "../middleware.php";
require_once "./PTO.php";
require_once "../logs/Log.php";

checkAuth();

// Receive data from POST request
$instructor_id = $_POST['instructor_id'];
$course_id = $_POST['course_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$status = $_POST['status'];
$reason = $_POST['reason'];

// Create new PTO request
$pto = PTO::create($instructor_id, $course_id, $start_date, $end_date, $status, $reason);

// Adjust course end date
PTO::adjustCourseEndDate($course_id, $start_date, $end_date);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Creo una solicitud de tiempo libre con ID: {$pto->getId()}");

// Redirect to the PTO requests list or another appropriate page
header("Location: ./");
