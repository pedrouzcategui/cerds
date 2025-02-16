<?php
require_once "../middleware.php";
require_once "./PTO.php";
require_once "../instructors/Instructor.php";
require_once "../courses/Course.php";

checkAuth();

$is_edit = isset($_GET['is_edit']);
$pto_id = isset($_GET['pto_id']);
$pto = null;
if ($is_edit && $pto_id) {
    $pto = PTO::findById($pto_id);
}

// Fetch available instructors and courses from the database
$instructors = Instructor::getAll();
$courses = Course::getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_edit ? "Editar solicitud de tiempo libre" : "Creación de solicitud de tiempo libre" ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 40px;
        }

        h2 {
            color: #333;
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
        input[type="date"],
        select {
            width: calc(100%);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
            margin-top: 20px;
        }

        button:hover {
            background-color: #218838;
        }
    </style>

</head>

<body>
    <?php include '../partials/sidebar/sidebar.php'; ?>

    <div class="content">
        <h2><?= $is_edit ? "Editar Solicitud de Tiempo Libre" : "Crear Solicitud de Tiempo Libre" ?></h2>
        <form method="POST" action="<?= $is_edit ? "update.php?pto_id=" . $pto->getId() : "create.php" ?>">
            <div>
                <label for="instructor_id">Instructor</label>
                <select id="instructor_id" name="instructor_id" required>
                    <option disabled>-- Selecciona un instructor --</option>
                    <?php foreach ($instructors as $instructor): ?>
                        <option value="<?= $instructor->getId() ?>" <?= $pto !== null && $pto->getInstructorId() == $instructor->getId() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($instructor->getFullName()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="course_id">Curso</label>
                <select id="course_id" name="course_id" required>
                    <option disabled>-- Selecciona el curso --</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course->getId() ?>" <?= $pto !== null && $pto->getCourseId() == $course->getId() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($course->getName()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="start_date">Fecha de Inicio</label>
                <input type="date" id="start_date" name="start_date" value="<?= $pto !== null ? $pto->getStartDate() : "" ?>" required>
            </div>
            <div>
                <label for="end_date">Fecha de Finalización</label>
                <input type="date" id="end_date" name="end_date" value="<?= $pto !== null ? $pto->getEndDate() : "" ?>" required>
            </div>
            <div>
                <label for="reason">Razón por la cual se está solicitando el tiempo libre</label>
                <textarea id="reason" name="reason" rows="4" required><?= $pto !== null ? htmlspecialchars($pto->getReason()) : "" ?></textarea>
            </div>
            <button type="submit"> <?= $is_edit ? "Editar" : "Crear" ?> </button>
        </form>
    </div>
</body>

</html>