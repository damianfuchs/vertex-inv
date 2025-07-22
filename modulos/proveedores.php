<?php include('./db/conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <style>
        .table img {
            max-width: 50px;
            max-height: 50px;
            width: auto;
            height: auto;
            object-fit: contain;
        }
    </style>

    <div class="table-responsive"><!-- menos margen vertical (my-1), padding 0 -->
            <table class="table table-striped"><!-- mb-0 quita margen inferior de la tabla -->
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="py-1 px-2">Código</th>
                        <th scope="col" class="py-1 px-2">Nombre</th>
                        <th scope="col" class="py-1 px-2">Descripción</th>
                        <th scope="col" class="py-1 px-2">Material</th>
                        <th scope="col" class="py-1 px-2">Cantidad</th>
                        <th scope="col" class="py-1 px-2">Ubicacion</th>
                        <th scope="col" class="py-1 px-2">Peso (kg)</th>
                        <th scope="col" class="py-1 px-2">Imagen</th>
                    </tr>
                </thead>
                <tbody id="tabla-productos">
                    <?php
                    $sql = "SELECT codigo_prod, nombre_prod, descripcion_prod, materia_prod, stock_prod, ubicacion_prod, peso_prod, imagen_prod FROM productos";
                    $resultado = $conexion->query($sql);

                    if ($resultado->num_rows > 0) {
                        while ($fila = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='py-1 px-2'>" . htmlspecialchars($fila['codigo_prod']) . "</td>";
                            echo "<td class='py-1 px-2'>" . htmlspecialchars($fila['nombre_prod']) . "</td>";
                            echo "<td class='py-1 px-2'>" . htmlspecialchars($fila['descripcion_prod']) . "</td>";
                            echo "<td class='py-1 px-2'>" . htmlspecialchars($fila['materia_prod']) . "</td>";
                            echo "<td class='py-1 px-2'>" . htmlspecialchars($fila['stock_prod']) . "</td>";
                            echo "<td class='py-1 px-2'>" . htmlspecialchars($fila['ubicacion_prod']) . "</td>";
                            echo "<td class='py-1 px-2'>" . htmlspecialchars($fila['peso_prod']) . "</td>";
                            echo "<td class='py-1 px-2'><img src='../img/" . htmlspecialchars($fila['imagen_prod']) . "' alt='Imagen' style='max-width:50px; height:auto; display:block; margin:auto;'></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='py-2 px-2 text-center'>No hay productos registrados.</td></tr>";
                    }

                    $conexion->close();
                    ?>
                </tbody>
            </table>
        </div>

</body>

</html>