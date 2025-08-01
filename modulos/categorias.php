<?php
include('./db/conexion.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .alert-flotante {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .modern-title {
             font-family: 'Nunito Sans', sans-serif;
            font-weight: 600;
            /* un poco más grueso para destacar */
            font-size: 1.6rem;
            color: #2c3e50;
            /* un azul oscuro moderno */
            display: flex;
            align-items: center;
            gap: 0.75rem;
            /* espacio entre icono y texto */
            text-transform: uppercase;
            letter-spacing: 1.5px;
            /* espacio entre letras */
            border-left: 4px solid #3498db;
            /* barra lateral color azul */
            padding-left: 12px;
            transition: color 0.3s ease;
        }

        .modern-title i {
            font-size: 1.8rem;
            color: #3498db;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        /* Hover */
        .modern-title:hover {
            color: #2980b9;
        }

        .modern-title:hover i {
            color: #2980b9;
            transform: scale(1.1) rotate(10deg);
        }


        .mensaje-flotante {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1055;
            /* más alto que modal para que se vea */
            min-width: 250px;
            padding: 1rem 1.5rem;
            border-radius: 0.3rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            font-weight: 500;
            color: white;
            opacity: 0.95;
            transition: opacity 0.3s ease;
        }

        .mensaje-flotante.alert-success {
            background-color: #198754;
            /* verde Bootstrap */
        }

        .mensaje-flotante.alert-danger {
            background-color: #dc3545;
            /* rojo Bootstrap */
        }

        .mensaje-flotante.d-none {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid ">
        <h2 class="modern-title mb-4">
            <i class="bi bi-tags"></i> Gestión de Categorías
        </h2>



        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria"
            style="margin-bottom: 28px; background: linear-gradient(135deg, #1f2c4c 0%, #3b5680 100%); border: none; color: white;">
            <i class="bi bi-tag"></i> Agregar Categoría
        </button>

        <div id="mensajeCategoria" class="mensaje-flotante d-none"></div>


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
                                    <button class='btn btn-warning btn-sm me-1 btn-editar' 
                                        data-bs-toggle='modal' data-bs-target='#modalEditarCategoria' title='Editar'>
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
                <div class="modal-content rounded-4 shadow border-0" style="font-family: 'Nunito Sans', sans-serif;">
                    <!-- Header con color verde -->
                    <div class="modal-header bg-success text-white rounded-top-4">
                        <h5 class="modal-title d-flex align-items-center" id="modalAgregarCategoriaLabel">
                            <i class="bi bi-tags-fill me-2"></i> Agregar Categoría
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarCategoria" method="POST"
                            action="modulos/controllers/agregar_categoria.php">
                            <div class="mb-3">
                                <label for="codigo_categ" class="form-label fw-semibold">Código:</label>
                                <input type="text" class="form-control rounded-3" name="codigo_categ" required />
                            </div>
                            <div class="mb-3">
                                <label for="nombre_categ" class="form-label fw-semibold">Nombre:</label>
                                <input type="text" class="form-control rounded-3" name="nombre_categ" required />
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_categ" class="form-label fw-semibold">Descripción:</label>
                                <textarea class="form-control rounded-3" name="descripcion_categ" rows="3"
                                    required></textarea>
                            </div>
                            <!-- Botón inferior -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-success rounded-3">
                                    <i class="bi bi-plus-circle me-1"></i> Guardar Categoría
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar categoría -->
        <div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoriaLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 shadow border-0" style="font-family: 'Nunito Sans', sans-serif;">
                    <!-- Header con color amarillo -->
                    <div class="modal-header bg-warning text-dark rounded-top-4">
                        <h5 class="modal-title d-flex align-items-center" id="modalEditarCategoriaLabel">
                            <i class="bi bi-pencil-square me-2"></i> Editar Categoría
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" style="padding: 1.5rem;">
                        <form id="formEditarCategoria" method="POST" action="modulos/controllers/editar_categoria.php">
                            <!-- ID oculto -->
                            <input type="hidden" name="id" id="editId">
                            <div class="mb-3">
                                <label for="editCodigo" class="form-label fw-semibold">Código:</label>
                                <input type="text" class="form-control rounded-3" name="codigo" id="editCodigo"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editNombre" class="form-label fw-semibold">Nombre:</label>
                                <input type="text" class="form-control rounded-3" name="nombre" id="editNombre"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editDescripcion" class="form-label fw-semibold">Descripción:</label>
                                <textarea class="form-control rounded-3" name="descripcion" id="editDescripcion"
                                    rows="3" required></textarea>
                            </div>
                            <!-- Botón ancho -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-warning rounded-3 fw-semibold">
                                    <i class="bi bi-save me-1"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para eliminar categoría -->
        <div class="modal fade" id="modalEliminarCategoria" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <form id="formEliminarCategoria" class="modal-content shadow rounded-4 border-0" method="POST"
                    action="modulos/controllers/eliminar_categoria.php"
                    style="font-family: 'Nunito Sans', sans-serif; background-color: #f8f9fa;">
                    <div class="modal-header bg-danger text-white rounded-top-4">
                        <h5 class="modal-title">
                            <i class="bi bi-trash3-fill me-2"></i> Eliminar Categoría
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <p class="mb-0">¿Estás seguro de que querés eliminar esta categoría?</p>
                        <input type="hidden" name="id" id="deleteCategoriaId">
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4 px-4 py-3">
                        <button type="submit" class="btn btn-danger w-100 fw-semibold py-2">
                            <i class="bi bi-trash me-1"></i> Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cargar solo el JavaScript de categorías -->
    <script>
        console.log("🔄 Cargando categorias.js...");
    </script>
    <script src="./modulos/js/categorias.js?v=<?= time() ?>" defer></script>

    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080"></div>

</body>

</html>