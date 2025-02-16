<?php

require_once "../middleware.php";
require_once "./Course.php";

checkAuth();

$courses = Course::getAll('DESC');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card h3 {
            margin-top: 0;
        }

        .card table {
            width: 100%;
            border-collapse: collapse;
        }

        .card table th,
        .card table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .card table th {
            background-color: #007BFF;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .btn-add {
            background-color: #28a745;
        }

        .btn-edit {
            background-color: #ffc107;
        }

        .btn-delete {
            background-color: #dc3545;
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

        .actions {
            display: flex;
            gap: 10px;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <?php include_once '../partials/sidebar/sidebar.php'; ?>

    <div class="content">
        <h2>Cursos</h2>
        <div class="card">
            <a href="form.php">
                <button class="btn btn-add">
                    Añadir nuevo curso
                </button>
            </a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Instructor</th>
                        <th>Laboratorio</th>
                        <th>Cursantes</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Finalización</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td><?= $course->getId() ?></td>
                            <td><?= $course->getName() ?></td>
                            <td><?= $course->instructor()->getFullName() ?> </td>
                            <td><?= $course->lab()->getName() ?> </td>
                            <td><?= $course->getCurrentEnrollments() ?></td>
                            <td><?= $course->getStartDate() ?></td>
                            <td><?= $course->getEndDate() ?></td>
                            <td><?= $course->getStatus() ?></td>
                            <td class="actions">
                                <a href="form.php?is_edit=true&course_id=<?= $course->getId() ?>" class="btn btn-edit">Editar</a>
                                <a href="delete.php?course_id=<?= $course->getId() ?>" class="btn btn-delete">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>