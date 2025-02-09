<?php

require_once "../middleware.php";
require_once "../utils.php";
require_once "./Lab.php";

checkAuth();

$labs = Lab::getAll('DESC');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Management</title>
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
    </style>
</head>

<body>
    <?php include_once '../partials/sidebar/sidebar.php'; ?>

    <div class="content">
        <h2>Lab Management</h2>
        <div class="card">
            <a href="form.php" class="btn btn-add">Add New Lab</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Capacity</th>
                        <th>Schedule</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($labs as $lab): ?>
                        <tr>
                            <td><?= $lab->getId() ?></td>
                            <td><?= $lab->getName() ?> </td>
                            <td><?= $lab->getCapacity() ?> </td>
                            <td><?= $lab->printPrettySchedule() ?></td>
                            <td class="actions">
                                <a href="form.php?is_edit=true&lab_id=<?= $lab->getId() ?>" class="btn btn-edit">Edit</a>
                                <a href="delete.php?lab_id=<?= $lab->getId() ?>" class="btn btn-delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>