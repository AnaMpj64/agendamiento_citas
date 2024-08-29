-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:33065
-- Tiempo de generación: 19-09-2023 a las 22:41:57
-- Versión del servidor: 10.4.24-MariaDB-log
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `achilie_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `ID` int(11) NOT NULL,
  `FECHA_RESERVA` date NOT NULL,
  `FECHA_CITA` date NOT NULL,
  `HORA_CITA` time NOT NULL,
  `SERVICIO` varchar(200) NOT NULL,
  `ESTADO` varchar(200) DEFAULT NULL,
  `PERSONAL_ID` int(11) DEFAULT NULL,
  `PACIENTE_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`ID`, `FECHA_RESERVA`, `FECHA_CITA`, `HORA_CITA`, `SERVICIO`, `ESTADO`, `PERSONAL_ID`, `PACIENTE_ID`) VALUES
(19, '2023-09-01', '2023-09-02', '10:00:00', 'Tratamiento quiropráctico', 'Cancelada', NULL, 1),
(20, '2023-09-01', '2023-08-30', '10:00:00', 'Consulta', 'Cancelada', NULL, 1),
(21, '2023-09-02', '2023-09-04', '08:00:00', 'Consulta', 'Incumplida', 2, 1),
(22, '2023-09-02', '2023-09-04', '10:00:00', 'Consulta', 'Cumplida', 1, 1),
(23, '2023-09-03', '2023-09-05', '09:00:00', 'Consulta', 'Cumplida', 1, 1),
(25, '2023-09-04', '2023-09-07', '12:00:00', 'Tratamientos para dolores específicos', 'Cumplida', 1, 1),
(26, '2023-09-04', '2023-09-06', '10:00:00', 'Tratamiento quiropráctico', 'Cumplida', 1, 2),
(27, '2023-09-04', '2023-09-07', '11:00:00', 'Tratamiento quiropráctico', 'Cumplida', 1, 1),
(28, '2023-09-04', '2023-09-07', '10:00:00', 'Rehabilitación', 'Cumplida', 1, 1),
(29, '2023-09-04', '2023-09-05', '10:00:00', 'Consulta', 'Incumplida', 1, 2),
(30, '2023-09-04', '2023-09-06', '09:00:00', 'Consulta', 'Cumplida', 1, 1),
(31, '2023-09-04', '2023-09-06', '11:00:00', 'Consulta', 'Incumplida', 1, 1),
(32, '2023-09-04', '2023-09-08', '10:00:00', 'Rehabilitación', 'Incumplida', 2, 1),
(33, '2023-09-05', '2023-09-08', '11:00:00', 'Consulta', 'Cancelada', NULL, 2),
(34, '2023-09-05', '2023-09-08', '12:00:00', 'Tratamiento quiropráctico', 'Cumplida', 3, 1),
(35, '2023-09-05', '2023-09-08', '09:00:00', 'Terapia de electroestimulación', 'Cumplida', 3, 2),
(36, '2023-09-05', '2023-09-08', '08:00:00', 'Rehabilitación', 'Incumplida', 1, 1),
(37, '2023-09-06', '2023-09-05', '14:00:00', 'Terapia de electroestimulación', 'Cancelada', NULL, 1),
(38, '2023-09-06', '2023-09-07', '14:00:00', 'Rehabilitación', 'Cancelada', NULL, 1),
(39, '2023-09-06', '2023-09-08', '15:00:00', 'Rehabilitación', 'Cancelada', NULL, 1),
(40, '2023-09-06', '2023-09-08', '14:00:00', 'Terapia de electroestimulación', 'Cancelada', NULL, 1),
(41, '2023-09-06', '2023-09-08', '16:00:00', 'Consulta', 'Cumplida', 2, 1),
(42, '2023-09-06', '2023-09-09', '09:00:00', 'Consulta', 'Incumplida', 3, 1),
(43, '2023-09-06', '2023-09-08', '17:00:00', 'Terapia de electroestimulación', 'Cumplida', 1, 1),
(44, '2023-09-07', '2023-09-09', '10:00:00', 'Tratamientos para dolores específicos', 'Cumplida', 2, 1),
(45, '2023-09-07', '2023-09-09', '11:00:00', 'Consulta', 'Cumplida', 3, 3),
(46, '2023-09-07', '2023-09-11', '08:00:00', 'Tratamiento quiropráctico', 'Cancelada', NULL, 1),
(47, '2023-09-07', '2023-09-09', '12:00:00', 'Consulta', 'En espera de confirmación', NULL, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correo_enviado`
--

CREATE TABLE `correo_enviado` (
  `ID` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `DESCRIPCION` varchar(200) NOT NULL,
  `CITAS_ID` int(11) NOT NULL,
  `EJERCICIOS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios`
--

CREATE TABLE `ejercicios` (
  `ID` int(11) NOT NULL,
  `NOMBRE_EJERCICIO` varchar(45) NOT NULL,
  `DESCRIPCION` varchar(2000) NOT NULL,
  `IMAGEN` varchar(50) DEFAULT NULL,
  `CONTRAINDICACION` varchar(300) DEFAULT NULL,
  `USUARIOS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`ID`, `NOMBRE_EJERCICIO`, `DESCRIPCION`, `IMAGEN`, `CONTRAINDICACION`, `USUARIOS_ID`) VALUES
