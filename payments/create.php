<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./Payment.php";
require_once "../logs/Log.php";

checkAuth();

$student_id = $_POST['student_id'];
$course_id = $_POST['course_id'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];
$reference = $_POST['reference'];
$date = $_POST['date'];
$status = $_POST['status'];

// Manejo de subidas de archivos, se suben en la carpeta uploads
$image = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        $image = basename($_FILES['image']['name']); // Solo se guarda el nombre del archivo.
    } else {
        die("Imagen no pudo ser subida");
    }
}

$payment = Payment::create($student_id, $course_id, $amount, $currency, $reference, $image, $date, $status);

$user_id = $_SESSION['user_id'];
Log::create($user_id, "Registro un nuevo pago: " . $payment->getId());

header("Location: ./");
