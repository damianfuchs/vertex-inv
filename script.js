const menu = document.getElementById('menu');
const sidebar = document.getElementById('sidebar');
const main = document.getElementById('main');

menu.addEventListener('click', (e) => {
    e.stopPropagation(); // Evita que se dispare el evento de cierre
    sidebar.classList.toggle('menu-toggle');
    menu.classList.toggle('menu-toggle');
    main.classList.toggle('menu-toggle');
});

// Función para asignar eventos a botones dentro del main, con delegación para botones Ver
function asignarEventosBotones() {
    // Escucha click dentro de main solo una vez (para no duplicar escuchas, mejor remover antes)
    main.removeEventListener('click', manejarClickBotones); // eliminamos posible listener previo
    main.addEventListener('click', manejarClickBotones);
}



function manejarClickBotones(e) {
    // Botón Ver
    const btnVer = e.target.closest('button[data-bs-toggle="modal"][data-bs-target="#modalVer"]');
    if (btnVer) {
        document.getElementById('verCodigo').textContent = btnVer.dataset.codigo || '';
        document.getElementById('verNombre').textContent = btnVer.dataset.nombre || '';
        document.getElementById('verDescripcion').textContent = btnVer.dataset.descripcion || '';
        document.getElementById('verCategoria').textContent = btnVer.dataset.categoria || '';
        document.getElementById('verMateria').textContent = btnVer.dataset.materia || '';
        document.getElementById('verPeso').textContent = btnVer.dataset.peso || '';
        document.getElementById('verStock').textContent = btnVer.dataset.stock || '';
        document.getElementById('verUbicacion').textContent = btnVer.dataset.ubicacion || '';

        const rutaImagen = btnVer.dataset.imagen ? `img/${btnVer.dataset.imagen}` : 'img/sinimagen.jpg';
        document.getElementById('verImagen').src = rutaImagen;
        return;
    }

    // Botón Editar
    const btnEditar = e.target.closest('button[data-bs-toggle="modal"][data-bs-target="#modalEditar"]');
    if (btnEditar) {
        document.getElementById('editarId').value = btnEditar.dataset.id || '';
        document.getElementById('editarCodigo').value = btnEditar.dataset.codigo || '';
        document.getElementById('editarNombre').value = btnEditar.dataset.nombre || '';
        document.getElementById('editarDescripcion').value = btnEditar.dataset.descripcion || '';
        document.getElementById('editarCategoria').value = btnEditar.dataset.categoriaid || '';
        document.getElementById('editarMateria').value = btnEditar.dataset.materia || '';
        document.getElementById('editarPeso').value = btnEditar.dataset.peso || '';
        document.getElementById('editarStock').value = btnEditar.dataset.stock || '';
        document.getElementById('editarUbicacion').value = btnEditar.dataset.ubicacion || '';

        // Mostrar nombre de imagen actual en un span o texto (no en input file)
        document.getElementById('nombreImagenActual').textContent = btnEditar.dataset.imagen || 'Sin imagen';
        return;
    }

    // Botón Eliminar
    const btnEliminar = e.target.closest('button[data-bs-toggle="modal"][data-bs-target="#modalEliminar"]');
    if (btnEliminar) {
        document.getElementById('eliminarId').value = btnEliminar.dataset.id || '';
        return;
    }
}



// Agregá el listener al documento para capturar clicks en los botones
document.addEventListener('click', manejarClickBotones);
// --------------------------------------------------------





// Muestra los módulos-------------------------------------------------------
const sidebarLinks = document.querySelectorAll('.sidebar a');

sidebarLinks.forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();

        // Eliminar clase 'selected' de todos los links
        sidebarLinks.forEach(item => item.classList.remove('selected'));
        this.classList.add('selected');

        // Obtener nombre de la página a cargar
        const page = this.getAttribute('data-page');

        // Cargar el archivo HTML correspondiente en el <main>
        fetch(`modulos/${page}.php`)
            .then(response => response.text())
            .then(html => {
                main.innerHTML = html;

                // Asignar eventos a botones del contenido nuevo
                asignarEventosBotones();
            })
            .catch(error => {
                main.innerHTML = `<p>Error al cargar la sección: ${page}</p>`;
                console.error('Error cargando contenido:', error);
            });

        // Cerrar el sidebar después de hacer clic en un link
        sidebar.classList.remove('menu-toggle');
        menu.classList.remove('menu-toggle');
        main.classList.remove('menu-toggle');
    });
});

// Cierra el sidebar al hacer clic fuera de él y del botón de menú
document.addEventListener('click', (e) => {
    const isClickInsideSidebar = sidebar.contains(e.target);
    const isClickOnMenu = menu.contains(e.target);

    if (!isClickInsideSidebar && !isClickOnMenu) {
        sidebar.classList.remove('menu-toggle');
        menu.classList.remove('menu-toggle');
        main.classList.remove('menu-toggle');
    }
});

