<?php
require 'conexion.php';
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if($stmt->rowCount() > 0){
        $error = "El email ya está registrado";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre,email,password,rol) VALUES (?,?,?,?)");
        if($stmt->execute([$nombre,$email,$hash,'admin'])){
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $nombre;
            $_SESSION['user_rol'] = 'admin';
            echo "<script>alert('Usuario registrado correctamente'); window.location='admin.php';</script>";
            exit;
        } else {
            $error = "Error al registrar usuario";
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
