<?php

session_start();

require_once "../utils.php";
require_once "./Course.php";
$course_id = $_GET['course_id'];
Course::delete($course_id);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Deleted course with ID: " . $course->getId());

header("Location: ./");
