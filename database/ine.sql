-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 19-11-2022 a las 02:01:28
-- Versión del servidor: 5.7.34
-- Versión de PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ine`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ine`
--

CREATE TABLE `ine` (
  `curp` varchar(100) NOT NULL,
  `claveElector` varchar(100) NOT NULL,
  `seccion` int(11) NOT NULL,
  `vigencia` int(11) NOT NULL,
  `emision` int(11) NOT NULL,
  `sexo` tinyint(4) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidoPaterno` varchar(45) NOT NULL,
  `apellidoMaterno` varchar(45) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `añoRegistro` int(11) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `numeroExterior` varchar(45) NOT NULL,
  `numeroInterior` varchar(45) DEFAULT NULL,
  `colonia` varchar(45) NOT NULL,
  `Municipio` varchar(45) NOT NULL,
  `Estado` varchar(45) NOT NULL,
  `codigoPostal` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ine`
--
ALTER TABLE `ine`
  ADD PRIMARY KEY (`curp`,`claveElector`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
