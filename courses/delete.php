<?php

require_once "../middleware.php";
require_once "../logs/Log.php";
require_once "../utils.php";
require_once "./Course.php";

checkAuth();

$course_id = $_GET['course_id'];
Course::delete($course_id);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Elimino el curso con ID: " . $course_id);

header("Location: ./");