(12, '\"Apertura de libro\" RDM rotación torácica tum', 'Túmbese de lado con los brazos extendidos en el suelo delante de usted.\r\nLa parte inferior de su pierna debe estar recta y en línea con el resto de su cuerpo.\r\nLa pierna superior debe estar doblada delante de usted con la cadera y la rodilla a 90 grados.\r\nPuede descansar la parte superior de la pierna sobre almohadas o un rodillo de espuma.\r\nInspire profundamente.\r\nAl exhalar, levante el brazo superior desde el suelo hacia el techo.\r\nSiga el movimiento con la cabeza.\r\nContinúe moviendo este brazo hacia arriba y hacia el suelo en el otro lado.\r\nPermita que la parte superior de su cuerpo y su cabeza sigan el movimiento de este brazo.\r\nRespire profundamente en este punto final.\r\nAl exhalar, levante este brazo del suelo, continuando hacia el techo y vuelva a colocarlo sobre el otro brazo.', '../../public/uploads/libro.PNG', 'No se indica ', 3),
(13, 'Postura gato-camello (Ortopedia espalda)', 'Manténgase arrodillado con las manos apoyadas sobre la colchoneta y la espalda recta. Sostenga esta posición unos segundos. Arquee la espalda hacia arriba bajando el mentón hacia el pecho e inclinando el cóccix hacia adelante. Sostenga unos segundos y regrese a la postura anterior.', '../../public/uploads/camello.PNG', 'Personas con lesión lumbar severa', 3),
(14, 'Sentadilla isométrica en pared', 'Colóquese de pie con una pared detrás de usted. Apoye su espalda y las nalgas contra la pared y luego camine con los pies hacia delante. Deslícese por la pared hasta alcanzar un ángulo de 90 grados en sus caderas y rodillas.\r\nAsegúrese de que la espalda y la zona glútea permanezcan en contacto con la pared. Mantenga esta posición.', '../../public/uploads/sentadilla.PNG', 'Problemas en las articulaciones de las rodillas', 3),
(17, 'Estiramiento del Músculo dorsal ancho', 'Comience apoyándose sobre sus manos y rodillas y deje caer sus glúteos sobre los talones. Estire las manos hacia adelante, dejando caer la cabeza entre los hombros hacia el suelo. Sentirá el estiramiento a lo largo de la espalda y los brazos.', '../../public/uploads/estiramiento.PNG', 'NINGUNA', 3),
(18, 'Ejercicio de prueba', 'descripcion de prueba', '../../public/uploads/estiramiento.PNG', 'ninguna ', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `ID` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `DIAGNOSTICO` varchar(200) NOT NULL,
  `RECOMENDACION` varchar(200) DEFAULT NULL,
  `PACIENTE_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`ID`, `FECHA`, `DIAGNOSTICO`, `RECOMENDACION`, `PACIENTE_ID`) VALUES
(1, '2023-08-28', 'Dolor de Espalda Baja (Lumbalgia)', 'Estiramientos de Espalda Baja', 2),
(2, '2023-09-06', 'Diagnóstico de Prueba', 'Descanso', 1),
(3, '2023-09-06', 'NADA', 'NINGUNA', 2),
(4, '2023-09-06', 'Otro', 'otra', 2),
(5, '2023-09-06', 'Diagnos', 'Recome', 2),
(6, '2023-09-07', 'Hoy tiene dolor de espalda', 'Revisar ejercicio en la plataforma de estiramiento', 2),
(7, '2023-09-07', 'Nuevo historial', 'Nueva recomendacion', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `ID` int(11) NOT NULL,
  `CEDULA` varchar(45) NOT NULL,
  `NOMBRES` varchar(60) NOT NULL,
  `APELLIDOS` varchar(60) NOT NULL,
  `FECHA_NACIMIENTO` date NOT NULL,
  `CORREO` varchar(100) NOT NULL,
  `TELEFONO` varchar(20) DEFAULT NULL,
  `OCUPACION` varchar(45) DEFAULT NULL,
  `ALERGIAS` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`ID`, `CEDULA`, `NOMBRES`, `APELLIDOS`, `FECHA_NACIMIENTO`, `CORREO`, `TELEFONO`, `OCUPACION`, `ALERGIAS`) VALUES
(1, '1719837468', 'Martha Parrales', 'Gonzales Párraga', '1989-08-01', 'n_nparrga@hotmail.com', '0947856785', 'Ama de casa', 'Ninguna conocida'),
(2, '1873674875', 'Carlos Manuel', 'Macías Zambrano', '1999-11-15', 'carlosdsfiuh@hotmail.com', '0947859999', 'Comediante', 'Acetaminofen'),
(3, '1752430444', 'Sheila Sonia', 'Perez Gonzales', '2001-07-12', 'shei_hau@gmail.com', '0982562321', 'Contadora', 'Polen'),
(4, '1752430444', 'Ana', 'Guzman', '2023-06-09', 'shei_hau@gmail.com', '0982562321', 'Contadora', 'Polen'),
(5, '324324324', 'ddsf', 'dsafdsf', '2023-09-09', 'dasf@hotmail.com', 'dsa', 'dsf', 'dsfdsfa'),
(6, '1752430666', 'kARINA', 'Guzman', '2023-09-01', 'dasf@hotmail.com', '0982562321', 'Contadora', 'Polen'),
(7, '1752430455', 'Maikol', 'Suarez', '2023-09-17', 'dassf@hotmail.com', '0982562321', 'Contadora', 'Polen');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `ID` int(11) NOT NULL,
  `CEDULA` varchar(45) NOT NULL,
  `NOMBRES` varchar(60) NOT NULL,
  `APELLIDOS` varchar(60) NOT NULL,
  `FECHA_NACIMIENTO` date NOT NULL,
  `CORREO` varchar(100) NOT NULL,
  `TELEFONO` varchar(20) NOT NULL,
  `CARGO` varchar(45) DEFAULT NULL,
  `SUELDO` decimal(6,2) DEFAULT NULL,
  `ESPECIALIDAD` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`ID`, `CEDULA`, `NOMBRES`, `APELLIDOS`, `FECHA_NACIMIENTO`, `CORREO`, `TELEFONO`, `CARGO`, `SUELDO`, `ESPECIALIDAD`) VALUES
(1, '9999999999', 'Ana', 'Gutierrez', '1998-07-15', 'ana78@hotmail.com', '09923983247', 'Administrador', '5000.00', 'Software Engeenier'),
(2, '1798726377', 'Dannosa Meilenosa', 'Cruzosa Verosa', '2001-09-03', 'dannosafloppy@gmail.com', '0984998576', 'Supervisora', '50.00', 'Traumatóloga'),
(3, '1719827364', 'Henry Esteban', 'Achilie Suarez', '1993-09-10', 'henry_ss15@gmail.com', '0990392540', 'Gerente', '1000.00', 'Traumatólogo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `USER` varchar(45) NOT NULL,
  `PASSWORD` varchar(45) NOT NULL,
  `ROL` varchar(45) NOT NULL,
  `PACIENTE_ID` int(11) DEFAULT NULL,
  `PERSONAL_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `USER`, `PASSWORD`, `ROL`, `PACIENTE_ID`, `PERSONAL_ID`) VALUES
