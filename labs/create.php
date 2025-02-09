<?php

require_once "../utils.php";
require_once "./Lab.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect Lab Name and Capacity
    $labName = $_POST['name'] ?? '';
    $labCapacity = $_POST['capacity'] ?? '';

    // Collect Lab Schedule
    $labSchedule = [];

    // Loop through selected days
    if (isset($_POST['open_days']) && is_array($_POST['open_days'])) {
        foreach ($_POST['open_days'] as $day) {
            $slots = [];
            $slotIndex = 1;

            // Iterate through all possible slots for the day
            while (isset($_POST["{$day}_start_time_slot_{$slotIndex}"]) && isset($_POST["{$day}_end_time_slot_{$slotIndex}"])) {
                $startTime = $_POST["{$day}_start_time_slot_{$slotIndex}"];
                $endTime = $_POST["{$day}_end_time_slot_{$slotIndex}"];

                // Add the slot to the schedule if both start and end times are provided
                if (!empty($startTime) && !empty($endTime)) {
                    $slots[] = [
                        'start_date' => $startTime,
                        'end_date' => $endTime,
                    ];
                }

                $slotIndex++;
            }

            // Add slots for the day to the schedule if there are any
            if (!empty($slots)) {
                $labSchedule[$day] = $slots;
            }
        }
    }

    // Create the final data structure
    try {
        $lab = Lab::create($labName, $labCapacity, json_encode($labSchedule));
        header("Location: ./");
    } catch (\Throwable $th) {
        Utils::prettyDump($th);
    }
}
