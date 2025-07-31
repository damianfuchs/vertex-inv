console.log("🚀 Módulo productos.js cargado - VERSIÓN CORREGIDA v2.2")

// Prevenir múltiples inicializaciones
if (window.productosManagerLoaded) {
  console.log("⚠️ ProductosManager ya está cargado, evitando duplicación")
} else {
  window.productosManagerLoaded = true

  // Funcionalidad específica para la página de productos
  class ProductosManager {
    constructor() {
      this.isInitialized = false
      this.init()
    }

    init() {
      if (this.isInitialized) {
        console.log("⚠️ ProductosManager ya inicializado")
        return
      }

      console.log("✅ ProductosManager inicializando...")
      this.setupEventListeners()
      this.isInitialized = true
      console.log("✅ ProductosManager inicializado correctamente")
    }

    setupEventListeners() {
      console.log("🔧 Configurando event listeners...")

      // Usar delegación de eventos para evitar problemas de timing
      document.body.addEventListener("click", (e) => {
        // Modal Ver Producto
        if (e.target.closest(".btn-ver")) {
          const btn = e.target.closest(".btn-ver")
          console.log("👁️ Abriendo modal ver producto")
          this.mostrarDetallesProducto(btn)
        }

        // Modal Editar Producto
        if (e.target.closest(".btn-editar")) {
          const btn = e.target.closest(".btn-editar")
          console.log("✏️ Abriendo modal editar producto")
          this.cargarDatosEdicion(btn)
        }

        // Modal Eliminar Producto
        if (e.target.closest(".btn-eliminar")) {
          const btn = e.target.closest(".btn-eliminar")
          console.log("🗑️ Abriendo modal eliminar producto")
          this.prepararEliminacion(btn)
        }
      })

      // Formularios con delegación de eventos
      document.body.addEventListener("submit", (e) => {
        if (e.target.id === "formAgregarProducto") {
          e.preventDefault()
          this.enviarFormulario(e, "agregar")
        } else if (e.target.id === "formEditarProducto") {
          e.preventDefault()
          this.enviarFormulario(e, "editar")
        } else if (e.target.id === "formEliminarProducto") {
          e.preventDefault()
          this.enviarFormulario(e, "eliminar")
        }
      })

      console.log("✅ Event listeners configurados con delegación")
    }

    mostrarDetallesProducto(btn) {
      const datos = btn.dataset
      console.log("📋 Mostrando detalles del producto:", datos.nombre)

      // Llenar campos del modal VER
      this.setElementText("verCodigo", datos.codigo)
      this.setElementText("verNombre", datos.nombre)
      this.setElementText("verDescripcion", datos.descripcion)
      this.setElementText("verCategoria", datos.categoria)
      this.setElementText("verMateria", datos.materia)
      this.setElementText("verPeso", datos.peso)
      this.setElementText("verStock", datos.stock)
      this.setElementText("verUbicacion", datos.ubicacion)

      // Manejar imagen
      const imgElement = document.getElementById("verImagen")
      const sinImagenElement = document.getElementById("sinImagen")

      if (datos.imagen && datos.imagen.trim() !== "") {
        imgElement.src = `./img/${datos.imagen}?v=${Date.now()}`
        imgElement.style.display = "block"
        sinImagenElement.style.display = "none"
      } else {
        imgElement.style.display = "none"
        sinImagenElement.style.display = "block"
      }

      console.log("✅ Detalles del producto cargados")
    }

    cargarDatosEdicion(btn) {
      const datos = btn.dataset
      console.log("📝 Cargando datos para edición:", datos.nombre)

      // Llenar campos del modal EDITAR
      this.setElementValue("editarId", datos.id)
      this.setElementValue("editarCodigo", datos.codigo)
      this.setElementValue("editarNombre", datos.nombre)
      this.setElementValue("editarDescripcion", datos.descripcion)
      this.setElementValue("editarMateria", datos.materia)
      this.setElementValue("editarPeso", datos.peso)
      this.setElementValue("editarStock", datos.stock)
      this.setElementValue("editarUbicacion", datos.ubicacion)
      this.setElementValue("editarCategoria", datos.categoriaId)

      // Limpiar el input de imagen
      const inputImagen = document.getElementById("editarImagen")
      if (inputImagen) {
        inputImagen.value = ""
      }

      // Mostrar nombre de imagen actual
      this.setElementText("nombreImagenActual", datos.imagen || "Sin imagen")

      console.log("✅ Datos de edición cargados")
    }

    prepararEliminacion(btn) {
      const datos = btn.dataset
      console.log("🗑️ Preparando eliminación:", datos.nombre)

      this.setElementValue("eliminarId", datos.id)
      this.setElementText("eliminarNombreProducto", datos.nombre)

      console.log("✅ Datos de eliminación preparados")
    }

    async enviarFormulario(e, tipo) {
      const form = e.target
      const formData = new FormData(form)
      const submitBtn = form.querySelector('button[type="submit"]')
      const originalBtnText = submitBtn.innerHTML

      try {
        // Deshabilitar botón y mostrar loading
        submitBtn.disabled = true
        submitBtn.innerHTML = `
          <span class="spinner-border spinner-border-sm me-2" role="status"></span>
          ${tipo === "agregar" ? "Agregando..." : tipo === "editar" ? "Guardando..." : "Eliminando..."}
        `

        console.log(`📤 Enviando formulario ${tipo}...`)
        console.log("📋 Datos del formulario:", Object.fromEntries(formData.entries()))

        const response = await fetch(form.action, {
          method: "POST",
          body: formData,
        })

        console.log(`📡 Respuesta del servidor:`, response.status, response.statusText)

        if (!response.ok) {
          throw new Error(`Error HTTP: ${response.status} - ${response.statusText}`)
        }

        const responseText = await response.text()
        console.log(`📄 Respuesta cruda:`, responseText)

        let result
        try {
          result = JSON.parse(responseText)
        } catch (parseError) {
          console.error("❌ Error al parsear JSON:", parseError)
          console.log("📄 Respuesta no JSON:", responseText)
          throw new Error("Respuesta del servidor no válida")
        }

        console.log(`✅ Respuesta parseada:`, result)

        if (result.success) {
          this.mostrarMensaje(result.message, "success")
          this.cerrarModal(form)

          if (tipo === "agregar") {
            form.reset()
          }

          // Recargar página completa para asegurar actualización
          setTimeout(() => {
            window.location.reload()
          }, 1000)

          // Timeout de seguridad: si después de 10 segundos sigue cargando, recargar página
          setTimeout(() => {
            const loadingElement = document.querySelector('tbody td:contains("Actualizando productos...")')
            if (loadingElement || document.querySelector(".spinner-border")) {
              console.log("⚠️ Timeout de actualización, recargando página...")
              window.location.reload()
            }
          }, 10000)
        } else {
          throw new Error(result.message || "Error desconocido")
        }
      } catch (error) {
        console.error(`❌ Error en ${tipo}:`, error)
        this.mostrarMensaje(`Error al ${tipo} el producto: ${error.message}`, "danger")
      } finally {
        // Restaurar botón
        submitBtn.disabled = false
        submitBtn.innerHTML = originalBtnText
      }
    }

    cerrarModal(form) {
      const modal = window.bootstrap.Modal.getInstance(form.closest(".modal"))
      if (modal) {
        modal.hide()
      }
    }

    async actualizarTabla() {
      try {
        console.log("🔄 Actualizando tabla...")

        const tbody = document.querySelector("table tbody")
        if (!tbody) {
          console.error("❌ No se encontró tbody")
          return
        }

        // Mostrar loading
        tbody.innerHTML = `
          <tr>
            <td colspan="11" class="text-center py-4">
              <div class="spinner-border spinner-border-sm me-2" role="status"></div>
              Actualizando productos...
            </td>
          </tr>
        `

        // Agregar timestamp para evitar caché
        const url = window.location.href.split("?")[0] + "?refresh=" + Date.now()
        console.log("📡 Fetching:", url)

        const response = await fetch(url, {
          method: "GET",
          headers: {
            "Cache-Control": "no-cache",
            Pragma: "no-cache",
          },
        })

        if (!response.ok) {
          throw new Error(`Error HTTP: ${response.status}`)
        }

        const html = await response.text()
        console.log("📄 HTML recibido, longitud:", html.length)

        const parser = new DOMParser()
        const doc = parser.parseFromString(html, "text/html")
        const nuevaTabla = doc.querySelector("table tbody")

        if (nuevaTabla && nuevaTabla.innerHTML.trim()) {
          tbody.innerHTML = nuevaTabla.innerHTML
          console.log("✅ Tabla actualizada correctamente")
        } else {
          console.error("❌ No se encontró contenido válido en la nueva tabla")
          // Fallback: recargar la página
          window.location.reload()
        }
      } catch (error) {
        console.error("❌ Error al actualizar tabla:", error)

        // En caso de error, recargar la página completa
        console.log("🔄 Recargando página como fallback...")
        window.location.reload()
      }
    }

    mostrarMensaje(mensaje, tipo = "info") {
      // Remover alertas anteriores
      document.querySelectorAll(".alert-flotante").forEach((el) => el.remove())

      const alert = document.createElement("div")
      alert.className = `alert alert-${tipo} alert-dismissible fade show position-fixed alert-flotante`
      alert.style.cssText = `
        top: 20px; 
        right: 20px; 
        z-index: 9999; 
        min-width: 350px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border: none;
      `

      const iconos = {
        success: '<i class="bi bi-check-circle-fill me-2"></i>',
        danger: '<i class="bi bi-exclamation-triangle-fill me-2"></i>',
        warning: '<i class="bi bi-exclamation-circle-fill me-2"></i>',
        info: '<i class="bi bi-info-circle-fill me-2"></i>',
      }

      alert.innerHTML = `
        <div class="d-flex align-items-center">
          ${iconos[tipo] || iconos.info}
          <div class="flex-grow-1">${mensaje}</div>
          <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
        </div>
      `

      document.body.appendChild(alert)

      // Auto-remover
      setTimeout(() => {
        if (alert.parentNode) {
          alert.classList.remove("show")
          setTimeout(() => alert.remove(), 150)
        }
      }, 5000)
    }

    // Métodos auxiliares
    setElementText(id, value) {
      const element = document.getElementById(id)
      if (element) element.textContent = value || "-"
    }

    setElementValue(id, value) {
      const element = document.getElementById(id)
      if (element) element.value = value || ""
    }
  }

  // Inicializar cuando el DOM esté listo
  function inicializarProductos() {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => {
        window.productosManager = new ProductosManager()
      })
    } else {
      window.productosManager = new ProductosManager()
    }
  }

  inicializarProductos()
}
