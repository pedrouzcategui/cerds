<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./Student.php";
require_once "../logs/Log.php";

checkAuth();

$student_id = $_GET['student_id'];
Student::delete($student_id);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Eliminó un estudiante con ID: " . $student_id);

header("Location: ./");
