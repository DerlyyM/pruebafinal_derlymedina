<?php
require 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no recibido");
}

$id = $_GET['id'];

$sql = "DELETE FROM asignaturas WHERE id = ?";
$stm = $pdo->prepare($sql);
$stm->execute([$id]);

header("Location: asignatura.php?msg=eliminado");
exit;
