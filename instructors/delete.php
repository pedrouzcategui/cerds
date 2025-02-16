<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./Instructor.php";
require_once "../logs/Log.php";

checkAuth();

$instructor_id = $_GET['instructor_id'];
Instructor::delete($instructor_id);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Eliminado Instructor con ID: " . $instructor_id);

header("Location: ./");
