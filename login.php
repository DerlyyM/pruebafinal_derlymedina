<?php
require 'conexion.php';
session_start();

// Si ya inició sesión, enviarlo a su panel
if (isset($_SESSION['usuario_id'])) {

    if ($_SESSION['rol'] == "admin") {
        header("Location: admin/index.php");
        exit;
    } else {
        header("Location: estudiante/index.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar usuario por email
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        // Guardar datos en sesión con claves correctas
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol'];

        // Redirigir según el rol
        if ($user['rol'] == "admin") {
            header("Location: admin/index.php");
            exit;
        } else {
            header("Location: estudiante/index.php");
            exit;
        }

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

