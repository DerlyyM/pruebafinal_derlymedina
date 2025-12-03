<?php
require 'conexion.php';
header('Content-Type: application/json');

if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
    echo json_encode(['success'=>false,'error'=>'No se recibió el nombre']);
    exit;
}

$nombre = $_POST['nombre'];
$stmt = $pdo->prepare("INSERT INTO asignaturas (nombre) VALUES (?)");

if($stmt->execute([$nombre])){
    $id = $pdo->lastInsertId();
    echo json_encode(['success'=>true,'id'=>$id,'nombre'=>$nombre]);
}else{
    echo json_encode(['success'=>false,'error'=>'No se pudo guardar la asignatura']);
}
