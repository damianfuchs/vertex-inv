<?php
include('../db/conexion.php');

// Validar que los datos vienen por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir y sanitizar datos
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $codigo = isset($_POST['codigo']) ? $conexion->real_escape_string(trim($_POST['codigo'])) : '';
    $nombre = isset($_POST['nombre']) ? $conexion->real_escape_string(trim($_POST['nombre'])) : '';
    $descripcion = isset($_POST['descripcion']) ? $conexion->real_escape_string(trim($_POST['descripcion'])) : '';

    if ($id > 0 && $codigo !== '' && $nombre !== '' && $descripcion !== '') {
        // Preparar consulta de actualización
        $sql = "UPDATE categorias SET codigo_categ = '$codigo', nombre_categ = '$nombre', descripcion_categ = '$descripcion' WHERE id_categ = $id";

        if ($conexion->query($sql) === TRUE) {
            // Si usas redirect:
            header('Location: ../../index.php'); // ACA CAMBIAR LA RUTA AL EDITAR LA CATEGORIA
            exit();

            // O si quieres responder JSON (descomentar esta parte para AJAX):
            /*
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Categoría actualizada correctamente']);
            exit();
            */
        } else {
            // Error en la consulta
            // Si usas redirect:
            header('Location: ../../categorias.php?edit=error');
            exit();

            /*
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $conexion->error]);
            exit();
            */
        }
    } else {
        // Datos incompletos
        header('Location: ../../categorias.php?edit=invalid');
        exit();

        /*
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Datos inválidos o incompletos']);
        exit();
        */
    }
} else {
    // Método no permitido
    header('HTTP/1.1 405 Method Not Allowed');
    exit();
}

$conexion->close();
?>
