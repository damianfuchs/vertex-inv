<?php
include('./db/conexion.php');
?>


<div class="container-fluid px-0">

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria"
        style="margin-bottom: 28px;">
        <i class="bi bi-tag"></i> Agregar Categoría
    </button>

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
                    <!-- Usamos un iframe oculto como target -->

                    <form method="POST" action="modulos/guardar_categoria.php">
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Tabla de categorías -->
<div class="table-responsive">
    <table class="table table-striped" id="tablaCategorias">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="py-1 px-2">ID</th>
                <th scope="col" class="py-1 px-2">Código</th>
                <th scope="col" class="py-1 px-2">Nombre</th>
                <th scope="col" class="py-1 px-2">Descripción</th>
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
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='py-2 px-2 text-center'>No hay categorías registradas.</td></tr>";
            }
            $conexion->close();
            ?>
        </tbody>
    </table>
</div>

<script>
document.querySelector('iframe[name="form_result"]').addEventListener('load', function() {
    const iframeDoc = this.contentDocument || this.contentWindow.document;
    const responseText = iframeDoc.body.innerText.trim();

    const mensajeDiv = document.getElementById('mensajeCategoria');

    if(responseText.toLowerCase().includes('error')) {
        mensajeDiv.classList.remove('alert-success');
        mensajeDiv.classList.add('alert-danger');
    } else {
        mensajeDiv.classList.remove('alert-danger');
        mensajeDiv.classList.add('alert-success');
        document.getElementById('formAgregarCategoria').reset();
    }

    mensajeDiv.style.display = 'block';
    mensajeDiv.textContent = responseText;
});
</script>
