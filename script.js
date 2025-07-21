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
        fetch(`modulos/${page}.html`)
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
    fetch('modulos/inicio.html')
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

        fetch(`modulos/${page}.html`)
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
