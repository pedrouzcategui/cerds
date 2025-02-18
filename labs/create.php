<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./Lab.php";
require_once "../logs/Log.php";

checkAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos por POST
    $labName = $_POST['name'] ?? '';
    $labCapacity = $_POST['capacity'] ?? '';

    // Obtener el horario del laboratorio
    $labSchedule = [];

    // Se itera sobre los días de la semana
    if (isset($_POST['open_days']) && is_array($_POST['open_days'])) {
        foreach ($_POST['open_days'] as $day) {
            $slots = [];
            $slotIndex = 1;

            // Iterar sobre los slots posibles seleccionados
            while (isset($_POST["{$day}_start_time_slot_{$slotIndex}"]) && isset($_POST["{$day}_end_time_slot_{$slotIndex}"])) {
                $startTime = $_POST["{$day}_start_time_slot_{$slotIndex}"];
                $endTime = $_POST["{$day}_end_time_slot_{$slotIndex}"];

                // Añadir el slot si el tiempo de inicio y fin no están vacíos
                if (!empty($startTime) && !empty($endTime)) {
                    $slots[] = [
                        'start_date' => $startTime,
                        'end_date' => $endTime,
                    ];
                }

                $slotIndex++;
            }

            // Añadir los slots al día si no está vacío
            if (!empty($slots)) {
                $labSchedule[$day] = $slots;
            }
        }
    }

    // Crear la estructura final, guardar JSON.
    try {
        $lab = Lab::create($labName, $labCapacity, json_encode($labSchedule));


        $user_id = $_SESSION['user_id'];
        Log::create($user_id, "Nuevo laboratorio creado: " . $lab->getId() . " - " . $lab->getName());

        header("Location: ./");
    } catch (\Throwable $th) {
        Utils::prettyDump($th);
    }
}
