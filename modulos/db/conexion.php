<?php
$host = "localhost";
$usuario = "root"; 
$contrasenia = "";
$basedatos = "vertex_inv";

$conexion = new mysqli($host, $usuario, $contrasenia, $basedatos);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>