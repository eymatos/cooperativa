-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-07-2019 a las 14:37:41
-- Versión del servidor: 5.6.41-84.1
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cooproco_amr`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion_herramienta`
--

CREATE TABLE `accion_herramienta` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprender_divertido`
--

CREATE TABLE `aprender_divertido` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula_creativo`
--

CREATE TABLE `aula_creativo` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula_quimica`
--

CREATE TABLE `aula_quimica` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `biceps`
--

CREATE TABLE `biceps` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambiar_mundo`
--

CREATE TABLE `cambiar_mundo` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coalicion_docentes`
--

CREATE TABLE `coalicion_docentes` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corazon_mirada`
--

CREATE TABLE `corazon_mirada` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desafio_escuela`
--

CREATE TABLE `desafio_escuela` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educacion_economia`
--

CREATE TABLE `educacion_economia` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `educacion_economia`
--

INSERT INTO `educacion_economia` (`id`, `cedula`, `nombre`, `apellido`, `institucion`) VALUES
(1, '402-3508865-1', 'Adriana', 'Ramírez Santiago', 'ISFODOSU');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fondo_innovacion`
--

CREATE TABLE `fondo_innovacion` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fundacion_varkey`
--

CREATE TABLE `fundacion_varkey` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_proyecto`
--

CREATE TABLE `gestion_proyecto` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ideas_sombrero`
--

CREATE TABLE `ideas_sombrero` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `igenieria_cognitiva`
--

CREATE TABLE `igenieria_cognitiva` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inclusion_escuela`
--

CREATE TABLE `inclusion_escuela` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `innovacion_calidad`
--

CREATE TABLE `innovacion_calidad` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `innovacion_transformacion`
--

CREATE TABLE `innovacion_transformacion` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juveniles_experiencia`
--

CREATE TABLE `juveniles_experiencia` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_ideice`
--

CREATE TABLE `libro_ideice` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestro_energia`
--

CREATE TABLE `maestro_energia` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medio_transformador`
--

CREATE TABLE `medio_transformador` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mentoria_docentes`
--

CREATE TABLE `mentoria_docentes` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `panel_expertos`
--

CREATE TABLE `panel_expertos` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedagogia_loto`
--

CREATE TABLE `pedagogia_loto` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_mejora`
--

