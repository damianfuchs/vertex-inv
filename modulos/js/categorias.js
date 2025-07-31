console.log("🚀 Módulo categorias.js cargado - VERSIÓN CORREGIDA v2.2")

// Solo ejecutar si estamos en la página de categorías
function esCategorias() {
  return (
    document.querySelector("#modalEditarCategoria") !== null ||
    document.querySelector("#modalAgregarCategoria") !== null ||
    document.querySelector("#tablaCategorias") !== null
  )
}

if (!esCategorias()) {
  console.log("⚠️ No estamos en la página de categorías")
} else {
  console.log("✅ Página de categorías detectada, inicializando...")

  // Prevenir múltiples inicializaciones
  if (window.categoriasManagerLoaded) {
    console.log("⚠️ CategoriasManager ya está cargado, evitando duplicación")
  } else {
    window.categoriasManagerLoaded = true

    // Funcionalidad específica para la página de categorías
    class CategoriasManager {
      constructor() {
        this.isInitialized = false
        this.init()
      }

      init() {
        if (this.isInitialized) {
          console.log("⚠️ CategoriasManager ya inicializado")
          return
        }

        console.log("✅ CategoriasManager inicializando...")
        this.setupEventListeners()
        this.isInitialized = true
        console.log("✅ CategoriasManager inicializado correctamente")
      }

      setupEventListeners() {
        console.log("🔧 Configurando event listeners...")

        // Usar delegación de eventos para evitar problemas de timing
        document.body.addEventListener("click", (e) => {
          // Modal Editar Categoría
          if (e.target.closest(".btn-editar")) {
            const btn = e.target.closest(".btn-editar")
            console.log("✏️ Abriendo modal editar categoría")
            this.cargarDatosEdicion(btn)
          }

          // Modal Eliminar Categoría
          if (e.target.closest(".btn-eliminar")) {
            const btn = e.target.closest(".btn-eliminar")
            console.log("🗑️ Abriendo modal eliminar categoría")
            this.prepararEliminacion(btn)
          }
        })

        // Formularios con delegación de eventos
        document.body.addEventListener("submit", (e) => {
          console.log("📝 Submit detectado en:", e.target.id || e.target.className)

          if (e.target.id === "formAgregarCategoria") {
            console.log("🟢 Formulario AGREGAR detectado")
            e.preventDefault()
            this.enviarFormulario(e, "agregar")
          } else if (e.target.closest("#modalEditarCategoria") && e.target.tagName === "FORM") {
            console.log("🟡 Formulario EDITAR detectado")
            e.preventDefault()
            this.enviarFormulario(e, "editar")
          } else if (e.target.id === "formEliminarCategoria") {
            console.log("🔴 Formulario ELIMINAR detectado")
            e.preventDefault()
            this.enviarFormulario(e, "eliminar")
          }
        })

        console.log("✅ Event listeners configurados con delegación")
      }

      cargarDatosEdicion(btn) {
        const fila = btn.closest("tr")
        if (!fila) return

        const datos = fila.dataset
        console.log("📝 Cargando datos para edición:", datos.nombre)

        // Llenar campos del modal EDITAR
        this.setElementValue("editId", datos.id)
        this.setElementValue("editCodigo", datos.codigo)
        this.setElementValue("editNombre", datos.nombre)
        this.setElementValue("editDescripcion", datos.descripcion)

        // Mostrar el modal
        const modalElement = document.getElementById("modalEditarCategoria")
        if (modalElement && window.bootstrap) {
          const modal = window.bootstrap.Modal.getOrCreateInstance(modalElement)
          modal.show()
        }

        console.log("✅ Datos de edición cargados")
      }

      prepararEliminacion(btn) {
        const id = btn.getAttribute("data-id")
        console.log("🗑️ Preparando eliminación de categoría ID:", id)

        this.setElementValue("deleteCategoriaId", id)

        console.log("✅ Datos de eliminación preparados")
      }

      async enviarFormulario(e, tipo) {
        const form = e.target
        const formData = new FormData(form)
        const submitBtn = form.querySelector('button[type="submit"]')
        const originalBtnText = submitBtn.innerHTML

        try {
          submitBtn.disabled = true
          submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
            ${tipo === "agregar" ? "Agregando..." : tipo === "editar" ? "Guardando..." : "Eliminando..."}
          `

          const response = await fetch(form.action, {
            method: "POST",
            body: formData,
          })

          if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status} - ${response.statusText}`)
          }

          const responseText = await response.text()

          let result
          try {
            result = JSON.parse(responseText)

            if (result.success) {
              // Aquí llamamos a mostrarMensaje para mostrar el cartel
              this.mostrarMensaje(result.message, "success")
              this.cerrarModal(form)

              if (tipo === "agregar") {
                form.reset()
              }

              setTimeout(() => {
                window.location.reload()
              }, 1500)
            } else {
              throw new Error(result.message || "Error desconocido")
            }
          } catch {
            // Si no es JSON válido igual mostrar mensaje genérico
            this.mostrarMensaje(
              `Categoría ${tipo === "agregar" ? "agregada" : tipo === "editar" ? "editada" : "eliminada"} correctamente`,
              "success"
            )
            this.cerrarModal(form)

            if (tipo === "agregar") {
              form.reset()
            }

            setTimeout(() => {
              window.location.reload()
            }, 1500)
          }
        } catch (error) {
          this.mostrarMensaje(`Error al ${tipo} la categoría: ${error.message}`, "danger")
        } finally {
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
          animation: slideIn 0.3s ease-out;
        `

        // Agregar animación CSS si no existe
        if (!document.querySelector("style[data-alerts]")) {
          const style = document.createElement("style")
          style.setAttribute("data-alerts", "true")
          style.textContent = `
            @keyframes slideIn {
              from { transform: translateX(100%); opacity: 0; }
              to { transform: translateX(0); opacity: 1; }
            }
          `
          document.head.appendChild(style)
        }

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

        // Auto-remover después de 4 segundos
        setTimeout(() => {
          if (alert.parentNode) {
            alert.classList.remove("show")
            setTimeout(() => alert.remove(), 150)
          }
        }, 4000)
      }

      // Métodos auxiliares
      setElementValue(id, value) {
        const element = document.getElementById(id)
        if (element) {
          element.value = value || ""
        } else {
          console.warn(`⚠️ Elemento ${id} no encontrado`)
        }
      }
    }

    // Inicializar cuando el DOM esté listo
    function inicializarCategorias() {
      if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", () => {
          window.categoriasManager = new CategoriasManager()
        })
      } else {
        window.categoriasManager = new CategoriasManager()
      }
    }

    inicializarCategorias()
  }
}
