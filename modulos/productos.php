<?php
include('./db/conexion.php'); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Productos</title>

    <!-- Incluí Bootstrap (si no lo tenés aún en tu layout principal) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

    <button type="button" class="btn btn-success" style="margin-bottom: 28px;" data-bs-toggle="modal"
        data-bs-target="#modalAgregar">
        <i class="bi bi-box"></i> Agregar Prodúcto
    </button>


    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>    
                    <th>Categoría</th> <!-- NUEVO -->
                    <th>Materia</th>
                    <th>Peso</th>
                    <th>Stock</th>
                    <th>Ubicación</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // JOIN con categorias para obtener nombre_categ
                $consulta = "
                SELECT p.*, c.nombre_categ 
                FROM productos p
                JOIN categorias c ON p.categoria_id = c.id_categ
                 ";
                $resultado = $conexion->query($consulta);

                while ($fila = $resultado->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['id_prod']) ?></td>
                        <td><?= htmlspecialchars($fila['codigo_prod']) ?></td>
                        <td><?= htmlspecialchars($fila['nombre_prod']) ?></td>
                        <td><?= htmlspecialchars($fila['descripcion_prod']) ?></td>
                        <td><?= htmlspecialchars($fila['nombre_categ']) ?></td> <!-- NUEVO -->
                        <td><?= htmlspecialchars($fila['materia_prod']) ?></td>
                        <td><?= htmlspecialchars($fila['peso_prod']) ?> kg</td>
                        <td><?= htmlspecialchars($fila['stock_prod']) ?></td>
                        <td><?= htmlspecialchars($fila['ubicacion_prod']) ?></td>
                        <td>
                            <?php if (!empty($fila['imagen_prod'])): ?>
                                <img src="./img/<?= htmlspecialchars($fila['imagen_prod']) ?>" alt="Imagen"
                                    style="max-width: 50px;">
                            <?php else: ?>
                                Sin imagen
                            <?php endif; ?>
                        </td>

                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalVer"
                                data-id="<?= $fila['id_prod'] ?>"
                                data-codigo="<?= htmlspecialchars($fila['codigo_prod']) ?>"
                                data-nombre="<?= htmlspecialchars($fila['nombre_prod']) ?>"
                                data-descripcion="<?= htmlspecialchars($fila['descripcion_prod']) ?>"
                                data-materia="<?= htmlspecialchars($fila['materia_prod']) ?>"
                                data-peso="<?= htmlspecialchars($fila['peso_prod']) ?>"
                                data-stock="<?= htmlspecialchars($fila['stock_prod']) ?>"
                                data-ubicacion="<?= htmlspecialchars($fila['ubicacion_prod']) ?>"
                                data-imagen="<?= htmlspecialchars($fila['imagen_prod']) ?>"
                                data-categoria="<?= htmlspecialchars($fila['nombre_categ']) ?>"> <!-- NUEVO -->
                                <i class="bi bi-eye"></i>
                            </button>

                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar"
                                data-id="<?= $fila['id_prod'] ?>"
                                data-codigo="<?= htmlspecialchars($fila['codigo_prod']) ?>"
                                data-nombre="<?= htmlspecialchars($fila['nombre_prod']) ?>"
                                data-descripcion="<?= htmlspecialchars($fila['descripcion_prod']) ?>"
                                data-categoriaid="<?= $fila['categoria_id'] ?>"
                                data-materia="<?= htmlspecialchars($fila['materia_prod']) ?>"
                                data-peso="<?= htmlspecialchars($fila['peso_prod']) ?>"
                                data-stock="<?= htmlspecialchars($fila['stock_prod']) ?>"
                                data-ubicacion="<?= htmlspecialchars($fila['ubicacion_prod']) ?>"
                                data-imagen="<?= htmlspecialchars($fila['imagen_prod']) ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                data-id="<?= $fila['id_prod'] ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>



    <!-- Modal Ver -->
    <div class="modal fade" id="modalVer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Ver Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Código:</strong> <span id="verCodigo"></span></p>
                    <p><strong>Nombre:</strong> <span id="verNombre"></span></p>
                    <p><strong>Descripción:</strong> <span id="verDescripcion"></span></p>
                    <p><strong>Categoría:</strong> <span id="verCategoria"></span></p> <!-- NUEVO -->
                    <p><strong>Materia:</strong> <span id="verMateria"></span></p>
                    <p><strong>Peso:</strong> <span id="verPeso"></span> kg</p>
                    <p><strong>Stock:</strong> <span id="verStock"></span></p>
                    <p><strong>Ubicación:</strong> <span id="verUbicacion"></span></p>
                    <p><strong>Imagen:</strong><br>
                        <img id="verImagen" src="" alt="Imagen del producto" style="max-width: 150px;">
                    </p>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditarProducto" class="modal-content" method="post" action="modulos/controllers/editar_producto.php"
                enctype="multipart/form-data" onsubmit="return enviarFormulario(event)">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_prod" id="editarId">

                    <div class="mb-2">
                        <label>Código:</label>
                        <input type="text" name="codigo_prod" id="editarCodigo" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Nombre:</label>
                        <input type="text" name="nombre_prod" id="editarNombre" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Descripción:</label>
                        <textarea name="descripcion_prod" id="editarDescripcion" class="form-control"></textarea>
                    </div>

                    <div class="mb-2">
                        <label>Categoría:</label>
                        <select name="categoria_id" id="editarCategoria" class="form-control">
                            <option value="">Seleccione una categoría</option>
                            <?php
                            // Cargar las categorías desde la base de datos
                            $categorias = $conexion->query("SELECT id_categ, nombre_categ FROM categorias");
                            while ($cat = $categorias->fetch_assoc()):
                                ?>
                                <option value="<?= $cat['id_categ'] ?>"><?= htmlspecialchars($cat['nombre_categ']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Materia:</label>
                        <input type="text" name="materia_prod" id="editarMateria" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Peso (kg):</label>
                        <input type="number" step="0.01" name="peso_prod" id="editarPeso" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Stock:</label>
                        <input type="number" name="stock_prod" id="editarStock" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Ubicación:</label>
                        <input type="number" name="ubicacion_prod" id="editarUbicacion" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Imagen:</label>
                        <input type="file" name="imagen_prod" id="editarImagen" class="form-control" accept="image/*">
                        <small>Imagen actual: <span id="nombreImagenActual"></span></small>
                    </div>


                </div>
                <div id="mensajeExito" class="alert alert-success" role="alert" style="display:none; margin-top:10px;">
                    Producto Editado con éxito.
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                </div>


            </form>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEliminar" class="modal-content" method="post" action="modulos/controllers/eliminar_producto.php">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Eliminar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que querés eliminar este producto?
                    <input type="hidden" name="id_prod" id="eliminarId">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>



    <!-- Modal Agregar Producto -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formAgregarProducto" class="modal-content" method="post" action="modulos/controllers/agregar_producto.php"
                enctype="multipart/form-data" onsubmit="return enviarAgregarProducto(event)">

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <label>Código:</label>
                        <input type="text" name="codigo_prod" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Nombre:</label>
                        <input type="text" name="nombre_prod" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Descripción:</label>
                        <textarea name="descripcion_prod" class="form-control"></textarea>
                    </div>
                    <div class="mb-2">
                        <label>Categoría:</label>
                        <select name="categoria_id" class="form-control" required>
                            <option value="">Seleccione una categoría</option>
                            <?php
                            $categorias = $conexion->query("SELECT id_categ, nombre_categ FROM categorias");
                            while ($cat = $categorias->fetch_assoc()):
                                ?>
                                <option value="<?= $cat['id_categ'] ?>"><?= htmlspecialchars($cat['nombre_categ']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Materia:</label>
                        <input type="text" name="materia_prod" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Peso (kg):</label>
                        <input type="number" step="0.01" name="peso_prod" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Stock:</label>
                        <input type="number" name="stock_prod" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Ubicación:</label>
                        <input type="number" name="ubicacion_prod" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Imagen:</label>
                        <input type="file" name="imagen_prod" class="form-control" accept="image/*">
                    </div>

                    <!-- Mensaje de éxito -->
                    <div id="mensajeAgregarExito" class="alert alert-success" role="alert"
                        style="display:none; margin-top:10px;">
                        Producto agregado con éxito.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Agregar Producto</button>
                </div>
            </form>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../script.js"></script>
</body>

</html>