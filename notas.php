<?php
require 'conexion.php';

$sql = "
SELECT 
    n.id,
    e.nombres,
    e.apellidos,
    a.nombre AS asignatura,
    n.nota,
    n.fecha_registro
FROM notas n
INNER JOIN estudiantes e ON n.estudiantes_id = e.id
INNER JOIN asignaturas a ON n.asignatura_id = a.id
";

$query = $pdo->query($sql);
$notas = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Listado de Notas</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            font-family: 'Poppins', sans-serif;
        }

        h2 {
            font-weight: 700;
            margin-bottom: 30px;
            color: #333;
        }

        .table-hover tbody tr:hover {
            background-color: #e9f3ff;
        }

        .btn-space {
            margin-right: 10px;
        }

        .card-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class='p-4'>

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Notas Registradas</h2>
        <a href="registrar_nota.php" class="btn btn-success">Registrar Nueva Nota</a>
    </div>

    <div class="card-container">
        <div class="table-responsive">
            <table class='table table-striped table-hover align-middle'>
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Estudiante</th>
                        <th>Asignatura</th>
                        <th>Nota</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($notas)): ?>
                        <?php foreach ($notas as $n): ?>
                            <tr>
                                <td><?= htmlspecialchars($n['id']) ?></td>
                                <td><?= htmlspecialchars($n['nombres'] . ' ' . $n['apellidos']) ?></td>
                                <td><?= htmlspecialchars($n['asignatura'] ?? 'Sin asignatura') ?></td>
                                <td><?= htmlspecialchars($n['nota']) ?></td>
                                <td><?= htmlspecialchars($n['fecha_registro']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay notas registradas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href='index.php' class='btn btn-secondary mt-3'>⬅ Volver</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
