<?php
require 'conexion.php';

// Obtener asignaturas
$asig = $pdo->query("SELECT * FROM asignaturas")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Asignaturas</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f0f2f5;
    font-family: 'Poppins', sans-serif;
}

h2 { font-weight: 700; color: #333; }

.card-table { box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 12px; }

.side-box {
    position: fixed;
    right: 20px;
    top: 80px;
    width: 300px;
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    animation: slideBox 0.5s ease;
}

@keyframes slideBox { from { transform: translateX(100px); opacity:0; } to { transform: translateX(0); opacity:1; } }

.table-hover tbody tr:hover { background-color: #e9f3ff; }

.btn-space { margin-right: 5px; }

.fade-in { opacity: 0; transition: opacity 0.6s; }
.fade-in.show { opacity: 1; }
</style>
</head>
<body class="p-4">

<div class="container" style="margin-right: 340px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Gestión de Asignaturas</h2>
    </div>

    <div class="card card-table p-3 fade-in">
        <table class="table table-striped table-hover align-middle" id="tabla-asignaturas">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Asignatura</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asig as $a): ?>
                <tr id="fila-<?= $a['id'] ?>">
                    <td><?= $a['id'] ?></td>
                    <td><?= $a['nombre'] ?></td>
                    <td>
                       
                        <button class="btn btn-danger btn-sm" onclick="eliminarAsignatura(<?= $a['id'] ?>)">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="index.php" class="btn btn-secondary mt-3">⬅ Volver</a>
</div>

<!-- CAJA FIJA PARA AGREGAR ASIGNATURA -->
<div class="side-box">
    <h5 class="fw-bold mb-3"> Nueva Asignatura</h5>

    <form id="form-asignatura">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control mb-3" required>
        <button type="submit" class="btn btn-primary w-100">Guardar</button>
    </form>

    <div id="mensaje" class="mt-2"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const tableCard = document.querySelector(".fade-in");
    setTimeout(() => tableCard.classList.add("show"), 200);

    const form = document.getElementById('form-asignatura');
    const tabla = document.getElementById('tabla-asignaturas').querySelector('tbody');
    const mensaje = document.getElementById('mensaje');

    form.addEventListener('submit', function(e){
        e.preventDefault();
        const nombre = document.getElementById('nombre').value;

        fetch('guardar_asignatura_ajax.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'nombre=' + encodeURIComponent(nombre)
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                // Agregar nueva fila a la tabla
                const nuevaFila = document.createElement('tr');
                nuevaFila.id = 'fila-' + data.id;
                nuevaFila.innerHTML = `
                    <td>${data.id}</td>
                    <td>${data.nombre}</td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-space">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarAsignatura(${data.id})">Eliminar</button>
                    </td>
                `;
                tabla.appendChild(nuevaFila);

                mensaje.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                     Asignatura "${data.nombre}" guardada correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`;
                form.reset();

                // Desaparece el mensaje después de 3 segundos
                setTimeout(() => {
                    const alert = bootstrap.Alert.getOrCreateInstance(mensaje.querySelector('.alert'));
                    alert.close();
                }, 3000);

            } else {
                mensaje.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
            }
        })
        .catch(err => {
            mensaje.innerHTML = `<div class="alert alert-danger">Error al guardar</div>`;
            console.error(err);
        });
    });
});

// Función eliminar asignatura
function eliminarAsignatura(id){
    if(!confirm('❗ ¿Seguro que deseas eliminar esta asignatura?')) return;

    fetch('eliminar_asignatura.php?id=' + id)
    .then(()=> {
        const fila = document.getElementById('fila-' + id);
        fila.remove();
    });
}
</script>
</body>
</html>
