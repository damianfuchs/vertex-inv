<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Búsqueda Global</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Filas sin stock resaltadas */
        .fila-stock-cero {
            background-color: #f8d7da;
            /* rojo suave */
            color: #842029;
        }

        /* Hover para toda la fila */
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
            /* gris claro */
        }

        /* Imagen con borde redondeado y sombra */
        .table img {
            border-radius: 6px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            max-height: 50px;
        }

        /* Margen entre botones */
        .btn-ver,
        .btn-editar,
        .btn-eliminar {
            margin-right: 0.25rem;
        }

        /* Opcional: iconos centrados y tamaño uniforme */
        .btn i {
            font-size: 1.1rem;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="bi bi-search"></i> Búsqueda Global
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="max-width: 500px;">
                    <div class="card-body p-4">
                        <!-- Selector de módulo -->
                        <div class="mb-3" style="max-width: 500px;">
                            <label for="selectModulo" class="form-label fw-semibold">
                                <i class="bi bi-funnel-fill text-secondary me-1"></i> Módulo
                            </label>
                            <select class="form-select" id="selectModulo">
                                <option value="productos" selected>Productos</option>
                                <option value="categorias">Categorías</option>
                                <option value="proveedores">Proveedores</option>
                                <option value="clientes">Clientes</option>
                                <option value="ventas">Ventas</option>
                                <option value="pedidos">Pedidos</option>
                            </select>
                        </div>

                        <div class="mb-3" style="max-width: 500px;">
                            <label for="inputBusqueda" class="form-label fw-semibold">
                                <i class="bi bi-search text-secondary me-1"></i> Buscar
                            </label>
                            <div class="input-group">
                                <input type="text" id="inputBusqueda" class="form-control" placeholder="Buscar...">
                                <button class="btn btn-primary px-4" type="button" id="btnBuscar">
                                    <i class="bi bi-arrow-right-circle"></i> Buscar
                                </button>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>


    </div>

    <div id="resultadosBusqueda" class="m-3"></div>

    <script src="./modulos/js/buscar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>