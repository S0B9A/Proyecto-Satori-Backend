-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306:3306
-- Tiempo de generación: 13-10-2024 a las 23:22:28
-- Versión del servidor: 8.0.35
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_satoriasiancuisine`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cocina`
--

CREATE TABLE `cocina` (
  `id` int NOT NULL,
  `id_pedido` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `id_estacion` int DEFAULT NULL,
  `estado` enum('En preparación','Listo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combo`
--

CREATE TABLE `combo` (
  `id` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `descripcion` text,
  `categoria` enum('Desayuno','Almuerzo','Navidad') DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `combo`
--

INSERT INTO `combo` (`id`, `nombre`, `precio`, `descripcion`, `categoria`, `imagen`) VALUES
(1, 'Combo Sushi', 25.00, 'Incluye sushi, ramen y té verde', 'Almuerzo', 'https://tb-static.uber.com/prod/image-proc/processed_images/4adbe69e8b11b017269cceac7a6eb832/3ac2b39ad528f8c8c5dc77c59abb683d.jpeg'),
(2, 'Combo Ramen', 20.00, 'Ramen, Bibimbap y té verde', 'Almuerzo', 'https://cdn.loveandlemons.com/wp-content/uploads/2020/03/bibimbap-500x500.jpg'),
(3, 'Combo Dim Sum', 15.00, 'Variedad de dim sum con salsa y ramen', 'Almuerzo', 'https://tb-static.uber.com/prod/image-proc/processed_images/c66ad7d9e224e3962586a64a6eb038d6/c73ecc27d2a9eaa735b1ee95304ba588.jpeg'),
(4, 'Combo Mochi', 10.00, 'Dulces de mochi con bibimbop', 'Desayuno', 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEi6sDFgmOcwtndkuiV26EbU0SRkck1AnJdIq-rchGQpAaI_yWgKPli5jo4H86YjgPBlnHVp-Gf5Wd6VgHF2xuX_5Td5coMX6lNoqD1magYXmn-jHk9urP3V1TKbBdx6J55H-f_lULL3WbUc/s1600/Baozi+de+anko+05.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combos_productos`
--

CREATE TABLE `combos_productos` (
  `id_combo` int NOT NULL,
  `id_producto` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `combos_productos`
--

INSERT INTO `combos_productos` (`id_combo`, `id_producto`) VALUES
(1, 1),
(4, 2),
(1, 3),
(2, 3),
(3, 4),
(3, 5),
(4, 5),
(1, 6),
(2, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estacion`
--

CREATE TABLE `estacion` (
  `id` int NOT NULL,
  `nombre` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `estacion`
--

INSERT INTO `estacion` (`id`, `nombre`) VALUES
(1, 'Estación de Preparación de Arroz'),
(2, 'Estación de Preparación y Corte de Ingredientes'),
(3, 'Estación de Montaje y Enrollado'),
(4, 'Estación de Cocción en Wok'),
(5, 'Estación de Preparación de Sopas y Caldos'),
(6, 'Estación de Preparación de Postres');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estaciones_productos`
--

CREATE TABLE `estaciones_productos` (
  `id_estacion` int NOT NULL,
  `id_producto` int NOT NULL,
  `orden` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `estaciones_productos`
--

INSERT INTO `estaciones_productos` (`id_estacion`, `id_producto`, `orden`) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 3, 1),
(3, 1, 2),
(4, 3, 4),
(5, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_pedidos`
--

CREATE TABLE `historial_pedidos` (
  `id` int NOT NULL,
  `id_pedido` int DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('Pendiente de pago','Aceptada','Preparación','Procesando','Entregada') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ingrediente`
--

INSERT INTO `ingrediente` (`id`, `nombre`) VALUES
(5, 'Alga nori'),
(4, 'Jengibre'),
(2, 'Kimchi'),
(1, 'Salsa de soja'),
(3, 'Tofu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`, `hora_inicio`, `hora_fin`) VALUES
(1, 'Menu de desayuno', '2024-10-10', '2024-12-31', '08:00:00', '20:00:00'),
(2, 'Menu de almuerzo', '2024-06-01', '2024-07-31', '08:00:00', '21:00:00'),
(3, 'Menu de cena', '2024-09-01', '2024-11-30', '08:00:00', '20:00:00'),
(4, 'Menu de entradas', '2024-12-01', '2024-02-28', '08:00:00', '19:00:00'),
(5, 'Menu de Fiestas', '2024-12-20', '2024-12-31', '10:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus_productos`
--

CREATE TABLE `menus_productos` (
  `id_menu` int NOT NULL,
  `id_producto` int NOT NULL,
  `id_combo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `menus_productos`
--

INSERT INTO `menus_productos` (`id_menu`, `id_producto`, `id_combo`) VALUES
(2, 2, NULL),
(1, 1, 1),
(1, 3, 1),
(1, 6, 2),
(4, 4, 2),
(1, 5, 3),
(1, 2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id` int NOT NULL,
  `id_pedido` int DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `metodo_pago` enum('Tarjeta','Efectivo') DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int NOT NULL,
  `id_cliente` int DEFAULT NULL,
  `estado` enum('Pendiente de pago','Aceptada','Preparación','Procesando','Entregada') DEFAULT NULL,
  `metodo_entrega` enum('Domicilio','Recogida') DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_productos`
--

CREATE TABLE `pedidos_productos` (
  `id_pedido` int NOT NULL,
  `id_producto` int NOT NULL,
  `id_combo` int NOT NULL,
  `cantidadCombos` int DEFAULT NULL,
  `cantidadProductos` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `tipo` enum('Japones','Coreano','Chino') DEFAULT NULL,
  `categoria` enum('Entrada','Principal','Postre','Bebida','Sopa') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `tipo`, `categoria`) VALUES
(1, 'Sushi', 'Bocados de arroz con pescado crudo o vegetales', 12.50, 'https://www.oliveradatenea.com/wp-content/uploads/2023/06/Sushi-rolls-de-salmon-y-Olivada-Olivera-dAtenea.jpg', 'Japones', 'Principal'),
(2, 'Bibimbap', 'Arroz mezclado con vegetales, carne y huevo', 10.00, 'https://cdn.stoneline.de/media/3f/12/g0/1727431220/koreanisches-bibimbap.jpeg', 'Coreano', 'Principal'),
(3, 'Ramen', 'Sopa de fideos con caldo y toppings', 9.50, 'https://www.recetas-japonesas.com/base/stock/Recipe/ramen-de-huevo/ramen-de-huevo_web.jpg.webp', 'Japones', 'Sopa'),
(4, 'Dim Sum', 'Bocaditos chinos al vapor rellenos de carne o vegetales', 8.00, 'https://www.sherry.wine/media/images/dim.width-876.jpg', 'Chino', 'Entrada'),
(5, 'Mochi', 'Dulce japonés a base de arroz pegajoso', 4.00, 'https://static01.nyt.com/images/2024/01/24/multimedia/ND-Mochi-hkpl/ND-Mochi-hkpl-superJumbo.jpg', 'Japones', 'Postre'),
(6, 'Té Verde Japonés', 'Un té verde premium de Japón, conocido por su sabor suave y propiedades antioxidantes.', 5.99, 'https://megustavolar.iberia.com/wp-content/uploads/mgv/Japon_Te_Verde_Bebida_iStock-1068639486.jpg', 'Japones', 'Bebida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_ingrediente`
--

CREATE TABLE `producto_ingrediente` (
  `id_producto` int NOT NULL,
  `id_ingrediente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `producto_ingrediente`
--

INSERT INTO `producto_ingrediente` (`id_producto`, `id_ingrediente`) VALUES
(1, 1),
(5, 1),
(2, 2),
(4, 2),
(2, 3),
(3, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `tipoDeUsario` enum('Cliente','Encargado','Cocina','Administrador') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `contraseña`, `tipoDeUsario`) VALUES
(1, 'Sebastian Arias Vargas', 'sebasxlm9@gmail.com', 'sebas200409', 'Administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cocina`
--
ALTER TABLE `cocina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_estacion` (`id_estacion`);

--
-- Indices de la tabla `combo`
--
ALTER TABLE `combo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `combos_productos`
--
ALTER TABLE `combos_productos`
  ADD PRIMARY KEY (`id_combo`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `estacion`
--
ALTER TABLE `estacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estaciones_productos`
--
ALTER TABLE `estaciones_productos`
  ADD PRIMARY KEY (`id_estacion`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `historial_pedidos`
--
ALTER TABLE `historial_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `menus_productos`
--
ALTER TABLE `menus_productos`
  ADD PRIMARY KEY (`id_menu`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `fk_menu_combo` (`id_combo`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  ADD PRIMARY KEY (`id_pedido`,`id_producto`,`id_combo`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `fk_pedido_combo` (`id_combo`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `producto_ingrediente`
--
ALTER TABLE `producto_ingrediente`
  ADD PRIMARY KEY (`id_producto`,`id_ingrediente`),
  ADD KEY `id_ingrediente` (`id_ingrediente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cocina`
--
ALTER TABLE `cocina`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `combo`
--
ALTER TABLE `combo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estacion`
--
ALTER TABLE `estacion`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `historial_pedidos`
--
ALTER TABLE `historial_pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cocina`
--
ALTER TABLE `cocina`
  ADD CONSTRAINT `cocina_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`),
  ADD CONSTRAINT `cocina_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `cocina_ibfk_3` FOREIGN KEY (`id_estacion`) REFERENCES `estacion` (`id`);

--
-- Filtros para la tabla `combos_productos`
--
ALTER TABLE `combos_productos`
  ADD CONSTRAINT `combos_productos_ibfk_1` FOREIGN KEY (`id_combo`) REFERENCES `combo` (`id`),
  ADD CONSTRAINT `combos_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `estaciones_productos`
--
ALTER TABLE `estaciones_productos`
  ADD CONSTRAINT `estaciones_productos_ibfk_1` FOREIGN KEY (`id_estacion`) REFERENCES `estacion` (`id`),
  ADD CONSTRAINT `estaciones_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `historial_pedidos`
--
ALTER TABLE `historial_pedidos`
  ADD CONSTRAINT `historial_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`);

--
-- Filtros para la tabla `menus_productos`
--
ALTER TABLE `menus_productos`
  ADD CONSTRAINT `fk_menu_combo` FOREIGN KEY (`id_combo`) REFERENCES `combo` (`id`),
  ADD CONSTRAINT `menus_productos_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `menus_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  ADD CONSTRAINT `fk_pedido_combo` FOREIGN KEY (`id_combo`) REFERENCES `combo` (`id`),
  ADD CONSTRAINT `pedidos_productos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`),
  ADD CONSTRAINT `pedidos_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `producto_ingrediente`
--
ALTER TABLE `producto_ingrediente`
  ADD CONSTRAINT `producto_ingrediente_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `producto_ingrediente_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
