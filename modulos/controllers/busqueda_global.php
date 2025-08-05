<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include('../db/conexion.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$modulo = $_GET['modulo'] ?? '';
$termino = $_GET['termino'] ?? '';

if (!$modulo || !$termino) {
    echo '<div class="alert alert-warning">Parámetros inválidos.</div>';
    exit;
}

$termino = "%{$termino}%";

switch ($modulo) {
    case 'productos':
        $sql = "SELECT p.id_prod, p.codigo_prod, p.nombre_prod, p.descripcion_prod, p.materia_prod, p.stock_prod, p.ubicacion_prod, p.peso_prod, p.imagen_prod, c.nombre_categ AS categoria
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id_categ
            WHERE p.nombre_prod LIKE ? OR p.codigo_prod LIKE ? OR p.descripcion_prod LIKE ? OR p.materia_prod LIKE ?";
        break;
    case 'categorias':
        $sql = "SELECT * FROM categorias WHERE nombre_categ LIKE ? OR codigo_categ LIKE ? OR descripcion_categ LIKE ?";
        break;
    case 'proveedores':
        $sql = "SELECT * FROM proveedores WHERE nombre_proveedores LIKE ? OR nombre_contacto_proveedores LIKE ? OR email_proveedores LIKE ?";
        break;
    case 'clientes':
        $sql = "SELECT * FROM clientes WHERE nombre_clientes LIKE ? OR dni_cuit_clientes LIKE ? OR email_clientes LIKE ?";
        break;
    case 'pedidos':
        $sql = "SELECT * FROM pedidos WHERE nombre_cliente_pedido LIKE ? OR estado_pedido LIKE ? OR observaciones_pedidos LIKE ?";
        break;
    default:
        echo '<div class="alert alert-danger">Módulo no válido.</div>';
        exit;
}

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    echo '<div class="alert alert-danger">Error en la consulta.</div>';
    exit;
}

$paramsCount = substr_count($sql, '?');
$params = array_fill(0, $paramsCount, $termino);
$types = str_repeat('s', $paramsCount);

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<div class="alert alert-info">No se encontraron resultados.</div>';
    exit;
}

echo '<div class="table-responsive">';
echo '<table class="table table-bordered table-striped table-hover">';
echo '<thead class="table-dark"><tr>';
foreach ($result->fetch_fields() as $field) {
    echo '<th>' . htmlspecialchars($field->name) . '</th>';
}
echo '</tr></thead><tbody>';

while ($row = $result->fetch_assoc()) {
    // Si tenés stock_prod en el resultado, podés resaltar fila:
    $claseFila = (isset($row['stock_prod']) && ($row['stock_prod'] == 0)) ? 'fila-stock-cero' : '';
    echo "<tr class=\"$claseFila\">";
    foreach ($row as $campo => $valor) {
        if (strpos($campo, 'imagen') !== false && !empty($valor)) {
            echo '<td><img src="./img/' . htmlspecialchars($valor) . '" alt="Imagen" style="max-height:50px; border-radius:6px; box-shadow: 0 0 5px rgba(0,0,0,0.1);"></td>';
        } else {
            echo '<td>' . htmlspecialchars($valor ?? '') . '</td>';
        }
    }
    echo '</tr>';
}
echo '</tbody></table>';
echo '</div>';
?>
