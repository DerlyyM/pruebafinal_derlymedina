<?php
require 'conexion.php';

// envio del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $documento = $_POST['documento'];

    $sql = "INSERT INTO estudiantes (nombres, apellidos, documento)
            VALUES (:nombres, :apellidos, :documento)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombres' => $nombres,
        ':apellidos' => $apellidos,
        ':documento' => $documento
    ]);

    header("Location: estudiantes.php?ok=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Estudiante</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="p-4">

<h2>Registrar Nuevo Estudiante</h2>

<form method="POST" class="mt-4">

    <div class="mb-3">
        <label class="form-label">Nombres</label>
        <input type="text" name="nombres" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Apellidos</label>
        <input type="text" name="apellidos" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Documento</label>
        <input type="text" name="documento" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="estudiantes.php" class="btn btn-secondary">Cancelar</a>

</form>

</body>
</html>
