<?php
require 'conexion.php';

$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$documento = $_POST['documento'];

$sql = "INSERT INTO estudiantes (nombres, apellidos, documento)
        VALUES (:nombres, :apellidos, :documento)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nombres' => $nombres,
    ':apellidos' => $apellidos,
    ':documento' => $documento
]);

header("Location: estudiantes.php");
exit();
?>
