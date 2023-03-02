-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2023 a las 03:56:28
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `libros_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `libros` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `fecha_pedido` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `libros`, `total`, `usuario`, `fecha_pedido`) VALUES
(20, 'Lo que el viento se llevó', '60.00', 'juan', '2023-03-02'),
(21, 'Orgullo y prejuicio', '60.00', 'juan', '2023-03-02'),
(22, 'IT', '30.00', 'juan', '2023-03-02'),
(23, 'El fin de los días', '15.00', 'juan', '2023-03-02'),
(24, 'El bazar de los malos sueños', '20.00', 'juan', '2023-03-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `editorial` varchar(255) NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `genero` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`id`, `titulo`, `autor`, `editorial`, `fecha_publicacion`, `genero`, `precio`, `imagen`, `descripcion`) VALUES
(1, 'Lo que el viento se llevó', 'Margaret Mitchell', '1', '2023-01-10', 'Amor', '15.00', '', 'Libro de amor'),
(2, 'Orgullo y prejuicio', 'Jane Austen', '1', '2023-03-07', 'Amor', '20.00', '', 'Libro de amor'),
(3, 'La historia de amor mas bonita del mundo', 'Ali HazelWood', '1', '2023-03-02', 'Amor', '25.00', '', 'Libro de amor\r\n'),
(4, 'Un cuento perfecto', 'Elísabet Benavent', '1', '2023-03-04', 'Amor', '30.00', '', 'Libro de amor'),
(5, 'El beso que no te dí', 'Magdalena Lasala', '1', '2023-02-02', 'Amor', '10.00', '', 'Libro de amor'),
(6, 'El amor no duele', 'Montse Barderi', '1', '2023-03-07', 'Amor', '10.00', '', 'Libro de amor'),
(7, 'El bazar de los malos sueños', 'Sthepen King', '2', '2023-03-02', 'Terror', '20.00', '', 'Libro de terror'),
(8, 'El fin de los días', 'Adam Nevill', '2', '2023-03-05', 'Terror', '15.00', '', 'Libro de terror'),
(9, 'IT', 'Sthepen King', '2', '2023-02-21', 'Terror', '30.00', '', 'Libro de terror'),
(10, 'Mi esposa y yo compramos un rancho', 'Matt y Harrison Query', '2', '2023-03-17', 'Terror', '15.00', '', 'Libro de terror'),
(11, 'Susurros en la oscuridad', 'Laurel Hightower', '2', '2023-02-08', 'Terror', '25.00', '', 'Libro de terror'),
(12, 'Anhelo', 'Tracy Wolff', '2', '2023-02-02', 'Terror', '20.00', '', 'Libro de terror');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `metodo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id`, `monto`, `fecha`, `usuario`, `metodo`) VALUES
(1, '2.00', '0000-00-00', 'juan', 'tarjeta'),
(2, '2.00', '0000-00-00', 'juan', 'tarjeta'),
(3, '2.00', '0000-00-00', 'juan', 'tarjeta'),
(4, '2.00', '0000-00-00', 'juan', 'tarjeta'),
(5, '2.00', '0000-00-00', 'juan', 'tarjeta'),
(6, '2.00', '0000-00-00', 'juan', 'tarjeta'),
(7, '2.00', '0000-00-00', 'juan', 'tarjeta'),
(8, '1.00', '0000-00-00', 'juan', 'tarjeta'),
(9, '1.00', '0000-00-00', 'juan', 'tarjeta'),
(10, '1.00', '0000-00-00', 'juan', 'tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `libros` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` date NOT NULL,
  `direccion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `correo`, `password`, `fecha_registro`, `direccion`) VALUES
(2, 'juan', 'vsdfsfgad@asdfgasd.com', '827ccb0eea8a706c4c34a16891f84e7b', '2023-02-10', 'sdfgdfg'),
(3, 'pepe', 'juan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2023-02-10', 'hola'),
(4, 'flores', 'floresmjuan17@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2023-02-10', 'hola'),
(5, 'alejandro', 'hola@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2023-02-10', 'sdfgdfg'),
(6, 'juan', 'juan@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2023-03-01', 'sadfasdf');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
