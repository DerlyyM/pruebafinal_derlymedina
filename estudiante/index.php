<?php
session_start();
require '../conexion.php';

// PROTEGER VISTA
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// 1. Obtener datos del estudiante
$stmt = $pdo->prepare("SELECT nombre, documento, email FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

// 2. Obtener notas con asignatura
$sql = "SELECT a.nombre AS asignatura, n.nota 
        FROM notas n 
        INNER JOIN asignaturas a ON n.asignatura_id = a.id
        WHERE n.estudiantes_id = ?";
$stmt2 = $pdo->prepare($sql);
$stmt2->execute([$usuario_id]);

$notas = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// 3. Calcular promedio
$promedio = 0;
if (count($notas) > 0) {
    $suma = 0;
    foreach ($notas as $n) { $suma += $n['nota']; }
    $promedio = $suma / count($notas);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Estudiante</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            font-family: 'Poppins', sans-serif;
        }

        h2, h4 {
            font-weight: 700;
            color: #333;
        }

        .card-info {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        .promedio-box {
            background: #4CAF50;
            color: white;
            border-radius: 12px;
            padding: 20px;
            font-size: 1.3rem;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body class="p-4">

<div class="container">

    <h2 class="text-center mb-4">Panel del Estudiante</h2>

    <!-- Información del estudiante -->
    <div class="card-info mb-4">
        <h4>Bienvenido, <?php echo htmlspecialchars($estudiante['nombre']); ?></h4>
        <p><strong>Documento:</strong> <?php echo $estudiante['documento']; ?></p>
        <p><strong>Email:</strong> <?php echo $estudiante['email']; ?></p>
    </div>

    <!-- Promedio -->
    <div class="promedio-box mb-4">
        Promedio general: <?php echo number_format($promedio, 2); ?>
    </div>

    <!-- Notas -->
    <h4 class="mb-3">Mis Notas</h4>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Asignatura</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notas as $n): ?>
            <tr>
                <td><?php echo $n['asignatura']; ?></td>
                <td><?php echo $n['nota']; ?></td>
            </tr>
            <?php endforeach; ?>

            <?php if (count($notas) === 0): ?>
            <tr>
                <td colspan="2" class="text-center">Aún no tienes notas registradas.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>
