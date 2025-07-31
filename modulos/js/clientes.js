document.addEventListener("DOMContentLoaded", () => {
  const bootstrap = window.bootstrap // Declare the bootstrap variable

  document.addEventListener("click", (e) => {
    // VER CLIENTE
    const btnVer = e.target.closest('[data-bs-target="#modalVerCliente"]')
    if (btnVer) {
      document.getElementById("verNombre").textContent = btnVer.dataset.nombre || ""
      document.getElementById("verDni").textContent = btnVer.dataset.dni || ""
      document.getElementById("verEmail").textContent = btnVer.dataset.email || ""
      document.getElementById("verTelefono").textContent = btnVer.dataset.telefono || ""
      document.getElementById("verDireccion").textContent = btnVer.dataset.direccion || ""
      document.getElementById("verLocalidad").textContent = btnVer.dataset.localidad || ""
      document.getElementById("verTipo").textContent = btnVer.dataset.tipo || ""
      document.getElementById("verObservaciones").textContent = btnVer.dataset.observaciones || ""
    }

    // EDITAR CLIENTE
    const btnEditar = e.target.closest('[data-bs-target="#modalEditarCliente"]')
    if (btnEditar) {
      document.getElementById("editarId").value = btnEditar.dataset.id || ""
      document.getElementById("editarNombre").value = btnEditar.dataset.nombre || ""
      document.getElementById("editarDni").value = btnEditar.dataset.dni || ""
      document.getElementById("editarEmail").value = btnEditar.dataset.email || ""
      document.getElementById("editarTelefono").value = btnEditar.dataset.telefono || ""
      document.getElementById("editarDireccion").value = btnEditar.dataset.direccion || ""
      document.getElementById("editarLocalidad").value = btnEditar.dataset.localidad || ""
      document.getElementById("editarTipo").value = btnEditar.dataset.tipo || ""
      document.getElementById("editarObservaciones").value = btnEditar.dataset.observaciones || ""
    }

    // ELIMINAR CLIENTE
    const btnEliminar = e.target.closest('[data-bs-target="#modalEliminarCliente"]')
    if (btnEliminar) {
      document.getElementById("eliminarId").value = btnEliminar.dataset.id || ""
    }
  })
})

// Función para copiar texto al portapapeles
function copiarTexto(elementoId, boton) {
  const elemento = document.getElementById(elementoId)
  const texto = elemento.textContent.trim()

  if (!texto) {
    mostrarMensaje(boton, "No hay texto para copiar", "warning")
    return
  }

  // Usar la API moderna del portapapeles
  if (navigator.clipboard && window.isSecureContext) {
    navigator.clipboard
      .writeText(texto)
      .then(() => {
        mostrarMensaje(boton, "¡Copiado!", "success")
      })
      .catch((err) => {
        console.error("Error al copiar: ", err)
        copiarTextoFallback(texto, boton)
      })
  } else {
    // Fallback para navegadores más antiguos
    copiarTextoFallback(texto, boton)
  }
}

// Función fallback para copiar texto (navegadores más antiguos)
function copiarTextoFallback(texto, boton) {
  const textArea = document.createElement("textarea")
  textArea.value = texto
  textArea.style.position = "fixed"
  textArea.style.left = "-999999px"
  textArea.style.top = "-999999px"
  document.body.appendChild(textArea)
  textArea.focus()
  textArea.select()

  try {
    document.execCommand("copy")
    mostrarMensaje(boton, "¡Copiado!", "success")
  } catch (err) {
    console.error("Error al copiar: ", err)
    mostrarMensaje(boton, "Error al copiar", "danger")
  }

  document.body.removeChild(textArea)
}

// Función para mostrar mensaje temporal en el botón
function mostrarMensaje(boton, mensaje, tipo) {
  const textoOriginal = boton.innerHTML
  const iconoOriginal = boton.querySelector("i").className

  // Cambiar el contenido del botón temporalmente
  if (tipo === "success") {
    boton.innerHTML = '<i class="bi bi-check-circle-fill"></i> ' + mensaje
    boton.className = boton.className.replace(/btn-outline-\w+/, "btn-success")
  } else if (tipo === "warning") {
    boton.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> ' + mensaje
    boton.className = boton.className.replace(/btn-outline-\w+/, "btn-warning")
  } else if (tipo === "danger") {
    boton.innerHTML = '<i class="bi bi-x-circle-fill"></i> ' + mensaje
    boton.className = boton.className.replace(/btn-outline-\w+/, "btn-danger")
  }

  // Restaurar el botón después de 2 segundos
  setTimeout(() => {
    boton.innerHTML = textoOriginal
    if (tipo === "success") {
      boton.className = boton.className.replace("btn-success", "btn-outline-primary")
    } else if (tipo === "warning") {
      boton.className = boton.className.replace("btn-warning", "btn-outline-primary")
    } else if (tipo === "danger") {
      boton.className = boton.className.replace("btn-danger", "btn-outline-primary")
    }
  }, 2000)
}

// Función para manejar el envío del formulario de agregar
function enviarAgregarCliente(event) {
  event.preventDefault()

  const form = event.target
  const formData = new FormData(form)

  fetch(form.action, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      // Mostrar mensaje de éxito
      const mensajeExito = document.getElementById("mensajeAgregarExito")
      if (mensajeExito) {
        mensajeExito.classList.remove("d-none")
        setTimeout(() => {
          mensajeExito.classList.add("d-none")
          // Cerrar modal y recargar página
          const modal = window.bootstrap.Modal.getInstance(document.getElementById("modalAgregarCliente"))
          modal.hide()
          form.reset()
          location.reload()
        }, 2000)
      }
    })
    .catch((error) => {
      console.error("Error:", error)
      alert("Error al agregar el cliente")
    })

  return false
}

// Función para manejar el envío del formulario de editar
function enviarEditarCliente(event) {
  event.preventDefault()

  const form = event.target
  const formData = new FormData(form)

  fetch(form.action, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      // Cerrar modal y recargar página
      const modal = window.bootstrap.Modal.getInstance(document.getElementById("modalEditarCliente"))
      modal.hide()
      location.reload()
    })
    .catch((error) => {
      console.error("Error:", error)
      alert("Error al editar el cliente")
    })

  return false
}

// Función para manejar el envío del formulario de eliminar
function enviarEliminarCliente(event) {
  event.preventDefault()

  const form = event.target
  const formData = new FormData(form)

  fetch(form.action, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      // Cerrar modal y recargar página
      const modal = window.bootstrap.Modal.getInstance(document.getElementById("modalEliminarCliente"))
      modal.hide()
      location.reload()
    })
    .catch((error) => {
      console.error("Error:", error)
      alert("Error al eliminar el cliente")
    })

  return false
}
