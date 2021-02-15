-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-12-2020 a las 14:18:12
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `Agenda`
--
CREATE DATABASE IF NOT EXISTS `Agenda` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `Agenda`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categoria`
--

CREATE TABLE `Categoria` (
                             `id` int(11) NOT NULL,
                             `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Categoria`
--

INSERT INTO `Categoria` (`id`, `nombre`) VALUES
(1, 'Familiares'),
(2, 'Amigos'),
(3, 'Trabajo'),
(4, 'Otros'),
(8, 'Estudios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Persona`
--

CREATE TABLE `Persona` (
                           `id` int(11) NOT NULL,
                           `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                           `apellidos` varchar(80) DEFAULT NULL,
                           `telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                           `estrella` tinyint(1) NOT NULL DEFAULT 0,
                           `categoriaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Persona`
--

INSERT INTO `Persona` (`id`, `nombre`, `apellidos`, `telefono`, `estrella`, `categoriaId`) VALUES
(1, 'Joseph', 'Smith', '600111222', 0, 3),
(3, 'Jose', 'Pérez Pi', '611222333', 0, 1),
(4, 'Cristina', 'Muñoz', '644999444', 1, 8),
(5, 'Laura', 'García', '666777888', 1, 2),
(6, 'Menganito', 'Mengánez', '699888777', 0, 3),
(13, 'Felipe', 'Fernández Ferrero', '684698462', 1, 3),
(14, 'Tupac', NULL, '69696969', 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Categoria`
--
ALTER TABLE `Categoria`
    ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Persona`
--
ALTER TABLE `Persona`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_categoriaIdIdx` (`categoriaId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Categoria`
--
ALTER TABLE `Categoria`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `Persona`
--
ALTER TABLE `Persona`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Persona`
--
ALTER TABLE `Persona`
    ADD CONSTRAINT `fk_categoriaId` FOREIGN KEY (`categoriaId`) REFERENCES `Categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;