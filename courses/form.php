<?php
require_once "../middleware.php";
require_once "../labs/Lab.php";
require_once "../instructors/Instructor.php";
require_once "../courses/Course.php";

checkAuth();

$is_edit = isset($_GET['is_edit']);
$course_id = isset($_GET['course_id']);
$course = null;
if ($is_edit && $course_id) {
    $course = Course::findById($_GET['course_id']);
}

// Fetch available instructors and labs from the database
$instructors = Instructor::getAll();
$labs = Lab::getAll();

// Define course statuses
$statuses = [
    'pending' => 'Pendiente',
    'in progress' => 'En Progreso',
    'cancelled' => 'Cancelado',
    'completed' => 'Completado'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>
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
        textarea,
        select {
            width: calc(100% - 24px);
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
        <h2><?= $is_edit ? "Edit Course" : "Create Course" ?></h2>
        <form method="POST" action="<?= $is_edit ? "update.php?course_id=" . $course->getId() : "create.php" ?>">
            <div>
                <label for="name">Course Name</label>
                <input type="text" id="name" name="name" value="<?= $course !== null ? $course->getName() : "" ?>" required>
            </div>
            <div>
                <label for="description">Course Description</label>
                <textarea type="text" id="description" name="description" required><?= $course !== null ? htmlspecialchars($course->getDescription()) : "" ?></textarea>
            </div>
            <div>
                <label for="instructor">Course Instructor</label>
                <select id="instructor" name="instructor_id" required>
                    <option disabled>-- Select Instructor --</option>
                    <?php foreach ($instructors as $instructor): ?>
                        <option value="<?= $instructor->getId() ?>" selected="<?= $course !== null && $course->getInstructorId() == $instructor->getId() ?>">
                            <?= htmlspecialchars($instructor->getFullName()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="lab">Where the course will be taught</label>
                <select id="lab" name="lab_id" required>
                    <option disabled>-- Select Lab --</option>
                    <?php foreach ($labs as $lab): ?>
                        <option value="<?= $lab->getId() ?>" selected="<?= $course !== null && $course->getLabId() == $lab->getId() ?>">
                            <?= htmlspecialchars($lab->getName()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" required value="<?= $course !== null ? $course->getStartDate() : "" ?>">
            </div>
            <div>
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" required value="<?= $course !== null ? $course->getEndDate() : "" ?>">
            </div>
            <div>
                <label for="status">Course Status</label>
                <select id="status" name="status" required>
                    <option value="" disabled>-- Select Status --</option>
                    <?php foreach ($statuses as $key => $value): ?>
                        <option value="<?= $key ?>"><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit"> <?= $is_edit ? "Actualizar" : "Agregar" ?> </button>
        </form>
    </div>
</body>

</html>