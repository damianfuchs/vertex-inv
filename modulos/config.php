<?php
// Define la URL base de tu aplicación.
// Esta debe ser la ruta desde la raíz de tu dominio web hasta la carpeta principal de tu proyecto (VERTEX-INV).

// IMPORTANTE: Para tu entorno local (XAMPP/WAMP/MAMP), usa la siguiente línea:
define('BASE_URL', '/VERTEX-INV');

// Cuando subas a Hostinger, DEBERÁS CAMBIAR esta línea según cómo lo subas:
// 1. Si subes el CONTENIDO de VERTEX-INV directamente a public_html en Hostinger (lo más común):
//    Tu sitio será http://tudominio.com/
// define('BASE_URL', ''); // O define('BASE_URL', '/');

// 2. Si subes la carpeta VERTEX-INV COMPLETA dentro de public_html en Hostinger:
//    Tu sitio será http://tudominio.com/VERTEX-INV/
// define('BASE_URL', '/VERTEX-INV');

// 3. Si subes la carpeta VERTEX-INV dentro de un SUBDIRECTORIO en public_html (ej. public_html/mi_app/VERTEX-INV/):
//    Tu sitio será http://tudominio.com/mi_app/VERTEX-INV/
// define('BASE_URL', '/mi_app/VERTEX-INV');
?>