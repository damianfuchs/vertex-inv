<?php
include 'db/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_prod = $_POST['id_prod'] ?? 0;

    // Opcional: eliminar la imagen del servidor antes
    $sql_img = "SELECT imagen_prod FROM productos WHERE id_prod = ?";
    $stmt_img = $conexion->prepare($sql_img);
    $stmt_img->bind_param("i", $id_prod);
    $stmt_img->execute();
    $result_img = $stmt_img->get_result();
    if ($row = $result_img->fetch_assoc()) {
        $imagen = $row['imagen_prod'];
        if ($imagen && file_exists("img/" . $imagen)) {
            unlink("img/" . $imagen);
        }
    }
    $stmt_img->close();

    // Eliminar producto
    $sql = "DELETE FROM productos WHERE id_prod = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_prod);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
            header('Location: ../index.php?modulos=productos.php');
            exit;
    } else {
            echo "error";
    }

    $stmt->close();
    $conexion->close();
}
?>

