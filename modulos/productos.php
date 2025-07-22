<?php
include('./db/conexion.php');?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Productos</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .table img {
            max-width: 50px;
            max-height: 50px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        tr:hover {
            cursor: pointer;
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    
    <div class="container-fluid px-0">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto"
            style="margin-bottom: 28px;">
            <i class="bi bi-box me-1"></i> Agregar Producto
        </button>

        <!-- Modal para agregar producto (tu modal original) -->
        <div class="modal fade" id="modalAgregarProducto" tabindex="-1" aria-labelledby="modalAgregarProductoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarProductoLabel">Agregar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form action="agregar_producto.php" method="POST" enctype="multipart/form-data">
                            
                            <div class="mb-2">
                                <label for="codigo" class="form-label">Código</label>
                                <input type="text" class="form-control" name="codigo" required />
                            </div>
                            <div class="mb-2">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" required />
                            </div>
                            <div class="mb-2">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" name="descripcion" required />
                            </div>
                            <div class="mb-2">
                                <label for="material" class="form-label">Material</label>
                                <input type="text" class="form-control" name="material" required />
                            </div>
                            <div class="mb-2">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" name="stock" required />
                            </div>
                            <div class="mb-2">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" name="ubicacion" required />
                            </div>
                            <div class="mb-2">
                                <label for="peso" class="form-label">Peso</label>
                                <input type="number" step="0.01" class="form-control" name="peso" required />
                            </div>
                            <div class="mb-2">
                                <label for="imagen" class="form-label">Imagen del producto</label>
                                <input type="file" class="form-control" name="imagen" accept="image/*" required />
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    

    <!-- Tabla de productos -->
    <div class="table-responsive">
        <table class="table table-striped" id="tablaProductos">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="py-1 px-2">ID</th>
                    <th scope="col" class="py-1 px-2">Código</th>
                    <th scope="col" class="py-1 px-2">Nombre</th>
                    <th scope="col" class="py-1 px-2">Descripción</th>
                    <th scope="col" class="py-1 px-2">Material</th>
                    <th scope="col" class="py-1 px-2">Cantidad</th>
                    <th scope="col" class="py-1 px-2">Ubicación</th>
                    <th scope="col" class="py-1 px-2">Peso (kg)</th>
                    <th scope="col" class="py-1 px-2">Imagen</th>
                </tr>
            </thead>
            <tbody id="tabla-productos">
                <?php
                $sql = "SELECT id_prod, codigo_prod, nombre_prod, descripcion_prod, materia_prod, stock_prod, ubicacion_prod, peso_prod, imagen_prod FROM productos";
                $resultado = $conexion->query($sql);

                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr
                            data-id='" . htmlspecialchars($fila['id_prod']) . "'
                            data-codigo='" . htmlspecialchars($fila['codigo_prod']) . "'
                            data-nombre='" . htmlspecialchars($fila['nombre_prod']) . "'
                            data-descripcion='" . htmlspecialchars($fila['descripcion_prod']) . "'
                            data-material='" . htmlspecialchars($fila['materia_prod']) . "'
                            data-stock='" . htmlspecialchars($fila['stock_prod']) . "'
                            data-ubicacion='" . htmlspecialchars($fila['ubicacion_prod']) . "'
                            data-peso='" . htmlspecialchars($fila['peso_prod']) . "'
                            data-imagen='" . htmlspecialchars($fila['imagen_prod']) . "'
                            >";
                        echo "<td class='py-1 px-2 id_prod'>" . htmlspecialchars($fila['id_prod']) . "</td>";
                        echo "<td class='py-1 px-2 codigo'>" . htmlspecialchars($fila['codigo_prod']) . "</td>";
                        echo "<td class='py-1 px-2 nombre'>" . htmlspecialchars($fila['nombre_prod']) . "</td>";
                        echo "<td class='py-1 px-2 descripcion'>" . htmlspecialchars($fila['descripcion_prod']) . "</td>";
                        echo "<td class='py-1 px-2 material'>" . htmlspecialchars($fila['materia_prod']) . "</td>";
                        echo "<td class='py-1 px-2 stock'>" . htmlspecialchars($fila['stock_prod']) . "</td>";
                        echo "<td class='py-1 px-2 ubicacion'>" . htmlspecialchars($fila['ubicacion_prod']) . "</td>";
                        echo "<td class='py-1 px-2 peso'>" . htmlspecialchars($fila['peso_prod']) . "</td>";
                        echo "<td><img src='../img/" . htmlspecialchars($fila['imagen_prod']) . "' alt='Imagen' style='max-width:50px; height:auto;'></td>";    
                        echo "</tr>";
                    }       
                } else {
                    echo "<tr><td colspan='9' class='py-2 px-2 text-center'>No hay productos registrados.</td></tr>";
                }
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   
</body>

</html>
