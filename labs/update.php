<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./Lab.php";
require_once "../logs/Log.php";

checkAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $labId = $_GET['lab_id'];
    $labName = $_POST['name'] ?? '';
    $labCapacity = $_POST['capacity'] ?? '';

    $labSchedule = [];

    if (isset($_POST['open_days']) && is_array($_POST['open_days'])) {
        foreach ($_POST['open_days'] as $day) {
            $slots = [];
            $slotIndex = 1;

            while (isset($_POST["{$day}_start_time_slot_{$slotIndex}"]) && isset($_POST["{$day}_end_time_slot_{$slotIndex}"])) {
                $startTime = $_POST["{$day}_start_time_slot_{$slotIndex}"];
                $endTime = $_POST["{$day}_end_time_slot_{$slotIndex}"];

                if (!empty($startTime) && !empty($endTime)) {
                    $slots[] = [
                        'start_date' => $startTime,
                        'end_date' => $endTime,
                    ];
                }

                $slotIndex++;
            }

            if (!empty($slots)) {
                $labSchedule[$day] = $slots;
            }
        }
    }

    try {
        $lab = Lab::update($labId, $labName, $labCapacity, json_encode($labSchedule));

        $user_id = $_SESSION['user_id'];
        Log::create($user_id, "Laboratorio actualizado: " . $lab->getId() . " - " . $lab->getName());

        header("Location: ./");
    } catch (\Throwable $th) {
        Utils::prettyDump($th);
    }
}
