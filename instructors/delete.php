<?php

require_once "../utils.php";
require_once "./Instructor.php";
$instructor_id = $_GET['instructor_id'];
Instructor::delete($instructor_id);
header("Location: ./");
