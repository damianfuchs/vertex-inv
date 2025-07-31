<?php
header('Content-Type: application/json');
include('../db/conexion.php');

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    // Obtener ID de la categoría
    $id = $_POST['id'] ?? '';

    // Validar que se proporcionó el ID
    if (empty($id) || !is_numeric($id)) {
        throw new Exception('ID de categoría no válido');
    }

    // Verificar que la categoría existe
    $consulta_categoria = "SELECT id_categ, nombre_categ FROM categorias WHERE id_categ = ?";
    $stmt_categoria = $conexion->prepare($consulta_categoria);
    
    if (!$stmt_categoria) {
        throw new Exception('Error al preparar consulta: ' . $conexion->error);
    }
    
    $stmt_categoria->bind_param("i", $id);
    $stmt_categoria->execute();
    $resultado_categoria = $stmt_categoria->get_result();
    
    if ($resultado_categoria->num_rows === 0) {
        throw new Exception('La categoría no existe');
    }
    
    $categoria = $resultado_categoria->fetch_assoc();

    // En lugar de verificar y bloquear, vamos a actualizar los productos
    // Actualizar productos asociados para que no tengan categoría
    $consulta_actualizar = "UPDATE productos SET categoria_id = NULL WHERE categoria_id = ?";
    $stmt_actualizar = $conexion->prepare($consulta_actualizar);
    $stmt_actualizar->bind_param("i", $id);
    $stmt_actualizar->execute();

    // Obtener cuántos productos se actualizaron
    $productos_actualizados = $stmt_actualizar->affected_rows;

    // Eliminar la categoría
    $sql = "DELETE FROM categorias WHERE id_categ = ?";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Error al preparar consulta de eliminación: ' . $conexion->error);
    }
    
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception('No se pudo eliminar la categoría');
    }
    
    // Respuesta exitosa
    $mensaje_productos = $productos_actualizados > 0 
        ? " y se actualizaron {$productos_actualizados} producto(s) para quedar sin categoría" 
        : "";

    echo json_encode([
        'success' => true,
        'message' => 'Categoría "' . $categoria['nombre_categ'] . '" eliminada correctamente' . $mensaje_productos,
        'id' => $id,
        'productos_actualizados' => $productos_actualizados
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    // Cerrar conexiones
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($stmt_categoria)) {
        $stmt_categoria->close();
    }
    if (isset($stmt_actualizar)) {
        $stmt_actualizar->close();
    }
    if (isset($conexion)) {
        $conexion->close();
    }
}

