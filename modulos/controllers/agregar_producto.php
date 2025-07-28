<?php
include('../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria_id = $_POST['categoria_id'] ?? null;
    $codigo_prod = $_POST['codigo_prod'] ?? '';
    $nombre_prod = $_POST['nombre_prod'] ?? '';
    $descripcion_prod = $_POST['descripcion_prod'] ?? '';
    $materia_prod = $_POST['materia_prod'] ?? '';
    $peso_prod = $_POST['peso_prod'] ?? 0;
    $stock_prod = $_POST['stock_prod'] ?? 0;
    $ubicacion_prod = $_POST['ubicacion_prod'] ?? 0;

    $imagen_prod = "";  // inicializo como string vacía

    if (isset($_FILES['imagen_prod']) && $_FILES['imagen_prod']['error'] === UPLOAD_ERR_OK) {
        $nombreTmp = $_FILES['imagen_prod']['tmp_name'];
        $nombreArchivo = basename($_FILES['imagen_prod']['name']);
        $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $nombreArchivoNuevo = uniqid('img_') . "." . $ext;
        $rutaDestino = "../../img/" . $nombreArchivoNuevo;

        if (move_uploaded_file($nombreTmp, $rutaDestino)) {
            $imagen_prod = $nombreArchivoNuevo;
        }
    }

    $sql = "INSERT INTO productos (categoria_id, codigo_prod, nombre_prod, descripcion_prod, materia_prod, peso_prod, stock_prod, ubicacion_prod, imagen_prod) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("issssdiis", $categoria_id, $codigo_prod, $nombre_prod, $descripcion_prod, $materia_prod, $peso_prod, $stock_prod, $ubicacion_prod, $imagen_prod);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: productos.php?msg=agregado');
        exit;
    } else {
        echo "Error al agregar producto.";
    }
    $stmt->close();
    $conexion->close();
}
?>
