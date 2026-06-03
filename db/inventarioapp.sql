-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-06-2026 a las 09:29:57
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventarioapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas`
--

DROP TABLE IF EXISTS `aulas`;
CREATE TABLE IF NOT EXISTS `aulas` (
  `idAula` int NOT NULL AUTO_INCREMENT,
  `nombreAula` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FK_localizacion` int NOT NULL,
  PRIMARY KEY (`idAula`),
  UNIQUE KEY `nombreAula` (`nombreAula`,`FK_localizacion`),
  KEY `FK_localizacion` (`FK_localizacion`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `aulas`
--

INSERT INTO `aulas` (`idAula`, `nombreAula`, `FK_localizacion`) VALUES
(1, 'Aula 1', 15),
(5, 'Aula 1', 16),
(2, 'Aula 2', 15),
(3, 'Aula 3', 15),
(4, 'Aula 4', 15),
(13, 'Aula 4', 21),
(11, 'Aula1', 16),
(6, 'Aula2', 16),
(10, 'oficina', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localizaciones`
--

DROP TABLE IF EXISTS `localizaciones`;
CREATE TABLE IF NOT EXISTS `localizaciones` (
  `idLocalizacion` int NOT NULL AUTO_INCREMENT,
  `nombreLocalizacion` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idLocalizacion`),
  UNIQUE KEY `nombreLocalizacion` (`nombreLocalizacion`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `localizaciones`
--

INSERT INTO `localizaciones` (`idLocalizacion`, `nombreLocalizacion`) VALUES
(16, 'ES'),
(15, 'PM'),
(21, 'YM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productoreserva`
--

DROP TABLE IF EXISTS `productoreserva`;
CREATE TABLE IF NOT EXISTS `productoreserva` (
  `idProductoReserva` int NOT NULL AUTO_INCREMENT,
  `nombreProductoReserva` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stockReserva` int NOT NULL,
  `FK_Tipo` int NOT NULL,
  PRIMARY KEY (`idProductoReserva`),
  KEY `FK_Tipo` (`FK_Tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productoreserva`
--

INSERT INTO `productoreserva` (`idProductoReserva`, `nombreProductoReserva`, `stockReserva`, `FK_Tipo`) VALUES
(14, 'Pc', 20, 2),
(15, 'Teclados', 3, 2),
(16, 'Raton', 45, 2),
(17, 'Mesas', 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `idProducto` int NOT NULL AUTO_INCREMENT,
  `nombreProducto` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `stockMinimo` int NOT NULL,
  `stockActual` int NOT NULL,
  `FK_aula` int NOT NULL,
  `FK_productoReserva` int NOT NULL,
  PRIMARY KEY (`idProducto`),
  UNIQUE KEY `nombreProducto` (`nombreProducto`,`FK_aula`),
  KEY `FK_aula` (`FK_aula`),
  KEY `FK_productoReserva` (`FK_productoReserva`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombreProducto`, `fechaActualizacion`, `stockMinimo`, `stockActual`, `FK_aula`, `FK_productoReserva`) VALUES
(12, 'Pc', '2026-06-02', 1, 5, 2, 14),
(15, 'Teclados', '2026-06-02', 3, 2, 2, 15),
(16, 'Pc', '2026-06-02', 3, 4, 3, 14),
(17, 'Pc', '2026-06-02', 20, 0, 4, 14),
(18, 'Mesas', '2026-06-02', 34, 5, 3, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

DROP TABLE IF EXISTS `tipos`;
CREATE TABLE IF NOT EXISTS `tipos` (
  `idTipo` int NOT NULL AUTO_INCREMENT,
  `nombreTipo` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idTipo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`idTipo`, `nombreTipo`) VALUES
(2, 'informatica'),
(3, 'muebles'),
(9, 'ropa'),
(10, 'comida'),
(11, 'mascotas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidadproducto`
--

DROP TABLE IF EXISTS `unidadproducto`;
CREATE TABLE IF NOT EXISTS `unidadproducto` (
  `idProductoUnitario` int NOT NULL AUTO_INCREMENT,
  `numeroIdentificativo` int NOT NULL,
  `propietarioProducto` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechaActualizacion` date NOT NULL,
  `FK_producto` int NOT NULL,
  PRIMARY KEY (`idProductoUnitario`),
  KEY `FK_productos` (`FK_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `unidadproducto`
--

INSERT INTO `unidadproducto` (`idProductoUnitario`, `numeroIdentificativo`, `propietarioProducto`, `fechaActualizacion`, `FK_producto`) VALUES
(33, 1, NULL, '2026-06-02', 12),
(34, 2, NULL, '2026-06-02', 12),
(35, 3, NULL, '2026-06-02', 12),
(36, 4, NULL, '2026-06-02', 12),
(37, 5, NULL, '2026-06-02', 12),
(48, 1, NULL, '2026-06-02', 15),
(49, 2, NULL, '2026-06-02', 15),
(50, 1, NULL, '2026-06-02', 16),
(51, 2, NULL, '2026-06-02', 16),
(52, 3, NULL, '2026-06-02', 16),
(53, 4, NULL, '2026-06-02', 16),
(57, 1, NULL, '2026-06-02', 18),
(58, 2, NULL, '2026-06-02', 18),
(59, 3, NULL, '2026-06-02', 18),
(60, 4, NULL, '2026-06-02', 18),
(61, 5, NULL, '2026-06-02', 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `nombreUsuario` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pasword` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombreUsuario`, `pasword`) VALUES
(1, 'ECOS', '$2y$12$tfQmtkgoFs9I.moajWeYPeOzYDTHuDdMTpXwp1./TlhX4vwKeyCFy');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD CONSTRAINT `aulas_ibfk_1` FOREIGN KEY (`FK_localizacion`) REFERENCES `localizaciones` (`idLocalizacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productoreserva`
--
ALTER TABLE `productoreserva`
  ADD CONSTRAINT `productoreserva_ibfk_1` FOREIGN KEY (`FK_Tipo`) REFERENCES `tipos` (`idTipo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`FK_aula`) REFERENCES `aulas` (`idAula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`FK_productoReserva`) REFERENCES `productoreserva` (`idProductoReserva`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `unidadproducto`
--
ALTER TABLE `unidadproducto`
  ADD CONSTRAINT `unidadproducto_ibfk_1` FOREIGN KEY (`FK_producto`) REFERENCES `productos` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
