<?php
include 'db/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_prod = $_POST['id_prod'] ?? 0;
    $categoria_id = $_POST['categoria_id'] ?? null;
    $codigo_prod = $_POST['codigo_prod'] ?? '';
    $nombre_prod = $_POST['nombre_prod'] ?? '';
    $descripcion_prod = $_POST['descripcion_prod'] ?? '';
    $materia_prod = $_POST['materia_prod'] ?? '';
    $peso_prod = $_POST['peso_prod'] ?? 0;
    $stock_prod = $_POST['stock_prod'] ?? 0;
    $ubicacion_prod = $_POST['ubicacion_prod'] ?? 0;

    // Primero obtenemos la imagen actual para conservar si no se sube una nueva
    $sql_img = "SELECT imagen_prod FROM productos WHERE id_prod = ?";
    $stmt_img = $conexion->prepare($sql_img);
    $stmt_img->bind_param("i", $id_prod);
    $stmt_img->execute();
    $result_img = $stmt_img->get_result();
    $imagen_actual = '';
    if ($row = $result_img->fetch_assoc()) {
        $imagen_actual = $row['imagen_prod'];
    }
    $stmt_img->close();

    // Manejar nueva imagen (si se subió)
    if (isset($_FILES['imagen_prod']) && $_FILES['imagen_prod']['error'] === UPLOAD_ERR_OK) {
        $nombreTmp = $_FILES['imagen_prod']['tmp_name'];
        $nombreArchivo = basename($_FILES['imagen_prod']['name']);
        $rutaDestino = "../img/" . $nombreArchivo;

        if (move_uploaded_file($nombreTmp, $rutaDestino)) {
            $imagen_prod = $nombreArchivo;
            // Opcional: borrar la imagen vieja si querés
            if ($imagen_actual && file_exists("img/" . $imagen_actual)) {
                unlink("img/" . $imagen_actual);
            }
        } else {
            $imagen_prod = $imagen_actual;
        }
    } else {
        $imagen_prod = $imagen_actual;
    }

    // Actualizar producto
    $sql = "UPDATE productos SET categoria_id=?, codigo_prod=?, nombre_prod=?, descripcion_prod=?, materia_prod=?, peso_prod=?, stock_prod=?, ubicacion_prod=?, imagen_prod=? WHERE id_prod=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isssssdisi", $categoria_id, $codigo_prod, $nombre_prod, $descripcion_prod, $materia_prod, $peso_prod, $stock_prod, $ubicacion_prod, $imagen_prod, $id_prod);
    $stmt->execute();

    if ($stmt->affected_rows >= 0) {
        header('Location: productos.php?msg=editado');
    } else {
        echo "Error al actualizar producto.";
    }

    $stmt->close();
    $conexion->close();
}
?>
