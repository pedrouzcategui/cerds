<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./Payment.php";
require_once "../logs/Log.php";

checkAuth();

// Receive data from POST request
$student_id = $_POST['student_id'];
$course_id = $_POST['course_id'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];
$reference = $_POST['reference'];
$date = $_POST['date'];
$status = $_POST['status'];

// Handle file upload
$image = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        $image = basename($_FILES['image']['name']); // Store only the file name with extension
    } else {
        die("Failed to upload image.");
    }
}

// Create new payment
$payment = Payment::create($student_id, $course_id, $amount, $currency, $reference, $image, $date, $status);

// Log the creation
$user_id = $_SESSION['user_id'];
Log::create($user_id, "Registro un nuevo pago: " . $payment->getId());

// Redirect to the payments list or another appropriate page
header("Location: ./");
