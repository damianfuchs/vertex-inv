<?php
include('./db/conexion.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <div class="container-fluid px-0">

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria"
            style="margin-bottom: 28px;">
            <i class="bi bi-tag"></i> Agregar Categoría
        </button>



        <!-- Tabla de categorías -->
        <div class="table-responsive">
            <table class="table table-striped" id="tablaCategorias">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="py-1 px-2">ID</th>
                        <th scope="col" class="py-1 px-2">Código</th>
                        <th scope="col" class="py-1 px-2">Nombre</th>
                        <th scope="col" class="py-1 px-2">Descripción</th>
                        <th scope="col" class="py-1 px-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-categorias">
                    <?php
                    $sql = "SELECT id_categ, codigo_categ, nombre_categ, descripcion_categ FROM categorias";
                    $resultado = $conexion->query($sql);

                    if ($resultado->num_rows > 0) {
                        while ($fila = $resultado->fetch_assoc()) {
                            echo "<tr
                                    data-id='" . htmlspecialchars($fila['id_categ']) . "'
                                    data-codigo='" . htmlspecialchars($fila['codigo_categ']) . "'
                                    data-nombre='" . htmlspecialchars($fila['nombre_categ']) . "'
                                    data-descripcion='" . htmlspecialchars($fila['descripcion_categ']) . "'>";

                            echo "<td class='py-1 px-2 id_categ'>" . htmlspecialchars($fila['id_categ']) . "</td>";
                            echo "<td class='py-1 px-2 codigo_categ'>" . htmlspecialchars($fila['codigo_categ']) . "</td>";
                            echo "<td class='py-1 px-2 nombre_categ'>" . htmlspecialchars($fila['nombre_categ']) . "</td>";
                            echo "<td class='py-1 px-2 descripcion_categ'>" . htmlspecialchars($fila['descripcion_categ']) . "</td>";

                            echo "<td class='py-1 px-2'>
                                    <button class='btn btn-warning btn-sm me-1 btn-editar' title='Editar'>
                                        <i class='bi bi-pencil-square'></i>
                                    </button>
                                    <button type='button' class='btn btn-danger btn-sm btn-eliminar' 
                                        data-bs-toggle='modal' data-bs-target='#modalEliminarCategoria' 
                                        data-id='" . htmlspecialchars($fila['id_categ']) . "'>
                                        <i class='bi bi-trash'></i>
                                    </button>
                                </td>";

                            echo "</tr>";   
                        }
                    } else {
                        echo "<tr><td colspan='5' class='py-2 px-2 text-center'>No hay categorías registradas.</td></tr>";
                    }

                    $conexion->close();
                    ?>
                </tbody>
            </table>
        </div>


        <!-- Modal para agregar categoría -->
        <div class="modal fade" id="modalAgregarCategoria" tabindex="-1" aria-labelledby="modalAgregarCategoriaLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarCategoriaLabel">Agregar Categoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="modulos/controllers/guardar_categoria.php">
                            <div class="mb-2">
                                <label for="codigo_categ" class="form-label">Código</label>
                                <input type="text" class="form-control" name="codigo_categ" required />
                            </div>
                            <div class="mb-2">
                                <label for="nombre_categ" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre_categ" required />
                            </div>
                            <div class="mb-2">
                                <label for="descripcion_categ" class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion_categ" rows="3" required></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar categoría -->
    <div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoriaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarCategoriaLabel">Editar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="modulos/controllers/editar_categoria.php">
                        <!-- ID oculto -->
                        <input type="hidden" name="id" id="editId">

                        <div class="mb-2">
                            <label for="editCodigo" class="form-label">Código</label>
                            <input type="text" class="form-control" name="codigo" id="editCodigo" required>
                        </div>
                        <div class="mb-2">
                            <label for="editNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="editNombre" required>
                        </div>
                        <div class="mb-2">
                            <label for="editDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="editDescripcion" rows="3"
                                required></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal para eliminar categoría -->
    <div class="modal fade" id="modalEliminarCategoria" tabindex="-1" aria-labelledby="modalEliminarCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarCategoriaLabel">Eliminar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar esta categoría?</p>
                </div>

                <form method="POST" action="modulos/controllers/eliminar_categoria.php">
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="deleteCategoriaId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>



    <script src="../script.js"></script>
</body>

</html>