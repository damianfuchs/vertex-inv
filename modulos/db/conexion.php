<?php
$host = "localhost";
$usuario = "root"; // o tu usuario
$contrasenia = ""; // o la contraseña
$basedatos = "vertex_inv"; // reemplazalo

$conn = new mysqli($host, $usuario, $contrasenia, $basedatos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>