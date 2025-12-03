<?php
require 'conexion.php';
session_start();

// si ya esta logueado
if(isset($_SESSION['user_id'])){
    header("Location: admin.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){
        // Guardar sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_rol'] = $user['rol']; // Si usas tabla de roles, ajusta
        header("Location: admin.php");
        exit;
    } else {
        $error = "Email o contraseña incorrectos";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container" style="max-width: 400px;">
    <h2 class="mb-4 text-center"> Iniciar Sesión</h2>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>
        <input type="password" name="password" placeholder="Contraseña" class="form-control mb-3" required>
        <button type="submit" class="btn btn-success w-100">Ingresar</button>
    </form>

    <p class="mt-3 text-center">¿No tienes cuenta? <a href="registro.php">Registrarse</a></p>
</div>

</body>
</html>
