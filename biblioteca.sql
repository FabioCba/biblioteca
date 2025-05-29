-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-01-2024 a las 01:10:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appgini_query_log`
--

CREATE TABLE `appgini_query_log` (
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `statement` longtext DEFAULT NULL,
  `duration` decimal(10,2) UNSIGNED DEFAULT 0.00,
  `error` text DEFAULT NULL,
  `memberID` varchar(200) DEFAULT NULL,
  `uri` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `appgini_query_log`
--

INSERT INTO `appgini_query_log` (`datetime`, `statement`, `duration`, `error`, `memberID`, `uri`) VALUES
('2022-08-30 13:08:48', 'ALTER TABLE `Catalogo` MODIFY `Codigo_Registro` INT UNSIGNED NULL', 1.20, NULL, 'admin', '/biblioteca/admin/pageRebuildFields.php?all=1'),
('2022-08-30 18:14:49', 'ALTER TABLE `Circulacion` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci', 1.04, NULL, 'admin', '/biblioteca/admin/pageRebuildFields.php?utf8=1'),
('2022-08-30 18:14:54', 'ALTER TABLE `Estado_Suscripcion` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci', 1.76, NULL, 'admin', '/biblioteca/admin/pageRebuildFields.php?utf8=1'),
('2022-08-30 18:14:56', 'ALTER TABLE `Usuarios` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci', 1.33, NULL, 'admin', '/biblioteca/admin/pageRebuildFields.php?utf8=1'),
('2022-08-30 18:14:58', 'OPTIMIZE TABLE `Politica_de_Prestamos`', 1.01, NULL, 'admin', '/biblioteca/admin/pageRebuildFields.php?utf8=1'),
('2022-08-30 18:15:02', 'ALTER TABLE `Tipo_Usuario` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci', 1.17, NULL, 'admin', '/biblioteca/admin/pageRebuildFields.php?utf8=1'),
('2022-08-30 18:15:04', 'ALTER TABLE `Materias` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci', 1.29, NULL, 'admin', '/biblioteca/admin/pageRebuildFields.php?utf8=1'),
('2024-01-14 00:09:05', 'select count(1) from `Itemes` WHERE 1=1', 0.00, 'Table \'biblioteca.itemes\' doesn\'t exist', 'admin', '/biblioteca/index.php'),
('2024-01-14 00:09:05', 'select count(1) from `Usuarios` WHERE 1=1', 0.00, 'Table \'biblioteca.usuarios\' doesn\'t exist', 'admin', '/biblioteca/index.php'),
('2024-01-14 00:09:17', 'SELECT `Catalogo`.`id` AS \'id\', `Catalogo`.`Portada` AS \'Portada\', IF(    CHAR_LENGTH(`Registros1`.`Codigo_de_Registro`), CONCAT_WS(\'\',   `Registros1`.`Codigo_de_Registro`), \'\') /* Codigo Registro */ AS \'Codigo_Registro\', IF(    CHAR_LENGTH(`Registros1`.`Codigo_Barras`), CONCAT_WS(\'\',   `Registros1`.`Codigo_Barras`), \'\') /* C&#243;digo de  Barras */ AS \'Cod_Barras\', `Catalogo`.`Item` AS \'Item\', `Catalogo`.`Cod_Ejemplar` AS \'Cod_Ejemplar\', `Catalogo`.`Tipo_Literatura` AS \'Tipo_Literatura\', IF(    CHAR_LENGTH(`Tipo_Documento1`.`Descripcion`), CONCAT_WS(\'\',   `Tipo_Documento1`.`Descripcion`), \'\') /* Tipo de Documento */ AS \'Tipo_Documento\', IF(    CHAR_LENGTH(`Estado_Catalogacion1`.`Descripcion`), CONCAT_WS(\'\',   `Estado_Catalogacion1`.`Descripcion`), \'\') /* Estado de Catalogacion */ AS \'id_Estado_Catalogacion\', `Catalogo`.`Signatura_Topografica` AS \'Signatura_Topografica\', IF(    CHAR_LENGTH(`Autoridades1`.`Nombre`), CONCAT_WS(\'\',   `Autoridades1`.`Nombre`), \'\') /* Autor */ AS \'Id_Autoridad\', `Catalogo`.`Titulo` AS \'Titulo\', `Catalogo`.`Responsabilidades` AS \'Responsabilidades\', `Catalogo`.`Edicion` AS \'Edicion\', IF(    CHAR_LENGTH(`Lugares1`.`Descripcion`), CONCAT_WS(\'\',   `Lugares1`.`Descripcion`), \'\') /* Lugar de Publicaci&#243;n */ AS \'Id_Lugar\', IF(    CHAR_LENGTH(`Editoriales1`.`Nombre`), CONCAT_WS(\'\',   `Editoriales1`.`Nombre`), \'\') /* Editorial */ AS \'id_Editorial\', `Catalogo`.`Fecha_Publicacion` AS \'Fecha_Publicacion\', `Catalogo`.`Desc_Fisica` AS \'Desc_Fisica\', `Catalogo`.`Notas` AS \'Notas\', IF(    CHAR_LENGTH(`Materias1`.`Descriptor`), CONCAT_WS(\'\',   `Materias1`.`Descriptor`), \'\') /* Materia 1 */ AS \'Materia_1\', IF(    CHAR_LENGTH(`Materias2`.`Descriptor`), CONCAT_WS(\'\',   `Materias2`.`Descriptor`), \'\') /* Materia 2 */ AS \'Materia_2\', IF(    CHAR_LENGTH(`Materias3`.`Descriptor`), CONCAT_WS(\'\',   `Materias3`.`Descriptor`), \'\') /* Materia 3 */ AS \'Materia_3\', `Catalogo`.`Ejemplares` AS \'Ejemplares\', if(`Catalogo`.`Fecha_Catalogacion`,date_format(`Catalogo`.`Fecha_Catalogacion`,\'%m/%d/%Y\'),\'\') AS \'Fecha_Catalogacion\', COALESCE(`Catalogo`.`id`) AS \'Catalogo.id\' FROM `Catalogo` LEFT JOIN `Registros` as Registros1 ON `Registros1`.`id`=`Catalogo`.`Codigo_Registro` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Catalogo`.`Tipo_Documento` LEFT JOIN `Estado_Catalogacion` as Estado_Catalogacion1 ON `Estado_Catalogacion1`.`id`=`Catalogo`.`id_Estado_Catalogacion` LEFT JOIN `Autoridades` as Autoridades1 ON `Autoridades1`.`id`=`Catalogo`.`Id_Autoridad` LEFT JOIN `Lugares` as Lugares1 ON `Lugares1`.`id`=`Catalogo`.`Id_Lugar` LEFT JOIN `Editoriales` as Editoriales1 ON `Editoriales1`.`id`=`Catalogo`.`id_Editorial` LEFT JOIN `Materias` as Materias1 ON `Materias1`.`id`=`Catalogo`.`Materia_1` LEFT JOIN `Materias` as Materias2 ON `Materias2`.`id`=`Catalogo`.`Materia_2` LEFT JOIN `Materias` as Materias3 ON `Materias3`.`id`=`Catalogo`.`Materia_3`  WHERE 1=1  LIMIT 0, 10', 0.00, 'Unknown column \'Catalogo.Item\' in \'field list\'', 'admin', '/biblioteca/Catalogo_view.php'),
('2024-01-14 00:09:20', 'SELECT COUNT(1) FROM `Usuarios`', 0.00, 'Table \'biblioteca.usuarios\' doesn\'t exist', 'admin', '/biblioteca/admin/pageHome.php'),
('2024-01-14 00:09:20', 'SELECT COUNT(1) FROM `Itemes`', 0.00, 'Table \'biblioteca.itemes\' doesn\'t exist', 'admin', '/biblioteca/admin/pageHome.php'),
('2024-01-14 00:09:20', 'SHOW FIELDS FROM `Usuarios`', 0.00, 'Table \'biblioteca.usuarios\' doesn\'t exist', 'admin', '/biblioteca/admin/pageHome.php');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoridades`
--

CREATE TABLE `autoridades` (
  `id` int(10) UNSIGNED NOT NULL,
  `Foto` varchar(50) DEFAULT NULL,
  `id_Tipo_autoridad` int(10) UNSIGNED DEFAULT NULL,
  `Nombre` varchar(150) DEFAULT NULL,
  `Fecha_Extrema` varchar(50) DEFAULT NULL,
  `Vease_Ademas` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `autoridades`
--

INSERT INTO `autoridades` (`id`, `Foto`, `id_Tipo_autoridad`, `Nombre`, `Fecha_Extrema`, `Vease_Ademas`) VALUES
(1, '9d5a35c89a29e8c24.png', 1, 'Holmbery, Bengt', '19--?', NULL),
(2, '5a30885e9d86967f5.png', 1, 'Rowling, J. K.', '19--?', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo`
--

