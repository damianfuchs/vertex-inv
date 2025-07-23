-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-07-2025 a las 23:34:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vertex_inv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categ` int(11) NOT NULL,
  `codigo_categ` varchar(50) NOT NULL,
  `nombre_categ` varchar(100) NOT NULL,
  `descripcion_categ` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categ`, `codigo_categ`, `nombre_categ`, `descripcion_categ`) VALUES
(6, 'CAT001', 'Electrónica', 'Categoría de productos electrónicos como celulares, computadoras, etc.'),
(7, 'CAT002', 'Ropa', 'Categoría de prendas de vestir para hombres y mujeres.'),
(8, 'CAT003', 'Alimentos', 'Categoría que incluye alimentos y bebidas.'),
(9, 'CAT004', 'Hogar', 'Productos relacionados con muebles y decoración del hogar.'),
(26, 'CAT1100', 'Dsada', 'dsada'),
(36, 'PRU123', 'Prueba', 'Prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_prod` int(11) NOT NULL,
  `codigo_prod` varchar(100) NOT NULL,
  `nombre_prod` varchar(300) NOT NULL,
  `descripcion_prod` varchar(500) NOT NULL,
  `materia_prod` varchar(300) NOT NULL,
  `stock_prod` int(11) NOT NULL,
  `ubicacion_prod` int(11) NOT NULL,
  `peso_prod` double NOT NULL,
  `imagen_prod` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_prod`, `codigo_prod`, `nombre_prod`, `descripcion_prod`, `materia_prod`, `stock_prod`, `ubicacion_prod`, `peso_prod`, `imagen_prod`, `categoria_id`) VALUES
(3, 'A0001', 'Silla de Oficina', 'Silla ergonómica con respaldo', 'Plástico y Metal', 20, 0, 7.5, 'bisagra.png', NULL),
(13, 'A0001', 'Silla Oficina', 'Silla ergonómica para oficina', 'Plástico y metal', 12, 101, 7.5, NULL, NULL),
(14, 'B0002', 'Mesa Comedor', 'Mesa de comedor rectangular', 'Madera maciza', 5, 102, 15, NULL, NULL),
(15, 'C0003', 'Lámpara LED', 'Lámpara de escritorio LED', 'Metal y plástico', 20, 103, 2.2, NULL, NULL),
(18, 'X1', 'Silla Gamer', 'Silla gamer ergonómica con soporte lumbar', 'Cuero sintético y metal', 8, 205, 12.5, 'bisagra.png', 9),
(35, 'ALB001', 'Marco de Ventana', 'Marco de aluminio para ventana corrediza', 'Aluminio', 50, 0, 4.5, 'bisagranegra.jpg', 6),
(36, 'ALB002', 'Puerta Ventana', 'Puerta ventana de aluminio con vidrio templado', 'Aluminio y vidrio', 20, 0, 12, 'bisagranegra.jpg', 26),
(37, 'ALB003', 'Cerradura para Puerta', 'Cerradura de aluminio para puerta corrediza', 'Aluminio', 100, 0, 1.2, 'bisagranegra.jpg', 8),
(38, 'ALB004', 'Bisagra para Ventana', 'Bisagra resistente para ventanas de aluminio', 'Aluminio', 150, 0, 0.3, 'bisagranegra.jpg', 9),
(39, 'ALB005', 'Perfil de Aluminio U', 'Perfil en forma de U para estructuras de ventana', 'Aluminio', 80, 0, 3, 'bisagranegra.jpg', 9),
(40, 'ALB00', 'Jaladera para Puerta', 'Jaladera de aluminio anodizado para puertas', 'Aluminio', 60, 0, 0.5, '', 7),
(41, 'ALB007', 'Sellador de Goma', 'Sellador de goma para juntas de ventanas', 'Goma', 200, 0, 0.2, 'bisagranegra.jpg', 26),
(42, 'ALB008', 'Marco Reforzado', 'Marco reforzado para puertas corredizas de aluminio', 'Aluminio', 30, 0, 6, 'bisagranegra.jpg', 8),
(43, 'ALB009', 'Guía Inferior', 'Guía inferior para ventana corrediza', 'Aluminio', 70, 0, 1, '', 9),
(44, 'ALB010', 'Riel Superior', 'Riel superior para puertas corredizas', 'Aluminio', 40, 0, 2.5, 'bisagranegra.jpg', 7),
(45, 'ALB011', 'Vidrio Templado', 'Vidrio templado de 6mm para ventanas y puertas', 'Vidrio', 25, 0, 15, '', 26),
(46, 'ALB012', 'Tornillos para Aluminio', 'Set de tornillos especiales para aberturas de aluminio', 'Metal', 500, 0, 0.1, 'bisagranegra.jpg', 8),
(47, 'ALB013', 'Marco Angular', 'Marco angular para refuerzo de ventanas', 'Aluminio', 35, 0, 4.2, 'bisagranegra.jpg', 8),
(48, 'ALB014', 'Junta de Espuma', 'Junta de espuma para aislamiento térmico', 'Espuma', 180, 0, 0.3, 'bisagranegra.jpg', 26),
(49, 'ALB015', 'Cierre de Seguridad', 'Cierre de seguridad para puertas de aluminio', 'Aluminio', 45, 0, 1.8, 'bisagranegra.jpg', 9),
(51, '1234', 'dsadasda', 'dsadsadsa', 'dsadasdas', 123, 213, 123, 'KID.jpg', 36);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categ`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_prod`),
  ADD KEY `fk_categoria` (`categoria_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id_categ`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
