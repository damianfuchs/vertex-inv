<?php
include('./db/conexion.php'); ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Incluí Bootstrap (si no lo tenés aún en tu layout principal) -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


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
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarCliente"
        style="margin-bottom: 28px;">
        <i class="bi bi-person-fill-add"></i> Agregar Cliente
    </button>



    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>

                    <th>Nombre</th>
                    <th>DNI / CUIT</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Localidad</th>
                    <th>Tipo Cliente</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $consulta = "SELECT * FROM clientes";
                $resultado = $conexion->query($consulta);

                while ($fila = $resultado->fetch_assoc()):
                    ?>
                    <tr>

                        <td><?= htmlspecialchars($fila['nombre_clientes']) ?></td>
                        <td><?= htmlspecialchars($fila['dni_cuit_clientes']) ?></td>
                        <td><?= htmlspecialchars($fila['email_clientes']) ?></td>
                        <td><?= htmlspecialchars($fila['telefono_clientes']) ?></td>
                        <td><?= htmlspecialchars($fila['direccion_clientes']) ?></td>
                        <td><?= htmlspecialchars($fila['localidad_clientes']) ?></td>
                        <td><?= htmlspecialchars($fila['tipo_cliente_clientes']) ?></td>
                        <td><?= htmlspecialchars($fila['observaciones_clientes']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalVerCliente"
                                data-id="<?= $fila['id_clientes'] ?>"
                                data-nombre="<?= htmlspecialchars($fila['nombre_clientes']) ?>"
                                data-dni="<?= htmlspecialchars($fila['dni_cuit_clientes']) ?>"
                                data-email="<?= htmlspecialchars($fila['email_clientes']) ?>"
                                data-telefono="<?= htmlspecialchars($fila['telefono_clientes']) ?>"
                                data-direccion="<?= htmlspecialchars($fila['direccion_clientes']) ?>"
                                data-localidad="<?= htmlspecialchars($fila['localidad_clientes']) ?>"
                                data-tipo="<?= htmlspecialchars($fila['tipo_cliente_clientes']) ?>"
                                data-observaciones="<?= htmlspecialchars($fila['observaciones_clientes']) ?>">
                                <i class="bi bi-eye"></i>
                            </button>

                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#modalEditarCliente" data-id="<?= $fila['id_clientes'] ?>"
                                data-nombre="<?= htmlspecialchars($fila['nombre_clientes']) ?>"
                                data-dni="<?= htmlspecialchars($fila['dni_cuit_clientes']) ?>"
                                data-email="<?= htmlspecialchars($fila['email_clientes']) ?>"
                                data-telefono="<?= htmlspecialchars($fila['telefono_clientes']) ?>"
                                data-direccion="<?= htmlspecialchars($fila['direccion_clientes']) ?>"
                                data-localidad="<?= htmlspecialchars($fila['localidad_clientes']) ?>"
                                data-tipo="<?= htmlspecialchars($fila['tipo_cliente_clientes']) ?>"
                                data-observaciones="<?= htmlspecialchars($fila['observaciones_clientes']) ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modalEliminarCliente" data-id="<?= $fila['id_clientes'] ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>



        <!-- Modal Ver Cliente -->
    <div class="modal fade" id="modalVerCliente" tabindex="-1" aria-labelledby="modalVerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalVerLabel">Detalles del Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nombre:</strong> <span id="verNombre"></span></p>
                    <p><strong>DNI / CUIT:</strong> <span id="verDni"></span></p>
                    
                    <!-- Email con botón copiar -->
                    <p>
                        <strong>Email:</strong> 
                        <span id="verEmail"></span>
                        <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="copiarTexto('verEmail', this)" title="Copiar email">
                            <i class="bi bi-clipboard"></i> Copiar
                        </button>
                    </p>
                    
                    <!-- Teléfono con botón copiar -->
                    <p>
                        <strong>Teléfono:</strong> 
                        <span id="verTelefono"></span>
                        <button type="button" class="btn btn-sm btn-outline-success ms-2" onclick="copiarTexto('verTelefono', this)" title="Copiar teléfono">
                            <i class="bi bi-clipboard"></i> Copiar
                        </button>
                    </p>
                    
                    <p><strong>Dirección:</strong> <span id="verDireccion"></span></p>
                    <p><strong>Localidad:</strong> <span id="verLocalidad"></span></p>
                    <p><strong>Tipo Cliente:</strong> <span id="verTipo"></span></p>
                    <p><strong>Observaciones:</strong> <span id="verObservaciones"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Editar Cliente -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="formEditarCliente" class="modal-content" method="POST" action="modulos/controllers/editar_cliente.php" onsubmit="return enviarEditarCliente(event)">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_clientes" id="editarId">

                    <div class="mb-3">
                        <label for="editarNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editarNombre" name="nombre_clientes" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarDni" class="form-label">DNI / CUIT</label>
                        <input type="text" class="form-control" id="editarDni" name="dni_cuit_clientes">
                    </div>
                    <div class="mb-3">
                        <label for="editarEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editarEmail" name="email_clientes">
                    </div>
                    <div class="mb-3">
                        <label for="editarTelefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="editarTelefono" name="telefono_clientes">
                    </div>
                    <div class="mb-3">
                        <label for="editarDireccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="editarDireccion" name="direccion_clientes">
                    </div>
                    <div class="mb-3">
                        <label for="editarLocalidad" class="form-label">Localidad</label>
                        <input type="text" class="form-control" id="editarLocalidad" name="localidad_clientes">
                    </div>
                    <div class="mb-3">
                        <label for="editarTipo" class="form-label">Tipo Cliente</label>
                        <select class="form-select" id="editarTipo" name="tipo_cliente_clientes" required>
                            <option value="">Seleccione una opción</option>
                            <option value="Minorista">Minorista</option>
                            <option value="Mayorista">Mayorista</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editarObservaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="editarObservaciones" name="observaciones_clientes"
                            rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Eliminar Cliente -->
    <div class="modal fade" id="modalEliminarCliente" tabindex="-1" aria-labelledby="modalEliminarLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="formEliminarCliente" class="modal-content" method="POST" action="modulos/controllers/eliminar_cliente.php" onsubmit="return enviarEliminarCliente(event)">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalEliminarLabel">Confirmar Eliminación</h5>h
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_clientes" id="eliminarId">
                    <p>¿Estás seguro que querés eliminar este cliente?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Agregar Cliente -->
    <div class="modal fade" id="modalAgregarCliente" tabindex="-1" aria-labelledby="modalAgregarLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="formAgregarCliente" class="modal-content" method="POST"
                action="modulos/controllers/agregar_cliente.php" onsubmit="return enviarAgregarCliente(event)">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalAgregarLabel">
                        <i class="bi bi-person-fill-add me-2"></i>Agregar Cliente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="agregarNombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control" id="agregarNombre" name="nombre_clientes" required>
                        </div>
                        <div class="col-md-6">
                            <label for="agregarDni" class="form-label">DNI / CUIT</label>
                            <input type="text" class="form-control" id="agregarDni" name="dni_cuit_clientes">
                        </div>
                        <div class="col-md-6">
                            <label for="agregarEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="agregarEmail" name="email_clientes">
                        </div>
                        <div class="col-md-6">
                            <label for="agregarTelefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="agregarTelefono" name="telefono_clientes">
                        </div>
                        <div class="col-12">
                            <label for="agregarDireccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="agregarDireccion" name="direccion_clientes">
                        </div>
                        <div class="col-md-6">
                            <label for="agregarLocalidad" class="form-label">Localidad</label>
                            <input type="text" class="form-control" id="agregarLocalidad" name="localidad_clientes">
                        </div>
                        <div class="col-md-6">
                            <label for="agregarTipo" class="form-label">Tipo Cliente *</label>
                            <select class="form-select" id="agregarTipo" name="tipo_cliente_clientes" required>
                                <option value="">Seleccione una opción</option>
                                <option value="Minorista">Minorista</option>
                                <option value="Mayorista">Mayorista</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="agregarObservaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="agregarObservaciones" name="observaciones_clientes"
                                rows="3"></textarea>
                        </div>
                    </div>
                    <div id="mensajeAgregarExito" class="alert alert-success mt-3 mb-0 d-none" role="alert">
                        Cliente agregado con éxito.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Agregar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



</body>

</html>