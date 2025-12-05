<?php
require 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $rol = $_POST['rol'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $documento = trim($_POST['documento'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password_raw = $_POST['password'] ?? '';

    if ($rol === '' || $nombre === '' || $documento === '' || $email === '' || $password_raw === '') {
        echo "<script>alert('Todos los campos son obligatorios');window.history.back();</script>";
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Correo ya registrado');window.location='login.php';</script>";
        exit;
    }

    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, documento, email, password, rol, fecha_registro)
            VALUES (?, ?, ?, ?, ?, NOW())";

    $insert = $pdo->prepare($sql);
    $insert->execute([$nombre, $documento, $email, $password, $rol]);

    echo "<script>alert('Registro exitoso como $rol');window.location='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registro</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>

<body class="p-4">
<div class="container" style="max-width: 430px;">
    <h2 class="text-center mb-4">Registro de Usuario</h2>

    <form method="POST" class="border p-3 rounded bg-light">

        <label class="fw-bold">Registrarse como:</label>
        <select name="rol" class="form-select mb-3" required>
            <option value="estudiante">Estudiante</option>
            <option value="admin">Administrador</option>
        </select>

        <label>Documento</label>
        <input type="text" name="documento" class="form-control mb-3" required>

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
</body>
</html>
