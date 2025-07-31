//Manejo de modales: ver, editar, eliminar (productos y clientes Categoria etc)

/*
function manejarClickBotones(e) {
    



    // === CATEGORÍA: ELIMINAR ===
    const btnEliminarCategoria = e.target.closest('.btn-eliminar');
    if (btnEliminarCategoria) {
        const fila = btnEliminarCategoria.closest('tr');
        const id = fila.dataset.id;
        document.getElementById('deleteCategoriaId').value = id || '';
        return;
    }



    // === CLIENTE: VER ===
    const btnVerCliente = e.target.closest('[data-bs-target="#modalVerCliente"]');
    if (btnVerCliente) {
        document.getElementById('verId').textContent = btnVerCliente.dataset.id || '';
        document.getElementById('verNombre').textContent = btnVerCliente.dataset.nombre || '';
        document.getElementById('verDni').textContent = btnVerCliente.dataset.dni || '';
        document.getElementById('verEmail').textContent = btnVerCliente.dataset.email || '';
        document.getElementById('verTelefono').textContent = btnVerCliente.dataset.telefono || '';
        document.getElementById('verDireccion').textContent = btnVerCliente.dataset.direccion || '';
        document.getElementById('verLocalidad').textContent = btnVerCliente.dataset.localidad || '';
        document.getElementById('verTipo').textContent = btnVerCliente.dataset.tipo || '';
        document.getElementById('verObservaciones').textContent = btnVerCliente.dataset.observaciones || '';
        return;
    }

    // === CLIENTE: EDITAR ===
    const btnEditarCliente = e.target.closest('.btn-sm.btn-warning');
    if (btnEditarCliente && btnEditarCliente.dataset.bsTarget === '#modalEditarCliente') {
        document.getElementById('editarId').value = btnEditarCliente.dataset.id || '';
        document.getElementById('editarNombre').value = btnEditarCliente.dataset.nombre || '';
        document.getElementById('editarDni').value = btnEditarCliente.dataset.dni || '';
        document.getElementById('editarEmail').value = btnEditarCliente.dataset.email || '';
        document.getElementById('editarTelefono').value = btnEditarCliente.dataset.telefono || '';
        document.getElementById('editarDireccion').value = btnEditarCliente.dataset.direccion || '';
        document.getElementById('editarLocalidad').value = btnEditarCliente.dataset.localidad || '';
        document.getElementById('editarTipo').value = btnEditarCliente.dataset.tipo || '';
        document.getElementById('editarObservaciones').value = btnEditarCliente.dataset.observaciones || '';
        return;
    }

    // === CLIENTE: ELIMINAR ===
    const btnEliminarCliente = e.target.closest('.btn-eliminar');
    if (btnEliminarCliente && btnEliminarCliente.dataset.bsTarget === '#modalEliminarCliente') {
        const id = btnEliminarCliente.dataset.id || '';
        document.getElementById('eliminarClienteId').value = id;
        return;
    }

}

*/