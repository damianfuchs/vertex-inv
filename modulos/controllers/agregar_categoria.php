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
    $codigo_categ = $_POST['codigo_categ'] ?? '';
    $nombre_categ = $_POST['nombre_categ'] ?? '';
    $descripcion_categ = $_POST['descripcion_categ'] ?? '';

    // Validar campos obligatorios
    if (empty($codigo_categ) || empty($nombre_categ) || empty($descripcion_categ)) {
        throw new Exception('Todos los campos son obligatorios');
    }

    // Verificar que el código no exista
    $consulta_codigo = "SELECT id_categ FROM categorias WHERE codigo_categ = ?";
    $stmt_codigo = $conexion->prepare($consulta_codigo);
    $stmt_codigo->bind_param("s", $codigo_categ);
    $stmt_codigo->execute();
    $resultado_codigo = $stmt_codigo->get_result();
    
    if ($resultado_codigo->num_rows > 0) {
        throw new Exception('Ya existe una categoría con ese código');
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO categorias (codigo_categ, nombre_categ, descripcion_categ) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . $conexion->error);
    }
    
    $stmt->bind_param("sss", $codigo_categ, $nombre_categ, $descripcion_categ);

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        throw new Exception('Error al agregar la categoría: ' . $stmt->error);
    }

    $nuevo_id = $conexion->insert_id;
    
    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => 'Categoría agregada correctamente',
        'id' => $nuevo_id
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
    if (isset($stmt_codigo)) {
        $stmt_codigo->close();
    }
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>