// Al recargar la página, cargar inicio.html por defecto
window.addEventListener('DOMContentLoaded', () => {
    fetch('modulos/inicio.php')
        .then(response => response.text())
        .then(html => {
            main.innerHTML = html;

            // Asignar eventos a botones del contenido cargado
            asignarEventosBotones();

            // Opcional: marcar como "seleccionado" el botón de Inicio
            sidebarLinks.forEach(link => {
                if (link.getAttribute('data-page') === 'inicio') {
                    link.classList.add('selected');
                } else {
                    link.classList.remove('selected');
                }
            });
        })
        .catch(error => {
            main.innerHTML = `<p>Error al cargar inicio.html</p>`;
            console.error('Error al cargar inicio.html:', error);
        });
});








// Delegación para tarjetas dentro del main que usen data-page (como Productos, Proveedores, etc.)
main.addEventListener('click', function (e) {
    const card = e.target.closest('.card-inventario');
    if (card && card.dataset.page) {
        const page = card.dataset.page;

        fetch(`modulos/${page}.php`)
            .then(response => response.text())
            .then(html => {
                main.innerHTML = html;

                // Asignar eventos a botones del contenido nuevo
                asignarEventosBotones();

                // Opcional: marcar el enlace del sidebar correspondiente como seleccionado
                sidebarLinks.forEach(link => {
                    if (link.getAttribute('data-page') === page) {
                        link.classList.add('selected');
                    } else {
                        link.classList.remove('selected');
                    }
                });
            })
            .catch(error => {
                main.innerHTML = `<p>Error al cargar la sección: ${page}</p>`;
                console.error('Error cargando tarjeta:', error);
            });
    }
});

document.addEventListener('submit', function (e) {
    if (e.target && e.target.id === 'formAgregarCategoria') {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch('modulos/agregar_categoria.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Categoría agregada con éxito');
                    // Opcional: cerrar modal y recargar listado categorías
                    form.reset();
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregarCategoria'));
                    modal.hide();

                    // Recargar tabla categorías llamando al módulo o hacer fetch para actualizar tabla
                    // Por ejemplo:
                    fetch('modulos/categorias.php')
                        .then(r => r.text())
                        .then(html => {
                            main.innerHTML = html;

                            // Asignar eventos a botones si tiene
                            asignarEventosBotones();
                        });
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al agregar categoría');
            });
    }
});



// EDITAR PRODUCTO
function enviarFormulario(event) {
  event.preventDefault();

  const form = event.target;
  const formData = new FormData(form);

  fetch(form.action, {
    method: form.method,
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    console.log('Respuesta del servidor:', data);

    // Mostrar mensaje de éxito
    const mensaje = document.getElementById('mensajeExito');
    mensaje.style.display = 'block';

    // Ocultar el mensaje a los 3 segundos
    setTimeout(() => {
      mensaje.style.display = 'none';
    }, 3000);

    // ✅ Cerrar el modal después de 2 segundos
    setTimeout(() => {
      const modalElement = document.getElementById('modalEditar'); // cambialo si el ID es otro
      const modal = bootstrap.Modal.getInstance(modalElement);
      if (modal) {
        modal.hide();
      }

      // ✅ Resetear el formulario
      form.reset();
    }, 2000);

    // Opcional: actualizar la tabla aquí si querés después de cerrar
    // setTimeout(cargarProductos, 2500);
  })
  .catch(error => {
    console.error('Error:', error);
  });

  return false;
}




// AGREGAR PRODUCTO

function enviarAgregarProducto(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: form.method,
        body: formData
    })
    .then(response => response.text())  // o response.json() si devolvés JSON
    .then(data => {
        console.log('Respuesta del servidor:', data);

        const mensaje = document.getElementById('mensajeAgregarExito');
        mensaje.style.display = 'block';

        form.reset();

        setTimeout(() => {
            mensaje.style.display = 'none';
        }, 3000);

        // Opcional: cerrar modal después de 3 segundos
        // const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregar'));
        // modal.hide();

        // Opcional: actualizar tabla productos aquí si querés
    })
    .catch(error => {
        console.error('Error al agregar producto:', error);
        alert('Error al agregar producto');
    });

    return false;
}



// ELIMINAR PRODUCTO

document.addEventListener('DOMContentLoaded', () => {
    const modalEliminar = document.getElementById('modalEliminar');
    const formEliminar = document.getElementById('formEliminar');
    const inputEliminar = document.getElementById('eliminarId');
    const bsModalEliminar = bootstrap.Modal.getOrCreateInstance(modalEliminar);

    // Cargar ID en input cuando se abre el modal
    modalEliminar.addEventListener('show.bs.modal', (e) => {
        const button = e.relatedTarget;
        const id = button.getAttribute('data-id');
        inputEliminar.value = id;
    });

    // Interceptar envío del formulario
    formEliminar.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('id_prod', inputEliminar.value);

        fetch('modulos/eliminar_producto.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') {
                // Cierra el modal
                bsModalEliminar.hide();

                // Mostrar mensaje (podés reemplazar por toast)
                alert('Producto eliminado con éxito');

                // Recargar la tabla o la página
                location.reload();
            } else {
                alert('Error al eliminar el producto');
            }
        })
        .catch(err => {
            console.error('Error:', err);
        });
    });
});


