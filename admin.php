<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== "admin") {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ESTILOS -->
    <style>
        body {
            background: #f5f6fa;
            font-family: 'Poppins', sans-serif;
        }

        h2 {
            font-weight: 700;
            color: #333;
        }

        .card-menu {
            transition: transform 0.3s, box-shadow 0.3s, opacity 0.6s;
            cursor: pointer;
            border-radius: 12px;
            opacity: 0; /* animación */
        }

        .card-menu:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .card-menu p {
            font-size: 0.95rem;
        }

        .row {
            margin-top: 30px;
        }
    </style>
</head>
<body class="p-4">

<div class="container">
    <h2 class="text-center mb-4">Bienvenido, <?= $_SESSION['user_name'] ?> </h2>

    <div class="row justify-content-center">

        <!-- Estudiantes -->
        <div class="col-md-4 mb-3">
            <a href="estudiantes.php" style="text-decoration:none">
                <div class="card card-menu shadow p-4 text-center bg-primary text-white">
                    <h4> Gestión de Estudiantes</h4>
                    <p>Registrar, editar y consultar estudiantes</p>
                </div>
            </a>
        </div>

        <!-- Asignaturas -->
        <div class="col-md-4 mb-3">
            <a href="asignatura.php" style="text-decoration:none">
                <div class="card card-menu shadow p-4 text-center bg-warning text-dark">
                    <h4> Asignaturas</h4>
                    <p>Agregar y administrar asignaturas</p>
                </div>
            </a>
        </div>

        <!-- Notas -->
        <div class="col-md-4 mb-3">
            <a href="notas.php" style="text-decoration:none">
                <div class="card card-menu shadow p-4 text-center bg-success text-white">
                    <h4> Notas</h4>
                    <p>Registrar y revisar calificaciones</p>
                </div>
            </a>
        </div>

    </div>

    <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</div>

<!-- JAVASCRIPT BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- SCRIPT EXTRA PARA ANIMACIÓN -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const cards = document.querySelectorAll(".card-menu");
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = 1;
            }, 200 * index); // efecto secuncia
        });
    });
</script>

</body>
</html>
