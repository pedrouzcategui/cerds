<?php

require_once "../middleware.php";
require_once "./Lab.php";

checkAuth();

// Check if Edit
$is_edit = isset($_GET['is_edit']);
$lab_id = isset($_GET['lab_id']);
$lab = null;
$lab_schedule = null;
if ($is_edit && $lab_id) {
    $lab = Lab::findById($_GET['lab_id']);
    $lab_schedule = json_decode($lab->getSchedule(), true);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Laboratorios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            padding: 15px;
            text-decoration: none;
            display: block;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="time"] {
            width: calc(100% - 24px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .slot {
            background: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
            position: relative;
        }

        .slot label {
            font-weight: normal;
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .slot span {
            font-weight: bold;
            color: #444;
            display: block;
            margin-bottom: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #218838;
        }

        .remove-btn {
            background-color: #dc3545;
            position: absolute;
            right: 10px;
            top: 10px;
            padding: 6px 12px;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }

        .slots-container {
            background: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
        }

        .error-message {
            background-color: red;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            display: none;
            text-align: center;
        }

        .invalid-slot {
            border: 2px solid red;
            padding: 5px;
            border-radius: 5px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .save-btn {
            width: 100%;
            padding: 12px;
            font-size: 16px;
        }

        .add-slot-btn {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php include '../partials/sidebar/sidebar.php'; ?>

    <div class="content">
        <div class="container">
            <h2> <?= $is_edit ? "Editar Laboratorio" : "Crear Laboratorio" ?> </h2>
            <form method="POST" action="<?= $is_edit ? 'update.php?lab_id=' . $lab->getId() : 'create.php' ?>">
                <input type="hidden" name="id" value="<?= $is_edit ? $lab->getId() : '' ?>">
                <div>
                    <label for="name">Nombre del laboratorio</label>
                    <input type="text" id="name" name="name" value="<?= $is_edit ? $lab->getName() : "" ?>" required>
                </div>
                <div>
                    <label for="capacity">Capacidad</label>
                    <input type="number" id="capacity" name="capacity" value="<?= $is_edit ? $lab->getCapacity() : "" ?>" required>
                </div>

                <div id="error-message" class="error-message"></div>

                <label>Días que el laboratorio estará funcionando</label>
                <div style="margin: 20px 0;">
                    <?php
                    $days = ['L' => 'Lunes', 'M' => 'Martes', 'X' => 'Miércoles', 'J' => 'Jueves', 'V' => 'Viernes', 'S' => 'Sábado', 'D' => 'Domingo'];
                    foreach ($days as $key => $day):
                        $is_checked = $is_edit && isset($lab_schedule[$key]) ? 'checked' : '';
                    ?>
                        <div class="checkbox-group">
                            <input class="open_day_checkbox" type="checkbox" name="open_days[]" id='<?= $key ?>' value="<?= $key ?>" <?= $is_checked ?> />
                            <label for="<?= $key ?>"> <?= $day ?> </label>
                        </div>
                        <div class="slots-container" id="slots_<?= $key ?>" style="<?= $is_edit && $is_checked ? 'display: block;' : 'display: none;' ?>">
                            <div class="slots-list">
                                <?php if ($is_edit && isset($lab_schedule[$key])): ?>
                                    <?php foreach ($lab_schedule[$key] as $index => $slot): ?>
                                        <div class="slot" id="<?= $key ?>_slot_<?= $index + 1 ?>">
                                            <span>Horario #<?= $index + 1 ?></span>
                                            <label>
                                                Desde
                                                <input type='time' name='<?= $key ?>_start_time_slot_<?= $index + 1 ?>' value="<?= htmlspecialchars($slot['start_date']) ?>" class="slot-input" oninput="validateSlots('<?= $key ?>')" />
                                                Hasta
                                                <input type='time' name='<?= $key ?>_end_time_slot_<?= $index + 1 ?>' value="<?= htmlspecialchars($slot['end_date']) ?>" class="slot-input" oninput="validateSlots('<?= $key ?>')" />
                                            </label>
                                            <button type="button" class="remove-btn" onclick="removeSlot('<?= $key ?>', this)">Remover</button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="slot" id="<?= $key ?>_slot_1">
                                        <span>Horario #1</span>
                                        <label>
                                            Desde
                                            <input type='time' name='<?= $key ?>_start_time_slot_1' class="slot-input" oninput="validateSlots('<?= $key ?>')" />
                                            Hasta
                                            <input type='time' name='<?= $key ?>_end_time_slot_1' class="slot-input" oninput="validateSlots('<?= $key ?>')" />
                                        </label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="add-slot-btn" onclick="addSlot('<?= $key ?>')">Add New Slot</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="save-btn"> <?= $is_edit ? "Actualizar" : "Crear" ?> </button>
            </form>
        </div>
    </div>

    <script>
        function validateSlots(day) {
            // Grab the main error message container
            const errorMessageElement = document.getElementById("error-message");
            // Clear previous error state
            errorMessageElement.style.display = "none";
            errorMessageElement.innerHTML = "";

            // Grab all the slots for the specified day
            const slotsContainer = document.getElementById(`slots_${day}`);
            const slots = slotsContainer.querySelectorAll(".slot");

            // We'll track the end time of the last valid slot
            let lastEndTime = "";
            let hasError = false;

            // Iterate over each slot
            for (let i = 0; i < slots.length; i++) {
                const timeInputs = slots[i].querySelectorAll(".slot-input");
                const startValue = timeInputs[0].value; // "HH:MM"
                const endValue = timeInputs[1].value; // "HH:MM"

                // Clear any previous error style
                slots[i].classList.remove("invalid-slot");

                // ─────────────────────────────────────────────────────
                // RULE: A slot cannot be completely empty
                //      (both start & end blank).
                // ─────────────────────────────────────────────────────
                if (!startValue && !endValue) {
                    hasError = true;
                    slots[i].classList.add("invalid-slot");
                    errorMessageElement.innerHTML =
                        "Ningún slot puede estar totalmente en blanco (hora de inicio y fin vacías).";
                }

                // If both times are provided, check the other rules:
                if (startValue && endValue) {
                    // RULE: Start time cannot be >= end time
                    if (startValue >= endValue) {
                        hasError = true;
                        slots[i].classList.add("invalid-slot");
                        errorMessageElement.innerHTML =
                            "La hora de inicio no puede ser mayor o igual que la hora de fin.";
                    }

                    // RULE: Each subsequent slot must start strictly after the previous slot’s end time
                    if (lastEndTime && startValue <= lastEndTime) {
                        hasError = true;
                        slots[i].classList.add("invalid-slot");
                        errorMessageElement.innerHTML =
                            "La hora de inicio del siguiente slot debe ser posterior a la hora de fin del slot anterior.";
                    }
                }

                // If no error so far for this slot, update lastEndTime to the current slot's end time
                // (only if endValue is actually filled)
                if (!hasError && endValue) {
                    lastEndTime = endValue;
                }
            }

            // If any error is detected, display the error message container
            if (hasError) {
                errorMessageElement.style.display = "block";
            }
        }

        function addSlot(day) {
            const slotsContainer = document.getElementById(`slots_${day}`).querySelector('.slots-list');
            const allSlots = slotsContainer.querySelectorAll('.slot');

            // ─────────────────────────────────────────────────────────
            //   PREVENT ADDING A NEW SLOT IF THE LAST SLOT IS EMPTY
            // ─────────────────────────────────────────────────────────
            if (allSlots.length > 0) {
                const lastSlot = allSlots[allSlots.length - 1];
                const timeInputs = lastSlot.querySelectorAll('.slot-input');
                const startValue = timeInputs[0].value;
                const endValue = timeInputs[1].value;

                if (!startValue && !endValue) {
                    alert("No puedes agregar un nuevo slot si el anterior está vacío (sin hora de inicio y fin).");
                    return;
                }
            }

            const slotCount = allSlots.length + 1;
            const newSlot = document.createElement('div');
            newSlot.classList.add('slot');
            newSlot.id = `${day}_slot_${slotCount}`;
            newSlot.innerHTML = `
            <span>Horario #${slotCount}</span>
            <label>
                Desde
                <input type='time' name='${day}_start_time_slot_${slotCount}' 
                       class="slot-input" oninput="validateSlots('${day}')" />
                Hasta
                <input type='time' name='${day}_end_time_slot_${slotCount}' 
                       class="slot-input" oninput="validateSlots('${day}')" />
            </label>
            <button type="button" class="remove-btn" onclick="removeSlot('${day}', this)">Remover</button>
        `;

            slotsContainer.appendChild(newSlot);
            renumberSlots(day);
        }

        function removeSlot(day, button) {
            button.closest('.slot').remove();
            renumberSlots(day);
        }

        function renumberSlots(day) {
            const slots = document.getElementById(`slots_${day}`).querySelectorAll('.slot');
            slots.forEach((slot, index) => {
                slot.querySelector('span').textContent = `Horario #${index + 1}`;
                const timeInputs = slot.querySelectorAll('input[type="time"]');

                // Re-assign the name attributes to keep them consistent
                timeInputs[0].name = `${day}_start_time_slot_${index + 1}`;
                timeInputs[1].name = `${day}_end_time_slot_${index + 1}`;
            });
        }

        function addSlot(day) {
            const slotsContainer = document.getElementById(`slots_${day}`).querySelector('.slots-list');
            const slotCount = slotsContainer.getElementsByClassName('slot').length + 1;

            const newSlot = document.createElement('div');
            newSlot.classList.add('slot');
            newSlot.innerHTML = `
                <span>Horario #${slotCount}</span>
                <label>
                    Desde
                    <input type='time' name='${day}_start_time_slot_${slotCount}' class="slot-input" oninput="validateSlots('${day}')" />
                    Hasta
                    <input type='time' name='${day}_end_time_slot_${slotCount}' class="slot-input" oninput="validateSlots('${day}')" />
                </label>
                <button type="button" class="remove-btn" onclick="removeSlot('${day}', this)">Remover</button>
            `;
            slotsContainer.appendChild(newSlot);
            renumberSlots(day);
        }

        function removeSlot(day, button) {
            button.closest('.slot').remove();
            renumberSlots(day);
        }

        function renumberSlots(day) {
            const slots = document.getElementById(`slots_${day}`).querySelectorAll('.slot');
            slots.forEach((slot, index) => {
                slot.querySelector('span').textContent = `Horario #${index + 1}`;
                slot.querySelector('input[type="time"]').name = `${day}_start_time_slot_${index + 1}`;
                slot.querySelectorAll('input[type="time"]')[1].name = `${day}_end_time_slot_${index + 1}`;
            });
        }

        document.querySelectorAll(".open_day_checkbox").forEach(checkbox => {
            checkbox.addEventListener('change', function(e) {
                const slotsContainer = document.getElementById(`slots_${e.target.id}`);
                slotsContainer.style.display = e.target.checked ? 'block' : 'none';

                if (e.target.checked && slotsContainer.querySelector('.slot') === null) {
                    addSlot(e.target.id);
                }
            });
        });
    </script>

</body>

</html>