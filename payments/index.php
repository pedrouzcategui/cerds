<?php

require_once "../middleware.php";
require_once "./Payment.php";

checkAuth();

$payments = Payment::getAll('DESC');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
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

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .image-preview {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <?php include_once '../partials/sidebar/sidebar.php'; ?>

    <div class="content">
        <h2>Pagos</h2>
        <div class="card">
            <a href="form.php">
                <button class="btn btn-add">
                    Añadir un nuevo pago
                </button>
            </a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Estudiante</th>
                        <th>Curso</th>
                        <th>Monto</th>
                        <th>Moneda</th>
                        <th>Referencia</th>
                        <th>Imagen</th>
                        <th>Fecha de pago</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td><?= $payment->getId() ?></td>
                            <td><?= $payment->getStudent()->getFullName() ?></td>
                            <td><?= $payment->getCourse()->getName() ?></td>
                            <td><?= $payment->getAmount() ?></td>
                            <td><?= $payment->getCurrency() ?></td>
                            <td><?= $payment->getReference() ?></td>
                            <td>
                                <button onclick="showImageModal('<?= $payment->getImage() ?>')">Ver Imagen</button>
                            </td>
                            <td><?= $payment->getDate() ?></td>
                            <td><?= $payment->getStatus() ?></td>
                            <td class="actions">
                                <a href="form.php?is_edit=true&payment_id=<?= $payment->getId() ?>" class="btn btn-edit">Editar</a>
                                <a href="delete.php?payment_id=<?= $payment->getId() ?>" class="btn btn-delete">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeImageModal()">&times;</span>
            <img id="modalImage" class="image-preview" src="" alt="Payment Image">
        </div>
    </div>

    <script>
        function showImageModal(imageName) {
            var modal = document.getElementById("imageModal");
            var modalImage = document.getElementById("modalImage");
            modalImage.src = "../uploads/" + imageName;
            modal.style.display = "block";
        }

        function closeImageModal() {
            var modal = document.getElementById("imageModal");
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("imageModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>