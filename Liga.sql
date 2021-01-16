

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `liga` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `liga`;



DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
                                           `id` int(11) NOT NULL AUTO_INCREMENT,
                                           `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;



INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Porteros'),
(2, 'Defensas'),
(3, 'Mediocentros'),
(4, 'Delanteros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--



DROP TABLE IF EXISTS `equipo`;
CREATE TABLE IF NOT EXISTS `equipo` (
                                           `id` int(11) NOT NULL AUTO_INCREMENT,
                                           `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;



INSERT INTO `equipo` (`id`, `nombre`) VALUES
(1, 'Real Madrid'),
(2, 'Barcelona'),
(3, 'Atlético de madrid');


DROP TABLE IF EXISTS `jugador`;
CREATE TABLE IF NOT EXISTS `jugador` (
                                         `jugadorId` int(11) NOT NULL AUTO_INCREMENT,
                                         `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                         `apellidos` varchar(80) DEFAULT NULL,
                                         `dorsal` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                         `lesionado` tinyint(1) NOT NULL DEFAULT 0,
                                         `categoriaId` int(11) NOT NULL,
                                         `equipoId` int(11) NOT NULL,
                                         PRIMARY KEY (`jugadorId`),
                                         KEY `fk_categoriaIdIdx` (`categoriaId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;



INSERT INTO `jugador` (`jugadorId`, `nombre`, `apellidos`, `dorsal`,`lesionado`, `categoriaId`,`equipoId`) VALUES
(1, 'Tibu', 'Curtois', '1', 0, 1,1),
(2, 'Sergio', 'Ramos', '4', 1, 2,1),
(3, 'Luca', 'Modric', '10', 0, 3,1),
(4, 'Toni', 'Kroos', '8', 0, 3,1),
(5, 'Vini', 'JR', '21', 0, 4,1),
(6, 'KARIM', 'Benzema', '9', 0, 4,1),
(7, 'Leo', 'Messi', '10', 0, 4,2),
(8, 'Sergio', 'Busquets', '80', 0, 3,2),
(9, 'Jan', 'Oblak', '13', 0, 1,3),
(10, 'Jose', 'Gimenez', '2', 0, 2,3);


CREATE TABLE `cliente` (
  `idCliente` int(10) NOT NULL,
  `usuarioCliente` varchar(25) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `contrasennaCliente` varchar(80) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `codigoCookieCliente` varchar(80) COLLATE utf8mb4_spanish2_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `usuarioCliente`, `contrasennaCliente`, `codigoCookieCliente`) VALUES
(1, 'alex','$2y$10$E3tvrmh3oOMlyAIbJcoM9OWaHcVu/kzdpE7Yt33ovRuD5eof0I1qq', ''),
(2, 'brechas', '$2y$10$YGyvxrOXe06JgdzW20nE3OT2KObnteubGG9qJzVW7DJbZZde67iA.',''),
(3, 'c', '$2y$10$7LDtrBZY8sRbObQw.2ORwuJqM1LGxFxBxZ3SRv/9jQ5Rl8EEBu/C2', '');


ALTER TABLE `jugador`
    ADD CONSTRAINT `fk_categoriaId` FOREIGN KEY (`categoriaId`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_equipoId` FOREIGN KEY (`equipoId`) REFERENCES `equipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;