(1, 'martha', 'martha', 'paciente', 1, NULL),
(2, 'ana', 'ana', 'Administrador', NULL, 1),
(3, 'henry', 'henry', 'Administrador', NULL, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_CITAS_PERSONAL1_idx` (`PERSONAL_ID`),
  ADD KEY `fk_CITAS_PACIENTE1_idx` (`PACIENTE_ID`);

--
-- Indices de la tabla `correo_enviado`
--
ALTER TABLE `correo_enviado`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_CORREO_ENVIADO_CITAS1_idx` (`CITAS_ID`),
  ADD KEY `fk_CORREO_ENVIADO_EJERCICIOS1_idx` (`EJERCICIOS_ID`);

--
-- Indices de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_EJERCICIOS_USUARIOS1_idx` (`USUARIOS_ID`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_HISTORIAL_PACIENTE_idx` (`PACIENTE_ID`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_USUARIOS_PACIENTE1_idx` (`PACIENTE_ID`),
  ADD KEY `fk_USUARIOS_PERSONAL1_idx` (`PERSONAL_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `correo_enviado`
--
ALTER TABLE `correo_enviado`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_CITAS_PACIENTE1` FOREIGN KEY (`PACIENTE_ID`) REFERENCES `paciente` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CITAS_PERSONAL1` FOREIGN KEY (`PERSONAL_ID`) REFERENCES `personal` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `correo_enviado`
--
ALTER TABLE `correo_enviado`
  ADD CONSTRAINT `fk_CORREO_ENVIADO_CITAS1` FOREIGN KEY (`CITAS_ID`) REFERENCES `citas` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CORREO_ENVIADO_EJERCICIOS1` FOREIGN KEY (`EJERCICIOS_ID`) REFERENCES `ejercicios` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD CONSTRAINT `fk_EJERCICIOS_USUARIOS1` FOREIGN KEY (`USUARIOS_ID`) REFERENCES `usuarios` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `fk_HISTORIAL_PACIENTE` FOREIGN KEY (`PACIENTE_ID`) REFERENCES `paciente` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_USUARIOS_PACIENTE1` FOREIGN KEY (`PACIENTE_ID`) REFERENCES `paciente` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USUARIOS_PERSONAL1` FOREIGN KEY (`PERSONAL_ID`) REFERENCES `personal` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
