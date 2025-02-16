<?php

require_once "../middleware.php";
require_once "./Student.php";

checkAuth();

// Check if Edit
$is_edit = isset($_GET['is_edit']);
$student_id = isset($_GET['student_id']);
$student = null;
if ($is_edit && $student_id) {
    $student = Student::findById($_GET['student_id']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            background-color: #28a745;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include '../partials/sidebar/sidebar.php'; ?>

    <div class="content">
        <div class="container">
            <a href="./">Volver a la tabla de estudiantes</a>
            <h2> <?= $is_edit ? "Editar" : "Crear" ?> Perfil de Estudiante</h2>
            <form action="<?= $is_edit ? './update.php?student_id=' . $student->getId() : './create.php' ?>" method="POST">
                <div class="form-group">
                    <label for="first_name">Nombre</label>
                    <input type="text" id="first_name" name="first_name" value="<?= $student != null ? $student->getFirstName() : "" ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Apellido</label>
                    <input type="text" id="last_name" name="last_name" value="<?= $student != null ? $student->getLastName() : "" ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= $student != null ? $student->getEmail() : "" ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input type="text" id="phone" name="phone" value="<?= $student != null ? $student->getPhone() : "" ?>" required>
                </div>
                <button type="submit" class="btn"><?= $is_edit ? "Actualizar" : "Crear" ?></button>
            </form>
        </div>
    </div>
</body>

</html>