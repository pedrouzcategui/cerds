<?php

require_once "../utils.php";
require_once "./Lab.php";
$lab_id = $_GET['lab_id'];
Lab::delete($lab_id);
header("Location: ./");
