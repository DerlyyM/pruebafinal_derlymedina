<?php
require 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $rol = $_POST['rol'];

    // ---------------------- ESTUDIANTE ----------------------
   if ($rol == "estudiante") {

    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        "INSERT INTO usuarios (documento, nombre, email, password, rol)
         VALUES (?, ?,  'estudiante')"
    );
    
    $stmt->execute([$documento, $nombre, $password]);

    header("Location: login.php");
    exit;
}


    // ---------------------- ADMINISTRADOR ----------------------
    // ADMINISTRADOR
if ($rol == "admin") {

    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // 1. Verificar si el email ya existe
    $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $error = "El correo ya está registrado.";
    } else {

        // 2. Insertar nuevo usuario admin
        $stmt = $pdo->prepare("
            INSERT INTO usuarios (email, nombre, password, rol)
            VALUES (?, ?, ?, 'admin')
        ");
        $stmt->execute([$email, $nombre, $password]);

        header("Location: login.php");
        exit;
     }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container" style="max-width: 400px;">
    <h2 class="mb-4 text-center">Registro de Usuario</h2>

    <label class="mb-2 fw-bold">Registrarse como:</label>
    <select id="rol" class="form-select mb-3">
        <option value="estudiante">Estudiante</option>
        <option value="admin">Administrador</option>
    </select>

    <!-- FORMULARIO ESTUDIANTE -->
    <form id="formEstudiante" method="POST" class="border p-3 rounded bg-light" style="display:block;">
    <input type="hidden" name="rol" value="estudiante">

    <label>Documento del estudiante</label>
    <input type="text" name="documento" class="form-control mb-3" required>

    <label>Nombre</label>
    <input type="text" name="nombre" class="form-control mb-3" required>

    <label>Email</label>
    <input type="email" name="email" class="form-control mb-3" required>

    <label>Contraseña</label>
    <input type="password" name="password" class="form-control mb-3" required>

    <button class="btn btn-primary w-100">Registrarse</button>
    </form>

    <!-- FORMULARIO ADMIN -->
    <form id="formAdmin" method="POST" class="border p-3 rounded bg-light" style="display:none;">
        <input type="hidden" name="rol" value="admin">

        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control mb-3" required>

        <label>Email</label>
        <input type="email" name="email" class="form-control mb-3" required>

        <label>Contraseña</label>
        <input type="password" name="password" class="form-control mb-3" required>

        <button class="btn btn-primary w-100">Registrarse</button>
    </form>

    <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
</div>

<script>
document.getElementById("rol").addEventListener("change", function(){
    let rol = this.value;
    document.getElementById("formEstudiante").style.display = rol === "estudiante" ? "block" : "none";
    document.getElementById("formAdmin").style.display = rol === "admin" ? "block" : "none";
});
</script>

</body>
</html>
