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
        background-color: #007bff;
        color: white;
    }
</style>

<div class="sidebar">
    <h2 style="text-align: center;">CERDS</h2>
    <a href="/sistema-cursos/index.php"><i class="fas fa-tachometer-alt"></i> Panel de Administración</a>
    <a href="/sistema-cursos/courses/index.php"><i class="fas fa-book"></i> Cursos</a>
    <a href="/sistema-cursos/payments/index.php"><i class="fas fa-money-check-alt"></i> Pagos</a>
    <a href="/sistema-cursos/students/index.php"><i class="fas fa-user-graduate"></i> Estudiantes </a>
    <a href="/sistema-cursos/instructors/index.php"><i class="fas fa-chalkboard-teacher"></i> Instructores </a>
    <a href="/sistema-cursos/labs/index.php"><i class="fas fa-flask"></i> Laboratorios </a>
    <a href="/sistema-cursos/users/index.php"><i class="fas fa-users"></i> Usuarios </a>
    <a href="/sistema-cursos/pto/index.php"><i class="fas fa-calendar-alt"></i> Solicitudes </a>
    <a href="/sistema-cursos/logs.php">Registro de sistema</a>
    <a href="/sistema-cursos/logout.php">Logout</a>
</div>