<?php
require 'conexion.php';

// Consultar estudiantes
$sql = "SELECT * FROM estudiantes";
$estudiantes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Listado de Estudiantes</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEstudiante">
            + Agregar Estudiante
        </button>
    </div>

    <table class="table table-striped table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Documento</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($estudiantes as $e): ?>
            <tr>
                <td><?= $e['id'] ?></td>
                <td><?= $e['nombres'] ?></td>
                <td><?= $e['apellidos'] ?></td>
                <td><?= $e['documento'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Volver</a>

</div>

<!-- MODAL PARA REGISTRAR ESTUDIANTE -->
<div class="modal fade" id="modalEstudiante" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">Registrar Estudiante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="guardar_estudiante.php" method="POST" id="formEstudiante">
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nombres</label>
                        <input type="text" class="form-control" name="nombres" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Documento</label>
                        <input type="text" class="form-control" name="documento" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- VALIDACIÓN JS -->
<script>
document.getElementById("formEstudiante").addEventListener("submit", function(e) {
    let doc = document.querySelector("input[name='documento']").value;

    if (doc.length < 5) {
        e.preventDefault();
        alert("El documento debe tener mínimo 5 dígitos");
    }
});
</script>

</body>
</html>