CREATE TABLE `catalogo` (
  `id` int(10) UNSIGNED NOT NULL,
  `Portada` varchar(50) DEFAULT NULL,
  `Fecha_Registro` date DEFAULT NULL,
  `Tipo_Literatura` varchar(50) DEFAULT NULL,
  `id_Estado_Catalogacion` int(10) UNSIGNED DEFAULT NULL,
  `Signatura_Topografica` varchar(50) DEFAULT NULL,
  `Id_Autoridad` int(10) UNSIGNED DEFAULT NULL,
  `Titulo` varchar(250) DEFAULT NULL,
  `Responsabilidades` varchar(250) DEFAULT NULL,
  `Edicion` varchar(50) DEFAULT NULL,
  `Id_Lugar` int(10) UNSIGNED DEFAULT NULL,
  `id_Editorial` int(10) UNSIGNED DEFAULT NULL,
  `Fecha_Publicacion` varchar(50) DEFAULT NULL,
  `Desc_Fisica` varchar(100) DEFAULT NULL,
  `Notas` text DEFAULT NULL,
  `Materia_1` int(10) UNSIGNED DEFAULT NULL,
  `Materia_2` int(10) UNSIGNED DEFAULT NULL,
  `Materia_3` int(10) UNSIGNED DEFAULT NULL,
  `Codigo_Registro` int(10) UNSIGNED DEFAULT NULL,
  `Cod_Barras` int(10) UNSIGNED DEFAULT NULL,
  `Tipo_Documento` int(10) UNSIGNED DEFAULT NULL,
  `Ejemplares` int(11) DEFAULT NULL,
  `Item` varchar(40) DEFAULT NULL,
  `Cod_Ejemplar` varchar(40) DEFAULT NULL,
  `Fecha_Catalogacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `circulacion`
--

CREATE TABLE `circulacion` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_Politica_pretamo` int(10) UNSIGNED DEFAULT NULL,
  `id_Tipo_usuario` int(10) UNSIGNED DEFAULT NULL,
  `id_Tipo_documento` int(10) UNSIGNED DEFAULT NULL,
  `id_Registro` int(10) UNSIGNED DEFAULT NULL,
  `Libro_Prestado` int(10) UNSIGNED DEFAULT NULL,
  `id_Usuario` int(10) UNSIGNED DEFAULT NULL,
  `Fecha_Prestamo` date DEFAULT NULL,
  `Fecha_Devolucion` date DEFAULT NULL,
  `id_Estado_prestamo` int(10) UNSIGNED DEFAULT NULL,
  `Foto_Usuario` int(10) UNSIGNED DEFAULT NULL,
  `Portada_libro` int(10) UNSIGNED DEFAULT NULL,
  `Porta_libro` varchar(50) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Ejemp_Disponibles` int(10) UNSIGNED DEFAULT NULL,
  `Item` int(10) UNSIGNED DEFAULT NULL,
  `Cod_Ejemplar` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editoriales`
--

CREATE TABLE `editoriales` (
  `id` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Direccion` varchar(200) DEFAULT NULL,
  `Telefono` varchar(50) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `Contacto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `editoriales`
--

INSERT INTO `editoriales` (`id`, `Nombre`, `Direccion`, `Telefono`, `Correo`, `Contacto`) VALUES
(1, 'Edición El Almendro', 'Edificio J. F. Martinez, no. 75. Av. W. Churchill', '829-632-7841', 'jrodriguez@sgn.gob.do', 'Alberto'),
(2, 'Edilib', 'Av. George no. 78. Barrio Chino', '829-632-7841', 'edilibros@gmail.com', 'Alberto Cortez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_catalogacion`
--

CREATE TABLE `estado_catalogacion` (
  `id` int(10) UNSIGNED NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `estado_catalogacion`
--

INSERT INTO `estado_catalogacion` (`id`, `Descripcion`) VALUES
(1, 'En procesos Técnicos'),
(2, 'En Circulación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_conservacion`
--

CREATE TABLE `estado_conservacion` (
  `id` int(10) UNSIGNED NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `estado_conservacion`
--

INSERT INTO `estado_conservacion` (`id`, `Descripcion`) VALUES
(1, 'Nuevo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_prestable`
--

CREATE TABLE `estado_prestable` (
  `id` int(10) UNSIGNED NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `estado_prestable`
--

INSERT INTO `estado_prestable` (`id`, `Descripcion`) VALUES
(1, 'Se presta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_prestamo`
--

CREATE TABLE `estado_prestamo` (
  `id` int(10) UNSIGNED NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `estado_prestamo`
--

INSERT INTO `estado_prestamo` (`id`, `Descripcion`) VALUES
(1, 'Prestado'),
(2, 'Devuelto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_suscripcion`
--

CREATE TABLE `estado_suscripcion` (
  `id` int(10) UNSIGNED NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `estado_suscripcion`
--

INSERT INTO `estado_suscripcion` (`id`, `Descripcion`) VALUES
(1, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemes`
--

CREATE TABLE `itemes` (
  `id` int(10) UNSIGNED NOT NULL,
  `Cod_item` int(10) UNSIGNED DEFAULT NULL,
  `Estado_Conservacion` int(10) UNSIGNED DEFAULT NULL,
  `Num_Copia` varchar(50) DEFAULT NULL,
  `Cod_Ejemplar` varchar(50) DEFAULT NULL,
  `Estado_de_Baja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugares`
--

CREATE TABLE `lugares` (
  `id` int(10) UNSIGNED NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `lugares`
--

INSERT INTO `lugares` (`id`, `Descripcion`) VALUES
(1, 'Estados Unidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(10) UNSIGNED NOT NULL,
  `Descriptor` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `Descriptor`) VALUES
(1, 'Cristianismo - Historia'),
(2, 'Cristianismo - Aspectos sociales'),
(3, 'Cristianismo primitivo'),
(4, 'Novela inglesa'),
(5, 'Literatura inglesa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membership_grouppermissions`
--

CREATE TABLE `membership_grouppermissions` (
  `permissionID` int(10) UNSIGNED NOT NULL,
  `groupID` int(10) UNSIGNED DEFAULT NULL,
  `tableName` varchar(100) DEFAULT NULL,
  `allowInsert` tinyint(4) NOT NULL DEFAULT 0,
  `allowView` tinyint(4) NOT NULL DEFAULT 0,
  `allowEdit` tinyint(4) NOT NULL DEFAULT 0,
  `allowDelete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membership_grouppermissions`
--

INSERT INTO `membership_grouppermissions` (`permissionID`, `groupID`, `tableName`, `allowInsert`, `allowView`, `allowEdit`, `allowDelete`) VALUES
(1, 2, 'Estado_Conservacion', 1, 3, 3, 3),
(2, 2, 'Estado_Prestable', 1, 3, 3, 3),
(3, 2, 'Registros', 1, 3, 3, 3),
(4, 2, 'Estado_Prestamo', 1, 3, 3, 3),
(5, 2, 'Estado_Catalogacion', 1, 3, 3, 3),
(6, 2, 'Editoriales', 1, 3, 3, 3),
(7, 2, 'Catalogo', 1, 3, 3, 3),
(8, 2, 'Circulacion', 1, 3, 3, 3),
(9, 2, 'Tipo_Documento', 1, 3, 3, 3),
(10, 2, 'Autoridades', 1, 3, 3, 3),
(11, 2, 'Estado_Suscripcion', 1, 3, 3, 3),
(12, 2, 'Usuarios', 1, 3, 3, 3),
(13, 2, 'Politica_de_Prestamos', 1, 3, 3, 3),
(14, 2, 'Lugares', 1, 3, 3, 3),
(15, 2, 'Tipo_Autoridad', 1, 3, 3, 3),
(16, 2, 'Tipo_Usuario', 1, 3, 3, 3),
(17, 2, 'Materias', 1, 3, 3, 3),
(0, 2, 'Itemes', 1, 3, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membership_groups`
--

CREATE TABLE `membership_groups` (
  `groupID` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `allowSignup` tinyint(4) DEFAULT NULL,
  `needsApproval` tinyint(4) DEFAULT NULL,
  `allowCSVImport` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membership_groups`
--

INSERT INTO `membership_groups` (`groupID`, `name`, `description`, `allowSignup`, `needsApproval`, `allowCSVImport`) VALUES
(2, 'Admins', 'Admin group created automatically on 2022-08-30', 0, 1, 0),
(1, 'anonymous', 'Anonymous group created automatically on 2022-08-30', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membership_userpermissions`
--

CREATE TABLE `membership_userpermissions` (
  `permissionID` int(10) UNSIGNED NOT NULL,
  `memberID` varchar(100) NOT NULL,
  `tableName` varchar(100) DEFAULT NULL,
  `allowInsert` tinyint(4) NOT NULL DEFAULT 0,
  `allowView` tinyint(4) NOT NULL DEFAULT 0,
  `allowEdit` tinyint(4) NOT NULL DEFAULT 0,
  `allowDelete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membership_userrecords`
--

CREATE TABLE `membership_userrecords` (
  `recID` bigint(20) UNSIGNED NOT NULL,
  `tableName` varchar(100) DEFAULT NULL,
  `pkValue` varchar(255) DEFAULT NULL,
  `memberID` varchar(100) DEFAULT NULL,
  `dateAdded` bigint(20) UNSIGNED DEFAULT NULL,
  `dateUpdated` bigint(20) UNSIGNED DEFAULT NULL,
  `groupID` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membership_userrecords`
--

INSERT INTO `membership_userrecords` (`recID`, `tableName`, `pkValue`, `memberID`, `dateAdded`, `dateUpdated`, `groupID`) VALUES
(1, 'Estado_Conservacion', '1', 'admin', 1661859746, 1661859746, 2),
(2, 'Estado_Prestable', '1', 'admin', 1661859756, 1661859756, 2),
(3, 'Registros', '1', 'admin', 1661859763, 1661859763, 2),
(4, 'Estado_Catalogacion', '1', 'admin', 1661859972, 1661859972, 2),
(5, 'Tipo_Autoridad', '1', 'admin', 1661860081, 1661860081, 2),
(6, 'Autoridades', '1', 'admin', 1661860146, 1661860149, 2),
(7, 'Lugares', '1', 'admin', 1661860190, 1661860190, 2),
(8, 'Editoriales', '1', 'admin', 1661860536, 1661860536, 2),
(9, 'Materias', '1', 'admin', 1661860605, 1661860628, 2),
(10, 'Materias', '2', 'admin', 1661860654, 1661860744, 2),
(11, 'Catalogo', '1', 'admin', 1661860780, 1661865838, 2),
(12, 'Materias', '3', 'admin', 1661860880, 1661860880, 2),
(13, 'Tipo_Usuario', '1', 'admin', 1661861278, 1661861278, 2),
(14, 'Estado_Suscripcion', '1', 'admin', 1661861310, 1661861310, 2),
(15, 'Usuarios', '1', 'admin', 1661861320, 1661861326, 2),
(16, 'Tipo_Documento', '1', 'admin', 1661861357, 1661861768, 2),
(17, 'Politica_de_Prestamos', '1', 'admin', 1661861377, 1661861809, 2),
(18, 'Estado_Prestamo', '1', 'admin', 1661865000, 1661865000, 2),
(19, 'Circulacion', '1', 'admin', 1661865011, 1661882733, 2),
(20, 'Estado_Prestamo', '2', 'admin', 1661865363, 1661865363, 2),
(21, 'Registros', '2', 'admin', 1661865408, 1661865408, 2),
(22, 'Estado_Catalogacion', '2', 'admin', 1661865454, 1661865454, 2),
(23, 'Catalogo', '2', 'admin', 1661865474, 1661865856, 2),
(24, 'Autoridades', '2', 'admin', 1661865531, 1661865534, 2),
(25, 'Editoriales', '2', 'admin', 1661865631, 1661865633, 2),
(26, 'Materias', '4', 'admin', 1661865664, 1661865664, 2),
(27, 'Materias', '5', 'admin', 1661865678, 1661865678, 2),
(28, 'Tipo_Usuario', '2', 'admin', 1661881767, 1661881767, 2),
(29, 'Usuarios', '2', 'admin', 1661881806, 1661881810, 2),
(30, 'Politica_de_Prestamos', '2', 'admin', 1661881855, 1661881855, 2),
(31, 'Circulacion', '2', 'admin', 1661881927, 1661882805, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membership_users`
--

CREATE TABLE `membership_users` (
  `memberID` varchar(100) NOT NULL,
  `passMD5` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `signupDate` date DEFAULT NULL,
  `groupID` int(10) UNSIGNED DEFAULT NULL,
  `isBanned` tinyint(4) DEFAULT NULL,
  `isApproved` tinyint(4) DEFAULT NULL,
  `custom1` text DEFAULT NULL,
  `custom2` text DEFAULT NULL,
  `custom3` text DEFAULT NULL,
  `custom4` text DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `pass_reset_key` varchar(100) DEFAULT NULL,
  `pass_reset_expiry` int(10) UNSIGNED DEFAULT NULL,
  `flags` text DEFAULT NULL,
  `allowCSVImport` tinyint(4) NOT NULL DEFAULT 0,
  `data` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membership_users`
--

INSERT INTO `membership_users` (`memberID`, `passMD5`, `email`, `signupDate`, `groupID`, `isBanned`, `isApproved`, `custom1`, `custom2`, `custom3`, `custom4`, `comments`, `pass_reset_key`, `pass_reset_expiry`, `flags`, `allowCSVImport`, `data`) VALUES
('admin', '$2y$10$IeTyUP6RWdGLAEOb1mWbbe8i4jiJR0TSf.mM6ufyF2sIKHsNylYIu', 'liahsuum@gmail.com', '2022-08-30', 2, 0, 1, NULL, NULL, NULL, NULL, 'Admin member created automatically on 2022-08-30', NULL, NULL, NULL, 0, NULL),
('guest', NULL, NULL, '2022-08-30', 1, 0, 1, NULL, NULL, NULL, NULL, 'Anonymous member created automatically on 2022-08-30', NULL, NULL, NULL, 0, NULL),
('admin', '$2y$10$IeTyUP6RWdGLAEOb1mWbbe8i4jiJR0TSf.mM6ufyF2sIKHsNylYIu', 'liahsuum@gmail.com', '2024-01-13', 2, 0, 1, NULL, NULL, NULL, NULL, 'Admin member created automatically on 2024-01-13', NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membership_usersessions`
--

CREATE TABLE `membership_usersessions` (
  `memberID` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `agent` varchar(100) NOT NULL,
  `expiry_ts` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `politica_de_prestamos`
--

CREATE TABLE `politica_de_prestamos` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_Tipo_usuario` int(10) UNSIGNED DEFAULT NULL,
  `id_Tipo_documento` int(10) UNSIGNED DEFAULT NULL,
  `Duracion_Prestamo` int(11) DEFAULT NULL,
  `Lim_Doc_Presado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `politica_de_prestamos`
--

INSERT INTO `politica_de_prestamos` (`id`, `id_Tipo_usuario`, `id_Tipo_documento`, `Duracion_Prestamo`, `Lim_Doc_Presado`) VALUES
(1, 1, 1, 3, 3),
(2, 2, 1, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` int(10) UNSIGNED NOT NULL,
  `Codigo_de_Registro` varchar(40) DEFAULT NULL,
  `Codigo_Barras` varchar(50) DEFAULT NULL,
  `id_Estado_Conservacion` int(10) UNSIGNED DEFAULT NULL,
  `id_Estado_Prestable` int(10) UNSIGNED DEFAULT NULL,
  `Fecha_Regsitro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`id`, `Codigo_de_Registro`, `Codigo_Barras`, `id_Estado_Conservacion`, `id_Estado_Prestable`, `Fecha_Regsitro`) VALUES
(1, 'R-000001', 'BI000000001', 1, 1, NULL),
(2, 'R-000002', 'BI000000002', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_autoridad`
--

CREATE TABLE `tipo_autoridad` (
  `id` int(10) UNSIGNED NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `tipo_autoridad`
--

INSERT INTO `tipo_autoridad` (`id`, `Descripcion`) VALUES
(1, 'Autor personal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(10) UNSIGNED NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `Descripcion`) VALUES
(1, 'Texto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL,
  `Lim_Doc_Prestado` int(11) DEFAULT NULL,
  `Lim_Doc_Reserva` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `Foto` varchar(50) DEFAULT NULL,
  `id_Tipo_usuario` int(10) UNSIGNED DEFAULT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `Nombres` varchar(50) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `Telefono` varchar(50) DEFAULT NULL,
  `id_Estado_suscripcion` int(10) UNSIGNED DEFAULT NULL,
  `Fecha_Registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autoridades`
--
ALTER TABLE `autoridades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Tipo_autoridad` (`id_Tipo_autoridad`);

--
-- Indices de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Codigo_Registro` (`Codigo_Registro`),
  ADD KEY `Tipo_Documento` (`Tipo_Documento`),
  ADD KEY `id_Estado_Catalogacion` (`id_Estado_Catalogacion`),
  ADD KEY `Id_Autoridad` (`Id_Autoridad`),
  ADD KEY `Id_Lugar` (`Id_Lugar`),
  ADD KEY `id_Editorial` (`id_Editorial`),
  ADD KEY `Materia_1` (`Materia_1`),
  ADD KEY `Materia_2` (`Materia_2`),
  ADD KEY `Materia_3` (`Materia_3`);

--
-- Indices de la tabla `circulacion`
--
ALTER TABLE `circulacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Usuario` (`id_Usuario`),
  ADD KEY `id_Tipo_usuario` (`id_Tipo_usuario`),
  ADD KEY `id_Politica_pretamo` (`id_Politica_pretamo`),
  ADD KEY `id_Tipo_documento` (`id_Tipo_documento`),
  ADD KEY `Libro_Prestado` (`Libro_Prestado`),
  ADD KEY `id_Estado_prestamo` (`id_Estado_prestamo`),
  ADD KEY `Cod_Ejemplar` (`Cod_Ejemplar`);

--
-- Indices de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_catalogacion`
--
ALTER TABLE `estado_catalogacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_conservacion`
--
ALTER TABLE `estado_conservacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_prestable`
--
ALTER TABLE `estado_prestable`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_prestamo`
--
ALTER TABLE `estado_prestamo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_suscripcion`
--
ALTER TABLE `estado_suscripcion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `itemes`
--
ALTER TABLE `itemes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Cod_item` (`Cod_item`),
  ADD KEY `Estado_Conservacion` (`Estado_Conservacion`);

--
-- Indices de la tabla `lugares`
--
ALTER TABLE `lugares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `membership_grouppermissions`
--
ALTER TABLE `membership_grouppermissions`
  ADD UNIQUE KEY `groupID_tableName` (`groupID`,`tableName`);

--
-- Indices de la tabla `membership_groups`
--
ALTER TABLE `membership_groups`
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `membership_userpermissions`
--
ALTER TABLE `membership_userpermissions`
  ADD UNIQUE KEY `memberID_tableName` (`memberID`,`tableName`);

--
-- Indices de la tabla `membership_userrecords`
--
ALTER TABLE `membership_userrecords`
  ADD UNIQUE KEY `tableName_pkValue` (`tableName`,`pkValue`(100)),
  ADD KEY `pkValue` (`pkValue`),
  ADD KEY `tableName` (`tableName`),
  ADD KEY `memberID` (`memberID`),
  ADD KEY `groupID` (`groupID`);

--
-- Indices de la tabla `membership_users`
--
ALTER TABLE `membership_users`
  ADD KEY `groupID` (`groupID`);

--
-- Indices de la tabla `politica_de_prestamos`
--
ALTER TABLE `politica_de_prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Tipo_usuario` (`id_Tipo_usuario`),
  ADD KEY `id_Tipo_documento` (`id_Tipo_documento`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Estado_Conservacion` (`id_Estado_Conservacion`),
  ADD KEY `id_Estado_Prestable` (`id_Estado_Prestable`);

--
-- Indices de la tabla `tipo_autoridad`
--
ALTER TABLE `tipo_autoridad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Tipo_usuario` (`id_Tipo_usuario`),
  ADD KEY `id_Estado_suscripcion` (`id_Estado_suscripcion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autoridades`
--
ALTER TABLE `autoridades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `circulacion`
--
ALTER TABLE `circulacion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_catalogacion`
--
ALTER TABLE `estado_catalogacion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_conservacion`
--
ALTER TABLE `estado_conservacion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estado_prestable`
--
ALTER TABLE `estado_prestable`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estado_prestamo`
--
ALTER TABLE `estado_prestamo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_suscripcion`
--
ALTER TABLE `estado_suscripcion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `itemes`
--
ALTER TABLE `itemes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lugares`
--
ALTER TABLE `lugares`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `politica_de_prestamos`
--
ALTER TABLE `politica_de_prestamos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_autoridad`
--
ALTER TABLE `tipo_autoridad`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
