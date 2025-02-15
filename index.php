<?php
require_once "./utils.php";
require_once "./middleware.php";
require_once "./courses/Course.php";
require_once "./payments/Payment.php";
require_once "./students/Student.php";
require_once "./instructors/Instructor.php";
require_once "./labs/Lab.php";

checkAuth();

// Fetch data
$latestCourses = Course::getAll('DESC');
$latestPayments = Payment::getAll('DESC');
$totalStudents = count(Student::getAll());
$totalInstructors = count(Instructor::getAll());
$totalLabs = count(Lab::getAll());

// Calculate total payments in each currency
$totalPaymentsVES = Payment::getTotalPayments('VES');
$totalPaymentsUSD = Payment::getTotalPayments('USD');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CERDS Dashboard</title>
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

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
            /* Added margin-bottom */
        }

        .metric {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .metric h3 {
            margin-top: 0;
            font-size: 1.2em;
        }

        .metric p {
            font-size: 2em;
            margin: 0;
        }
    </style>
</head>

<body>
    <?php include_once 'partials/sidebar/sidebar.php'; ?>

    <div class="content">
        <h1>Métricas</h1>
        <div class="metrics-grid">
            <div class="metric">
                <h3>Total de Estudiantes</h3>
                <p><?= $totalStudents ?></p>
            </div>
            <div class="metric">
                <h3>Total de Instructores</h3>
                <p><?= $totalInstructors ?></p>
            </div>
            <div class="metric">
                <h3>Total de Laboratorios</h3>
                <p><?= $totalLabs ?></p>
            </div>
            <div class="metric">
                <h3>Total de pagos en Bolívares</h3>
                <p><?= number_format($totalPaymentsVES, 2) ?> VES</p>
            </div>
            <div class="metric">
                <h3>Total de pagos en Dólares</h3>
                <p><?= number_format($totalPaymentsUSD, 2) ?> USD</p>
            </div>
        </div>

        <div class="card">
            <h3>Últimos cursos agregados</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del curso</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Finalización</th>
                        <th>Estado del curso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($latestCourses as $course): ?>
                        <tr>
                            <td><?= $course->getId() ?></td>
                            <td><?= $course->getName() ?></td>
                            <td><?= $course->getStartDate() ?></td>
                            <td><?= $course->getEndDate() ?></td>
                            <td><?= $course->getStatus() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Ultimos pagos registrados: </h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student ID</th>
                        <th>Course ID</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($latestPayments as $payment): ?>
                        <tr>
                            <td><?= $payment->getId() ?></td>
                            <td><?= $payment->getStudentId() ?></td>
                            <td><?= $payment->getCourseId() ?></td>
                            <td><?= $payment->getAmount() ?></td>
                            <td><?= $payment->getDate() ?></td>
                            <td><?= $payment->getStatus() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>