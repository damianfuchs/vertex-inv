const menu = document.getElementById('menu');
const sidebar = document.getElementById('sidebar');
const main = document.getElementById('main');

menu.addEventListener('click', (e) => {
    e.stopPropagation(); // Evita que se dispare el evento de cierre
    sidebar.classList.toggle('menu-toggle');
    menu.classList.toggle('menu-toggle');
    main.classList.toggle('menu-toggle');
});

// Muestra los módulos
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



document.addEventListener('submit', function(e) {
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
