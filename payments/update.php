<?php

require_once "../middleware.php";
require_once "../logs/Log.php";
require_once "../utils.php";
require_once "./Payment.php";

checkAuth();

$payment_id = $_GET['payment_id'];
$student_id = $_POST['student_id'];
$course_id = $_POST['course_id'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];
$reference = $_POST['reference'];
$date = $_POST['date'];
$status = $_POST['status'];

$image = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        $image = basename($_FILES['image']['name']);
    } else {
        die("Failed to upload image.");
    }
} else {
    $payment = Payment::findById($payment_id);
    $image = $payment->getImage();
}

$payment = Payment::update($payment_id, $student_id, $course_id, $amount, $currency, $reference, $image, $date, $status);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Pago con ID: $payment_id fue actualizado");

header("Location: ./");
