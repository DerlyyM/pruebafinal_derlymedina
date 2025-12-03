<?php
include 'conexion.php';

$stmt = $conn->query("SHOW COLUMNS FROM notas");
$cols = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($cols);
echo "</pre>";
