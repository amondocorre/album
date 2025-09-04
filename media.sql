-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-09-2025 a las 04:34:13
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `graduacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` enum('foto','video') DEFAULT NULL,
  `drive_id` varchar(200) DEFAULT NULL,
  `cloudinary_url` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `corazones` int(11) DEFAULT 0,
  `creado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `media`
--

INSERT INTO `media` (`id`, `nombre`, `descripcion`, `tipo`, `drive_id`, `cloudinary_url`, `likes`, `corazones`, `creado`) VALUES
(12, 'das', 'asd', 'foto', '1KQbNxnt_tRvylSgjLF_yAB1vR7tPXhUA', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756767442/graduacion/rmqktftiqnx8xnnkjvx4.jpg', 1, 1, '2025-09-01 22:57:23'),
(13, 'as', 'asdas', 'foto', '1hWPFUDjTGFwS5UwoU6ZfPxu1XSm5EJ9s', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756767470/graduacion/tc2jmubvplscyewl2vm2.png', 4, 4, '2025-09-01 22:57:50'),
(14, 'as', 'asdas', 'foto', '1Hb6YMZGHC120Kun7p9VLhikxzkRjaknP', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756767476/graduacion/bpkk7frc9bgz5iae5w3n.png', 0, 0, '2025-09-01 22:57:56'),
(15, 'admin', 'wert', 'foto', '16sP3rdll9SVof3pm-dD2OADibV_WDPzX', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756844554/graduacion/kimokp7r2jtqkurripry.png', 0, 0, '2025-09-02 20:22:34'),
(16, 'CXVC', 'XCVXCV', 'foto', '14RLE1-a_7KxNgbnl5myA4AFCHIwg8XdB', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756844733/graduacion/j0kkosprkqph7h1z38h3.png', 0, 0, '2025-09-02 20:25:33'),
(17, 'CXVC', 'XCVXCV', 'foto', '1JcYOq8qe2RVbCRyotJFIW1xiLNujCi9o', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756844740/graduacion/czdutz7qe65ctt2gxiou.jpg', 0, 0, '2025-09-02 20:25:40'),
(18, 'CXVC', 'XCVXCV', 'foto', '1hl-D5Qa1L_4Kcck0CzI_52sMPZYcIfoU', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756844747/graduacion/h2t9ttwtss1oyhjppxkd.jpg', 0, 0, '2025-09-02 20:25:47'),
(19, 'CXVC', 'XCVXCV', 'foto', '1o0fNTUZg-TbfgBGCHZe-VUeVjWLYSfRO', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756844753/graduacion/m3ibbpydsrwfehsylk2r.jpg', 0, 2, '2025-09-02 20:25:53'),
(20, 'CXVC', 'XCVXCV', 'foto', '11bt3fhQ-Eyso3JgkypvnNzuzDMOW-UK_', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756844758/graduacion/beuoypuf3dlxltokz6ni.png', 0, 0, '2025-09-02 20:25:58'),
(21, 'Adolfo', 'Feliz', 'foto', '1rtAs5ARVx-pLdg1HmxqtqM2GU0lQBkLv', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756849955/graduacion/somyjd0pdv731qdvxjxh.jpg', 2, 3, '2025-09-02 21:52:35'),
(22, 'Adolfo', 'Feliz', 'foto', '1EfQbCfcCOD1703CC_TWpTzNUAYRLUIf1', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756849955/graduacion/kns384np0z1islnivcfg.jpg', 0, 0, '2025-09-02 21:52:35'),
(23, 'Dudue', 'Hdyey', 'foto', '1u3e3390qf4DDqR2VM4-WDmOQeOeRXYU4', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756936465/graduacion/a9cp3kpxibco39hcbmyk.jpg', 0, 0, '2025-09-03 21:54:25'),
(24, 'Dudue', 'Hdyey', 'foto', '1_QTamniHj0tI3qXj6P1noCB4X8EfZOim', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756936470/graduacion/r0gkrm1dj2wrczyvagmh.jpg', 0, 0, '2025-09-03 21:54:31'),
(25, 'Dudue', 'Hdyey', 'foto', '1PJJkZ8WJ7u1RcDNNhCxuLn4KmuMYyEXQ', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756936471/graduacion/bpcg9w1xprcyzwyfz3m6.jpg', 0, 0, '2025-09-03 21:54:31'),
(26, 'Dudue', 'Hdyey', 'foto', '14UqRbQM6iAmfbFtsGVOBdUvdvqdaW2gi', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756936479/graduacion/eiapm7qk9ogpanswcdqe.jpg', 0, 0, '2025-09-03 21:54:40'),
(27, 'asdasd', 'asdasd', 'foto', '1CazXlyRJuuuBga0kn-4JtwJamvmt7XDu', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756937108/graduacion/heds0xrv8p6dib7r4m3a.png', 0, 0, '2025-09-03 22:05:09'),
(28, 'asd', 'asd', 'foto', '1nRGle8TUtD8v8RFHb1TuB2kTB_2baEDc', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756937757/graduacion/xzrun4nbhlvsmygknel2.png', 0, 0, '2025-09-03 22:15:57'),
(29, 'sdfsdf', 'sdfsdf', 'foto', '1tArXERRh7AyKwYR9jkD-mJ6IwOZtM5PH', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756938187/graduacion/tx0s9l8gr8dctamenm6g.png', 0, 0, '2025-09-03 22:23:07'),
(30, 'sdfsdf', 'sdfsdf', 'foto', '1YcSU-oo1KiJfge-ZXaa3qA4_pwoXaaWN', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756938193/graduacion/moegb7ofryxrx00d2lqz.pdf', 0, 0, '2025-09-03 22:23:16'),
(31, 'sdfsdf', 'sdfsdf', 'foto', '1aXsxMXUYlxvNW4vn1wN5opefUMYc-Nd6', 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756938204/graduacion/jxbwpmorbvr21ju9c0xx.png', 0, 0, '2025-09-03 22:23:24'),
(32, 'sdf', 'sdf', 'foto', NULL, 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756938993/graduacion/uawv58dbqg7dddufsjbi.png', 0, 0, '2025-09-03 22:36:34'),
(33, 'asdfasd', 'asdasd', 'foto', NULL, 'https://res.cloudinary.com/dq3touuoa/image/upload/v1756939261/graduacion/gr8ws14ilkqjehmn8p2m.jpg', 0, 0, '2025-09-03 22:41:01'),
(34, 'sdf', 'sdf', 'video', NULL, 'https://res.cloudinary.com/dq3touuoa/video/upload/v1756939280/graduacion/bc0uq6jokewzhkzmpuhm.mkv', 0, 0, '2025-09-03 22:41:21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
