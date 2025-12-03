<?php
require 'conexion.php';
// Redirige automáticamente al login
header("Location: login.php");
exit;


$sql = "SELECT id, nombres, apellidos, documento FROM estudiantes";
$estudiantes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Notas</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ESTILOS PERSONALIZADOS -->
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
            opacity: 0; /* Para animación */
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
        <h2 class="text-center mb-5">📘 Sistema de Gestión de Notas</h2>

        <div class="row justify-content-center">

            <!-- Estudiantes -->
            <div class="col-md-4 mb-3">
                <a href="estudiantes.php" style="text-decoration:none">
                    <div class="card card-menu shadow p-4 text-center bg-primary text-white">
                        <h4>👩‍🎓 Gestión de Estudiantes</h4>
                        <p>Registrar, editar y consultar estudiantes</p>
                    </div>
                </a>
            </div>

            <!-- Asignaturas -->
            <div class="col-md-4 mb-3">
                <a href="asignatura.php" style="text-decoration:none">
                    <div class="card card-menu shadow p-4 text-center bg-warning text-dark">
                        <h4>📚 Asignaturas</h4>
                        <p>Agregar y administrar asignaturas</p>
                    </div>
                </a>
            </div>

            <!-- Notas -->
            <div class="col-md-4 mb-3">
                <a href="notas.php" style="text-decoration:none">
                    <div class="card card-menu shadow p-4 text-center bg-success text-white">
                        <h4>📝 Notas</h4>
                        <p>Registrar y revisar calificaciones</p>
                    </div>
                </a>
            </div>

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
                }, 200 * index); // efecto secuencial
            });
        });
    </script>

</body>
</html>
