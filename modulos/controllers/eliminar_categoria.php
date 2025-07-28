<?php
include('../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $stmt = $conexion->prepare("DELETE FROM categorias WHERE id_categ = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) { 
        header("Location: ../../index.php"); // Cambiá la ruta si querés ir a otra 
    } else {
        echo "Error al eliminar: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Acceso no permitido.";
}
?>


