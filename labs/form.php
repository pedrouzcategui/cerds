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
    <title>Labs Management</title>
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
            <h2>Labs Management</h2>
            <form method="POST" action="<?= $is_edit ? 'update.php?lab_id=' . $lab->getId() : 'create.php' ?>">
                <input type="hidden" name="id" value="<?= $is_edit ? $lab->getId() : '' ?>">
                <div>
                    <label for="name">Lab Name</label>
                    <input type="text" id="name" name="name" value="<?= $is_edit ? $lab->getName() : "" ?>" required>
                </div>
                <div>
                    <label for="capacity">Capacity</label>
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
                                            <span>Slot #<?= $index + 1 ?></span>
                                            <label>
                                                From
                                                <input type='time' name='<?= $key ?>_start_time_slot_<?= $index + 1 ?>' value="<?= htmlspecialchars($slot['start_date']) ?>" class="slot-input" oninput="validateSlots('<?= $key ?>')" />
                                                To
                                                <input type='time' name='<?= $key ?>_end_time_slot_<?= $index + 1 ?>' value="<?= htmlspecialchars($slot['end_date']) ?>" class="slot-input" oninput="validateSlots('<?= $key ?>')" />
                                            </label>
                                            <button type="button" class="remove-btn" onclick="removeSlot('<?= $key ?>', this)">Remove</button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="slot" id="<?= $key ?>_slot_1">
                                        <span>Slot #1</span>
                                        <label>
                                            From
                                            <input type='time' name='<?= $key ?>_start_time_slot_1' class="slot-input" oninput="validateSlots('<?= $key ?>')" />
                                            To
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
        function addSlot(day) {
            const slotsContainer = document.getElementById(`slots_${day}`).querySelector('.slots-list');
            const slotCount = slotsContainer.getElementsByClassName('slot').length + 1;

            const newSlot = document.createElement('div');
            newSlot.classList.add('slot');
            newSlot.innerHTML = `
                <span>Slot #${slotCount}</span>
                <label>
                    From
                    <input type='time' name='${day}_start_time_slot_${slotCount}' class="slot-input" oninput="validateSlots('${day}')" />
                    To
                    <input type='time' name='${day}_end_time_slot_${slotCount}' class="slot-input" oninput="validateSlots('${day}')" />
                </label>
                <button type="button" class="remove-btn" onclick="removeSlot('${day}', this)">Remove</button>
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
                slot.querySelector('span').textContent = `Slot #${index + 1}`;
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