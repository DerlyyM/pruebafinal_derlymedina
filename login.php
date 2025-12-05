<?php
require 'conexion.php';
session_start();

// Si ya inició sesión, redirigir según su rol
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_rol'] == "admin") {
        header("Location: admin.php");
        exit;
    } else {
        header("Location: estudiante.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar el usuario en la BD
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validar contraseña
    if ($user && password_verify($password, $user['password'])) {

        // Guardar datos en sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_rol'] = $user['rol'];  // admin / estudiante

        // Redirigir según el rol
        if ($user['rol'] == "admin") {
            header("Location: admin.php");
            exit;
        } else {
            header("Location: estudiante.php");
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
