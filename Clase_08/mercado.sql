-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2019 a las 04:46:41
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mercado`
--
CREATE DATABASE IF NOT EXISTS `mercado` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `mercado`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo_barra` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `nombre` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `path_foto` varchar(50) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo_barra`, `nombre`, `path_foto`) VALUES
(2, '789', 'manzana', 'manzana.jpg'),
(4, '333', 'banana', 'asdasd.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `apellido` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `clave` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `perfil` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `correo` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `foto` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `clave`, `perfil`, `estado`, `correo`, `foto`) VALUES
(2, 'esteban', 'locura', 'rojo5454', 1, 9, 'esteban@gmail.com', 'tomiti.jpg'),
(4, 'matias', 'herrera', '333', 2, 2, 'matias@gmail.com', 'prueba.jpg'),
(6, 'carlitos', 'chapetin', 'azul2323', 5, 4, 'carlitos@gmail.com', 'gatoMeme.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
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
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
