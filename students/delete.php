<?php

require_once "../utils.php";
require_once "./Student.php";
$student_id = $_GET['student_id'];
Student::delete($student_id);
header("Location: ./");
