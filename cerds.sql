-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-02-2025 a las 05:27:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cerds`
--

-- --------------------------------------------------------

DROP DATABASE IF EXISTS cerds;
CREATE DATABASE cerds;
USE cerds;

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('pending','in progress','cancelled','completed') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`id`, `instructor_id`, `lab_id`, `name`, `description`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 'Programación en Java', 'Este curso está dirigido a las personas que deseen aprender a programar en Java, el lenguaje enterprise más importante del mundo. Con excelente salida laboral. Te enseñaremos todo lo que necesitas para ser un excelente programador.', '2025-02-01', '2025-03-02', 'pending', '2025-02-18 03:40:12', '2025-02-18 03:47:50'),
(2, 1, 1, 'UML: Una herramienta para las bases de datos', 'Este curso está dirigido a todas las personas que deseen aprender a crear modelos UML para representación de bases de datos.', '2025-02-01', '2025-02-28', 'pending', '2025-02-18 03:41:03', '2025-02-18 03:41:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructors`
--

CREATE TABLE `instructors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instructors`
--

INSERT INTO `instructors` (`id`, `first_name`, `last_name`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Andrea', 'Canino', 'andreacanino@gmail.com', '+12015554848', '2025-02-18 03:34:53', '2025-02-18 03:34:53'),
(2, 'Alexis', 'Mola', 'alexismola@gmail.com', '+584241234567', '2025-02-18 03:35:15', '2025-02-18 03:35:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `labs`
--

CREATE TABLE `labs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `schedule` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`schedule`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `labs`
--

INSERT INTO `labs` (`id`, `name`, `capacity`, `schedule`, `created_at`, `updated_at`) VALUES
(1, 'Simón Bolivar', 30, '{\"L\":[{\"start_date\":\"09:00\",\"end_date\":\"12:00\"},{\"start_date\":\"13:00\",\"end_date\":\"18:00\"}],\"X\":[{\"start_date\":\"09:00\",\"end_date\":\"12:00\"},{\"start_date\":\"13:00\",\"end_date\":\"18:00\"}],\"V\":[{\"start_date\":\"09:00\",\"end_date\":\"12:00\"},{\"start_date\":\"13:00\",\"end_date\":\"18:00\"}]}', '2025-02-18 03:38:12', '2025-02-18 03:38:12'),
(2, 'Francisco de Miranda', 10, '{\"M\":[{\"start_date\":\"09:00\",\"end_date\":\"12:00\"}],\"J\":[{\"start_date\":\"09:00\",\"end_date\":\"12:00\"}]}', '2025-02-18 03:38:45', '2025-02-18 03:38:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `created_at`) VALUES
(1, NULL, 'Creado el usuario con ID: 1 - Alexis Mola', '2025-02-17 04:31:50'),
(2, NULL, 'Creado el usuario con ID: 2 - alexismola', '2025-02-17 04:32:16'),
(3, 3, 'Creo un nuevo estudiante: Pedro Uzcátegui', '2025-02-18 03:32:58'),
(4, 3, 'Edito el estudiante con ID 1 - Pedro Uzcátegui', '2025-02-18 03:33:03'),
(5, 3, 'Actualizado el usuario con ID: 3 - test', '2025-02-18 03:33:20'),
(6, 3, 'Creo un nuevo estudiante: Laura Toro', '2025-02-18 03:34:00'),
(7, 3, 'Creo un nuevo estudiante: Mercedes Francis', '2025-02-18 03:34:28'),
(8, 3, 'Nuevo instructor creado: 1 - Andrea Canino', '2025-02-18 03:34:53'),
(9, 3, 'Nuevo instructor creado: 2 - Alexis Mola', '2025-02-18 03:35:15'),
(10, 3, 'Nuevo laboratorio creado: 1 - Simón Bolivar', '2025-02-18 03:38:12'),
(11, 3, 'Nuevo laboratorio creado: 2 - Francisco de Miranda', '2025-02-18 03:38:45'),
(12, 3, 'Creo un nuevo curso: Programación en Java', '2025-02-18 03:40:12'),
(13, 3, 'Edito el curso: 1 - Programación en Java', '2025-02-18 03:40:19'),
(14, 3, 'Creo un nuevo curso: UML: Una herramienta para las bases de datos', '2025-02-18 03:41:03'),
(15, 3, 'Edito el curso: 1 - Programación en Java', '2025-02-18 03:41:06'),
(16, 3, 'Registro un nuevo pago: 1', '2025-02-18 03:41:58'),
(17, 3, 'Registro un nuevo pago: 2', '2025-02-18 03:47:03'),
(18, 3, 'Pago con ID: 2 fue actualizado', '2025-02-18 03:47:15'),
(19, 3, 'Creo una solicitud de tiempo libre con ID: 1', '2025-02-18 03:47:46'),
(20, 3, 'Actualizo una solicitud de tiempo libre con ID: 1', '2025-02-18 03:47:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `currency` enum('VES','USD') DEFAULT NULL,
  `reference` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `payments`
--

INSERT INTO `payments` (`id`, `student_id`, `course_id`, `amount`, `currency`, `reference`, `image`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 50.00, 'USD', '#123456', 'enhorabuena-jorge-juego.png', '2025-02-17', 'completed', '2025-02-18 03:41:58', '2025-02-18 03:41:58'),
(2, 3, 2, 50.00, 'USD', '#654321', 'artworks-000481811877-78eg1c-t500x500.jpg', '2025-02-17', 'completed', '2025-02-18 03:47:03', '2025-02-18 03:47:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pto_requests`
--

CREATE TABLE `pto_requests` (
  `id` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pto_requests`
--

INSERT INTO `pto_requests` (`id`, `instructor_id`, `course_id`, `start_date`, `end_date`, `status`, `reason`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-02-19', '2025-02-19', NULL, 'Debo llevar a mis hijos al colegio para un acto especial', '2025-02-18 03:47:46', '2025-02-18 03:47:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Pedro', 'Uzcátegui', 'pedrouzcategui0103@gmail.com', '+584140236066', '2025-02-18 03:32:58', '2025-02-18 03:32:58'),
(2, 'Laura', 'Toro', 'lauratoro@gmail.com', '+584128293284', '2025-02-18 03:34:00', '2025-02-18 03:34:00'),
(3, 'Mercedes', 'Francis', 'mercedesfrancis@gmail.com', '+584241496278', '2025-02-18 03:34:28', '2025-02-18 03:34:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'alexismola', 'd885585de6c025fc9f94bb1ee2ff8382', 'alexismola@gmail.com', '+58 412-9840922', '2025-02-17 04:31:50', '2025-02-17 04:31:50'),
(2, 'admintest', 'e4b4efd20ada72c6f7708b0c1cc78469', 'admin@test.com', '+584140236066', '2025-02-17 04:32:16', '2025-02-17 04:32:16'),
(3, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test@test.com', '+12015554848', '2025-02-17 04:37:21', '2025-02-18 03:33:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `lab_id` (`lab_id`);

--
-- Indices de la tabla `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indices de la tabla `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indices de la tabla `pto_requests`
--
ALTER TABLE `pto_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
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
-- AUTO_INCREMENT de la tabla `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `labs`
--
ALTER TABLE `labs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pto_requests`
--
ALTER TABLE `pto_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`lab_id`) REFERENCES `labs` (`id`);

--
-- Filtros para la tabla `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Filtros para la tabla `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Filtros para la tabla `pto_requests`
--
ALTER TABLE `pto_requests`
  ADD CONSTRAINT `pto_requests_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pto_requests_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
