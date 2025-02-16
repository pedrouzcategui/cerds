<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./Payment.php";
require_once "../logs/Log.php";

checkAuth();

$payment_id = $_GET['payment_id'];
Payment::delete($payment_id);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Pago con ID: $payment_id fue eliminado");

header("Location: ./");