CREATE TABLE `planes_mejora` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planificacion_evaluacion`
--

CREATE TABLE `planificacion_evaluacion` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `portafolio_digital`
--

CREATE TABLE `portafolio_digital` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `cedula` varchar(14) DEFAULT NULL,
  `nombre` varchar(23) DEFAULT NULL,
  `apellido` varchar(28) DEFAULT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `celular` varchar(10) DEFAULT NULL,
  `correo` varchar(10) DEFAULT NULL,
  `institucion` varchar(64) DEFAULT NULL,
  `tipoinstitucion` varchar(10) DEFAULT NULL,
  `cargo` varchar(10) DEFAULT NULL,
  `regional` varchar(10) DEFAULT NULL,
  `distrito` varchar(10) DEFAULT NULL,
  `redes` varchar(10) DEFAULT NULL,
  `asistenciaespecial` varchar(10) DEFAULT NULL,
  `participaras` varchar(10) DEFAULT NULL,
  `teenteraste` varchar(10) DEFAULT NULL,
  `participaste` varchar(10) DEFAULT NULL,
  `notificaciones` varchar(10) DEFAULT NULL,
  `taller` varchar(10) DEFAULT NULL,
  `fecha1` varchar(10) DEFAULT NULL,
  `fecha2` varchar(10) DEFAULT NULL,
  `fecha3` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`cedula`, `nombre`, `apellido`, `sexo`, `celular`, `correo`, `institucion`, `tipoinstitucion`, `cargo`, `regional`, `distrito`, `redes`, `asistenciaespecial`, `participaras`, `teenteraste`, `participaste`, `notificaciones`, `taller`, `fecha1`, `fecha2`, `fecha3`) VALUES
('402-0051984-7', 'Ámbar', 'Andújar', '', '', '', 'Ad Maiora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2567715-8', 'Gleybet', 'Sabido', '', '', '', 'Ad Maiora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0910934-8', 'Raquel', 'Brito Jiménez', '', '', '', 'Ad Maiora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0790390-8', 'Marisela', 'Bencosme', '', '', '', 'American School', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1570734-1', 'Elisa', 'Vilorio de la Cruz', '', '', '', 'Ángeles Custodios', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-4579498-3', 'Diana', 'García Revilla', '', '', '', 'Asociación Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0080554-8', 'Clarineisy', 'Frías Pérez', '', '', '', 'Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0015909-4', 'Yenny Zaira', 'Rosario Alcántara', '', '', '', 'Ave María, Villa Mella', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0145476-9', 'Jordan Manuel', 'Reyes Alfonso', '', '', '', 'Cardenal Sancha', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0404115-7', 'Celeste', 'González Jáquez', '', '', '', 'Centro Cultural Poveda', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('024-0027465-6', 'Diomaris', 'García Acosta', '', '', '', 'Centro Cultural Poveda', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0008464-9', 'Francisca del Carmen', 'Ferreira Genao', '', '', '', 'Centro Cultural Poveda', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0434045-0', 'Perfecta', 'Ferreira', '', '', '', 'Centro Cultural Poveda', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0157361-6', 'Zoila Arelis', 'Montás', '', '', '', 'Centro Cultural Poveda', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0048361-8', 'Lety Altagraciia ', 'Pimentel Pimentel', '', '', '', 'Centro De Excelencia Melba Baéz De Erazo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0000892-8', 'Altagracia', 'García', '', '', '', 'Centro de Excelencia Melba Báez de Erazo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0012001-2', 'Carlos', 'Silvestre Guerrero', '', '', '', 'Centro de Excelencia Melba Báez de Erazo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0065134-7', 'Damiamny', 'Peréz Palmero', '', '', '', 'Centro de Excelencia Melba Báez de Erazo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0001594-0', 'Juana', 'Gil', '', '', '', 'Centro de Excelencia Melba Báez de Erazo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1016620-4', 'Francia', 'Carvajal', '', '', '', 'Centro de Excelencia Profesor Luis Encarnación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('048-0066411-4', 'Claribel', 'De Jesús Ruviera', '', '', '', 'Centro de Formacion Integral Cigar Family', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('048-0099433-9', 'Rosmery', 'Elena', '', '', '', 'Centro de Formación Integral Cigar Family', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0187737-1', 'Ana Lucila', 'De los Santos Ventura', '', '', '', 'Centro de Integración Familiar', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-0957732-5', 'Jorgina', 'Pujols', '', '', '', 'Centro de Integración Familiar', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1895030-2', 'Luisanna', 'Maldonado Genao', '', '', '', 'Centro de Integración Familiar', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0963241-4', 'Claudia', 'Guerra', '', '', '', 'Centro Educativo Alicia Guerra', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0048465-7', 'Rafael Antonio', 'Casado Abreu', '', '', '', 'Centro Educativo Bartolomé Olegario Pérez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('048-0044855-9', 'Alejandro', 'Martínez Paulino', '', '', '', 'Centro Educativo Cigar Family', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0498292-5', 'Stephannie', 'Polanco Rodríguez', '', '', '', 'Centro Educativo Cristiano Amanecer', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1722815-5', 'Katherine', 'Suárez Batista', '', '', '', 'Centro Educativo Divina Providencia', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2359791-1', 'Dianny Carolina', 'Pérez Rámirez', '', '', '', 'Centro Educativo El Buen Pastor', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('014-0014074-3', 'Domingo', 'Bocio Nova', '', '', '', 'Centro Educativo El Buen Pastor', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0078441-1', 'Keyly María', 'Carrasco Pérez', '', '', '', 'Centro Educativo El Buen Pastor', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0070423-2', 'Cristian', 'Jean', '', '', '', 'Centro Educativo Felipe Vicini Perdomo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2161923-8', 'Rosa Carolina', 'Mesa Jacobo', '', '', '', 'Centro Educativo Felipe Vicini Perdomo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('034-0051412-5', 'Russevely', 'Rodríguez Collado', '', '', '', 'Centro Educativo Francisco Del Rosario Sánchez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0990957-2', 'Milka Esther', 'Alcántara Molina', '', '', '', 'Centro Educativo Madre Teresa de Calcuta', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0170138-7', 'Iselsa', 'Ángeles Tejada', '', '', '', 'Centro Educativo Manuel Acevedo Serrano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0055651-9', 'Nuris Altagracia', 'Toribio', '', '', '', 'Centro Educativo Manuel Acevedo Serrano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0301394-6', 'Mariele', 'Pimentel', '', '', '', 'Centro Educativo Manuela Díez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0082817-6', 'Juan Bautista', 'Heredia Cabrera', '', '', '', 'Centro Educativo Marcos Castañer, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('104-0017710-0', 'Juana Ybelisse', 'Mejía Ortíz', '', '', '', 'Centro Educativo Marcos Castañer, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('201-670874', 'Wilquin', 'Solano Piña', '', '', '', 'Centro Educativo Marcos Castañer, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0020128-0', 'Ramona Yulisa', 'Regalado Henriquez', '', '', '', 'Centro Educativo María Auxiliadora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0030402-7', 'Rosario Altagracia', 'Torres Torres', '', '', '', 'Centro Educativo María Auxiliadora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0336297-6', 'Sor Aracelis Altagracia', 'Infante Monegro', '', '', '', 'Centro Educativo María Auxiliadora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1785051-1', 'Indhira', 'Cornelio', '', '', '', 'Centro Educativo María Inmaculada', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1890008-3', 'Noelia', 'Gutiérrez', '', '', '', 'Centro Educativo María Inmaculada', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0397423-4', 'Theamnis', 'Vargas', '', '', '', 'Centro Educativo María Inmculada', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0111617-2', 'Yrma', 'Pérez', '', '', '', 'Centro Educativo María Inmculada', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0027456-8', 'Lourdes', 'Florentino', '', '', '', 'Centro Educativo Marillac', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1045729-8', 'Noemí', 'Alcántara Valdez', '', '', '', 'Centro Educativo Marillac', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0000530-5', 'Albania', 'Alcántara', '', '', '', 'Centro Educativo Politécnico Virgen de la Altagracia', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0927545-3', 'Elena Mercedes', 'Rojas', '', '', '', 'Centro Educativo Rudy María Comas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('057-0011428-2', 'Mayra Caridad', 'Domínguez González', '', '', '', 'Centro Educativo Rudy María Comas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0066867-2', 'Bacilia', 'Aracena', '', '', '', 'Centro Educativo Salesiana San José', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2329874-2', 'Génesis', 'Cáceres', '', '', '', 'Centro Educativo Santo Cura De Ars', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0159534-0', 'Yaneiry Carolina', 'Guevara Polanco', '', '', '', 'Centro Felipe Vicini Perdomo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0082824-9', 'Clara Evangelina', 'Martínez Pérez', '', '', '', 'Centro María Auxiliadora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0946465-1', 'Crisoria', 'Dovil Cedano', '', '', '', 'Centro Melba Báez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('004-0022137-0', 'Wendy María', 'Mendoza', '', '', '', 'Centro Salesiano San José', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('034-0054440-3', 'Miledy ', 'Bejarán  Almonte', '', '', '', 'Centro Santa Teresita', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('034-0046945-', 'Santa Teresa', 'Ignacio ', '', '', '', 'Centro Santa Teresita', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0041056-8', 'Felicia', 'Pérez Ramírez', '', '', '', 'Centro Virginia Fidelina Matos De La Cruz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2140805-3', 'Maribel', 'Martínez de la Cruz', '', '', '', 'Centro Virginia Fidelina Matos De La Cruz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1651429-0', 'katelyn Melina', 'Espinal', '', '', '', 'CESCEAR', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0908866-6', 'Faustino Antonio', 'Marcelino Crisóstomo', '', '', '', 'CILGE', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0198049-8', 'Katia', 'Guzmán', '', '', '', 'Claro', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0036190-9', 'Minerva Ester ', 'Javier', '', '', '', 'Colegio Daher', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1112575-3', 'Cristian', 'De Oleo Tejada', '', '', '', 'Colegio Don Bosco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1298355-1', 'Eliana', 'Francisco Cuello', '', '', '', 'Colegio Eliezer', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0339411-0', 'Bárbara', 'Castillo González', '', '', '', 'Colegio María Auxiliadora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0078729-0', 'Sor Ana Lucía', 'Plasencia Castillo', '', '', '', 'Colegio Nuestra Señora de las Mercedes', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0127065-8', 'Brenda', 'Batista Rosario', '', '', '', 'Colegio O & M Hostos School', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2548200-5', 'Karina Altagracia', 'Fernández Medina', '', '', '', 'Colegio Santa Ana', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0224129-0', 'Sor Ana Mercedes', 'Duarte Duarte', '', '', '', 'Colegio Santa Ana', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('034-0041595-0', 'Milagros', 'Uceta', '', '', '', 'Colegio Santa Teresita de Mao', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0015375-4', 'Dulce', 'García', '', '', '', 'Colegio UNPHU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('050-0027348-1', 'Josefina Eunice', 'Bonifacio Durán', '', '', '', 'Colego Nuestra Señora de la Altagracia', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0055144-6', 'José del Carmen', 'Canario Encarnación', '', '', '', 'Dirección de Educación Técnico Profesional, MINERD', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0064916-9', 'Orfelina', 'Díaz Aponte', '', '', '', 'Dirección de Educación Técnico Profesional, MINERD', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1528881-3', 'Miguel Ángel', 'Ortiz', '', '', '', 'Dirección General de Educación Secundaria, MINERD', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1636841-6', 'Ronald', 'Santana', '', '', '', 'Direción Regional 10', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('044-0002212-7', 'Francisco Antonio', 'De la Cruz', '', '', '', 'Director Regional de la Regional 15', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0004345-3', 'Aura Estela', 'RAMÍREZ DÍAZ', '', '', '', 'Distrito Educativo 03-01', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('104-0007805-0', 'Denny Josefina', 'Nova Domínguez', '', '', '', 'Distrito Educativo 04-01', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0070565-5', 'Julia Gricel', 'Guzmán Pérez', '', '', '', 'Distrito Educativo 04-03', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0033917-4', 'Natividad', 'Concepción Pérez', '', '', '', 'Distrito Educativo 04-06', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('083-0001167-6', 'Yimy', 'Encarnación Marte', '', '', '', 'Distrito Educativo 04-07 ', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1440544-2', 'Greicy Marina', 'Cabrera', '', '', '', 'Distrito Educativo 10-02', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('039-0000170-6', 'Euclides Antonio', 'Hiraldo Cabrera', '', '', '', 'Distrito Educativo 10-03', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0945994-1', 'Ridelina ', 'Novas Medrano', '', '', '', 'Distrito Educativo 10-03', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('020-0002007-9', 'José', 'Peña', '', '', '', 'Distrito Educativo 10-04', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1297020-7', 'Andrea', 'Báez José', '', '', '', 'Distrito Educativo 10-05', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0602840-0', 'María Esther', 'Luna Bautista', '', '', '', 'Distrito Educativo 10-07', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0069797-5', 'Edisson', 'Tejeda Matos', '', '', '', 'Distrito Educativo 15-01', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0709722-2', 'Francisca', 'Tamares Soto', '', '', '', 'Distrito Educativo 15-01', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1581953-4', 'Hitleny', 'Almonte', '', '', '', 'Distrito Educativo 15-01', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0800199-1', 'Trinidad', 'Moreno', '', '', '', 'Distrito Educativo 15-02', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('053-0020981-3', 'Cristóbal', 'Peralta', '', '', '', 'Distrito Educativo 15-03', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0365323-4', 'María Del Carmen', 'Suero', '', '', '', 'Distrito Educativo 15-04', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0021944-9', 'Celestina', 'Beltrán Heredia', '', '', '', 'Distrito Educativo 15-06', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('049-0041378-4', 'Elizabeth', 'Reyes', '', '', '', 'Distrito Educativo 16-07', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-008560-7', 'Juan Fernando ', 'Rodríguez', '', '', '', 'Distrito Educativo 17-00', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0000026-0', 'Josefa Ramona', 'Acosta Guillén', '', '', '', 'Distrito Educativo 17-01', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0032053-3', 'Eddy Alexander', 'Antigua Santana', '', '', '', 'Distrito Educativo 17-02', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0020608-8', 'María Hildalicia', 'Aquino', '', '', '', 'Distrito Educativo 17-02', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0437969-2', 'Noemí', 'Reyes Rosario', '', '', '', 'Don Bosco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('052-0011166-3', 'Ramon Emilio', 'Frias Rubio', '', '', '', 'Don Pepe Álvarez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('104-0021632-0', 'Galicia', 'Encarnación', '', '', '', 'Eliceo Antonio Garabito', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0654878-7', 'Seneida', 'Ozuna', '', '', '', 'Escuela Básica Gautiere', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0131455-1', 'Yesenia', 'Capoix', '', '', '', 'Escuela Básica Profesor Sergio Augusto Veras', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2035720-2', 'Julián', 'García', '', '', '', 'Escuela Básica Un Milagro de Dios', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('0020028188-9', 'Juana', 'Pereyra Alc+antara', '', '', '', 'Escuela Carmen Celia Balaguer', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1586884-6', 'Cristina', 'Paula Aybar', '', '', '', 'Escuela Celina Pellier', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1118887-6', 'Amarilis Samuel', 'González de Acevedo', '', '', '', 'Escuela Comunal El Paraíso', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-116597-3', 'Alexandra', 'Vargas Lora', '', '', '', 'Escuela Comunitaria Mauricio Báez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1191401-6', 'Alicia', 'Eduardo', '', '', '', 'Escuela Comunitaria Mauricio Báez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0781852-8', 'Carmen', 'García', '', '', '', 'Escuela Comunitaria Mauricio Báez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1444894-7', 'Madelyn', 'García', '', '', '', 'Escuela Comunitaria Mauricio Báez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('123-0012242-6', 'María Antonia', 'Dominguez', '', '', '', 'Escuela Comunitaria Mauricio Báez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1328810-4', 'María', 'Melo', '', '', '', 'Escuela Cristo Obrero', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0022165-7', 'Anny Floiran', 'Chalas Martínez', '', '', '', 'Escuela Divina Pastora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0113817-9', 'Delida', 'Mercedes Rodríguez', '', '', '', 'Escuela Doctor Max Henríquez Ureña', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0038091-8', 'Francia', 'Sánchez Rosario', '', '', '', 'Escuela Felipe Vicini perdomo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0124491-5', 'Juan Carlos', 'Vanterpool Carmona', '', '', '', 'Escuela Felipe Vicini Perdomo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0057136-7', 'Nelly Dionelis', 'Peña', '', '', '', 'Escuela Felipe Vicini Perdomo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0090566-4', 'Wanda Ibones', 'Lizardo Zorrilla', '', '', '', 'Escuela Felipe Vicini Perdomo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('025-0044435-7', 'Alfonso', 'Febles', '', '', '', 'Escuela Hogar Mercedes Amiama Blandino', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0019751-7', 'Celeste Aurora', 'Mesa Pérez', '', '', '', 'Escuela Hogar Mercedes Amiama Blandino', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2505153-7', 'Linda', 'De La Cruz Manzueta', '', '', '', 'Escuela Hogar Mercedes Amiama Blandino', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1768814-3', 'Lucía Meisys', 'Ceballo Suárez', '', '', '', 'Escuela Hogar Mercedes Amiama Blandino', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0825885-6', 'Nurys', 'Jiménez', '', '', '', 'Escuela Hogar Mercedes Amiama Blandino', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0017134-5', 'Johanny', 'Thomas', '', '', '', 'Escuela La Culebra', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('032-0011053-8', 'María', 'Martinez', '', '', '', 'Escuela La Milagrosa', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0064167-9', 'Jenny Fior', 'Quezada Quezada', '', '', '', 'Escuela Loreto Rojas Reynoso', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('052-0003442-8', 'Yanira', 'Santana Rosario', '', '', '', 'Escuela Luis Reyes', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0918092-7', 'Wendy Milagros', 'Vidal Romero', '', '', '', 'Escuela María Teresa Mirabal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0205560-9', 'Aridia', 'Martínez', '', '', '', 'Escuela Mercedes Guarina Gómez Grullón', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0306594-2', 'Jiannis ', 'Arismendy Jímenez De Ortiz', '', '', '', 'Escuela Molaco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1357213-5', 'Adriana', 'Heredia', '', '', '', 'Escuela Nuestra Señora Del Carmen', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('026-0106434-4', 'Elena Asunción', 'Cooper Núñez', '', '', '', 'Escuela Parroquial Calasanz San Pedro', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('020-0012669-4', 'Maira', 'Peña', '', '', '', 'Escuela Parroquial Cristo Rey', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1282789-4', 'Rosalvy', 'Paulino', '', '', '', 'Escuela Parroquial Cristo Rey', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0307591-1', 'Bernardo Inokar', 'Bisonó Domínguez', '', '', '', 'Escuela Parroquial San Pedro Nolasco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('011-0027661-5', 'Leonel Alberto', 'Rosario Pérez', '', '', '', 'Escuela Parroquial Santa Lucía', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0087276-8', 'Claribel', 'Terrero Valdez', '', '', '', 'Escuela Primaria Fiordaliza Castillo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0008028-0', 'Amancia', 'Martínez de Bastista', '', '', '', 'Escuela Primaria la Gina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0003031-9', 'Ana Silvia', 'Minaya', '', '', '', 'Escuela Primaria La Gina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0014163-7', 'Dulce María', 'Thomas Jimenez', '', '', '', 'Escuela primaria la Gina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0016823-4', 'Glorivel', 'Cepin De lisardo', '', '', '', 'Escuela Primaria La Gina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('29-0002913-9', 'Lucía', 'González', '', '', '', 'Escuela Primaria La Gina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0010731-5', 'Marian Inmaculada', 'Marte Duarte', '', '', '', 'Escuela Primaria la Gina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0018394-4', 'Sirilenny', 'Thomas', '', '', '', 'Escuela Primaria la Gina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0068071-8', 'Dariana Alejandrina', 'Castillo Rodríguez', '', '', '', 'Escuela Primaria Piedra Blanca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0095672-3', 'David', 'Germonsén Then', '', '', '', 'Escuela República de Belice', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1443210-1', 'Angela María', 'González', '', '', '', 'Escuela Salesiana San José', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('0010311262-9', 'Juan', 'Ortiz', '', '', '', 'Escuela Santo Cura de Ars', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0925562-0', 'María Del Carmen', 'García Savala', '', '', '', 'Escuela Santo Cura de Ars', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1108335-8', 'María Ysabel', 'Rodríguez De Veras', '', '', '', 'Escuela Santo Cura de Ars', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0063460-9', 'María Altagracia', 'Estrella', '', '', '', 'Escuela UNPHU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('050-0027348-1', 'Santa', 'Antigua Soriano', '', '', '', 'Especializado de Enseñanza Virginia Fidelina Matos de De la Cruz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('cédula', 'Ismael', 'Valentín', '', '', '', 'Expositor', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0909811-1', 'Santa', 'Gómez', '', '', '', 'Expositor', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1395178-4', 'Wilson', 'Cordero', '', '', '', 'Expositor', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('108-0006974-1', 'Aurora María', 'De La Cruz Encarnación', '', '', '', 'Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0083238-5', 'Eliomar', 'Segura', '', '', '', 'Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0041315-2', 'Ingrit', 'Figueroa', '', '', '', 'Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1290184-8', 'Vilesi', 'Ventura', '', '', '', 'Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1290184-8', 'Vilesi', 'Ventura', '', '', '', 'Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('022-0036635-5', 'Caren', 'Paulino Feliz', '', '', '', 'Fe y Alegría, Oficina Principal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0423317-6', 'Verónica', 'Luzón', '', '', '', 'Fe y Alegría, Oficina Principal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0114303-4', 'Freddy Ernesto', 'Joseph', '', '', '', 'Felipe Vicini Perdomo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('106-0006783-8', 'Yarisa Grisel', 'Ramírez Pérez', '', '', '', 'Fernando Alberto Defilló', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0130764-7', 'Rosaliz Mariel', 'Calderón Mejía', '', '', '', 'Fundación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('0011190517-0', 'Laura', 'Abreu', '', '', '', 'Fundación León Jiménez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0094349-7', 'Soraya', 'Pérez Gautier', '', '', '', 'Fundación Universitaria Pedro Henríquez Ureña', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('035-0020801-6', 'Daniel Antonio', 'Jerez Rodriguez', '', '', '', 'Generosa Ferreira', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0091633-7', 'Ana Maritza', 'Almonte Ventura', '', '', '', 'Hogar Escuela Luisa Ortea', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('038-0014165-1', 'Hilsa', 'Laoz', '', '', '', 'Hogar Escuela Luisa Ortea', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0108106-3', 'Johanna José', 'Silverio', '', '', '', 'Hogar Escuela Luisa Ortea', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0031459-6', 'Ysabel', 'Florentino', '', '', '', 'Hogar Escuela Luisa Ortea', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0103140-8', 'Ana Julissa', 'Polanco', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0634829-5', 'Bertha María', 'Vargas Santana', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1617922-7', 'Brunilda Madeleine', 'Comas Landa', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0353693-4', 'Cesalina', 'Polanco', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('090-0017375-8', 'Cristina', 'Rodríguez', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('068-0021003-8', 'Edra', 'Alvarez', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2340872-1', 'Ester', 'Florentino', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('011-0032894-5', 'Griselda', 'Durán Peralta', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1491730-5', 'Henry', 'Rivas', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0116446-4', 'Janny', 'Turbi Dipré', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0443329-7', 'Jennifer', 'Rosario Toribio', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2281669-2', 'Juan Antonio', 'Polanco Valerio', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0041191-6', 'Juana Isidra', 'Peña Hernández', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0001976-5', 'Juana Jacquelín', 'Páez Araujo', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1039577-9', 'Lucía', 'Figuereo González', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0826649-5', 'Luz', 'González', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0153488-5', 'María de Jesús', 'Ureña Puello', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0030889-8', 'Maritza Aracelis', 'Soriano Céspedes', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0125371-3', 'Miguel Ángel', 'Rodríguez Beltrán', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0048694-2', 'Rafaela Lissette', 'Pérez Filpo', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0312429-3', 'Silvia', 'Díaz Santiago', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0129388-3', 'Wallys ', 'Cuello', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0374238-3', 'Yesenia Altagracia', 'Pepén Nolasco', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0019535-9', 'Yrma Altagracia', 'Rodríguez', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0156555-3', 'Yeranny', 'Brito Garcia', '', '', '', 'INAFOCAN', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0023466-6', 'Johanna', 'Samboy Ramírez', '', '', '', 'Infantil Futuro', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1018536-0', 'Amelia', 'Vicini', '', '', '', 'Inicia Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1216276-3', 'Antonio', 'Caparrós', '', '', '', 'Inicia Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('cédula', 'Danna ', 'Quezada', '', '', '', 'Inicia Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1770445-2', 'Rocío', 'Sánchez', '', '', '', 'Inicia Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0032706-9', 'Ángela María', 'Díaz Díaz', '', '', '', 'Instituto Agronómico y Técnico Salesiano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('470-1993455', 'Junior Radhames', 'Sánchez Vásquez', '', '', '', 'Instituto Agronómico y Técnico Salesiano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0212668-3', 'Luis Alfredo', 'Fernández Serrata', '', '', '', 'Instituto Agronómico y Técnico Salesiano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0193119-0', 'María Margarita', 'Cabrera De Jiménez', '', '', '', 'Instituto Agronómico y Técnico Salesiano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('073-0001975-4', 'Nansi', 'Espinal', '', '', '', 'Instituto Iberia', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('003-0121653-7', 'Ana Luz', 'Soto ', '', '', '', 'Instituto Politecnico Ángeles custodio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('003-0121653-7', 'Analuz', 'Soto', '', '', '', 'Instituto Politecnico Ángeles custodio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0562789-7', 'Carlos', 'Soler', '', '', '', 'Instituto Politecnico Ángeles custodio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0206694-1', 'Hemenegildo', 'Herrera González', '', '', '', 'Instituto Politecnico Ángeles custodio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0212629-9', 'Julio César', 'Herrera González', '', '', '', 'Instituto Politecnico Ángeles custodio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1067713-5', 'Ernesto', 'Caraballo Segura', '', '', '', 'Instituto Politécnico Artes y Oficios', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0001174-1', 'Mayleni', 'Díaz', '', '', '', 'Instituto Politécnico Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1687035-3', 'Isabel María', 'Pérez Méndez', '', '', '', 'Instituto Politécnico Cardenal Sancha', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1451638-8', 'Justa Lourdes', 'Avalos Gomel', '', '', '', 'Instituto Politécnico Cardenal Sancha', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1147788-1', 'Yndiana', 'Contreras', '', '', '', 'Instituto Politécnico Cardenal Sancha', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0050755-6', 'Mirna Mercedes', 'Sánchez', '', '', '', 'Instituto Politécnico de Haina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0503335-1', 'Adriana', 'Del Rosario', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2335936-1', 'Debora', 'Mateo Espino', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('052-0002831-3', 'Genara', 'Candelario', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1239937-3', 'Hna. Lourdes', 'Orsini Oquendo', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1337691-7', 'Josefina', 'Javier', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0104615-5', 'Kizis Maria', 'Sanchez Paulino', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('016-0014196-2', 'Llanys', 'Dicent Marcelo', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1374353-8', 'Ray', 'Cortorreal', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1639832-2', 'Raysa Cristina', 'Cortorreal Familia', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0062480-8', 'Vianelbis', 'Rivera Alcantara', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1473230-8', 'Yasmin Elizabeth', 'Reyes Montero', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0065596-7', 'Fidelina', 'Concepción', '', '', '', 'Instituto Politécnico Francisco José Peynado', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0007083-8', 'Marcily Bertha', 'Montás D Oleo', '', '', '', 'Instituto Politécnico Hainamosa', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0342736-5', 'Martha', 'Fernández Martínez', '', '', '', 'Instituto Politécnico Hainamosa', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1090131-1', 'Yaneris', 'Carrasco Bautista', '', '', '', 'Instituto Politécnico Hainamosa', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0101407-8', 'Elva', 'Polanco Vásquez', '', '', '', 'Instituto Politécnico Industrial Don Bosco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1370061-1', 'Esmeralda', 'Lorenzo Bautista', '', '', '', 'Instituto Politécnico Lic. Juan De los Santos', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1363844-9', 'Fredesvinda', 'Lorenzo Bautista', '', '', '', 'Instituto Politécnico Lic. Juan De los Santos', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0630187-2', 'Roberta Caralis', 'Moreno Carbonell', '', '', '', 'Instituto Politécnico Lic. Juan De los Santos', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0036805-0', 'Johanna Carleny', 'Pérez Cuevas', '', '', '', 'Instituto Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0000191-5', 'Lenis Grisel', 'Garcia Gerónimo', '', '', '', 'Instituto Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0092051-0', 'Manuel', 'Brito', '', '', '', 'Instituto Politécnico Padre Zegri', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('090-0024332-0', 'Martha', 'Polanco Mejía', '', '', '', 'Instituto Politécnico Padre Zegri', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0041638-6', 'Matilde', 'Mota Hernández', '', '', '', 'Instituto Politécnico Padre Zegri', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0001675-6', 'Natividad Altagracia', 'Valverde Solano', '', '', '', 'Instituto Politécnico Padre Zegri', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0041167-6', 'Rosagni Libertad', 'Muñoz', '', '', '', 'Instituto Politécnico Padre Zegri', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0542382-6', 'Cándida Natalia', 'Lugo', '', '', '', 'Instituto Politécnico Pilar Constanzo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0094702-7', 'Leticia', 'Cespedes', '', '', '', 'Instituto Politécnico Pilar Constanzo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0387350-1', 'María Elena', 'Amarante', '', '', '', 'Instituto Politécnico Pilar Constanzo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('129-0001592-1', 'Kelvin Manuel', 'Valenzuela de los Santos', '', '', '', 'Instituto Politécnico San Miguel Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2075944-9', 'Luisa María', 'Ferreras Liriano', '', '', '', 'Instituto Politécnico San Miguel Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0073661-7', 'Odrys Anllely', 'Ogando Nin', '', '', '', 'Instituto Politécnico San Miguel Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1846575-6', 'Martha Amalia', 'Núñez', '', '', '', 'Instituto Superior de Estudios Educativos Pedro Poveda', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2075663-5', 'Yennifert Nathaly', 'Franco Franco', '', '', '', 'Instituto Superior de Formación Docente', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1450290-4', 'Rachel', 'Lobetty', '', '', '', 'Instituto Superior de Formación Docente Salomé Ureña', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1543098-5', 'Henry Marcelino', 'Candelario', '', '', '', 'Instituto Técnico Salesiano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0281108-0', 'Ramona', 'Mena M.', '', '', '', 'Instituto Técnico Salesiano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0275262-3', 'Elsa', 'Jorge', '', '', '', 'Instituto Tecnológico Artes y Oficios', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0425959-3', 'Santiago Ernesto', 'Vólquez Sandoval', '', '', '', 'Instituto Tecnológico Artes y Oficios', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0224655-4', 'Dania', 'González Corona', '', '', '', 'IPIDBOSCO', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0272465-9', 'Rafaela', 'Hernández Peña', '', '', '', 'IPISA', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2575119-3', 'Adonis de Jesús', 'Vásquez Balbuena', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-3508865-1', 'Adriana', 'Ramírez Santiago', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-0044794-0', 'Albert', 'Rosario', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-114432-8', 'Ana Berenice', 'Mejía Encarnación', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2756869-4', 'Armando Rafael', 'Gómez Trinidad', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2756513-8', 'Berenice', 'Aracena Fernández', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1441054-6', 'Bladimir Antonio', 'Gómez Peralta', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0080511-0', 'Carlos Arturo', 'González Lara', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1403488-2', 'Ceferino', 'Medina Peralta', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1307845-0', 'Derian Rafael', 'Reyes de los Santos', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('102-0013406-1', 'Diana Carolina', 'Guzmán Sánchez', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1388179-6', 'Diómedes', 'Sánchez Morillo', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('12929555', 'Dirwin Alfonzo', 'Muñoz Pinto', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-3829361-3', 'Eliezer', 'Díaz Jiménez', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2800667-8', 'Enmanuel', 'Cornielle', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0093496-1', 'Germanía Esther', 'Gómez Martínez', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('229-0030009-0', 'Hilaris Shanel', 'Polanco Pérez', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1433274-0', 'José Antonio', 'Vargas Acosta', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2847918-0', 'Karleny', 'Cornielle Minaya', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2847453-8', 'Layha María', 'Viloria Ventura', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('061-0025702-8', 'Leilany', 'Balbuena', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-3875041-4', 'Lucía', 'Alcántara', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0036265-8', 'María Teresa', 'Peralta Bello', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-3654605-3', 'Marian', 'Meléndez', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0083443-1', 'Mercedes', 'Hernández', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-3651466-4', 'Miguel', 'Guevara', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-4049050-4', 'Miladys', 'Peralta Paniagua', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1301968-6', 'Natalia', 'Rosario', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-3929918-9', 'Noemí', 'Espinal', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1459307-7', 'Pedro Abel', 'Padilla Nuñez', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('114-048350', 'Rafael Pastor', 'Martínez Vargas', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1194249-1', 'Samy Alexander', 'Rodríguez Martínez', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-0897310-3', 'Vianibel Altagracia', 'Valerio Bejarán', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-3968024-8', 'Yan Carlos', 'Torres', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1454958-2', 'Yannolis', 'Zapata Jiménez', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0100243-0', 'Yenny', 'Rosario', '', '', '', 'ISFODOSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1252651-7', 'Johan Manuel', 'López López', '', '', '', 'ISFODUSU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0030954-1', 'Francis', 'Japa', '', '', '', 'ITESA', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2064092-0', 'Anaitis', 'Cabrera García', '', '', '', 'ITLA', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0024376-5', 'Jennifer', 'Acosta', '', '', '', 'JOMAVE', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('049-0030085-8', 'Ramona', 'Cantalicio Payano', '', '', '', 'José Adón Adames Abreu', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0033645-3', 'Reina', 'Matos', '', '', '', 'Juan Emilio Bosch Gaviño', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('087-0003782-6', 'Ramona', 'Ángeles', '', '', '', 'Juan Francisco Alfonseca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0811361-4', 'Jesús Victoria', 'De La Rosa', '', '', '', 'Juan Pablo II, Fe y alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0058893-7', 'Reye', 'De la Cruz', '', '', '', 'Liceo Altagracia Lucas de García', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0061619-1', 'Santa Cristina', 'Mejía Tejeda', '', '', '', 'Liceo Altagracia Lucas de García', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('082-0018833-5', 'Claudia', 'Vizcaíno Cruz', '', '', '', 'Liceo Andrés Bremon', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('082-0003406-7', 'Ignacia', 'Aquino Martínez', '', '', '', 'Liceo Andrés Bremon', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('104-0003310-5', 'Fausto', 'Vega', '', '', '', 'Liceo Antonio Garabito', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('104-0017929-6', 'José Miguel', 'Lorenzo', '', '', '', 'Liceo Antonio Garabito', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('104-0021362-4', 'Oneixis', 'Lorenzo Lorenzo', '', '', '', 'Liceo Antonio Garabito', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0017828-5', 'Deysy Neyda', 'D\' Oleo Luis', '', '', '', 'Liceo Apolonia Ledesma', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0047751-3', 'Modestina', 'Piñeiro', '', '', '', 'Liceo Apolonia Ledesma', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0058315-3', 'Yahaira', 'San Gilbert', '', '', '', 'Liceo Apolonia Ledesma', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('068-0021469-1', 'Andrea', 'Arias Betancourt De González', '', '', '', 'Liceo Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0207120-0', 'Carmen Rosa', 'Vargas Pérez ', '', '', '', 'Liceo Ave María Padre Miguel Fenollera Roca ', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1129443-5', 'Clara Altagracia', 'Mosquea Farías', '', '', '', 'Liceo Ave María Padre Miguel Fenollera Roca ', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0087744-7', 'María', 'Garces', '', '', '', 'Liceo Bienvenido Carlos Almánzar', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0098002-7', 'Juana', 'Dipré Romero', '', '', '', 'Liceo Bienvenido Caro Amancio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1439070-1', 'Ramona', 'Pinales', '', '', '', 'Liceo Bienvenido Caro Amancio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-3333930-3', 'Viterba', 'Sierra Medrano', '', '', '', 'Liceo Bienvenido Caro Amanzio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1489752-3', 'Edward', 'Fernández Bautista', '', '', '', 'Liceo Celeste Argentina Beltré Melo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0635980-5', 'Eristeidy', 'Jiménez Suero', '', '', '', 'Liceo Celeste Argentina Beltré Melo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('004-0021676-8', 'Patricia Angélica', 'De León Pérez', '', '', '', 'Liceo Celeste Argentina Beltré Melo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0469414-6', 'Rut', 'De Los Santos Suero De López', '', '', '', 'Liceo Celeste Argentina Beltré Melo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0153528-0', 'Sorangelys Nicaulys', 'Lugo Vásquez de Díaz', '', '', '', 'Liceo Celeste Argentina Beltré Melo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('027-0026723-0', 'Janet Martina', 'Tejada Morla', '', '', '', 'Liceo César Nicolás Penson', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('AS062171', 'Diana Alejandra', 'Duarte Caro', '', '', '', 'Liceo Científico Dr. Miguel Canela Lázaro', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('I499689', 'Ibrahin', 'Clavel Hernández', '', '', '', 'Liceo Científico Dr. Miguel Canela Lázaro', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0049716-2', 'Xiomara', 'Agramonte', '', '', '', 'Liceo Don Pepe Álvarez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('060-0017915-7', 'Ana Belkis', 'Acosta', '', '', '', 'Liceo Eduardo Brito', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0052358-4', 'Noel', 'Reynoso González', '', '', '', 'Liceo El Ave María Padre Miguel Fenollera Roca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1751849-8', 'Profeta', 'Tolentino Mosquea', '', '', '', 'Liceo El Ave María Padre Miguel Fenollera Roca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0389339-6', 'Rosmeri Altagracia', 'Gutiérrez Beato', '', '', '', 'Liceo El Carmen', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('020-0000392-7', 'Jeannette Bernardette', 'Terrero Medrano', '', '', '', 'Liceo Enriquillo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('020-0013189-2', 'Yazmin Antonia', 'Medrano Morla', '', '', '', 'Liceo Enriquillo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('004-0020523-3', 'Darling', 'Vásquez Sánchez ', '', '', '', 'Liceo Federico Henríquez y Carvajal', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `registro` (`cedula`, `nombre`, `apellido`, `sexo`, `celular`, `correo`, `institucion`, `tipoinstitucion`, `cargo`, `regional`, `distrito`, `redes`, `asistenciaespecial`, `participaras`, `teenteraste`, `participaste`, `notificaciones`, `taller`, `fecha1`, `fecha2`, `fecha3`) VALUES
('001-1206646-9', 'Enelio', 'De La Cruz Portorreal', '', '', '', 'Liceo Federico Henríquez y Carvajal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0840366-8', 'Wilson', 'Peralta Herrera', '', '', '', 'Liceo Federico Henríquez y Carvajal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0042601-5', 'Jeffrys', 'Monero Ramírez', '', '', '', 'Liceo Hermana Rosario Torres', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0511966-3', 'Austria', 'Moreta', '', '', '', 'Liceo José Dolores Vásquez Peña', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('099-0001471-4', 'Mártirez', 'Mendez Sierra', '', '', '', 'Liceo José Dolores Vásquez Peña', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2227798-6', 'Marileny', 'Rondón', '', '', '', 'Liceo Juan Francisco Alfonseca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0644012-6', 'Ramona', 'Hurtado', '', '', '', 'Liceo Juan Pablo Duarte', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0002843-8', 'Delmira', 'Díaz', '', '', '', 'Liceo La Gira', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0023827-1', 'Anuvi', 'Aquino Ponceano', '', '', '', 'Liceo Madre Ascensión Nicol', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0384974-5', 'Alondra Josefina', 'Cisnero Rodríguez', '', '', '', 'Liceo Madre Teresa de Calcuta', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0839902-3', 'Cristian', 'Aybar', '', '', '', 'Liceo Manuel del Cabral', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0446170-2', 'Liliana', 'Paulino', '', '', '', 'Liceo María Marcia Comprés', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0683104-3', 'Angelina', 'Decena Méndez', '', '', '', 'Liceo María Teresa Quidiello', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0090632-9', 'Ledys Altagracia', 'Paredes Bivieca', '', '', '', 'Liceo Mariano de Jesús Sabá', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('104-0014648-5', 'Diomedes De Jesús', 'Vizcaíno Villar', '', '', '', 'Liceo Marino Garabito', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('077-3333834-7', 'Solennia', 'Volquez', '', '', '', 'Liceo Máximo Pérez Florián', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0015009-2', 'Gladys', 'De La Rosa', '', '', '', 'Liceo Napoleón Alberto Casillas Díaz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0084056-4', 'Victoria', 'Simón Sosa', '', '', '', 'Liceo Nocturno José Joaquín Pérez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1403690-8', 'Julio Celso', 'Cruz Abreu', '', '', '', 'Liceo Parroquial Domingo Savio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0074091-6', 'Raúl', 'Alcántara', '', '', '', 'Liceo Parroquial Domingo Savio, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('048-0044855-9', 'Juan Carlos', 'Leonardo Sánchez', '', '', '', 'Liceo Pedro Antonio Frías', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('056-0122930-4', 'José Radhilenmi', 'García Santana', '', '', '', 'Liceo Pedro Francisco Bonó', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('025-0003579-1', 'Pío Juan', 'Colón Morales', '', '', '', 'Liceo Pedro Sánchez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2743409-5', 'Carlos Alberto', 'Soriano Guzmán', '', '', '', 'Liceo Politécnico Ciudad del Conocimiento', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0332497-6', 'Adalis', 'Feliz Cuevas', '', '', '', 'Liceo Politécnico Domingo Savio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0003463-4', 'Eufemia', 'Leonardo Sánchez', '', '', '', 'Liceo Politécnico La Gina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0019659-9', 'Gabriela', 'Ventura Cruz', '', '', '', 'Liceo Politécnico La Gina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('048-0042615-9', 'Bernardo', 'Miliano Acosta', '', '', '', 'Liceo Politécnico Los Héroes', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('770-001075-9', 'Ulises', 'Matos Pérez', '', '', '', 'Liceo Politécnico Manuel Novas Cuevas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('049-0057686-1', 'María Elena', 'Adames Rodríguez', '', '', '', 'Liceo Politécnico Miguel Angel García Viloria', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('087-0014898-7', 'José Alberto', 'Pérez', '', '', '', 'Liceo Politécnico Simón Orozco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('065-0020863-9', 'Reinilda', 'Villavicencio González', '', '', '', 'Liceo Profesor Raúl Horacio Cairo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0961004-5', 'Kenia', 'Calderón', '', '', '', 'Liceo Profesor Simón Orozco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('048-0056746-5', 'Severino', 'Núñez', '', '', '', 'Liceo Ramón Agustín Porcino', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('026-0038757-1', 'Ceferina Altagracia', 'Castillo Castillo', '', '', '', 'Liceo Raúl Cairo Fernández', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('103-0003000-3', 'Anny', 'Emilio Guillén', '', '', '', 'Liceo Raúl Horacio Cairo Ferrand', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1054588-6', 'Marcelina', 'Acevedo', '', '', '', 'Liceo Rudy María Comas Bautista', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0071217-2', 'Mayelin', 'Díaz', '', '', '', 'Liceo Sagrado Corazón De Jesús', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('226-0007540-6', 'Danelis', 'Feliz Brito', '', '', '', 'Liceo Salomé Ureña De Henríquez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1492169-5', 'Maritza', 'de Sena de los Santos', '', '', '', 'Liceo Salomé Ureña de Henríquez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0141961-8', 'José Dario', 'López León', '', '', '', 'Liceo San Luis Gonzaga', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('108-0002651-7', 'Ana Julia', 'Diaz', '', '', '', 'Liceo Secuandario Hermanas Mirabal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('027-0034777-2', 'Damaris Alexandra', 'Peguero Santana', '', '', '', 'Liceo Secundario el Buen Samaritano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1495432-4', 'Evelin', 'Sánchez', '', '', '', 'Liceo Secundario Hermanas Mirabal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2032738-7', 'Yissel María', 'Núñez Araujo', '', '', '', 'Liceo Secundario Hermanas Mirabal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0119487-6', 'Cándida Alexandra', 'Sánchez Pérez', '', '', '', 'Liceo Sor Ángeles Valls, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0053844-7', 'Delia Yohanna', 'Sosa Ramírez', '', '', '', 'Liceo Técnico Cristo Rey', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0034915-9', 'Rosa Nilsy', 'Feliz Suero', '', '', '', 'Liceo Técnico Cristo Rey', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0065998-7', 'Yanet Victoria', 'Mariñez Caraballo', '', '', '', 'Liceo Técnico Cristo Rey', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0924494-7', 'Gisela', 'Germán', '', '', '', 'Liceo Técnico Hermana Rosario Torres, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1646281-3', 'Maritza Gabriel', 'Javier Brito', '', '', '', 'Liceo Técnico Hermana Rosario Torres, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1642206-4', 'Richard', 'Reyes Javier', '', '', '', 'Liceo Técnico Hermana Rosario Torres, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0254267-7', 'Rosalía Altagracia', 'Almanzar Toribio', '', '', '', 'Liceo Técnico Hermana Rosario Torres, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('013-0023236-8', 'Clara Andrea', 'Añasco Mateo', '', '', '', 'Liceo Técnico José Núñez de Cáceres', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('013-3331967-4', 'Wendy Marisol', 'Féliz Ortiz', '', '', '', 'Liceo Técnico José Núñez de Cáceres', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1189164-4', 'Milciades', 'Mateo Jiménez', '', '', '', 'Liceo Técnico Juan De los Santos', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('070-0005583-5', 'Nohemi Antonia', 'Méndez Amador', '', '', '', 'Liceo Técnico Juan Ruperto Polanco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0041711-3', 'Alba Rhina', 'Diclo Reyes', '', '', '', 'Liceo Técnico Manuel del Cabral, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0754208-6', 'Bibiana', 'Pimentel', '', '', '', 'Liceo Técnico Manuel del Cabral, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0007730-6', 'Carlos', 'Thomas', '', '', '', 'Liceo Técnico Manuel del Cabral, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('048-0075087-1', 'Francisco', 'Núñez Castillo', '', '', '', 'Liceo Técnico Manuel del Cabral, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('014-0008740-7', 'Grecia Ondina', 'Montero De Oleo', '', '', '', 'Liceo Técnico Manuel del Cabral, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('068-0043360-6', 'Elsa Francisca', 'Reynoso Reyes', '', '', '', 'Liceo Técnico Medina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1736470-3', 'Ramonita', 'Bautista', '', '', '', 'Liceo Técnico Medina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0040492-1', 'Angelina', 'Borja', '', '', '', 'Liceo Técnico Parroquial Domingo Savio, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0356498-5', 'Daysi', 'Rodríguez', '', '', '', 'Liceo Técnico Parroquial Domingo Savio, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0083101-3', 'Dorka', 'Rodríguez', '', '', '', 'Liceo Técnico Parroquial Domingo Savio, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('118-0006267-8', 'Albania', 'Reyes Abreu', '', '', '', 'Liceo Técnico Parroquial San Pablo Apostol', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0232137-9', 'Daisy', 'Peña', '', '', '', 'Liceo Técnico Parroquial San Pablo Apostol', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0030847-6', 'Esteban Francis', 'Dicent Ruíz', '', '', '', 'Liceo Técnico Profesional Juan Pablo II', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0022905-3', 'Suleinys', 'Mañón Mieses', '', '', '', 'Liceo Técnico Profesional Juan Pablo II', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0019607-1', 'Paula', 'Valentín', '', '', '', 'Liceo Técnico Profesional Profesor Juan Bosh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('045-0006290-8', 'Rosa Josefina', 'Pérez Peña', '', '', '', 'Liceo Vespertino República de Guatemala', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0041029-5', 'Brunilda Altagracia', 'De La Cruz', '', '', '', 'Liceo Vespertino San Miguel Arcángel', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('090-0007639-9', 'Elvido', 'Medina Ventura', '', '', '', 'Liceo Yolanda Ester Rivera', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0271775-2', 'Inés Altagracia', 'Pimentel Martínez', '', '', '', 'Madre Teresa de Calcuta, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0156321-7', 'Erik', 'Flores', '', '', '', 'Manuel Acevedo Serrano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('470-0343736', 'Socorro', 'Méndez Guzmán', '', '', '', 'Manuel Acevedo Serrano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0243887-6', 'Elsa Altagracia', 'Arias Ozuna', '', '', '', 'Manuel Aurelio Tavárez Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0000480-3', 'Johanka', 'Sosa', '', '', '', 'Manuel del Cabral', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0020189-9', 'Roberto', 'Fabian Moreno', '', '', '', 'Manuel del Cabral', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('065-0017952-5', 'Felipe', 'Tapia Ozuna', '', '', '', 'Manuela Mullix Fermín', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('065-0032161-4', 'Roberto Carlos', 'Fermín Fermín', '', '', '', 'Manuela Mullix Fermín', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('003-0049577-7', 'Héctor', 'Mejía', '', '', '', 'Marcos Evangelista Adón', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0513283-1', 'Yoberki', 'Reyes Alcantara', '', '', '', 'Marcos Evangelista Adón', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('1905790', 'Aracelis', 'Reyes', '', '', '', 'María Auxiliadora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0133516-0', 'Hilda María', 'Brito Hernández', '', '', '', 'María Auxiliadora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0075110-2', 'Olivia Mercedes', 'Pérez Grullon', '', '', '', 'María Auxiliadora', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0208600-6', 'Celia Rosa', 'Trinidad', '', '', '', 'María Inmaculada', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1147273-4', 'Dily Altagracia', 'Calderón Rodríguez', '', '', '', 'MINERD', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0872222-4', 'Agustina', 'Duvergé', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('003-0063286-0', 'Alba Miosotis', 'Medrano', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1040389-6', 'Ana Cristina', 'Paulino de la Cruz', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('029-0009392-9', 'Andrea', 'Castillo', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('090-0021068-3', 'Andrea', 'De Los Santos', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0029424-1', 'Anny Linosca', 'Ureña Martínez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('090-0023350-3', 'Bartolo', 'De Los Santos', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0812215-1', 'Basilio', 'López', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0024041-4', 'Carlos', 'Barrientos', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('004-0019799-2', 'Carlos Johan', 'Sánchez Puente', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0228547-5', 'Casilda María', 'Avila Mejía', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('068-0034649-3', 'Celestina', 'Vásquez Mota', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0017402-7', 'Celida Eridania', 'Castro', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1423116-0', 'Charles Miguel', 'Diaz Acosta', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('72-0001851-8', 'Domingo', 'Cruz Fernández', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0075575-7', 'Eduardo', 'Jiménez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1022473-0', 'Elizabeth', 'Benítez Marte', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1033458-8', 'Elizabeth', 'Alcántara Mejía', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0262660-3', 'Estervina', 'Gil Marte', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('070-0002888-1', 'Eugenio Emilio', 'Duval Méndez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0081014-2', 'Evelin Betzaida', 'Urbáez Pérez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('048-0026943-5', 'Fabia', 'Espinal Santos', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1062260-2', 'Fabiola', 'De Morla Genao', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0009897-8', 'Félix Manuel', 'García', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0026380-1', 'Francis', 'Severino Heredia', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0132749-1', 'Franny', 'Guzman', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('49-0003496-0', 'Franquelis', 'Silverio', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('090-0015326-3', 'Glenny', 'Concepción', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1600314-6', 'Graciela', 'Taveras', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0758014-4', 'Guillermina', 'Peguero', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0198623-4', 'Héctor', 'Pérez Moquete', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1621101-2', 'Henry Alberto', 'Contreras Peña', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('025-0033271-9', 'Hiladia', 'Ciprian Santana', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0063038-1', 'Hilda', 'Fabián', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0003856-8', 'Ironelis', 'Herrera Montilla', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0087535-4', 'Isabel', 'Reyes López', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0054310-1', 'Isabel Todd', 'Santana', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('066-0016741-2', 'José Ramón', 'Gil García', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('076-0000724-4', 'Josefina', 'Figuereo', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0071101-3', 'Juan Andrés', 'Veras', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0093861-1', 'Juan José', 'Jaspez Neró', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('003-0067657-4', 'Juana', 'Villalona', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('049-0059558-0', 'Juana', 'Sánchez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('100-0005642-3', 'Juana', 'Caraballo', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1142022-0', 'Juana Yulisa', 'Checo Monegro', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2568952-5', 'Kedwin', 'Martinez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('229-0010245-4', 'Kenia Julia', 'Manzueta de la Cruz', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('025-0005409-9', 'Lauro Alfonso', 'Ramírez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0037378-2', 'Leonel', 'De la Cruz Morla', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0059862-6', 'Lidia', 'Zayas Polanco', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0277463-9', 'Luis', 'Ureña', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0136652-4', 'Manuel Alberto', 'De la Rosa Polanco', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0029708-3', 'Margarita', 'De la Rosa', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0004830-2', 'María Altagracia', 'Ramírez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1309409-8', 'María Angelina', 'Rodríguez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('079-0004557-1', 'María Virginia', 'González de León', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0867469-8', 'Marilanda', 'Paniagua Moreta', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1138950-8', 'Martina', 'Guillén', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1240718-4', 'Miriam Altagracia', 'Domínguez De Henríquez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0158746-6', 'Mirna', 'Reyes', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0091378-8', 'Mirtha', 'Abad Almonte', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0097436-3', 'Moraima', 'Arias', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0018229-3', 'Nellys Yovanny', 'Mejía Calderón', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0016418-4', 'Nerte', 'Encarnación Vargas', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0020004-1', 'Palmira', 'Sacariaz', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('011-0026684-8', 'Patria Kenia', 'Martínez Echavarría', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0140781-4', 'Rafaelina', 'De La Rosa De León', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0024091-1', 'Raquel', 'Sánchez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0438817-8', 'Reyna', 'Rijo', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1510336-8', 'Richard', 'Buret', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1736186-5', 'Rosalía', 'Báez Perdomo', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0153625-7', 'Rubinier', 'Lara', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1672625-8', 'Ruth Esther', 'De León', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('104-0012604-0', 'Santa Felicia', 'Troncoso Lara', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1325306-6', 'Scarlet', 'García de Toribio', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1319463-3', 'Soledad', 'Montero Montero', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('051-0012742-2', 'Solenny', 'Polanco Rosa', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0111359-9', 'Sugeidy', 'Rabsatt', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0920169-9', 'Teresa', 'García', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0075347-3', 'Teresa de Jesús', 'Pérez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0025896-7', 'Vicenta', 'Laurencio Soriano', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0028413-5', 'Werner', 'Ramírez Sánchez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1296857-8', 'Wiscar', 'Presinal', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1712420-6', 'Yamilca Amparo', 'Taveras Jiménez', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0036826-1', 'Yaneyri', 'De Los Santos De Morel', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('024-0013171-6', 'Yris Evelise', 'García Rojas', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0601139-8', 'Yudelis', 'Rojas', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0060072-4', 'Sujey', 'Linares Robert', '', '', '', 'Napoleón Alberto Casilla Díaz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1326774-4', 'Cruz', 'Ferreras', '', '', '', 'Niño Jesús, Fe Y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2023485-6', 'Yegeiny', 'Pimentel', '', '', '', 'Nuestra Señora Del Valle', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0051974-3', 'Angel Claudio', 'Matos', '', '', '', 'OMABE', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('079-0012100-0', 'Kesia Maritza', 'Ferreras González', '', '', '', 'Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0020567-3', 'Yancell Oderay', 'Ferreras Cabreja', '', '', '', 'Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('056-0155184-8', 'Francisca Elizabeth', 'Taveras Álvarez', '', '', '', 'Pedro Francisco Bonó', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('056-0101672-7', 'Juana Elvira', 'Bobadilla Sánchez', '', '', '', 'Pedro Francisco Bonó', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1181329-1', 'Cesar Augusto', 'Núñez Casilla', '', '', '', 'Politécnico Alfredo Peña Castillo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('065-0011219-5', 'Francisco Antonio', 'Bratini Coplin', '', '', '', 'Politécnico Alfredo Peña Castillo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('065-0016079-8', 'Thelmo Andrés', 'Benjamín Figuereo', '', '', '', 'Politécnico Alfredo Peña Castillo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('082-0018756-8', 'Vicenta', 'Martínez Aquino', '', '', '', 'Politécnico Andrés Bremon', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1274147-5', 'Lilian', 'De los Santos', '', '', '', 'Politécnico Ángeles Custodio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0118322-2', 'Duanny Mariel', 'Rodriguez Castillo', '', '', '', 'Politécnico Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('051-0017335-9', 'Mildre Margarita', 'Acevedo Rodríguez', '', '', '', 'Politécnico Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0104187-5', 'Yanira', 'Almonte García', '', '', '', 'Politécnico Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0082746-4', 'Yaneris Mercedes', 'De León Jiménez', '', '', '', 'Politécnico Ave María, Moca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0104465-8', 'Juan Carlos', 'Tejada Pineda', '', '', '', 'Politécnico Bienvenido Caro Amancio', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('123-0005885-1', 'Jose Francisco', 'Tejeda', '', '', '', 'Politécnico Cacique Don Francisco Bonao', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('123-00157927', 'Luci Estefanía', 'Dilone Vásquez', '', '', '', 'Politécnico Cacique Don Francisco Bonao', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0329468-2', 'Mireya Argelia', 'Nuñez Rodríguez', '', '', '', 'Politécnico Cardenal Sancha, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0008390-6', 'Yoelvis', 'Marmolejos Gómez', '', '', '', 'Politécnico Cardenal Sancha, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0027550-5', 'Yajaira', 'Sebastian', '', '', '', 'Politecnico Ciudad de Conocimiento', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0016820-5', 'Héctor', 'Brito', '', '', '', 'Politécnico Ciudad Del Conocimiento Carlitos Alcántara Rojas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0022548-4', 'Juana Ramona', 'Pascual Puente', '', '', '', 'Politécnico Ciudad Del Conocimiento Carlitos Alcántara Rojas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0025609-1', 'Lilian', 'Rivera', '', '', '', 'Politécnico Ciudad Del Conocimiento Carlitos Alcántara Rojas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0031062-5', 'Lorraine', 'Frías', '', '', '', 'Politécnico Ciudad Del Conocimiento Carlitos Alcántara Rojas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0025391-6', 'Miriam', 'Santana', '', '', '', 'Politécnico Ciudad Del Conocimiento Carlitos Alcántara Rojas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0033277-7', 'Soranyi', 'Rodríguez', '', '', '', 'Politécnico Ciudad Del Conocimiento Carlitos Alcántara Rojas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0027550-5', 'Yajaira', 'Sebastian', '', '', '', 'Politécnico Ciudad Del Conocimiento Carlitos Alcántara Rojas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0945690-5', 'Angélica María', 'Fabian', '', '', '', 'Politécnico Cristo Obrero', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('011-0027659-9', 'Aura', 'Reyes Familia', '', '', '', 'Politécnico Cristo Obrero', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0116667-5', 'Rosario', 'Cohen', '', '', '', 'Politécnico Cristo Obrero', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0048454-3', 'Cynthia Cecilia', 'Herrea Heredia', '', '', '', 'Politécnico Cruce de Palo Alto', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0050590-9', 'Greisy', 'Lantigua González', '', '', '', 'Politécnico Cruce de Palo Alto', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('104-0019019-4', 'Margarita', 'Arial Zoquiel', '', '', '', 'Politécnico de Haina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0039310-6', 'Mariano', 'Brea', '', '', '', 'Politécnico de Haina', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0273362-3', 'Ana', 'Ramírez Ramírez', '', '', '', 'Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0097090-0', 'Cecilia Alexandra', 'Pérez de León', '', '', '', 'Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0064857-1', 'Juana', 'Guzmán García', '', '', '', 'Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0038905-7', 'Liliana', 'Santana Montero', '', '', '', 'Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0082750-6', 'Luz del Carmen', 'de León Bobonagua', '', '', '', 'Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0104705-4', 'Reyna Jissel', 'Sánchez Sánchez', '', '', '', 'Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0012342-7', 'Rubén Lorenzo', 'Sánchez Utate', '', '', '', 'Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0093489-8', 'Josefina Dominga', 'de León Bobonagua', '', '', '', 'Politécnico El Ave María, Moca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1391285-1', 'Luisa Altagracia', 'Amador Rojas', '', '', '', 'Politecnico El Ave María, Santo Domingo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0093663-8', 'Francisco Alberto', 'Santana Pérez', '', '', '', 'Politécnico El Corozo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0119937-6', 'Maireni Carolina', 'Taveras Bautista', '', '', '', 'Politécnico El Corozo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0940577-9', 'María Elizabeth', 'Santos Santos', '', '', '', 'Politécnico Emma Balaguer de Vallejo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0428134-4', 'Camilo', 'Severino', '', '', '', 'Politécnico Ernesto Disla', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0400731-9', 'Elizabeth', 'De León Cruz', '', '', '', 'Politécnico Ernesto Disla', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('095-009259-9', 'Juan Felipe', 'Morel', '', '', '', 'Politécnico Ernesto Disla', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0011095-8', 'Gerson Virgilio', 'De Paula De Los Santos', '', '', '', 'Politécnico Félix María Ruiz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1516925-2', 'Luchy', 'Frías', '', '', '', 'Politécnico Félix María Ruiz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('049-0070775-5', 'Viarda', 'Martínez', '', '', '', 'Politécnico Félix María Ruiz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('074-0003110-5', 'Ana Ybelise', 'Rosario Tapia', '', '', '', 'Politécnico Francisco Alberto Caamaño Deñó', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0021277-1', 'Denia María', 'Mueses Alcántara', '', '', '', 'Politécnico Francisco Alberto Caamaño Deñó', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2281047-1', 'Jonathan Bernardo', 'Amador Pitre', '', '', '', 'Politécnico Francisco José Peynado', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0127097-2', 'Yaniris', 'Aquino Mercedes', '', '', '', 'Politécnico Francisco José Peynado', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0865314-8', 'Lidia', 'Báez', '', '', '', 'Politécnico Francisco Ramírez Capellán', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('090-0023468-3', 'Manol Antonio', 'Villanueva', '', '', '', 'Politécnico Gregorio Aybar Contreras', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0053629-9', 'Ana', 'Guzmán De Dorville', '', '', '', 'Politécnico Gregorio Urbano Gilbert', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0013455-8', 'Grace Ysabel', 'Lightbowrne', '', '', '', 'Politécnico Gregorio Urbano Gilbert, Puerto Plata', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0136402-0', 'Deldania Ivelise', 'Gómez Lima', '', '', '', 'Politécnico Hermanas Mir', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0138218-8', 'Lissette Rafaelina', 'Henríquez Rojas', '', '', '', 'Politécnico Industrial Don Bosco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0019819-7', 'Yahaira', 'Rodríguez', '', '', '', 'Politécnico Jamao al Norte', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0024410-0', 'Nancy Altagracia', 'Batista Castillo', '', '', '', 'Politécnico Javier Martínez Arias', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0051173-9', 'Julio César', 'Sánchez Sánchez', '', '', '', 'Politécnico Jinova', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0105817-6', 'Eduardo', 'Acosta', '', '', '', 'Politécnico José Antonio Castillo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0151011-9', 'Lissette', 'Paulino Rodríguez', '', '', '', 'Politécnico José Antonio Castillo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0038862-4', 'Ana Cecilia', 'Payán', '', '', '', 'Politécnico José de la Luz Guillén', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0038862-4', 'Ana Cecilia', 'Payano', '', '', '', 'Politécnico José de la Luz Guillén', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0000135-9', 'Sonia Altagracia', 'de la Cruz', '', '', '', 'Politécnico José de la Luz Guillén', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('057-0000641-3', 'Angélica María', 'Morel Croussett', '', '', '', 'Politécnico José María Velaz, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('016-0008291-9', 'Nieve Luisa', 'Novas', '', '', '', 'Politécnico José María Velaz, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0003976-9', 'Yesmelis Esmeralda', 'Franco Minaya', '', '', '', 'Politécnico José María Velaz, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0811170-9', 'Pablo', 'Vanderhorst Hilton', '', '', '', 'Politécnico José María, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0829952-0', 'Randol', 'Catalino', '', '', '', 'Politécnico José María, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('097-0016883-5', 'Antonia', 'Ureña de la Cruz', '', '', '', 'Politécnico José Miguel Remigio Vásquez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('097-0016883-5', 'Antonia', 'Ureña de la Cruz', '', '', '', 'Politécnico José Miguel Remigio Vásquez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0020817-8', 'Yolanda', 'De la Cruz Belen', '', '', '', 'Politécnico José Reyes', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0076435-5', 'Kenia', 'Custodio', '', '', '', 'Politécnico Juan de los Santos', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('049-0054162-6', 'Eduardo', 'Regalado', '', '', '', 'Politécnico Juan Francisco Alfonseca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('087-0001554-1', 'Luz María', 'Jiménez Castillo', '', '', '', 'Politécnico Juan Francisco Alfonseca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('49-0018808-9', 'Marily', 'Roque Flores', '', '', '', 'Politécnico Juan Francisco Alfonseca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('540-0609748', 'Mercedes', 'Sánchez González', '', '', '', 'Politécnico Juan Miguel Vicente Martín', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0565522-9', 'Hirialto', 'Pierrot', '', '', '', 'Politécnico Juan Pablo II, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1478659-3', 'Yudelka', 'Javier Moreno', '', '', '', 'Politécnico Juan Pablo II, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0530047-9', 'Belkis', 'Francisco Frías', '', '', '', 'Politécnico Madre Laura', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1450978-9', 'Ducarmel', 'Fenelón', '', '', '', 'Politécnico Madre Laura', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1384383-3', 'Juan Pedro', 'Rincón', '', '', '', 'Politécnico Madre Laura', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-07580115-1', 'Luisa Marelis', 'Peguero', '', '', '', 'Politécnico Madre Laura', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1419667-8', 'Manuel', 'Rodríguez', '', '', '', 'Politécnico Madre Laura', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0013664-8', 'Ana Paola', 'Féliz Jiménez', '', '', '', 'Politécnico Madre Rafaela Ybarra', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0715389-2', 'Dometila', 'De Jesús', '', '', '', 'Politécnico Madre Rafaela Ybarra', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('129-0000988-2', 'Pedro', 'Reyes', '', '', '', 'Politécnico Madre Rafaela Ybarra', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0937699-6', 'Cirila', 'Hernández', '', '', '', 'Politécnico Manuel Aurelio Tavares Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0041293-0', 'Daniel', 'Céspedes Reyes', '', '', '', 'Politécnico Manuel Aurelio Tavares Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('049-0041224-0', 'Elva Iris', 'Flores Paula', '', '', '', 'Politécnico Manuel Aurelio Tavares Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('068-0035481-0', 'Mayra', 'Mejía Basora', '', '', '', 'Politécnico Manuel Aurelio Tavares Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1673046-6', 'Ramón', 'Ortiz Restituyo', '', '', '', 'Politécnico Manuel Aurelio Tavares Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('068-0037968-4', 'Ruth Esther', 'De Jesús', '', '', '', 'Politécnico Manuel Aurelio Tavares Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0132845-0', 'Stephanie', 'Morillo', '', '', '', 'Politécnico Manuel Aurelio Tavares Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0048095-2', 'Teresa', 'Quezada', '', '', '', 'Politécnico Manuel Aurelio Tavares Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0018212-1', 'Wanda', 'Clime', '', '', '', 'Politécnico Manuel Aurelio Tavares Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0086467-9', 'Gloria', 'De la Cruz', '', '', '', 'Politécnico Manuela Mullix Fermín', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1288432-5', 'Karina Altagracia', 'Henríquez Parra', '', '', '', 'Politécnico Marco Evangelista Adón', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1640514-3', 'Lilian', 'Moreno', '', '', '', 'Politécnico Marco Evangelista Adón', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2506982-8', 'Mariela', 'Polanco Polanco', '', '', '', 'Politécnico María de la Altagracia', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0011373-7', 'Jesús Miguel', 'Castellanos Herasme', '', '', '', 'Politécnico María de la Altagracia, Villa Duarte', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('014-0009162-3', 'Julia', 'Ramírez', '', '', '', 'Politécnico María Inmaculada', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1282539-1', 'Santa Isabel', 'Grullón Beltré', '', '', '', 'Politécnico María Teresa Quiedillo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('078-0007309-5', 'Eva Cristina', 'Trinidad Méndez', '', '', '', 'Politécnico Marie Poussepin', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('078-0011848-6', 'Oscalina', 'Segura Ferreras', '', '', '', 'Politécnico Marie Poussepin', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('078-0000832-3', 'Pablo Evertz', 'Ferreras', '', '', '', 'Politécnico Marie Poussepin', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('077-0002994-0', 'Felicita', 'Peña Nova', '', '', '', 'Politécnico Máximo Pérez Florián', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('077-0003098-9', 'Nelina', 'Trinidad Trinidad', '', '', '', 'Politécnico Máximo Pérez Florián', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('095-0014730-2', 'Eliacim', 'Serrata Taveras', '', '', '', 'Politécnico Mercedes Peña', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0426180-9', 'Maria Esther', 'Almonte Rodríguez', '', '', '', 'Politécnico Monseñor Juan Antonio Flores', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0959881-3', 'Angheli Claudia Lucía', 'Jiménez Henríquez', '', '', '', 'Politécnico Monseñor Thomas F. Reilly', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0082500-6', 'Grissel Elizabeth', 'Mateo Mora', '', '', '', 'Politécnico Monseñor Thomas F. Reilly', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('109-0006613-4', 'Pedro', 'Sánchez Vicente', '', '', '', 'Politécnico Monseñor Thomas F. Reilly', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0036713-4', 'Léon', 'Pérez Moreno', '', '', '', 'Politécnico Napoleón García Díaz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2070232-4', 'Juan José', 'Roustand de la Rosa', '', '', '', 'Politécnico Natividad Zuleica Abreu', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2597218-7', 'Marcos Antonio', 'Ramón Calcaño', '', '', '', 'Politécnico Natividad Zuleica de Acosta', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0080739-9', 'Bacilio Antonio', 'Dirocie Roa', '', '', '', 'Politécnico Nuestra Señora del Perpetuo Socorro', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0026650-4', 'Santa', 'Mariano', '', '', '', 'Politécnico Nuestra Señora del Perpetuo Socorro', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1240501-4', 'Santa Seferina', 'Sierra Familia', '', '', '', 'Politécnico Nuestra Señora del Perpetuo Socorro', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0012802-3', 'Eddy Alberto', 'Zabala Contreras', '', '', '', 'Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('011-0027430-5', 'Fabio', 'Ogando', '', '', '', 'Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0919987-7', 'Francisca', 'Plasencia', '', '', '', 'Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1484385-7', 'Jessica', 'Cuello Del Orbe', '', '', '', 'Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('010-0089335-2', 'Sobeyda Elizabeth', 'Cuevas Feliz', '', '', '', 'Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('020-0010638-1', 'Cecir', 'Bello', '', '', '', 'Politécnico Padre Zegrí', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0514543-1', 'Luis Miguel', 'Hernández', '', '', '', 'Politécnico Padre Zegrí', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0047404-5', 'Ironelis', 'Duval Romero', '', '', '', 'Politécnico Pedro Corto', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('011-0025519-7', 'María Idalia', 'Florentino Ogando', '', '', '', 'Politécnico Pedro Corto', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1408649-9', 'Esther Yovanca', 'Francon De Reinoso', '', '', '', 'Politécnico Pilar Constanzo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0413929-4', 'Eduardo', 'Alcántara Rodriguez', '', '', '', 'Politécnico Plinio Martínez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0002900-6', 'Pablo Augusto', 'Rosario Caraballo', '', '', '', 'Politécnico Prof. Javier Martínez Arias', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0033583-6', 'Claritza', 'Matos Matos', '', '', '', 'Politécnico Prof. Juan Bosch', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2023924-4', 'Michael Enrique', 'Matos Batista', '', '', '', 'Politécnico Prof. Juan Bosch', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('061-0026088-1', 'Pastora', 'Martínez Pérez', '', '', '', 'Politécnico Profesor José Morel', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0117442-1', 'Alexander', 'Méndez Lántigua', '', '', '', 'Politécnico Profesor Santos Rommel Cruz de León', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0065363-1', 'Ana Ramona', 'Del Rosario', '', '', '', 'Politécnico Profesor Santos Rommel Cruz de León', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('008-0030088-1', 'Juana Esthefany', 'Rodríguez Mejía', '', '', '', 'Politécnico Promapec', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('039-0017190-5', 'Eduard Antonio', 'Cabrera Vargas', '', '', '', 'Politécnico Rubén Darío', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('016-0012598-1', 'Elvira Altagracia', 'Sánchez Díaz', '', '', '', 'Politécnico Sagrado Corazón de Jesús', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('016-0013134-4', 'Jesús Gil', 'Aquino Terrero', '', '', '', 'Politécnico Sagrado Corazón de Jesús', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('340-0004697', 'Jocelín Altagracia', 'Vidal González', '', '', '', 'Politécnico Sagrado Corazón de Jesús', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('110-0005779-1', 'Marco Antonio', 'Quezada Durán', '', '', '', 'Politécnico Sagrado Corazón de Jesús', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('034-0050909-1', 'Yolanda', 'Mora', '', '', '', 'Politécnico Sagrado Corazón de Jesús, Mao', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0099131-0', 'Bernardino Antonio', 'Hernández Batista', '', '', '', 'Politécnico Salesiano Arquides Calderón', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0104651-0', 'Heidy María', 'Tejada Bencosme', '', '', '', 'Politécnico Salesiano Arquides Calderón', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0109130-0', 'Rodolfo Raul', 'Dur&aacuten Vargas', '', '', '', 'Politécnico Salesiano Arquides Calderón', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('084-0008290-8', 'Juana Yeraldin', 'Matos González', '', '', '', 'Politécnico San Felipe Neri', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('015-0004462-1', 'Yudeysis', 'Rivera de la Rosa', '', '', '', 'Politécnico San Francisco de Asís', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0243374-5', 'Pelagia', 'De la Cruz', '', '', '', 'Politécnico San José', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `registro` (`cedula`, `nombre`, `apellido`, `sexo`, `celular`, `correo`, `institucion`, `tipoinstitucion`, `cargo`, `regional`, `distrito`, `redes`, `asistenciaespecial`, `participaras`, `teenteraste`, `participaste`, `notificaciones`, `taller`, `fecha1`, `fecha2`, `fecha3`) VALUES
('056-0127395-5', 'Rosmery', 'Terrero Paredes', '', '', '', 'Politécnico San José', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1449262-2', 'Cruz', 'Toro', '', '', '', 'Politécnico San José de los Frailes', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0088163-0', 'Cruz María', 'González Cruz', '', '', '', 'Politécnico San José de los Frailes', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0047244-4', 'Félix', 'De la Cruz', '', '', '', 'Politécnico San José de los Frailes', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1045960-9', 'Adolfo', 'Peguero', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0915453-4', 'Angela', 'Araujo Rodríguez', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1496133-7', 'Deicy', 'Mercedes Bussi', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1426764-4', 'Dorka Yuderca', 'Contreras', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0018582-7', 'Felicia', 'De los Santos de Jesus', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0560533-1', 'Gabriel', 'Montilla Vargas', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1899461-5', 'Indriana', 'Reyes', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1104461-6', 'Juana', 'Méndez Valenzuela', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-1298355-1', 'Laura Marina', 'Corporán', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1267066-6', 'Marisol del Socorro', 'Correa Correa', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0035082-7', 'Rosmery', 'González Bello', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0610522-4', 'Seferino', 'Pinera Domínguez', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1472910-6', 'Sely', 'Perdomo', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('025-0045373-9', 'Rebeca Del Socorro', 'Aguirre Vargas', '', '', '', 'Politécnico Santa Cruz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0090513-0', 'Enmanuel de Jesús', 'Cruz Osoria', '', '', '', 'Politécnico Santo Romel Cruz de León', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1239242-8', 'Mercedes', 'Francisco Salvador', '', '', '', 'Politécnico Tulio Manuel Cestero', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0034109-2', 'Milagros', 'Lapaix', '', '', '', 'Politécnico Ulises Francisco Espaillat', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('045-0018313-4', 'José', 'Báez', '', '', '', 'Politécnico Víctor Manuel Espaillat', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('025-0015174-7', 'Félix', 'Santana', '', '', '', 'Politécnico Virgen De La Altagracia', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1098622-1', 'Magalys', 'Candelario Matias', '', '', '', 'Politécnico Virgen De La Altagracia', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0770435-5', 'Xiomara', 'González', '', '', '', 'Politécnico Virgen De La Altagracia', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0725365-0', 'Newton Aníbal', 'Peña García', '', '', '', 'Politécnico Virgilio Casilla Minaya', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0377034-7', 'Ana Cristina', 'Ureña González', '', '', '', 'Politécnico Vitalina Gallardo de Abinader', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('045-0019516-1', 'Danny Altagracia', 'Batista Muñoz', '', '', '', 'Politécnico Vitalina Gallardo de Abinader', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0111049-6', 'Yuderkis', 'Mejía de Mejía', '', '', '', 'Politécnico Vitalina Gallardo de Abinader', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('045-0015932-4', 'Víctor José', 'Mena', '', '', '', 'Politecnico Ysabel Rosalba Torres', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0050357-6', 'Wendy', 'Lendof', '', '', '', 'Politecnico Ysabel Rosalba Torres', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-3702718-6', 'Gelmarlin', 'Rosario De Los Santos', '', '', '', 'PUCMM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0061634-0', 'Ana Iris', 'Peña Silas', '', '', '', 'Pura Rijo de Rivera', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2021581-4', 'Elvin', 'Morales', '', '', '', 'Rafaela Marrero Paulino', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2021581-4', 'Elvyn', 'Morales', '', '', '', 'Rafaela Marrero Paulino', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0035531-1', 'Anicasio', 'Asensio', '', '', '', 'Regional 04', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-0047497-1', 'Cristino', 'Pérez Rámirez', '', '', '', 'Regional 04', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('093-001771-7', 'Franklin Alberto', 'Cuello Soriano', '', '', '', 'Regional 04', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1294996-1', 'Esther Nidia', 'Tineo', '', '', '', 'Regional 10', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0316568-4', 'Martha Georgina', 'Matthews', '', '', '', 'Regional 10', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0742604-1', 'Isis Margarita', 'Rodríguez', '', '', '', 'Regional 10, Santo Domingo II', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0424973-5', 'Lucidania', 'Mota', '', '', '', 'Regional 10, Santo Domingo II', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0507858-8', 'Teresa', 'Japa', '', '', '', 'Regional 10, Santo Domingo II', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0495350-0', 'Malta', 'Ventura Ventura', '', '', '', 'Regional 10-03', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1329386-4', 'Luz Del Alba', 'Pastor Merino', '', '', '', 'Regional 15', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('078-0008307-8', 'Reina', 'Tapia Sena', '', '', '', 'Regional 15', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('078-0004607-5', 'Ana Catalina', 'Peréz Peréz', '', '', '', 'Regional 15 MINERD', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0085367-9', 'Ramonita', 'Domínguez', '', '', '', 'Regional de Educación 04 San Cristóbal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('049-0065302-5', 'Yaquelín', 'Batista', '', '', '', 'Regional de Educación 16', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1138203-2', 'Anton', 'Tejeda', '', '', '', 'Saint George School', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0409990-2', 'Jeferich Josue', 'Rodríguez Polanco', '', '', '', 'Saint Joseph School', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0060294-7', 'Yenisis', 'Medina Tejeda', '', '', '', 'San Alberto Defilló', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0066667-4', 'Evaristo', 'Tavárez', '', '', '', 'San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0223820-1', 'Leónidas Neftalí', 'Morel', '', '', '', 'San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0398632-9', 'Martha María', 'Vicioso', '', '', '', 'San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1889730-5', 'Hellen Cristina', 'Kranwinkel Moleiro', '', '', '', 'San Judas Tadeo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0125090-6', 'Newton', 'Guzmán', '', '', '', 'San Luis Gonzaga', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('011-0004983-0', 'Elba Luz', 'Rosario', '', '', '', 'Santo Cura de Ars', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('0010452048-1', 'Gertrudys', 'Figueroa Henríquez', '', '', '', 'Santo Cura de Ars', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0445048-1', 'Jacqueline', 'Veras', '', '', '', 'Santo Cura de Ars', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1652739-1', 'Judith Josefina', 'Firpo Fernández', '', '', '', 'Santo Cura de Ars', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('049-0061788-9', 'Martina', 'Bautista Farías', '', '', '', 'Santo Cura de Ars', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1745748-1', 'Sterphyn', 'Pérez', '', '', '', 'Santo Cura de Ars', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0295147-2', 'Ada Teresa', 'Del Mar Illescas Luna', '', '', '', 'Sor Ángeles Valls, Fe y alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2349822-7', 'Ely', 'Peralta de Jesús', '', '', '', 'Sor Ángeles Valls, Fe y alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0015994-7', 'Maribel', 'Beriguete Méndez', '', '', '', 'Técnico Cristo Rey', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('049-0038875-4', 'Maximina Antonia', 'Valdez', '', '', '', 'Técnico Parroquial Domingo Savio, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0594518-2', 'Zoila', 'Arias', '', '', '', 'Técnico Profesional', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1061342-9', 'Altagracia', 'Francisco', '', '', '', 'Tulio Manuel Cestero', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0078715-9', 'Arelys', 'Paulino', '', '', '', 'UCONARES', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2166652-8', 'Milagros', 'Hidalgo', '', '', '', 'UCONARES', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0128432-1', 'Teresa', 'Guzmán', '', '', '', 'UNIBE', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-4010221-5', 'Yolimar', 'Mejías', '', '', '', 'UNPHU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1773160-4', 'María del Carmen', 'Hidalgo Vásquez', '', '', '', 'Vinicio Valenzuela Pérez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('cédula', 'Cynthia Lissbeth', 'Olivier Sterling', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1105611-0', 'Faride', 'Holguín-Veras', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('cédula', 'Orly Jasmín', 'Vargas', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('cédula', 'Perla ', 'Mercado ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0332585-8', 'Eddy Miguel Ángel', 'Hernández Genao', '', '', '', 'Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0036163-3', 'Keily', 'Alcántara Herasme', '', '', '', 'Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0050457-6', 'Dori', 'Bautista', '', '', '', 'Ave María, Moca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1388973-7', 'Luis Alberto', 'Ramírez Alcantara', '', '', '', 'Ave María, Padre Miguel Fenollera', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0015909-4', 'Yenny Zaira', 'Rosario Alcántara', '', '', '', 'Ave María, Villa Mella', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0940187-7', 'Roberto J.', 'Cruz Uribe', '', '', '', 'Babeque Secundaria', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0008464-9', 'Francisca del Carmen', 'Ferreira Genao', '', '', '', 'Centro Cultural Poveda', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0157361-6', 'Zoila Arelis', 'Montás', '', '', '', 'Centro Cultural Poveda', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0404115-7', 'Estauro', 'Gonsalez Jaquez', '', '', '', 'Centro Cultural Poveda', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('024-0027465-6', 'Diomaris', 'García Acosta', '', '', '', 'Centro Cultural Poveda', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0187737-1', 'Ana Lucila', 'De los Santos Ventura', '', '', '', 'Centro de Integración Familiar', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1895030-2', 'Luisanna', 'Maldonado Genao', '', '', '', 'Centro de Integración Familiar', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-0957732-5', 'Jorgina', 'Pujols', '', '', '', 'Centro de Integración Familiar', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('034-0051412-5', 'Russevely', 'Rodríguez Collado', '', '', '', 'Centro Educativo Francisco Del Rosario Sánchez', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1024368-0', 'Graciela', 'Grullón', '', '', '', 'Centro Educativo María Inmaculada', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1473028-6', 'Humberto', 'Pérez', '', '', '', 'Centro Educativo María Inmaculada', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0081036-7', 'Erenia', 'Gomera', '', '', '', 'Centro Educativo María Inmaculada', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0290934-8', 'Ramón Loreto', 'Valdez Cabrera', '', '', '', 'Centro Educativo Rudy María Comas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0927545-3', 'Elena Mercedes', 'Rojas', '', '', '', 'Centro Educativo Rudy María Comas', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0092656-4', 'Anny Mayilenny', 'Oviedo Roa', '', '', '', 'Colegio Padre Guido Gildea', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0052837-3', 'Odalis Lissette', 'De La Cruz Rojas', '', '', '', 'Don Bosco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2505153-7', 'Linda', 'De La Cruz Manzueta', '', '', '', 'Escuela Hogar Mercedes Amiama Blandino', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0918092-7', 'Wendy Milagros', 'Vidal Romero', '', '', '', 'Escuela María Teresa Mirabal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0114855-1', 'Anthony Wilmer', 'Paredes', '', '', '', 'Escuela María Teresa Mirabal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('005-0013177-6', 'Juana', 'Santana De La Cruz', '', '', '', 'Escuela Mercedes Amiama Blandino', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('011-0027661-5', 'Leonel Alberto', 'Rosario Pérez', '', '', '', 'Escuela Parroquial Santa Lucía', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0423317-6', 'Verónica', 'Luzón', '', '', '', 'Fe y Alegría, Oficina Principal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('022-0036635-5', 'Caren', 'Paulino Feliz', '', '', '', 'Fe y Alegría, Oficina Principal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0199345-5', 'Junior', 'Sánchez Vásquez', '', '', '', 'IATESA', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0948166-3', 'Anny', 'Castillo', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('014-0002660-3', 'Pedro', 'Bidó Fulcar', '', '', '', 'INAFOCAM', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0023466-6', 'Johanna', 'Samboy Ramírez', '', '', '', 'Infantil Futuro', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1265283-9', 'Ángela', 'Español', '', '', '', 'Inicia Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('047-0032706-9', 'Ángela María', 'Díaz Díaz', '', '', '', 'Instituto Agronómico y Técnico Salesiano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('073-0001975-4', 'Nansi', 'Espinal', '', '', '', 'Instituto Iberia', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0889009-6', 'Yris Altagracia', 'Liriano Liriano', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1247845-8', 'Ana', 'Orozco', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('023-0073446-0', 'Alexandra Agustina', 'Lucas Smith', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0035730-0', 'Yordelis Coss', 'Morrobel de Fernández', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0050902-5', 'Marisol', 'Tolentino', '', '', '', 'Instituto Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0020172-2', 'Lucía', 'Vásquez', '', '', '', 'Instituto Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('108-944620', 'Manuel de Jesús', 'Zayas Payano', '', '', '', 'Instituto Técnico Salesiano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0004829-8', 'Carlos José', 'Alberto Peña', '', '', '', 'Instituto Técnico Salesiano', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0893007-4', 'Miledys', 'Heredia Cabrera', '', '', '', 'JOMAVE', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0020189-8', 'Janna Suzette', 'Santana Vásquez', '', '', '', 'Liceo Argentina Mateo Lara', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1206646-9', 'Enelio', 'De La Cruz Portorreal', '', '', '', 'Liceo Federico Henríquez y Carvajal', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0581289-5', 'Quircia Fredida', 'Buret Montas', '', '', '', 'Liceo José Manuel Buret Taveras', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2297982-1', 'Yuli Isabel', 'Bautista Acevedo', '', '', '', 'Liceo José Manuel Buret Taveras', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0961004-5', 'Kenia', 'Calderón', '', '', '', 'Liceo Profesor Simón Orozco', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0119487-6', 'Cándida Alexandra', 'Sánchez Pérez', '', '', '', 'Liceo Sor Ángeles Valls, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0234516-2', 'Carmen Lidia', 'Valdez Ureña', '', '', '', 'Liceo Técnico Hermana Rosario Torres', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('114-987738', 'María Isabel', 'Bautista de Henríquez', '', '', '', 'Liceo Técnico Hermana Rosario Torres', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0016607-4', 'Adela Miguelina', 'Peralta San Pablo de Hidalgo', '', '', '', 'Liceo Vigilo Casilla Minaya', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1204866-5', 'Carolina', 'Díaz Disla', '', '', '', 'Liceo Virgilio Casilla Minaya', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('402-2031496-3', 'Saily Francisco', 'Padilla Monclús', '', '', '', 'Liceo Virgilio Casilla Minaya', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1073905-9', 'Carmen Rosa', 'Mora', '', '', '', 'Mercedes Amiama', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0581583-1', 'Carlos', 'Buret Montás', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('225-0078820-7', 'Laura Melissa', 'Then', '', '', '', 'Ministerio de Educación', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('079-0012100-0', 'Kesia Maritza', 'Ferreras González', '', '', '', 'Padre Bartolomé', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0081815-9', 'Brenny Sulay', 'Melo Ortíz', '', '', '', 'Padre Guido Gildea', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0620860-6', 'Elena', 'Chávez', '', '', '', 'Politécnico Cardenal Sancha, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1223431-5', 'María Alexandra', 'Pérez de Encarnación', '', '', '', 'Politécnico Cardenal Sancha, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('031-0304709-2', 'Bernardo Antonio', 'Rodríguez', '', '', '', 'Politécnico Don Juan Hernández', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0120190-9', 'Mirian', 'Castaño Santiago', '', '', '', 'Politécnico El Ave María', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('054-0082746-4', 'Yaneris Mercedes', 'De León Jiménez', '', '', '', 'Politécnico El Ave María, Moca', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('223-0011095-8', 'Gerson Virgilio', 'De Paula De Los Santos', '', '', '', 'Politécnico Félix María Ruiz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0541851-1', 'Juberkis', 'Lorenzo', '', '', '', 'Politécnico José María Velaz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('012-0032129-5', 'Sandra', 'Lorenzo', '', '', '', 'Politécnico José María Velaz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('104-0023451-3', 'Kari Estela', 'Reyes Quiterio', '', '', '', 'Politécnico José María Velaz', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0811170-9', 'Pablo', 'Vanderhorst Hilton', '', '', '', 'Politécnico José María, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0829952-0', 'Randol', 'Catalino', '', '', '', 'Politécnico José María, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0254275-0', 'Rosanna', 'Arias Ozuna', '', '', '', 'Politécnico Manuel Aurelio Tavárez Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0990003-5', 'Osvaldo Ramon', 'Hodge', '', '', '', 'Politécnico Manuel Aurelio Tavárez Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('108-0007477-4', 'Yahiminson', 'Montero', '', '', '', 'Politécnico Manuel Aurelio Tavárez Justo', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0994839-8', 'José', 'Hichez Ramírez', '', '', '', 'Politécnico Nuestra Señora del Carmen', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('034-0009190-0', 'Ingry', 'Durán Piña', '', '', '', 'Politécnico Nuestra Señora del Carmen', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1484385-7', 'Jessica', 'Cuello Del Orbe', '', '', '', 'Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('002-0012802-3', 'Eddy Alberto', 'Zabala Contreras', '', '', '', 'Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('018-0062621-8', 'Leidiana', 'López', '', '', '', 'Politécnico Padre Bartolomé Vegh', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0243374-5', 'Pelagia', 'De la Cruz', '', '', '', 'Politécnico San José', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0088163-0', 'Cruz María', 'González Cruz', '', '', '', 'Politécnico San José de los Frailes', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1449262-2', 'Cruz', 'Toro', '', '', '', 'Politécnico San José de Los Frailes', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0223820-1', 'Leónidas Neftalí', 'Morel', '', '', '', 'Politécnico San José, Fe y Alegria', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('037-0066667-4', 'Evaristo', 'Tavárez', '', '', '', 'Politécnico San José, Fe y Alegria', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0806401-5', 'Andrea', 'Martínez Tejada', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1089322-9', 'José Altagracia', 'Rubio Santana', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1496133-7', 'Deicy', 'Mercedes Bussi', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('224-0035082-7', 'Rosmery', 'González Bello', '', '', '', 'Politécnico San José, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0295147-2', 'Ada Teresa', 'Del Mar Illescas Luna', '', '', '', 'Politécnico Sor Ángeles Valls, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1565564-9', 'Patricia', 'Mordán Almonte', '', '', '', 'Politécnico Sor Ángeles Valls, Fe y Alegría', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1787581-5', 'Arístides Rafael', 'Peralta Henríquez', '', '', '', 'Politécnico Ulises Francisco Espaillat', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1489640-0', 'Ana', 'Brito', '', '', '', 'Técnico Profesional', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0128432-1', 'Teresa', 'Guzmán', '', '', '', 'UNIBE', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-0062667-0', 'Carmen', 'Florentino', '', '', '', 'UNPHU', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('001-1149186-6', 'Alicia', 'Tejada', '', '', '', 'UNPHU', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sinergias_positivas`
--

