<?php
require 'conexion.php';

// Obtener estudiantes
$estudiantes = $pdo->query("SELECT id, nombres, apellidos FROM estudiantes")->fetchAll(PDO::FETCH_ASSOC);

// Obtener asignaturas
$asignaturas = $pdo->query("SELECT id, nombre FROM asignaturas")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f6fa; font-family: 'Poppins', sans-serif; }
        h2 { font-weight: 700; margin-bottom: 30px; }
        .form-container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
    </style>
</head>
<body class="p-4">

<div class="form-container">
    <h2 class="text-center mb-4">📝 Registrar Nota</h2>

    <form id="form-nota">
        <label>Estudiante:</label>
        <select name="estudiante_id" id="estudiante_id" class="form-control" required>
            <option value="">Seleccione</option>
            <?php foreach ($estudiantes as $e): ?>
                <option value="<?= $e['id'] ?>"><?= $e['nombres'] . " " . $e['apellidos'] ?></option>
            <?php endforeach; ?>
        </select>

        <label class="mt-3">Asignatura:</label>
        <select name="asignatura_id" id="asignatura_id" class="form-control" required>
            <option value="">Seleccione</option>
            <?php foreach ($asignaturas as $a): ?>
                <option value="<?= $a['id'] ?>"><?= $a['nombre'] ?></option>
            <?php endforeach; ?>
        </select>

        <label class="mt-3">Nota:</label>
        <input type="number" step="0.01" name="nota" id="nota" class="form-control" required>

        <button type="submit" class="btn btn-primary mt-4 w-100">Guardar Nota</button>
    </form>

    <div id="mensaje" class="mt-3"></div>
    <a href="notas.php" class="btn btn-secondary mt-3 w-100">⬅ Volver</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const form = document.getElementById('form-nota');
const mensaje = document.getElementById('mensaje');

form.addEventListener('submit', function(e){
    e.preventDefault();

    const estudiante_id = document.getElementById('estudiante_id').value;
    const asignatura_id = document.getElementById('asignatura_id').value;
    const nota = document.getElementById('nota').value;

    fetch('guardar_nota.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `estudiante_id=${encodeURIComponent(estudiante_id)}&asignatura_id=${encodeURIComponent(asignatura_id)}&nota=${encodeURIComponent(nota)}`
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            mensaje.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                     Nota registrada correctamente.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`;
            form.reset();
        } else {
            mensaje.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
        }
    })
    .catch(err => {
        mensaje.innerHTML = `<div class="alert alert-danger">Error al guardar la nota</div>`;
        console.error(err);
    });
});
</script>
</body>
</html>
