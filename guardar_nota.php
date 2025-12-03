<?php
require 'conexion.php';
header('Content-Type: application/json');

if(!isset($_POST['estudiante_id'], $_POST['asignatura_id'], $_POST['nota'])){
    echo json_encode(['success'=>false,'error'=>'Faltan datos']);
    exit;
}

$estudiante_id = $_POST['estudiante_id'];
$asignatura_id = $_POST['asignatura_id'];
$nota = $_POST['nota'];

$sql = "INSERT INTO notas (estudiantes_id, asignatura_id, nota, fecha_registro)
        VALUES (:est, :asig, :nota, NOW())";

$stmt = $pdo->prepare($sql);

if($stmt->execute([':est'=>$estudiante_id, ':asig'=>$asignatura_id, ':nota'=>$nota])){
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false,'error'=>'No se pudo registrar la nota']);
}
