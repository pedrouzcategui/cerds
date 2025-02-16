<?php
require_once "../students/Student.php";
require_once "../courses/Course.php";
require_once "./Payment.php";

$is_edit = isset($_GET['is_edit']);
$payment_id = isset($_GET['payment_id']);
$payment = null;
if ($is_edit && $payment_id) {
    $payment = Payment::findById($_GET['payment_id']);
}

// Fetch available students and courses from the database
$students = Student::getAll();
$courses = Course::getAll();

// Define payment statuses
$statuses = [
    'pending' => 'Pending',
    'completed' => 'Completed',
    'failed' => 'Failed'
];

// Define currencies
$currencies = [
    'VES' => 'VES',
    'USD' => 'USD'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_edit ? "Editar Pago" : "Crear Pago" ?></title>
    <style>
        * {
            box-sizing: border-box;
        }

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
        input[type="date"],
        textarea,
        select {
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

        .image-preview {
            margin-top: 10px;
        }

        .image-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php include '../partials/sidebar/sidebar.php'; ?>

    <div class="content">
        <div class="container">
            <h2><?= $is_edit ? "Editar Pago" : "Crear Pago" ?></h2>
            <form method="POST" action="<?= $is_edit ? "update.php?payment_id=" . $payment->getId() : "create.php" ?>" enctype="multipart/form-data">
                <div>
                    <label for="student_id">Estudiante</label>
                    <select id="student_id" name="student_id" required>
                        <option disabled>-- Selecciona al Estudiante --</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student->getId() ?>" <?= $payment !== null && $payment->getStudentId() == $student->getId() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($student->getFirstName() . ' ' . $student->getLastName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="course_id">Curso</label>
                    <select id="course_id" name="course_id" required>
                        <option disabled>-- Selecciona el curso --</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= $course->getId() ?>" <?= $payment !== null && $payment->getCourseId() == $course->getId() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($course->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="amount">Monto</label>
                    <input type="number" id="amount" name="amount" value="<?= $payment !== null ? $payment->getAmount() : "" ?>" required>
                </div>
                <div>
                    <label for="currency">Moneda</label>
                    <select id="currency" name="currency" required>
                        <option disabled>-- Selecciona la Moneda --</option>
                        <?php foreach ($currencies as $currency): ?>
                            <option value="<?= $currency ?>" <?= $payment !== null && $payment->getCurrency() == $currency ? 'selected' : '' ?>>
                                <?= $currency ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="reference">Referencia (opcional)</label>
                    <input type="text" id="reference" name="reference" value="<?= $payment !== null ? $payment->getReference() : "" ?>">
                </div>
                <div>
                    <label for="image">Imagen (opcional)</label>
                    <input type="file" id="image" name="image" <?= $payment !== null ? '' : 'required' ?>>
                    <?php if ($is_edit && $payment !== null && $payment->getImage()): ?>
                        <div class="image-preview" id="image-preview">
                            <img src="../uploads/<?= htmlspecialchars($payment->getImage()) ?>" alt="Current Image">
                        </div>
                    <?php else: ?>
                        <div class="image-preview" id="image-preview" style="display: none;">
                            <img src="#" alt="Image Preview">
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="date">Fecha del Pago</label>
                    <input type="date" id="date" name="date" value="<?= $payment !== null ? $payment->getDate() : "" ?>" required>
                </div>
                <div>
                    <label for="status">Estatus</label>
                    <select id="status" name="status" required>
                        <option value="" disabled>-- Select Status --</option>
                        <?php foreach ($statuses as $key => $value): ?>
                            <option value="<?= $key ?>" <?= $payment !== null && $payment->getStatus() == $key ? 'selected' : '' ?>>
                                <?= $value ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit"> <?= $is_edit ? "Actualizar" : "Crear" ?> </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('image-preview');
                const img = preview.querySelector('img');
                img.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
    </script>
</body>

</html>