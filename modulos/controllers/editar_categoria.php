<?php
// Incluir la conexión a la base de datos
include('../db/conexion.php');

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    // Obtener datos del formulario
    $id = $_POST['id'] ?? '';
    $codigo = $_POST['codigo'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    // Validar campos obligatorios
    if (empty($id) || empty($codigo) || empty($nombre) || empty($descripcion)) {
        throw new Exception('Todos los campos son obligatorios');
    }

    // Validar que el ID sea numérico
    if (!is_numeric($id)) {
        throw new Exception('ID de categoría no válido');
    }

    // Verificar que la categoría existe
    $consulta_existe = "SELECT id_categ FROM categorias WHERE id_categ = ?";
    $stmt_existe = $conexion->prepare($consulta_existe);
    $stmt_existe->bind_param("i", $id);
    $stmt_existe->execute();
    $resultado_existe = $stmt_existe->get_result();
    
    if ($resultado_existe->num_rows === 0) {
        throw new Exception('La categoría no existe');
    }

    // Verificar que el código no esté en uso por otra categoría
    $consulta_codigo = "SELECT id_categ FROM categorias WHERE codigo_categ = ? AND id_categ != ?";
    $stmt_codigo = $conexion->prepare($consulta_codigo);
    $stmt_codigo->bind_param("si", $codigo, $id);
    $stmt_codigo->execute();
    $resultado_codigo = $stmt_codigo->get_result();
    
    if ($resultado_codigo->num_rows > 0) {
        throw new Exception('Ya existe otra categoría con ese código');
    }

    // Preparar la consulta SQL
    $sql = "UPDATE categorias SET codigo_categ = ?, nombre_categ = ?, descripcion_categ = ? WHERE id_categ = ?";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . $conexion->error);
    }
    
    $stmt->bind_param("sssi", $codigo, $nombre, $descripcion, $id);

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        throw new Exception('Error al actualizar la categoría: ' . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception('No se encontró la categoría o no hubo cambios');
    }

    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => 'Categoría actualizada correctamente',
        'id' => $id
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
    if (isset($stmt_existe)) {
        $stmt_existe->close();
    }
    if (isset($stmt_codigo)) {
        $stmt_codigo->close();
    }
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>
