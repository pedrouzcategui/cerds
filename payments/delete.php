<?php

require_once "../utils.php";
require_once "./Payment.php";

$payment_id = $_GET['payment_id'];
Payment::delete($payment_id);

header("Location: ./");
