<?php
include('../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_categ = $conexion->real_escape_string(trim($_POST['codigo_categ']));
    $nombre_categ = $conexion->real_escape_string(trim($_POST['nombre_categ']));
    $descripcion_categ = $conexion->real_escape_string(trim($_POST['descripcion_categ']));

    $sql = "INSERT INTO categorias (codigo_categ, nombre_categ, descripcion_categ) VALUES ('$codigo_categ', '$nombre_categ', '$descripcion_categ')";

    if ($conexion->query($sql)) {
        header("Location: ../../index.php"); // Cambiá la ruta si querés ir a otra
        exit;
    } else {
        echo "Error: " . $conexion->error;
    }
}
$conexion->close();


