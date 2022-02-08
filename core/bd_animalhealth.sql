-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-02-2022 a las 17:56:03
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_animalhealth`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedentes`
--

CREATE TABLE `antecedentes` (
  `id` int(11) NOT NULL,
  `historial_clinico_id` int(11) DEFAULT NULL,
  `cirugias` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_cirugia` date DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `antecedentes`
--

INSERT INTO `antecedentes` (`id`, `historial_clinico_id`, `cirugias`, `descripcion`, `fecha_cirugia`, `estado`) VALUES
(6, 6, 'NO', '', '0000-00-00', 'A'),
(7, 7, 'Si ', 'cirugia de castracion', '2022-01-04', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `estado`) VALUES
(1, 'Vacunas', 'A'),
(2, 'Parvovirus', 'A'),
(3, 'Analgesicos', 'A'),
(4, 'Comidas', 'A'),
(12, 'Antibioticos', 'A'),
(13, 'Antiparasitos', 'A'),
(14, 'Anestesicos', 'A'),
(15, 'Antiinflamatorios', 'A'),
(16, 'Ectoparasticida', 'A'),
(17, 'Cardiovasculares', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `servicios_id` int(11) NOT NULL,
  `mascota_id` int(11) DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  `estado_cita_id` int(11) NOT NULL,
  `horarios_atencion_id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `doctor_id`, `servicios_id`, `mascota_id`, `cliente_id`, `estado_cita_id`, `horarios_atencion_id`, `fecha`, `estado`) VALUES
