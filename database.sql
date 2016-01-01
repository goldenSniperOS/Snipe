-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-01-2016 a las 01:03:03
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `permissions` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'goldensniper', 'd2ba36032b4a2f1e56213b510debe3e343aa43c75f749ba4cb7aae560044413a', '÷õif@þìZ°t¡\ZÙ¦ae"[?j?6¨¬ìX¿è(', '{total:true}', '2015-12-30 15:51:18', '2015-12-30 19:57:40'),
(2, 'anguelsc', '4991f9b2dfe08f44321694932347e81d171b53f3f97a097327633d6f0fa9c04e', '¥W?Ú"0Û???i1²K+ä¿¾B5Õ&©TxÑ;', '{total:true}', '2015-12-30 15:51:18', '2015-12-30 19:57:45'),
(5, 'goldensniper', '5e3268784018081beb754094887e3c9e4c388596776ccfd35dc131741222b2d9', '¬EÛÙ?»¿?Ü\n#+»Â<èÇ¶Åä?@ÙB', '', '2015-12-30 20:05:09', '0000-00-00 00:00:00'),
(6, 'anguelsc', '48bf2056212a0b3957b3b9724dae9992620302f32055283ba1fe61f205f6885f', 'ÿÕkÑÀà?tz¸Gûü?v\rdgÉyí??Ã³®', '', '2015-12-30 20:05:09', '0000-00-00 00:00:00'),
(7, 'goldensniper', 'e6dc33dbd027a03cfb9e9e0a4b8e41f11686f1fc4de79ec73fe3c22f719c5dc0', 'J?¦?¡:#Âö;DÄíà_Ödëo?ÔÉTrü?(ø{', '', '2015-12-30 20:05:40', '0000-00-00 00:00:00'),
(8, 'anguelsc', '5613b8ffd596677f2b100702258400586737142891b97fe21c4d9dbe662b4996', 'Ú?ª³Â±û1Ùx??í?	\0°R³\r?õ´Õ?Ï·?ÁÑ?', '', '2015-12-30 20:05:41', '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `sessions`
--
ALTER TABLE `sessions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
