(function () {
  'use strict';

  console.log("🚀 Módulo categorias.js cargado");

  function esCategorias() {
    return document.querySelector("#modalEditarCategoria") !== null;
  }

  if (!esCategorias()) {
    console.log("⚠️ No estamos en la página de categorías");
    return;
  }

  console.log("✅ Página de categorías detectada, inicializando...");

  // Mostrar mensaje igual que proveedores.js
  function mostrarMensaje(texto, tipo = "success") {
    const contenedor = document.getElementById("mensajeCategoria");
    if (!contenedor) return;

    contenedor.textContent = texto;
    contenedor.className = `mensaje-flotante alert-${tipo}`;
    contenedor.classList.remove("d-none");

    setTimeout(() => {
      contenedor.classList.add("d-none");
    }, 3000);
  }

  // Cerrar modal
  function cerrarModal(form) {
    const modal = bootstrap.Modal.getInstance(form.closest(".modal"));
    if (modal) modal.hide();
  }

  // Enviar formulario
  function enviarFormulario(event, tipo) {
    event.preventDefault();
    console.log(`📝 Enviando formulario de ${tipo}...`);

    const formData = new FormData(event.target);

    fetch(event.target.action, {
      method: "POST",
      body: formData,
    })
      .then(response => response.text())
      .then(data => {
        try {
          const jsonResponse = JSON.parse(data);
          if (jsonResponse.success) {
            mostrarMensaje("✅ " + jsonResponse.message, "success");
            cerrarModal(event.target);
            if (tipo === "agregar") event.target.reset();
            setTimeout(() => location.reload(), 1500);
          } else {
            mostrarMensaje("❌ Error: " + jsonResponse.message, "danger");
          }
        } catch (e) {
          mostrarMensaje(`✅ ${tipo} realizado con éxito`, "success");
          cerrarModal(event.target);
          if (tipo === "agregar") event.target.reset();
          setTimeout(() => location.reload(), 1500);
        }
      })
      .catch(error => {
        console.error("❌ Error:", error);
        mostrarMensaje(`Error al ${tipo.toLowerCase()} la categoría`, "danger");
      });
  }

  // Cargar datos para editar (igual que tenés)
  function cargarDatosEdicion(btn) {
    const fila = btn.closest("tr");
    if (!fila) return;
    const datos = fila.dataset;

    document.getElementById("editId").value = datos.id || "";
    document.getElementById("editCodigo").value = datos.codigo || "";
    document.getElementById("editNombre").value = datos.nombre || "";
    document.getElementById("editDescripcion").value = datos.descripcion || "";

    const modalElement = document.getElementById("modalEditarCategoria");
    if (modalElement) {
      const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
      modal.show();
    }
  }

  // Preparar eliminación
  function prepararEliminacion(btn) {
    const id = btn.getAttribute("data-id");
    document.getElementById("deleteCategoriaId").value = id || "";

    const modalEliminar = document.getElementById("modalEliminarCategoria");
    if (modalEliminar) {
      const modal = bootstrap.Modal.getOrCreateInstance(modalEliminar);
      modal.show();
    }
  }

  // Eventos click
  document.body.addEventListener("click", (e) => {
    if (e.target.closest(".btn-editar")) {
      cargarDatosEdicion(e.target.closest(".btn-editar"));
    }
    if (e.target.closest(".btn-eliminar")) {
      prepararEliminacion(e.target.closest(".btn-eliminar"));
    }
  });

  // Eventos submit
  document.getElementById("formAgregarCategoria")?.addEventListener("submit", e => enviarFormulario(e, "agregar"));
  document.getElementById("formEditarCategoria")?.addEventListener("submit", e => enviarFormulario(e, "editar"));
  document.getElementById("formEliminarCategoria")?.addEventListener("submit", e => enviarFormulario(e, "eliminar"));

})();
