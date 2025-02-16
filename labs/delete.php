<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./Lab.php";
require_once "../logs/Log.php";

checkAuth();

$lab_id = $_GET['lab_id'];
Lab::delete($lab_id);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Laboratorio con ID: " . $lab_id . " eliminado");

header("Location: ./");
