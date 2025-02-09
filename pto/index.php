<?php

require_once "../middleware.php";
require_once "./PTO.php";
require_once "../instructors/Instructor.php";
require_once "../courses/Course.php";

checkAuth();

$ptos = PTO::getAll('DESC');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTO Requests</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <?php include '../partials/sidebar/sidebar.php'; ?>

    <div class="content">
        <h2>PTO Requests</h2>
        <div class="card">
            <a href="form.php" class="btn btn-add">Submit PTO Request</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Instructor</th>
                        <th>Course</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ptos as $pto): ?>
                        <?php $instructor = Instructor::findById($pto->getInstructorId()); ?>
                        <?php $course = Course::findById($pto->getCourseId()); ?>
                        <tr>
                            <td><?= $pto->getId() ?></td>
                            <td><?= $instructor->getFullName() ?></td>
                            <td><?= $course->getName() ?></td>
                            <td><?= $pto->getStartDate() ?></td>
                            <td><?= $pto->getEndDate() ?></td>
                            <td><?= $pto->getReason() ?></td>
                            <td><?= $pto->getStatus() ?></td>
                            <td class="actions">
                                <a href="form.php?is_edit=true&pto_id=<?= $pto->getId() ?>" class="btn btn-edit">Edit</a>
                                <a href="delete.php?pto_id=<?= $pto->getId() ?>" class="btn btn-delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>