CREATE TABLE `sinergias_positivas` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio_emocionales`
--

CREATE TABLE `socio_emocionales` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stress_docente`
--

CREATE TABLE `stress_docente` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajo_equipo`
--

CREATE TABLE `trabajo_equipo` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transforma_sociedad`
--

CREATE TABLE `transforma_sociedad` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(13) NOT NULL,
  `clave` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`) VALUES
(1, 'user1', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(2, 'user2', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(3, 'user3', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(4, 'user4', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(5, 'user5', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(11, 'user6', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(12, 'user7', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(13, 'user8', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(14, 'user9', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(15, 'user10', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(16, 'user11', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(17, 'user12', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(18, 'user13', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(19, 'user14', 'ef6299c9e7fdae6d775819ce1e2620b8'),
(20, 'user15', 'ef6299c9e7fdae6d775819ce1e2620b8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `victoria_zorraquin`
--

CREATE TABLE `victoria_zorraquin` (
  `id` int(10) NOT NULL,
  `cedula` varchar(13) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accion_herramienta`
--
ALTER TABLE `accion_herramienta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `aprender_divertido`
--
ALTER TABLE `aprender_divertido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `aula_creativo`
--
ALTER TABLE `aula_creativo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `aula_quimica`
--
ALTER TABLE `aula_quimica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `biceps`
--
ALTER TABLE `biceps`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cambiar_mundo`
--
ALTER TABLE `cambiar_mundo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `coalicion_docentes`
--
ALTER TABLE `coalicion_docentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `corazon_mirada`
--
ALTER TABLE `corazon_mirada`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `desafio_escuela`
--
ALTER TABLE `desafio_escuela`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `educacion_economia`
--
ALTER TABLE `educacion_economia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fondo_innovacion`
--
ALTER TABLE `fondo_innovacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fundacion_varkey`
--
ALTER TABLE `fundacion_varkey`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gestion_proyecto`
--
ALTER TABLE `gestion_proyecto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ideas_sombrero`
--
ALTER TABLE `ideas_sombrero`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `igenieria_cognitiva`
--
ALTER TABLE `igenieria_cognitiva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inclusion_escuela`
--
ALTER TABLE `inclusion_escuela`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `innovacion_calidad`
--
ALTER TABLE `innovacion_calidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `innovacion_transformacion`
--
ALTER TABLE `innovacion_transformacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `juveniles_experiencia`
--
ALTER TABLE `juveniles_experiencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libro_ideice`
--
ALTER TABLE `libro_ideice`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `maestro_energia`
--
ALTER TABLE `maestro_energia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medio_transformador`
--
ALTER TABLE `medio_transformador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mentoria_docentes`
--
ALTER TABLE `mentoria_docentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `panel_expertos`
--
ALTER TABLE `panel_expertos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedagogia_loto`
--
ALTER TABLE `pedagogia_loto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planes_mejora`
--
ALTER TABLE `planes_mejora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planificacion_evaluacion`
--
ALTER TABLE `planificacion_evaluacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `portafolio_digital`
--
ALTER TABLE `portafolio_digital`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sinergias_positivas`
--
ALTER TABLE `sinergias_positivas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socio_emocionales`
--
ALTER TABLE `socio_emocionales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stress_docente`
--
ALTER TABLE `stress_docente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajo_equipo`
--
ALTER TABLE `trabajo_equipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transforma_sociedad`
--
ALTER TABLE `transforma_sociedad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `victoria_zorraquin`
--
ALTER TABLE `victoria_zorraquin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accion_herramienta`
--
ALTER TABLE `accion_herramienta`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aprender_divertido`
--
ALTER TABLE `aprender_divertido`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aula_creativo`
--
ALTER TABLE `aula_creativo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aula_quimica`
--
ALTER TABLE `aula_quimica`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `biceps`
--
ALTER TABLE `biceps`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cambiar_mundo`
--
ALTER TABLE `cambiar_mundo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `coalicion_docentes`
--
ALTER TABLE `coalicion_docentes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corazon_mirada`
--
ALTER TABLE `corazon_mirada`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `desafio_escuela`
--
ALTER TABLE `desafio_escuela`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `educacion_economia`
--
ALTER TABLE `educacion_economia`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fondo_innovacion`
--
ALTER TABLE `fondo_innovacion`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fundacion_varkey`
--
ALTER TABLE `fundacion_varkey`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gestion_proyecto`
--
ALTER TABLE `gestion_proyecto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ideas_sombrero`
--
ALTER TABLE `ideas_sombrero`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `igenieria_cognitiva`
--
ALTER TABLE `igenieria_cognitiva`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inclusion_escuela`
--
ALTER TABLE `inclusion_escuela`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `innovacion_calidad`
--
ALTER TABLE `innovacion_calidad`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `innovacion_transformacion`
--
ALTER TABLE `innovacion_transformacion`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `juveniles_experiencia`
--
ALTER TABLE `juveniles_experiencia`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libro_ideice`
--
ALTER TABLE `libro_ideice`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `maestro_energia`
--
ALTER TABLE `maestro_energia`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medio_transformador`
--
ALTER TABLE `medio_transformador`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mentoria_docentes`
--
ALTER TABLE `mentoria_docentes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `panel_expertos`
--
ALTER TABLE `panel_expertos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedagogia_loto`
--
ALTER TABLE `pedagogia_loto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `planes_mejora`
--
ALTER TABLE `planes_mejora`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `planificacion_evaluacion`
--
ALTER TABLE `planificacion_evaluacion`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `portafolio_digital`
--
ALTER TABLE `portafolio_digital`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sinergias_positivas`
--
ALTER TABLE `sinergias_positivas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `socio_emocionales`
--
ALTER TABLE `socio_emocionales`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `stress_docente`
--
ALTER TABLE `stress_docente`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajo_equipo`
--
ALTER TABLE `trabajo_equipo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transforma_sociedad`
--
ALTER TABLE `transforma_sociedad`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `victoria_zorraquin`
--
ALTER TABLE `victoria_zorraquin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