(1, 1, 1, 17, 17, 2, 1, '2022-01-17', 'A'),
(2, 1, 3, 6, 3, 2, 2, '2022-01-25', 'A'),
(3, 1, 5, 4, 11, 2, 6, '2022-01-25', 'A'),
(4, 2, 3, 7, 11, 2, 12, '2022-01-26', 'A'),
(5, 2, 3, 10, 13, 2, 15, '2022-01-26', 'A'),
(6, 1, 6, 10, 13, 2, 3, '2022-01-25', 'A'),
(7, 2, 3, 17, 17, 2, 10, '2022-01-26', 'A'),
(8, 1, 6, 14, 11, 2, 7, '2022-01-25', 'A'),
(9, 2, 1, 19, 19, 2, 13, '2022-01-26', 'A'),
(10, 2, 5, 20, 20, 2, 25, '2021-01-11', 'I'),
(11, 2, 1, 21, 21, 2, 20, '2022-01-27', 'A'),
(12, 2, 3, 20, 20, 2, 24, '2022-01-27', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `persona_id`, `estado`) VALUES
(1, 5, 'A'),
(2, 6, 'A'),
(3, 9, 'A'),
(4, 12, 'A'),
(5, 13, 'A'),
(6, 14, 'A'),
(7, 15, 'A'),
(8, 16, 'A'),
(9, 17, 'A'),
(10, 18, 'A'),
(11, 19, 'A'),
(12, 20, 'A'),
(13, 21, 'A'),
(14, 22, 'A'),
(15, 23, 'A'),
(16, 24, 'A'),
(17, 25, 'A'),
(18, 26, 'A'),
(19, 27, 'A'),
(20, 28, 'A'),
(21, 29, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos`
--

CREATE TABLE `codigos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(25) DEFAULT NULL,
  `tipos` varchar(10) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `codigos`
--

INSERT INTO `codigos` (`id`, `codigo`, `tipos`, `estado`) VALUES
(1, '000001', 'historial', 'A'),
(2, '000002', 'historial', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `numero_compra` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descuento` double NOT NULL,
  `subtotal` double NOT NULL,
  `iva` double NOT NULL,
  `total` double NOT NULL,
  `fecha_compra` date NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `proveedor_id`, `usuario_id`, `numero_compra`, `descuento`, `subtotal`, `iva`, `total`, `fecha_compra`, `estado`) VALUES
(1, 1, 8, '07ca9', 0, 75, 9, 84, '2022-01-31', 'A'),
(2, 1, 8, '0685c', 0, 75, 9, 84, '2022-01-31', 'A'),
(3, 2, 8, 'a5ef3', 0, 126, 15.12, 141.12, '2022-02-02', 'A'),
(5, 3, 8, 'd49e0', 0, 187, 22.44, 209.44, '2022-02-02', 'A'),
(6, 1, 8, 'bc4d8', 0, 54.8, 6.58, 61.38, '2022-02-04', 'A'),
(7, 3, 8, '91950', 0, 2.5, 0.3, 2.8, '0000-00-00', 'A'),
(9, 2, 8, '2fe76', 0, 66, 7.92, 73.92, '2022-02-04', 'A'),
(10, 2, 8, 'd036a', 0, 20, 2.4, 22.4, '0000-00-00', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

CREATE TABLE `configuraciones` (
  `id` int(11) NOT NULL,
  `porcentaje_ganancia` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `configuraciones`
--

INSERT INTO `configuraciones` (`id`, `porcentaje_ganancia`, `iva`, `estado`) VALUES
(1, 5, 12, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id` int(11) NOT NULL,
  `detalle` varchar(100) NOT NULL,
  `valor` int(11) DEFAULT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`id`, `detalle`, `valor`, `estado`) VALUES
(1, 'Muy Insastisfecho', 1, 'A'),
(2, 'Insastisfecho', 2, 'A'),
(3, 'Neutral', 3, 'A'),
(4, 'Sastisfecho', 4, 'A'),
(5, 'Muy Sastisfecho', 5, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `compras_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id`, `compras_id`, `producto_id`, `cantidad`, `precio_compra`, `total`) VALUES
(1, 1, 2, 50, 1.5, 75),
(2, 2, 2, 50, 1.5, 75),
(3, 3, 3, 20, 1.5, 30),
(4, 3, 5, 60, 1.6, 96),
(5, 5, 7, 100, 1.87, 187),
(6, 6, 6, 30, 1.5, 45),
(7, 6, 8, 10, 0.98, 9.8),
(8, 7, 10, 10, 0.25, 2.5),
(9, 9, 15, 60, 1.1, 66),
(10, 10, 14, 10, 2, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_receta`
--

CREATE TABLE `detalle_receta` (
  `id` int(11) NOT NULL,
  `receta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_receta`
--

INSERT INTO `detalle_receta` (`id`, `receta_id`, `producto_id`, `cantidad`, `total`) VALUES
(1, 1, 1, 1, 3),
(2, 2, 2, 1, 3),
(3, 3, 2, 1, 3),
(4, 5, 1, 2, 7),
(5, 6, 1, 1, 3),
(6, 7, 2, 1, 3),
(7, 8, 1, 1, 3),
(8, 9, 2, 2, 6),
(9, 10, 1, 1, 3),
(10, 11, 2, 1, 3),
(11, 12, 1, 1, 3),
(12, 13, 1, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL,
  `ventas_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `ventas_id`, `producto_id`, `cantidad`, `precio_venta`, `total`) VALUES
(1, 1, 2, 20, 1.57, 31.4),
(2, 2, 2, 2, 1.57, 3.14),
(3, 3, 7, 30, 1, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`id`, `persona_id`, `estado`) VALUES
(1, 2, 'A'),
(2, 3, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor_horario`
--

CREATE TABLE `doctor_horario` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `horarios_atencion_id` int(11) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `doctor_horario`
--

INSERT INTO `doctor_horario` (`id`, `doctor_id`, `horarios_atencion_id`, `estado`) VALUES
(1, 1, 1, 'A'),
(2, 1, 2, 'A'),
(3, 1, 3, 'A'),
(4, 1, 4, 'A'),
(5, 1, 5, 'A'),
(6, 1, 6, 'A'),
(7, 1, 7, 'A'),
(8, 1, 8, 'A'),
(9, 1, 9, 'A'),
(10, 2, 10, 'A'),
(11, 2, 11, 'A'),
(12, 2, 12, 'A'),
(13, 2, 13, 'A'),
(14, 2, 14, 'A'),
(15, 2, 15, 'A'),
(16, 2, 16, 'A'),
(17, 2, 17, 'A'),
(18, 2, 18, 'A'),
(19, 2, 19, 'A'),
(20, 2, 20, 'A'),
(21, 2, 21, 'A'),
(22, 2, 22, 'A'),
(23, 2, 23, 'A'),
(24, 2, 24, 'A'),
(25, 2, 25, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cita`
--

CREATE TABLE `estado_cita` (
  `id` int(11) NOT NULL,
  `detalle` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estado_cita`
--

INSERT INTO `estado_cita` (`id`, `detalle`, `estado`) VALUES
(1, 'Pendiente', 'A'),
(2, 'Atendido', 'A'),
(3, 'Cancelado', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen_fisico`
--

CREATE TABLE `examen_fisico` (
  `id` int(11) NOT NULL,
  `historial_clinico_id` int(11) DEFAULT NULL,
  `temperatura` int(11) DEFAULT NULL,
  `peso` int(11) DEFAULT NULL,
  `hidratacion` int(11) DEFAULT NULL,
  `frecuencia_cardiaca` int(11) DEFAULT NULL,
  `pulso` int(11) DEFAULT NULL,
  `frecuencia_respiratoria` int(11) DEFAULT NULL,
  `diagnostico` varchar(300) DEFAULT NULL,
  `tratamiento` varchar(300) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `examen_fisico`
--

INSERT INTO `examen_fisico` (`id`, `historial_clinico_id`, `temperatura`, `peso`, `hidratacion`, `frecuencia_cardiaca`, `pulso`, `frecuencia_respiratoria`, `diagnostico`, `tratamiento`, `estado`) VALUES
(3, 6, 60, 80, 15, 88, 80, 90, 'HOLA', 'DOS', 'A'),
(4, 7, 38, 10, 50, 90, 86, 99, 'Caries', 'Lavar los dientes', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero_mascota`
--

CREATE TABLE `genero_mascota` (
  `id` int(11) NOT NULL,
  `genero` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `genero_mascota`
--

INSERT INTO `genero_mascota` (`id`, `genero`, `estado`) VALUES
(1, 'Macho', 'A'),
(2, 'Hembra', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_clinico`
--

CREATE TABLE `historial_clinico` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `mascota_id` int(11) DEFAULT NULL,
  `numero_historia` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `motivo_consulta` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_h` date DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `historial_clinico`
--

INSERT INTO `historial_clinico` (`id`, `cliente_id`, `mascota_id`, `numero_historia`, `motivo_consulta`, `fecha_h`, `estado`) VALUES
(6, 15, 12, '000001', 'PERROCON PULGAS', '2022-01-24', 'A'),
(7, 3, 9, '000002', 'Mascota con dientes partidos', '2022-01-24', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_atencion`
--

CREATE TABLE `horarios_atencion` (
  `id` int(11) NOT NULL,
  `horaE` time DEFAULT NULL,
  `horaS` time DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `intervalo` int(11) DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `libre` char(1) DEFAULT NULL,
  `asignacion` varchar(1) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `horarios_atencion`
--

INSERT INTO `horarios_atencion` (`id`, `horaE`, `horaS`, `fecha`, `intervalo`, `horario`, `libre`, `asignacion`, `estado`) VALUES
(1, '08:00:00', '12:00:00', '2022-01-25', 30, '08:00:00', 'O', 'S', 'I'),
(2, '08:00:00', '12:00:00', '2022-01-25', 30, '08:30:00', 'O', 'S', 'I'),
(3, '08:00:00', '12:00:00', '2022-01-25', 30, '09:00:00', 'O', 'S', 'I'),
(4, '08:00:00', '12:00:00', '2022-01-25', 30, '09:30:00', 'S', 'S', 'A'),
(5, '08:00:00', '12:00:00', '2022-01-25', 30, '10:00:00', 'S', 'S', 'A'),
(6, '08:00:00', '12:00:00', '2022-01-25', 30, '10:30:00', 'O', 'S', 'I'),
(7, '08:00:00', '12:00:00', '2022-01-25', 30, '11:00:00', 'S', 'S', 'A'),
(8, '08:00:00', '12:00:00', '2022-01-25', 30, '11:30:00', 'S', 'S', 'A'),
(9, '08:00:00', '12:00:00', '2022-01-25', 30, '12:00:00', 'S', 'S', 'A'),
(10, '14:00:00', '18:00:00', '2022-01-26', 30, '14:00:00', 'O', 'S', 'I'),
(11, '14:00:00', '18:00:00', '2022-01-26', 30, '14:30:00', 'S', 'S', 'A'),
(12, '14:00:00', '18:00:00', '2022-01-26', 30, '15:00:00', 'O', 'S', 'I'),
(13, '14:00:00', '18:00:00', '2022-01-26', 30, '15:30:00', 'O', 'S', 'I'),
(14, '14:00:00', '18:00:00', '2022-01-26', 30, '16:00:00', 'S', 'S', 'A'),
(15, '14:00:00', '18:00:00', '2022-01-26', 30, '16:30:00', 'O', 'S', 'I'),
(16, '14:00:00', '18:00:00', '2022-01-26', 30, '17:00:00', 'S', 'S', 'A'),
(17, '14:00:00', '18:00:00', '2022-01-26', 30, '17:30:00', 'S', 'S', 'A'),
(18, '14:00:00', '18:00:00', '2022-01-26', 30, '18:00:00', 'S', 'S', 'A'),
(19, '15:00:00', '18:00:00', '2022-01-27', 30, '15:00:00', 'S', 'S', 'A'),
(20, '15:00:00', '18:00:00', '2022-01-27', 30, '15:30:00', 'O', 'S', 'I'),
(21, '15:00:00', '18:00:00', '2022-01-27', 30, '16:00:00', 'S', 'S', 'A'),
(22, '15:00:00', '18:00:00', '2022-01-27', 30, '16:30:00', 'S', 'S', 'A'),
(23, '15:00:00', '18:00:00', '2022-01-27', 30, '17:00:00', 'S', 'S', 'A'),
(24, '15:00:00', '18:00:00', '2022-01-27', 30, '17:30:00', 'O', 'S', 'I'),
(25, '15:00:00', '18:00:00', '2022-01-27', 30, '18:00:00', 'O', 'S', 'I');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `transaccion_id` int(11) DEFAULT NULL,
  `tipo` enum('E','S') DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `cantidad_disponible` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `total_disponible` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `producto_id`, `transaccion_id`, `tipo`, `cantidad`, `cantidad_disponible`, `total`, `total_disponible`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'E', 50, 50, NULL, NULL, '2022-02-01 04:30:51', '2022-02-01 04:30:51'),
(2, 2, 2, 'E', 50, 100, NULL, NULL, '2022-02-01 04:32:30', '2022-02-01 04:32:30'),
(3, 2, 3, 'S', -20, 80, NULL, NULL, '2022-02-01 04:34:06', '2022-02-01 04:34:06'),
(4, 3, 4, 'E', 20, 20, NULL, NULL, '2022-02-03 01:47:38', '2022-02-03 01:47:38'),
(5, 5, 4, 'E', 60, 60, NULL, NULL, '2022-02-03 01:47:38', '2022-02-03 01:47:38'),
(6, 7, 5, 'E', 100, 100, NULL, NULL, '2022-02-03 01:49:54', '2022-02-03 01:49:54'),
(7, 2, 6, 'S', -2, 78, NULL, NULL, '2022-02-03 01:51:07', '2022-02-03 01:51:07'),
(8, 7, 7, 'S', -30, 70, NULL, NULL, '2022-02-03 01:51:34', '2022-02-03 01:51:34'),
(9, 6, 8, 'E', 30, 30, NULL, NULL, '2022-02-04 21:40:21', '2022-02-04 21:40:21'),
(10, 8, 8, 'E', 10, 10, NULL, NULL, '2022-02-04 21:40:22', '2022-02-04 21:40:22'),
(11, 10, 9, 'E', 10, 10, NULL, NULL, '2022-02-04 21:41:37', '2022-02-04 21:41:37'),
(12, 15, 10, 'E', 60, 60, NULL, NULL, '2022-02-04 21:43:13', '2022-02-04 21:43:13'),
(13, 14, 11, 'E', 10, 10, NULL, NULL, '2022-02-04 22:08:04', '2022-02-04 22:08:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

CREATE TABLE `mascota` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `tipo_mascota_id` int(11) NOT NULL,
  `genero_mascota_id` int(11) NOT NULL,
  `raza_id` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `edad` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `peso` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `imagen` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mascota`
--

INSERT INTO `mascota` (`id`, `cliente_id`, `tipo_mascota_id`, `genero_mascota_id`, `raza_id`, `nombre`, `edad`, `peso`, `fecha_nacimiento`, `imagen`, `estado`) VALUES
(1, 1, 1, 1, 1, 'Max', '5', '10kg', '2021-12-01', 'mascotasdefault.jpg', 'A'),
(2, 2, 1, 1, 2, 'Black', '3', '5kg', '2021-12-04', 'aleman.jpg', 'A'),
(3, 2, 2, 1, 4, 'Can', '5', '2kg', '2021-12-09', 'mascotasdefault.jpg', 'A'),
(4, 11, 1, 1, 4, 'FITO', '5', '60kg', '2013-07-20', 'mascotasdefault.jpg', 'A'),
(5, 12, 1, 1, 1, 'Solovino', '7', '120', '2017-07-15', 'perrossss.jpg', 'A'),
(6, 3, 1, 1, 1, 'Danny', '5', '525257', '2022-01-14', 'mascotasdefault.jpg', 'A'),
(7, 11, 1, 1, 1, 'Maxi', '4', '227', '2022-01-14', 'perrossss.jpg', 'A'),
(8, 3, 1, 1, 2, 'firulais', '3', '200', '2022-01-15', 'mascotasdefault.jpg', 'A'),
(9, 3, 1, 2, 3, 'gufi', '4', '50', '2022-01-15', 'mascotasdefault.jpg', 'A'),
(10, 13, 1, 2, 3, 'Pitufo', '2', '50', '2022-01-12', 'perrossss.jpg', 'A'),
(11, 14, 1, 2, 2, 'Lulu', '3', '25kg', '2022-01-05', 'perrossss.jpg', 'A'),
(12, 15, 1, 1, 1, 'sdfsdfs', '25', '25', '2022-01-16', 'mascotasdefault.jpg', 'A'),
(13, 16, 1, 1, 4, 'Choco', '5', '20kg', '2018-05-17', 'aleman.jpg', 'A'),
(14, 11, 1, 1, 4, 'randy', '5', '250', '2022-01-05', 'aleman.jpg', 'A'),
(15, 2, 1, 1, 2, 'gufi2', '5', '60', '2022-01-04', 'perrossss.jpg', 'A'),
(16, 2, 3, 1, 3, 'Loro', '1', '10', '2021-12-31', 'aleman.jpg', 'A'),
(17, 17, 1, 1, 3, 'Teo', '4', '60', '2022-01-25', 'mascotasdefault.jpg', 'A'),
(18, 18, 1, 1, 1, 'Jack', '7', '50', '2022-01-25', 'mascotasdefault.jpg', 'A'),
(19, 19, 1, 2, 3, 'Simba', '3', '60', '2022-01-26', 'perrossss.jpg', 'A'),
(20, 20, 1, 2, 4, 'Kiara', '3', '50', '2022-01-06', 'perrossss.jpg', 'A'),
(21, 21, 1, 2, 2, 'Luna', '4', '25', '2022-01-05', 'perrossss.jpg', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `seccion_id` int(11) DEFAULT NULL,
  `menu` varchar(100) DEFAULT NULL,
  `icono` varchar(100) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `pos` int(2) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `seccion_id`, `menu`, `icono`, `url`, `pos`, `estado`) VALUES
(1, 0, 'Doctores', 'fas fa-user-md', 'doctor', 2, 'A'),
(2, 1, 'Listado de Doctores', '#', 'doctor/listar', 0, 'A'),
(3, 0, 'Inicio', 'fas fa-laptop', 'inicio', 0, 'A'),
(4, 3, 'Dashboard ', '#', 'inicio/administrador', 0, 'A'),
(5, 0, 'Usuarios', 'fas fa-user', 'usuario', 1, 'A'),
(6, 5, 'Registro de Usuario', '#', 'usuario/registro', 0, 'A'),
(7, 0, 'Clientes', 'fas fa-user-friends', 'cliente', 3, 'A'),
(8, 7, 'Registro de Clientes', '#', 'cliente/registro', 0, 'A'),
(9, 0, 'Gestionar Mascota', 'fas fa-paw', 'gestionar-mascota', 4, 'A'),
(10, 9, 'Mascota', '#', 'mascota/gestion', 0, 'A'),
(12, 3, 'Doctor ', '#', 'inicio/doctor', 1, 'A'),
(13, 0, 'Citas Medicas', 'fas fa-notes-medical', 'citas ', 5, 'A'),
(14, 13, 'Agendar Citas', '#', 'citas/agendar', 0, 'A'),
(15, 3, 'Recepcionista', '#', 'inicio/recepcionista', 2, 'A'),
(17, 3, 'Cliente', '#', 'inicio/cliente', 3, 'A'),
(18, 0, 'Citas Mascotas', 'fas fa-dog', 'agendar', 6, 'A'),
(19, 18, 'Agendar C Mascotas', '#', 'citascliente/mascotasagendar', 0, 'A'),
(20, 0, 'Programas de Inmunizacion', 'fas fa-user-md', 'inmunizacion', 7, 'A'),
(21, 20, 'P. Vacunacion', '#', 'inmunizacion/vacunacion', 0, 'A'),
(22, 20, 'P. Desparasitacion', '#', 'inmunizacion/desparasitacion', 1, 'A'),
(23, 0, 'Ver Mascotas', 'fas fa-paw', 'ver', 8, 'A'),
(24, 0, 'Ver Citas', 'fas fa-envelope-open-text', 'citas', 9, 'A'),
(25, 24, 'Pendientes', '#', 'citas/pendientes', 0, 'A'),
(26, 24, 'Atendidas', '#', 'citas/atendidas', 1, 'A'),
(27, 0, 'Historial Clinico', 'fas fa-clipboard-check', 'historial', 10, 'A'),
(28, 27, 'Registrar Historial Clinico', '#', 'historial/registro', 0, 'A'),
(29, 3, 'Asistente', '#', 'inicio/asistente', 4, 'A'),
(30, 0, 'Categorias', 'fas fa-laptop-medical', 'categorias', 11, 'A'),
(31, 0, 'Gestion Productos', 'fas fa-tablets', 'productos', 12, 'A'),
(32, 0, 'Proveedores', 'fas fa-people-carry', 'proveedores', 13, 'A'),
(33, 0, 'Compras', 'fas fa-shopping-cart', 'compras', 14, 'A'),
(34, 33, 'Nueva Compra', '#', 'compras/nueva', 0, 'A'),
(35, 33, 'Consultar Compras', '#', 'compras/consultas', 1, 'A'),
(36, 33, 'Compras Fecha', '#', 'compras/consultafecha', 2, 'A'),
(37, 33, 'Compras Mes', '#', 'compras/consultames', 3, 'A'),
(38, 0, 'Clientes', 'fas fa-user-friends', 'clienteso', 15, 'A'),
(39, 0, 'Ventas', 'fas fa-shopping-cart', 'ventas', 16, 'A'),
(40, 0, 'Reportes de Compras', 'fas fa-chart-bar', 'reportesC', 17, 'A'),
(41, 0, 'Reportes de Ventas', 'fas fa-chart-pie', 'reporteV', 18, 'A'),
(42, 31, 'Registro Productos', '#', 'productos/registrar', 0, 'A'),
(43, 32, 'Registro Proveedor', '#', 'proveedores/registrar', 0, 'A'),
(44, 0, 'Gestión de Horarios', 'fas fa-book-reader', 'gestion-horarios', 19, 'A'),
(45, 44, 'Registrar Horarios de Atención', '#', 'gestion/horario', 0, 'A'),
(46, 38, 'Registrar Clientes', '#', 'clienteso/nuevo', 0, 'A'),
(47, 39, 'Nueva Venta', '#', 'ventas/nueva', 0, 'A'),
(48, 39, 'Consultar Ventas', '#', 'ventas/consultas', 1, 'A'),
(49, 39, 'Ventas Fecha', '#', 'ventas/consultafechas', 2, 'A'),
(50, 39, 'Ventas Mes', '#', 'ventas/consultames', 3, 'A'),
(51, 0, 'Gestión de Horarios 2', 'fas fa-book-reader', 'gestion-hora', 20, 'A'),
(52, 51, 'Registrar Horario ', '#', 'gestionn/horarion', 0, 'A'),
(54, 24, 'Canceladas', '#', 'citas/canceladas', 2, 'A'),
(55, 23, 'Mis Mascotas', '#', 'ver/mismascotas', 0, 'A'),
(56, 40, 'Compras Mensuales', '#', 'reporte/compra', 0, 'A'),
(57, 0, 'Configuraciones', 'fas fa-cogs', 'configuracion', 21, 'A'),
(58, 57, 'General', '#', 'configuracion/general', 0, 'A'),
(59, 0, 'Reportes', 'fas fa-file-invoice', 'reporte', 22, 'A'),
(60, 59, 'Servicios Adquiridos', '#', 'reporte/servicios', 0, 'A'),
(61, 59, 'Medicina mas Compra', '#', 'reporte/medicinamasc', 1, 'A'),
(62, 59, 'Medicina mas Vendida', '#', 'reporte/medicinamasv', 2, 'A'),
(63, 59, 'Agendamientos Doctor', '#', 'reporte/agendamientoxdoc', 3, 'A'),
(64, 59, 'Mascotas Atendidas', '#', 'reporte/mascotasmasatendidas', 4, 'A'),
(65, 41, 'Ventas Mensuales', '#', 'reporte/venta', 0, 'A'),
(66, 59, 'Compras Mensuales', '#', 'reporte/compra', 5, 'A'),
(67, 59, 'Ventas Mensuales', '#', 'reporte/venta', 6, 'A'),
(69, 0, 'Inventarios', 'fas fa-clipboard-list', 'inventarios', 23, 'A'),
(70, 69, 'Ver inventario', '#', 'inventarios/verinventario', 0, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `acceso` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `rol_id`, `menu_id`, `acceso`, `estado`) VALUES
(2, 1, 1, 'N', 'A'),
(3, 1, 2, 'N', 'A'),
(4, 1, 3, 'S', 'A'),
(5, 1, 4, 'S', 'A'),
(6, 1, 5, 'S', 'A'),
(7, 1, 6, 'S', 'A'),
(8, 1, 7, 'N', 'A'),
(9, 1, 8, 'N', 'A'),
(10, 1, 9, 'N', 'A'),
(11, 1, 10, 'N', 'A'),
(12, 3, 1, 'N', 'A'),
(13, 3, 2, 'N', 'A'),
(15, 3, 12, 'S', 'A'),
(16, 3, 3, 'S', 'A'),
(17, 3, 13, 'N', 'A'),
(18, 3, 14, 'N', 'A'),
(19, 2, 1, 'S', 'A'),
(20, 2, 2, 'S', 'A'),
(22, 3, 9, 'N', 'A'),
(23, 3, 10, 'N', 'A'),
(25, 5, 17, 'S', 'A'),
(26, 5, 18, 'S', 'A'),
(28, 5, 19, 'S', 'A'),
(29, 5, 20, 'S', 'A'),
(30, 5, 21, 'S', 'A'),
(31, 5, 22, 'S', 'A'),
(32, 5, 23, 'S', 'A'),
(33, 2, 13, 'S', 'A'),
(34, 2, 14, 'S', 'A'),
(35, 4, 7, 'S', 'A'),
(36, 4, 8, 'S', 'A'),
(37, 2, 9, 'S', 'A'),
(38, 2, 10, 'S', 'A'),
(39, 3, 24, 'S', 'A'),
(40, 3, 25, 'S', 'A'),
(41, 3, 26, 'S', 'A'),
(42, 3, 27, 'S', 'A'),
(43, 3, 28, 'S', 'A'),
(44, 4, 29, 'S', 'A'),
(45, 4, 30, 'N', 'A'),
(46, 4, 3, 'S', 'A'),
(47, 4, 31, 'S', 'A'),
(48, 4, 32, 'S', 'A'),
(49, 4, 33, 'S', 'A'),
(50, 4, 34, 'S', 'A'),
(51, 4, 35, 'S', 'A'),
(52, 4, 36, 'N', 'A'),
(53, 4, 37, 'N', 'A'),
(54, 2, 38, 'S', 'A'),
(55, 4, 39, 'S', 'A'),
(56, 4, 40, 'S', 'A'),
(57, 4, 41, 'S', 'A'),
(58, 4, 42, 'S', 'A'),
(59, 4, 43, 'S', 'A'),
(60, 3, 44, 'S', 'A'),
(61, 3, 45, 'S', 'A'),
(62, 2, 46, 'S', 'A'),
(63, 4, 47, 'S', 'A'),
(64, 4, 48, 'S', 'A'),
(65, 4, 49, 'N', 'A'),
(66, 4, 50, 'N', 'A'),
(67, 4, 48, 'N', 'A'),
(68, 3, 51, 'N', 'A'),
(69, 3, 52, 'N', 'A'),
(70, 3, 54, 'S', 'A'),
(71, 5, 55, 'S', 'A'),
(72, 4, 56, 'S', 'A'),
(73, 1, 57, 'S', 'A'),
(74, 1, 58, 'S', 'A'),
(75, 1, 59, 'S', 'A'),
(76, 1, 60, 'S', 'A'),
(77, 1, 61, 'S', 'A'),
(78, 1, 62, 'S', 'A'),
(79, 1, 63, 'S', 'A'),
(80, 1, 64, 'S', 'A'),
(81, 4, 65, 'S', 'A'),
(82, 1, 56, 'S', 'A'),
(83, 1, 66, 'S', 'A'),
(84, 1, 67, 'S', 'A'),
(86, 1, 69, 'S', 'A'),
(87, 1, 70, 'S', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perscripcion`
--

CREATE TABLE `perscripcion` (
  `id` int(11) NOT NULL,
  `historial_clinico_id` int(11) DEFAULT NULL,
  `descripcion` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `perscripcion`
--

INSERT INTO `perscripcion` (`id`, `historial_clinico_id`, `descripcion`, `estado`) VALUES
(3, 6, 'ERE', 'A'),
(4, 7, 'XKALDKLASKA', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `cedula` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `sexo_id` int(11) DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `cedula`, `nombre`, `apellido`, `telefono`, `direccion`, `sexo_id`, `estado`) VALUES
(1, '2400032559', 'Danny', 'Chavez', '0979569707', 'Salinas-Jose Luis Tamayo', 1, 'A'),
(2, '2400456105', 'Brenda', 'Sanchez', '0987862515', 'Salinas', 2, 'A'),
(3, '0927265546', 'Jose', 'Lopez', '0987526262', 'La Libertad', 1, 'A'),
(4, '2450376468', 'Maria', 'Mejillon', '0984851659', 'Guayas', 2, 'A'),
(5, '2400026726', 'Juan', 'Pablo', '0984165269', 'Muey', 1, 'A'),
(6, '2450516428', 'Nathaly', 'Surez', '0984626262', 'La Libertad', 2, 'A'),
(8, '2450881780', 'Juanita', 'Cordova', '0454865165', 'Guayas', 2, 'A'),
(9, '2450306887', 'Marcos', 'Miranda', '0845645465', 'Salinas', 1, 'A'),
(10, '2450330515', 'Alejandro ', 'Sanz', '0945313185', 'Madrid España ', 1, 'A'),
(12, '2400321903', 'patricio', 'carlos', '6546644676', 'Salinas', 1, 'A'),
(13, '2450309444', 'Juan ', 'Enrique', '0841161621', 'salinas', 1, 'A'),
(14, '2450293481', 'sasasas', 'asasas', '0979569707', 'Calle 4', 1, 'A'),
(15, '0705461432', 'fsdffdsfd', 'dffdssdffd', '1321321321', 'fasfasf542', 1, 'A'),
(16, '2450826835', 'Brando', 'lainez', '0845641561', 'Santa elena', 1, 'A'),
(17, '2400320798', 'RICARDO', 'GONZALEZ', '0843213216', 'LIBERTAD', 1, 'A'),
(18, '0928388248', 'JOSHEP', 'GUARANDA', '0845321846', 'SANTA ELENA', 1, 'A'),
(19, '2450587387', 'Juliana ', 'Gonzalez', '0912345678', 'Salinas - Muey', 2, 'A'),
(20, '2400454720', 'Juan ', 'Carlos', '0874562313', 'La libertad', 1, 'A'),
(21, '2450311556', 'Juanito', 'Cazarez', '0915484798', 'Salinas', 1, 'A'),
(22, '0928166701', 'Fernanda', 'Gallardo', '0942131321', 'Salinas', 2, 'A'),
(23, '0912305539', 'Maria', 'Yagual', '099839035', 'Salinas', 2, 'A'),
(24, '2450399015', 'Luisa', 'Rodriguez', '0985151865', 'Santa Elena', 2, 'A'),
(25, '2450526211', 'Karla', 'Laniado', '0946515613', 'Guayaquil', 2, 'A'),
(26, '2450482167', 'Teresa', 'Sanchez', '0945612313', 'Manabi', 2, 'A'),
(27, '0928225440', 'Karen ', 'Barreiro', '0942316541', 'Guayaquil', 2, 'A'),
(28, '2450218579', 'Andrea', 'Ortiz', '0843218465', 'Salinas', 2, 'A'),
(29, '2450358854', 'Rita', 'Zambrano', '0924561654', 'Santa Elena', 1, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `codigo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` double NOT NULL,
  `precio_venta` double NOT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `categoria_id`, `codigo`, `nombre`, `descripcion`, `imagen`, `stock`, `precio_compra`, `precio_venta`, `fecha`, `estado`) VALUES
(1, 15, '00001', 'Carprofeno', 'Antiinflamatorios', 'med.jpg', 100, 2, 2.1, '2022-01-05', 'A'),
(2, 13, '00002', 'ProGuard 4', 'Desparacitacion gatos', 'dddd.png', 78, 1.5, 1.57, '2022-01-14', 'A'),
(3, 16, '00003', 'Profelis', 'Profelis para gatos ', 'sssss.png', 20, 1.5, 5.35, '2022-01-14', 'A'),
(4, 16, '00004', 'Proventis 10 ', 'proventis para caninos edad media ', 'aaa.png', 0, 5.11, 5.37, '2022-01-14', 'A'),
(5, 13, '00005', 'Supramectin 10', 'antiparasitante plugicida oral interno externo de accion sistemica', '437_2863e82aad6a6fe6928bf6cd611be590.png', 60, 1.6, 3.36, '2022-01-14', 'A'),
(6, 15, '00006', 'Carprodly 25', 'Antiinflamatorio no esterioidal para perros pequenos y medianos ', 'images.jpg', 30, 1.5, 2.31, '2022-01-13', 'A'),
(7, 13, '00007', 'AntiForteWermix', 'Antidesparasitante', 'med.jpg', 70, 1.87, 1, '2022-01-12', 'A'),
(8, 4, '00008', 'Dog Chow', 'comida para perros grandes', 'sssdd.jpg', 10, 0.98, 0.73, '2022-01-14', 'A'),
(9, 4, '00009', 'Pure Nature', 'comida humeda para perros', 'fff.jpeg', 0, 1.6, 1.68, '2022-01-14', 'A'),
(10, 17, '0008', 'Aspirina', 'aspirijnansfjsafjbjksbfjskbfkjsdfsdfsdf', 'fff.jpeg', 10, 0.25, 0, '2022-01-18', 'A'),
(11, 17, '85561484', 'Aspirina', 'afsfasfnfsjibfsuifbkjdsbfksdbfsdhkfsdfsdf', 'fff.jpeg', 0, 1.5, 1.57, '2022-01-18', 'A'),
(14, 1, '000095', 'Parasital', '', '41kI51ZRfhL.jpg', 10, 2, 0, '2022-02-03', 'A'),
(15, 17, '000546546', 'Apixabán ', 'Apixabán ', '41kI51ZRfhL.jpg', 60, 1.1, 0, '2022-02-04', 'A'),
(16, 13, '05454564648', 'Netx Gard', 'Uso veterinario mata pulgas garra[atas altamente palatavel', 'productodefault.jpg', 0, 0, 0, '2022-02-05', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `ruc` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `razon_social` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `ruc`, `razon_social`, `telefono`, `correo`, `direccion`, `estado`) VALUES
(1, '0912154654546', 'DAG Cia. Ltda.', '0994017050', 'https://www.dag-nutricionanimal.com/', 'Quito, Ecuador Av Teniente Hugo Ortiz Mercado Mayorista, #80 170102', 'A'),
(2, '1345423132184', 'Agripac ', '5934373870', 'info@agripac.com.ec', 'Matriz: General Córdova No. 623 y Padre Solano\nSanta Elena- Ecuador', 'A'),
(3, '0841213156512', 'Farm Agro', '0238221910', '', 'Dirección: Cdla. Los Vergeles Calle 23A Dr. Carlos Julio Arosemena No 1667 Interseccion avenida G2857', 'A'),
(4, '2400032559001', 'Zona Rosa e buro', '0988380828', 'zr@encantodemujer.com', 'via la upse', 'A'),
(5, '1321546318546', 'Asd', '', '', '', 'I');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `raza`
--

CREATE TABLE `raza` (
  `id` int(11) NOT NULL,
  `raza` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `raza`
--

INSERT INTO `raza` (`id`, `raza`, `estado`) VALUES
(1, 'Pastor Alemán', 'A'),
(2, 'labrador', 'A'),
(3, 'Persa', 'A'),
(4, 'Siamés', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta`
--

CREATE TABLE `receta` (
  `id` int(11) NOT NULL,
  `cita_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `pagado` varchar(1) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total` float DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `receta`
--

INSERT INTO `receta` (`id`, `cita_id`, `doctor_id`, `pagado`, `fecha`, `total`, `descripcion`, `estado`) VALUES
(1, 7, 2, 'S', '2022-01-25', 3.75, 'Fsdfs', 'A'),
(2, 4, 2, 'S', '2022-01-25', 3.21, 'Assfddsgsdsdgsgd', 'A'),
(3, 5, 2, 'S', '2022-01-25', 3.21, 'Fdjfgkfgk', 'A'),
(4, 1, 1, 'N', '2022-01-25', 0, 'Dsaadsaasd', 'A'),
(5, 1, 1, 'S', '2022-01-25', 7.5, 'Dsaadsaasd', 'A'),
(6, 2, 1, 'S', '2022-01-25', 3.75, 'Fhghgfhgfhf', 'A'),
(7, 6, 1, 'S', '2022-01-25', 3.21, 'Fasfas', 'A'),
(8, 3, 1, 'S', '2022-01-25', 3.75, 'Kkll', 'A'),
(9, 8, 1, 'N', '2022-01-25', 6.42, 'Higyig', 'A'),
(10, 9, 2, 'S', '2022-01-26', 3.75, 'Zxxxcvbn', 'A'),
(11, 10, 2, 'S', '2022-01-27', 3.21, 'Sdffsdfds', 'A'),
(12, 11, 2, 'S', '2022-01-27', 3.75, 'Sgsgs', 'A'),
(13, 12, 2, 'S', '2022-01-27', 3.75, 'Dxvdss', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`, `estado`) VALUES
(1, 'Administrador', 'A'),
(2, 'Recepcionista', 'A'),
(3, 'Doctor', 'A'),
(4, 'Asistente Ventas', 'A'),
(5, 'Cliente', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sastifaccion`
--

CREATE TABLE `sastifaccion` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `detalle_id` int(11) DEFAULT NULL,
  `valoracion` char(1) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sastifaccion`
--

INSERT INTO `sastifaccion` (`id`, `cliente_id`, `detalle_id`, `valoracion`, `fecha`, `estado`) VALUES
(1, 20, 4, 'P', '2022-02-06', 'A'),
(2, 18, 5, 'P', '2022-02-06', 'A'),
(3, 15, 3, 'P', '2022-02-06', 'A'),
(4, 14, 2, 'N', '2022-02-06', 'A'),
(5, 18, 1, 'N', '2022-02-06', 'A'),
(6, 13, 5, 'P', '2022-02-07', 'A'),
(7, 16, 1, 'N', '2022-02-07', 'A'),
(8, 8, 4, 'P', '2022-02-07', 'A'),
(9, 19, 2, 'N', '2022-02-07', 'A'),
(10, 20, 5, 'P', '2022-02-07', 'A'),
(11, 12, 5, 'P', '2022-02-07', 'A'),
(12, 16, 4, 'P', '2022-02-07', 'A'),
(13, 15, 5, 'P', '2022-02-07', 'A'),
(14, 14, 5, 'P', '2022-02-07', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre_servicio` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre_servicio`, `precio`, `estado`) VALUES
(1, 'Consultas', 15, 'A'),
(2, 'Cirugias', 100, 'A'),
(3, 'Desparacitacion', 10, 'A'),
(4, 'Vitaminas', 10, 'A'),
(5, 'Tratamientos', 20, 'A'),
(6, 'Baños Medicados', 25, 'A'),
(7, 'Emergencias', 25, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE `sexo` (
  `id` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`id`, `tipo`, `estado`) VALUES
(1, 'Masculino', 'A'),
(2, 'Femenino', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_mascota`
--

CREATE TABLE `tipo_mascota` (
  `id` int(11) NOT NULL,
  `nombre_tipo` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_mascota`
--

INSERT INTO `tipo_mascota` (`id`, `nombre_tipo`, `estado`) VALUES
(1, 'Perro', 'A'),
(2, 'Gato', 'A'),
(3, 'Aves', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

CREATE TABLE `transaccion` (
  `id` int(11) NOT NULL,
  `tipo_movimiento` varchar(1) DEFAULT NULL,
  `ventas_id` int(11) DEFAULT NULL,
  `compras_id` int(11) DEFAULT NULL,
  `receta_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `transaccion`
--

INSERT INTO `transaccion` (`id`, `tipo_movimiento`, `ventas_id`, `compras_id`, `receta_id`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 'E', NULL, 1, NULL, '2022-01-31', '2022-02-01 04:30:51', '2022-02-01 04:30:51'),
(2, 'E', NULL, 2, NULL, '2022-01-31', '2022-02-01 04:32:30', '2022-02-01 04:32:30'),
(3, 'S', 1, NULL, NULL, '2022-01-31', '2022-02-01 04:34:06', '2022-02-01 04:34:06'),
(4, 'E', NULL, 3, NULL, '2022-02-02', '2022-02-03 01:47:37', '2022-02-03 01:47:37'),
(5, 'E', NULL, 5, NULL, '2022-02-02', '2022-02-03 01:49:54', '2022-02-03 01:49:54'),
(6, 'S', 2, NULL, NULL, '2022-02-02', '2022-02-03 01:51:07', '2022-02-03 01:51:07'),
(7, 'S', 3, NULL, NULL, '2022-02-02', '2022-02-03 01:51:34', '2022-02-03 01:51:34'),
(8, 'E', NULL, 6, NULL, '2022-02-04', '2022-02-04 21:40:21', '2022-02-04 21:40:21'),
(9, 'E', NULL, 7, NULL, '2022-02-04', '2022-02-04 21:41:37', '2022-02-04 21:41:37'),
(10, 'E', NULL, 9, NULL, '2022-02-04', '2022-02-04 21:43:12', '2022-02-04 21:43:12'),
(11, 'E', NULL, 10, NULL, '2022-02-04', '2022-02-04 22:08:04', '2022-02-04 22:08:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento`
--

CREATE TABLE `tratamiento` (
  `id` int(11) NOT NULL,
  `historial_clinico_id` int(11) NOT NULL,
  `descripcion` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `usuario` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `password2` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `persona_id`, `roles_id`, `usuario`, `correo`, `password`, `password2`, `imagen`, `estado`) VALUES
(1, 1, 1, 'danny_791', 'danny_791@hotmail.es', '668e2b73ac556a2f051304702da290160b29bad3392ddcc72074fefbee80c55a', '668e2b73ac556a2f051304702da290160b29bad3392ddcc72074fefbee80c55a', 'userdefault.png', 'A'),
(2, 2, 3, 'brenda', 'brenda@gmail.com', '94dc354ccaa14e47b774467966de2b443e428ae8ed4849d4e423fb387463d9a0', '94dc354ccaa14e47b774467966de2b443e428ae8ed4849d4e423fb387463d9a0', 'userdefault.png', 'A'),
(3, 3, 3, 'jose', 'jose@gmail.com', '1ec4ed037766aa181d8840ad04b9fc6e195fd37dedc04c98a5767a67d3758ece', '1ec4ed037766aa181d8840ad04b9fc6e195fd37dedc04c98a5767a67d3758ece', 'userdefault.png', 'A'),
(4, 4, 2, 'maria', 'maria@gmail.com', '94aec9fbed989ece189a7e172c9cf41669050495152bc4c1dbf2a38d7fd85627', '94aec9fbed989ece189a7e172c9cf41669050495152bc4c1dbf2a38d7fd85627', 'userdefault.png', 'A'),
(6, 8, 5, 'juanita', 'juanita@gmail.com', 'af766babb9f08e9c1a10a6eae5a048e53169f4d3824e3861f759f750a85b029b', 'af766babb9f08e9c1a10a6eae5a048e53169f4d3824e3861f759f750a85b029b', 'userdefault.png', 'A'),
(7, 9, 5, 'marcos', 'marcos@gmail.com', '43f1efecd33031b0ccd142b1c5cccc44ea19ad3e7a947965c5b0c16a632b5d7b', '43f1efecd33031b0ccd142b1c5cccc44ea19ad3e7a947965c5b0c16a632b5d7b', 'userdefault.png', 'A'),
(8, 10, 4, 'alejandro', 'alejandro@hotmail.com', 'a9010fd21a93c687b3c4c506313993b5a2ade87b719d09792b120a27b852f749', 'a9010fd21a93c687b3c4c506313993b5a2ade87b719d09792b120a27b852f749', 'userdefault.png', 'A'),
(9, 12, 5, 'patricio', 'patricio@gmail.com', '7d1bee543bf4c50e925a5f80bfea95128d1766ebc717a9f14936ac008204d2e9', '7d1bee543bf4c50e925a5f80bfea95128d1766ebc717a9f14936ac008204d2e9', 'userdefault.png', 'A'),
(10, 13, 5, 'juan', 'juan16@hotmail.com', 'ed08c290d7e22f7bb324b15cbadce35b0b348564fd2d5f95752388d86d71bcca', 'ed08c290d7e22f7bb324b15cbadce35b0b348564fd2d5f95752388d86d71bcca', 'userdefault.png', 'A'),
(11, 15, 5, 'dd', 'ruth@hotmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'userdefault.png', 'A'),
(12, 16, 5, 'brando', 'brando@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'userdefault.png', 'A'),
(13, 17, 5, 'RICAR', 'ricardo@g.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'userdefault.png', 'A'),
(14, 18, 5, 'joshep', 'joshep@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'userdefault.png', 'A'),
(15, 19, 5, 'juliana', 'juliana@hotmail.com', 'aa4c231348ed81024de144fdc13020a000d718eec0e7deb86ceb2158ce60bbb0', 'aa4c231348ed81024de144fdc13020a000d718eec0e7deb86ceb2158ce60bbb0', 'userdefault.png', 'A'),
(16, 20, 5, 'juan', 'juanca@gmai.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'userdefault.png', 'A'),
(17, 21, 5, 'juanito', 'juanito123@gmail.com', '46b2150accc75b4ae7b461fe4f5dde39512d2e034ee4d91df9c09b9bd0e090c9', '46b2150accc75b4ae7b461fe4f5dde39512d2e034ee4d91df9c09b9bd0e090c9', 'userdefault.png', 'A'),
(18, 22, 5, 'fernanda99', 'fernanda@gmail.com', '92c778ed016379a4bb64f46d261dee6575c054785204d7f8c8cef9b77c414aa6', '92c778ed016379a4bb64f46d261dee6575c054785204d7f8c8cef9b77c414aa6', 'userdefault.png', 'A'),
(19, 23, 5, 'maria', 'mariayagual@gmail.com', '94aec9fbed989ece189a7e172c9cf41669050495152bc4c1dbf2a38d7fd85627', '94aec9fbed989ece189a7e172c9cf41669050495152bc4c1dbf2a38d7fd85627', '', 'A'),
(20, 24, 5, 'luisa22', 'luisa@gmail.com', '73e4935fcd6dfbc26aa88d49b1304bff6f1dfdcfaa021e72e73d06025286eb1c', '73e4935fcd6dfbc26aa88d49b1304bff6f1dfdcfaa021e72e73d06025286eb1c', '', 'A'),
(21, 5, 5, 'juanpablo', 'juanpablo@hotmail.com', 'f758486eb6f335ea87b37a3cd4ee7236b5d48fbc03776b21bd9e931ca8bdab3f', 'f758486eb6f335ea87b37a3cd4ee7236b5d48fbc03776b21bd9e931ca8bdab3f', 'userdefault.png', 'A'),
(22, 25, 5, 'karla', 'karla99@gmail.com', '1cfcffbd0d0536e2b354a0bbe9a0df8f7c15b26293e99ce5bd468e1716154295', '1cfcffbd0d0536e2b354a0bbe9a0df8f7c15b26293e99ce5bd468e1716154295', '', 'A'),
(23, 26, 5, 'teresa', 'teresa@gmail.com', '9e88b067408182d0bd525120e9ba2607e19b0dfa17b48582d2d405fc52dc4a1a', '9e88b067408182d0bd525120e9ba2607e19b0dfa17b48582d2d405fc52dc4a1a', '', 'A'),
(24, 27, 5, 'karen', 'karen@gmail.com', '904294d8c54b1c63e40832fa1d95bcde534b310df6d42882ce4baf28f3e0184a', '904294d8c54b1c63e40832fa1d95bcde534b310df6d42882ce4baf28f3e0184a', '', 'A'),
(25, 28, 5, 'andrea', 'andrea1@gmail.com', '5f3d6952c5c5e22077fabf461de80f1ce475752fe75afcf5ca46bac438405619', '5f3d6952c5c5e22077fabf461de80f1ce475752fe75afcf5ca46bac438405619', '', 'A'),
(26, 29, 5, 'rita', 'rita@gmail.com', 'c5420b43786b20f6cd116002a483b128e9d24020852c5e1c53731e25f40217f0', 'c5420b43786b20f6cd116002a483b128e9d24020852c5e1c53731e25f40217f0', '', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `descuento` double NOT NULL,
  `subtotal` double NOT NULL,
  `iva` double NOT NULL,
  `total` double NOT NULL,
  `fecha_venta` date NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `numero_venta` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `cliente_id`, `usuario_id`, `descuento`, `subtotal`, `iva`, `total`, `fecha_venta`, `estado`, `numero_venta`) VALUES
(1, 1, 8, 0, 31.4, 3.77, 35.17, '2022-01-31', 'A', '2c6e5'),
(2, 1, 8, 0, 3.14, 0.38, 3.52, '2022-02-02', 'A', 'e4e56'),
(3, 12, 8, 0, 30, 3.6, 33.6, '2022-02-02', 'A', '822dd');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `antecedentes`
--
ALTER TABLE `antecedentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_antecedentes_historial_clinico` (`historial_clinico_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_citas_doctor` (`doctor_id`),
  ADD KEY `fk_citas_cliente` (`cliente_id`),
  ADD KEY `fk_cliente_servicios` (`servicios_id`),
  ADD KEY `fk_cliente_estado_cita` (`estado_cita_id`),
  ADD KEY `fk_citas_mascota` (`mascota_id`),
  ADD KEY `fk_citas_horarios_atencion` (`horarios_atencion_id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cliente_persona` (`persona_id`);

--
-- Indices de la tabla `codigos`
--
ALTER TABLE `codigos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compras_proveedor` (`proveedor_id`),
  ADD KEY `fk_compras_usuario` (`usuario_id`);

--
-- Indices de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalle_compra_compras` (`compras_id`),
  ADD KEY `fk_detalle_compra_producto` (`producto_id`);

--
-- Indices de la tabla `detalle_receta`
--
ALTER TABLE `detalle_receta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_deallereceta_receta` (`receta_id`),
  ADD KEY `fk_detallereceta_producto` (`producto_id`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalle_venta_venta` (`ventas_id`),
  ADD KEY `fk_detalle_venta_producto` (`producto_id`);

--
-- Indices de la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctor_persona` (`persona_id`);

--
-- Indices de la tabla `doctor_horario`
--
ALTER TABLE `doctor_horario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dh_doctor` (`doctor_id`),
  ADD KEY `fk_dh_horario_atencion` (`horarios_atencion_id`);

--
-- Indices de la tabla `estado_cita`
--
ALTER TABLE `estado_cita`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `examen_fisico`
--
ALTER TABLE `examen_fisico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_examen_hisotial_clinico` (`historial_clinico_id`);

--
-- Indices de la tabla `genero_mascota`
--
ALTER TABLE `genero_mascota`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_historial_clinico_cliente` (`cliente_id`),
  ADD KEY `fk_historial_mascota` (`mascota_id`);

--
-- Indices de la tabla `horarios_atencion`
--
ALTER TABLE `horarios_atencion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inventario_producto` (`producto_id`),
  ADD KEY `fk_inventario_transaccion` (`transaccion_id`);

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mascota_cliente` (`cliente_id`),
  ADD KEY `fk_mascota_genero_mascota` (`genero_mascota_id`),
  ADD KEY `fk_mascota_tipo_mascota` (`tipo_mascota_id`),
  ADD KEY `fk_mascota_raza` (`raza_id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_permisos_rol` (`rol_id`),
  ADD KEY `fk_permisos_menu` (`menu_id`);

--
-- Indices de la tabla `perscripcion`
--
ALTER TABLE `perscripcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_perscripcion_historial_clinico` (`historial_clinico_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sexo_id` (`sexo_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_categoria` (`categoria_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `raza`
--
ALTER TABLE `raza`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `receta`
--
ALTER TABLE `receta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cita_id` (`cita_id`),
  ADD KEY `producto_id` (`doctor_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sastifaccion`
--
ALTER TABLE `sastifaccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sastifaccion_cliente` (`cliente_id`),
  ADD KEY `fk_sastifaccion_detalle` (`detalle_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_mascota`
--
ALTER TABLE `tipo_mascota`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_id` (`compras_id`),
  ADD KEY `fk_transaccion_venta` (`ventas_id`),
  ADD KEY `receta_id` (`receta_id`);

--
-- Indices de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tratamiento_historial_clinico` (`historial_clinico_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_persona` (`persona_id`),
  ADD KEY `fk_usuario_roles` (`roles_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ventas_usuario` (`usuario_id`),
  ADD KEY `fk_ventas_clientes` (`cliente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `antecedentes`
--
ALTER TABLE `antecedentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `codigos`
--
ALTER TABLE `codigos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle`
--
ALTER TABLE `detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_receta`
--
ALTER TABLE `detalle_receta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `doctor_horario`
--
ALTER TABLE `doctor_horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `estado_cita`
--
ALTER TABLE `estado_cita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `examen_fisico`
--
ALTER TABLE `examen_fisico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `genero_mascota`
--
ALTER TABLE `genero_mascota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `horarios_atencion`
--
ALTER TABLE `horarios_atencion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `perscripcion`
--
ALTER TABLE `perscripcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `raza`
--
ALTER TABLE `raza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `receta`
--
ALTER TABLE `receta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sastifaccion`
--
ALTER TABLE `sastifaccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_mascota`
--
ALTER TABLE `tipo_mascota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `antecedentes`
--
ALTER TABLE `antecedentes`
  ADD CONSTRAINT `fk_antecedentes_historial_clinico` FOREIGN KEY (`historial_clinico_id`) REFERENCES `historial_clinico` (`id`);

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_citas_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `fk_citas_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`),
  ADD CONSTRAINT `fk_citas_horarios_atencion` FOREIGN KEY (`horarios_atencion_id`) REFERENCES `horarios_atencion` (`id`),
  ADD CONSTRAINT `fk_citas_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascota` (`id`),
  ADD CONSTRAINT `fk_cliente_estado_cita` FOREIGN KEY (`estado_cita_id`) REFERENCES `estado_cita` (`id`),
  ADD CONSTRAINT `fk_cliente_servicios` FOREIGN KEY (`servicios_id`) REFERENCES `servicios` (`id`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_persona` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`),
  ADD CONSTRAINT `fk_compras_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_detalle_compra_compras` FOREIGN KEY (`compras_id`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `fk_detalle_compra_producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `detalle_receta`
--
ALTER TABLE `detalle_receta`
  ADD CONSTRAINT `fk_deallereceta_receta` FOREIGN KEY (`receta_id`) REFERENCES `receta` (`id`),
  ADD CONSTRAINT `fk_detallereceta_producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_detalle_venta_producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `fk_detalle_venta_venta` FOREIGN KEY (`ventas_id`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `fk_doctor_persona` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `doctor_horario`
--
ALTER TABLE `doctor_horario`
  ADD CONSTRAINT `fk_dh_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`),
  ADD CONSTRAINT `fk_dh_horario_atencion` FOREIGN KEY (`horarios_atencion_id`) REFERENCES `horarios_atencion` (`id`);

--
-- Filtros para la tabla `examen_fisico`
--
ALTER TABLE `examen_fisico`
  ADD CONSTRAINT `fk_examen_hisotial_clinico` FOREIGN KEY (`historial_clinico_id`) REFERENCES `historial_clinico` (`id`);

--
-- Filtros para la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD CONSTRAINT `fk_historial_clinico_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `fk_historial_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascota` (`id`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inventario_producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `fk_inventario_transaccion` FOREIGN KEY (`transaccion_id`) REFERENCES `transaccion` (`id`);

--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `fk_mascota_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `fk_mascota_genero_mascota` FOREIGN KEY (`genero_mascota_id`) REFERENCES `genero_mascota` (`id`),
  ADD CONSTRAINT `fk_mascota_raza` FOREIGN KEY (`raza_id`) REFERENCES `raza` (`id`),
  ADD CONSTRAINT `fk_mascota_tipo_mascota` FOREIGN KEY (`tipo_mascota_id`) REFERENCES `tipo_mascota` (`id`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `fk_permisos_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `fk_permisos_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `perscripcion`
--
ALTER TABLE `perscripcion`
  ADD CONSTRAINT `fk_perscripcion_historial_clinico` FOREIGN KEY (`historial_clinico_id`) REFERENCES `historial_clinico` (`id`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_persona_sexo` FOREIGN KEY (`sexo_id`) REFERENCES `sexo` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

--
-- Filtros para la tabla `receta`
--
ALTER TABLE `receta`
  ADD CONSTRAINT `fk_receta_cita` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`),
  ADD CONSTRAINT `fk_receta_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

--
-- Filtros para la tabla `sastifaccion`
--
ALTER TABLE `sastifaccion`
  ADD CONSTRAINT `fk_sastifaccion_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `fk_sastifaccion_detalle` FOREIGN KEY (`detalle_id`) REFERENCES `detalle` (`id`);

--
-- Filtros para la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD CONSTRAINT `fk_transaccion_compra` FOREIGN KEY (`compras_id`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `fk_transaccion_receta` FOREIGN KEY (`receta_id`) REFERENCES `receta` (`id`),
  ADD CONSTRAINT `fk_transaccion_venta` FOREIGN KEY (`ventas_id`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD CONSTRAINT `fk_tratamiento_historial_clinico` FOREIGN KEY (`historial_clinico_id`) REFERENCES `historial_clinico` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_persona` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `fk_usuario_roles` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `fk_ventas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
