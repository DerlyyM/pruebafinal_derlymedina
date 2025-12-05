<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== "estudiante") {
    header("Location: login.php");
    exit;
}
?>
<h1>Bienvenido Estudiante: <?php echo $_SESSION['user_name']; ?></h1>

<p>Aquí vas a ver tus notas (lo haremos luego).</p>

<a href="logout.php">Cerrar sesión</a>
