<?php
require 'conexion.php';
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
   
    $rol = $_POST['rol'];

    // SI ES ESTUDINATE

     if ($rol == "estudiante") {

        $documento = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (documento, nombre, password, rol) VALUES (?, ?, ?, 'estudiante')");
        $stmt->execute([$documento, $nombre, $password]);

        $mensaje = "Registro de estudiante exitoso";

    } else {

     // ADMINSTRADOR

      $email = $_POST['email'];
        $nombre = $_POST['nombre'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (email, nombre, password, rol) VALUES (?, ?, ?, 'admin')");
        $stmt->execute([$email, $nombre, $password]);

        $mensaje = "Registro de administrador exitoso";
    }

    

    header("Location: login.php");

    exit;
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
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" class="form-control mb-3" required>
        <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>
        <input type="password" name="password" placeholder="Contraseña" class="form-control mb-3" required>
        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>

    <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
</div>
</body>
</html>
