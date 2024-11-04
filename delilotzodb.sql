-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-11-2024 a las 23:08:05
-- Versión del servidor: 10.11.9-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u364272907_pedidoslotzo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_de_productos`
--

CREATE TABLE `categorias_de_productos` (
  `id` mediumint(5) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `adicion` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_de_productos`
--

INSERT INTO `categorias_de_productos` (`id`, `nombre`, `adicion`) VALUES
(1, 'Hamburguesas', 1),
(2, 'Perros', 1),
(3, 'Perras ', 1),
(4, 'Chuzos', 1),
(5, 'Papas Fritas ', 1),
(6, 'Adiciones ', 0),
(7, 'Bebidas Azucaradas ', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_de_pedido`
--

CREATE TABLE `detalles_de_pedido` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `producto` varchar(50) NOT NULL,
  `salsas` varchar(1000) NOT NULL,
  `cantidad` mediumint(5) NOT NULL,
  `valor_producto` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `direccion_entrega` text NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `valor_total` decimal(10,0) NOT NULL,
  `pagado` tinyint(1) NOT NULL,
  `recoger` tinyint(1) NOT NULL,
  `excedente` decimal(10,2) DEFAULT NULL,
  `observacion_texto` text DEFAULT NULL,
  `suma_valores` decimal(10,2) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` bigint(10) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_categoria` mediumint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `descripcion`, `id_categoria`) VALUES
(1, 'Hamburguesa Especial', 16000, 'Queso , Tocineta premium , Carne tradicional , Tomate , ensalada de la casa ,Ripio de papa.', 1),
(2, 'Hamburguesa Súper', 22000, 'Doble Queso , Doble Tocineta premium  , Doble Carne tradicional , Tomate , ensalada de la casa ,Ripio de papá.', 1),
(3, 'Hamburguesa Lotzo', 25000, 'Doble queso , Carne Artesanal  150g , Tocineta premium , Pan Artesanal , ensalada de la casa , tomate , Ripio de papa y salsas de la casa.', 1),
(4, 'Perro Pequeño', 13000, 'Queso , Tocineta premium  ,salchicha , ensalada de la casa  y Ripio de papa.', 2),
(5, 'Perro Grande ', 16000, 'Queso , Tocineta premium  ,salchicha , ensalada de la casa  y Ripio de papa.', 2),
(6, 'Perro Súper', 19000, 'Doble Queso , Doble Tocineta premium  ,salchicha , ensalada de la casa  y Ripio de papa.', 2),
(7, 'Perro Lotzo', 21000, 'Doble  Queso , Doble Tocineta premium  ,salchicha Premium americana  , ensalada de la casa  y Ripio de papa.', 2),
(8, 'Perra Grande', 17000, 'Doble Queso , Doble Tocineta premium  , , ensalada de la casa  y Ripio de papa.', 3),
(9, 'Chuzo de pollo', 21000, 'acompañado de papas a la francesa o Cascos , arepa con queso y ensalada de la casa.', 4),
(10, 'Chuzo de Cerdo', 21000, 'Acompañado de papas a la francesa o Cascos , arepa con queso y ensalada de la casa', 4),
(11, 'Porción de Papas ', 6000, 'Papas a La Francesa ', 5),
(13, 'Carne Tradicional ', 5000, 'Carne Tradicional 90 G', 6),
(14, 'Carne Lotzo', 10000, 'Carne artesanal 100% RES de 150 G', 6),
(16, 'Salchicha Lotzo ', 5000, 'Salchicha Americana', 6),
(17, 'Tocineta ', 4000, 'Tocineta Premium ', 6),
(18, 'Queso', 5000, 'Queso al bañaria', 6),
(19, 'Ensalada ', 6000, 'Ensalada de la casa ', 6),
(21, 'CocaCola personal ', 4000, 'Cocacola Pet', 7),
(22, 'Cocacola Litro 1.5', 8000, 'litro y cuarto ', 7),
(23, 'Cuatro personal', 4000, 'Gaseosa 400 ml', 7),
(24, 'Cuatro Litro 1.5', 8000, 'Cuatro 1.5', 7),
(25, 'Premio Personal', 4000, 'premio pet', 7),
(26, 'Premio Litro 1.5', 8000, 'Bebida', 7),
(27, 'Sprite personal', 4000, 'Bebida', 7),
(28, 'Sprite litro 1.5', 8000, 'Bebida', 7),
(29, 'Coca Cola Zero litro 1.5', 8000, 'Bebida', 7),
(30, 'Coca Cola Zero personal', 4000, 'Bebida', 7),
(31, 'DelValle litro 1.5 Naranja', 8000, 'Bebida', 7),
(32, 'DelValle personal naranja', 4000, 'Bebida', 7),
(33, 'DelValle mango personal', 4000, 'Bebida', 7),
(34, 'DelValle mango fresa Personal', 4000, 'Bebida', 7),
(35, 'Delvalle Salpicon Personal', 4000, 'Bebida', 7),
(36, 'DelValle piña mandarina Personal', 4000, 'Bebida', 7),
(37, 'DelValle mora Personal', 4000, 'Bebida', 7),
(38, 'Agua Brisa Lima Limon personal', 4000, 'Bebida', 7),
(39, 'Agua Brisa Manzana personal', 4000, 'Bebida', 7),
(40, 'Agua Brisa Maracuyá Personal', 4000, 'Agua ', 7),
(41, 'Agua Brisa Personal', 4000, 'Agua ', 7),
(42, 'Fuze tea Limon Personal', 4000, 'Tea', 7),
(43, 'Fuze Tea Durazno Personal', 4000, 'Tea', 7),
(44, 'Fuze Tea Mango Mazanilla Personal', 4000, 'Tea', 7),
(45, 'Fuze Tea Manzana Personal', 4000, 'Tea', 7),
(46, 'Soda Schweppes Personal ', 4000, 'Soda', 7),
(47, 'Cool Drink Mangostino Personal', 4000, 'Soda', 7),
(48, 'Cool Drink Maracuya Personal', 4000, 'Soda', 7),
(49, 'Cool Drink Granada Personal ', 4000, 'Soda', 7),
(50, 'Cool Drink Manzana Verde Personal', 4000, 'Soda', 7),
(51, 'Cool Drink Kiwi Personal', 4000, 'Soda', 7),
(55, 'tomas', 4502, 'asdasd', 8),
(56, 'asdasd', 4500, 'asdasd', 9),
(57, 'asdasd', 455, 'asdasd', 9),
(58, 'asdasd', 480, 'io', 8),
(59, 'aceite', 2500, 'asdasd', 8),
(60, 'Salchicha Tradicional ', 3000, 'salchicha tradicional ', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumen_pedidos`
--

CREATE TABLE `resumen_pedidos` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `suma_total` int(11) NOT NULL DEFAULT 0,
  `cantidad_pedidos` int(11) DEFAULT NULL,
  `suma_total_con_excedente` int(11) NOT NULL DEFAULT 0,
  `suma_total_sin_excedente` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` tinyint(2) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contrasena` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contrasena`) VALUES
(1, 'admin_1', 'admin125');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias_de_productos`
--
ALTER TABLE `categorias_de_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_de_pedido`
--
ALTER TABLE `detalles_de_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`producto`),
  ADD KEY `detalles_de_pedido_ibfk_1` (`id_pedido`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `resumen_pedidos`
--
ALTER TABLE `resumen_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias_de_productos`
--
ALTER TABLE `categorias_de_productos`
  MODIFY `id` mediumint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalles_de_pedido`
--
ALTER TABLE `detalles_de_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `resumen_pedidos`
--
ALTER TABLE `resumen_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
