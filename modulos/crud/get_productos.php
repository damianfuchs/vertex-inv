<?php
header('Content-Type: application/json');
include 'db/conexion.php'; // Asegurate que este archivo exista

$sql = "SELECT codigo_prod, nombre_prod, descripcion_prod, materia_prod, stock_prod, ubicacion_prod, peso_prod, imagen_prod FROM productos";
$result = $conn->query($sql);

$productos = [];

while ($row = $result->fetch_assoc()) {
    $row['imagen_prod'] = base64_encode($row['imagen_prod']);
    $productos[] = $row;
}

echo json_encode($productos);
$conn->close();
?>