<?php

require_once "../middleware.php";
require_once "./PTO.php";
require_once "../logs/Log.php";

checkAuth();

$pto_id = $_GET['pto_id'];
$pto = PTO::findById($pto_id);
$course_id = $pto->getCourseId();

// Delete PTO request
PTO::delete($pto_id);

// Log the action
$user_id = $_SESSION['user_id'];
Log::create($user_id, "Elimino una solicitud de tiempo libre con ID $pto_id");

// Redirect to the PTO requests list or another appropriate page
header("Location: ./");
