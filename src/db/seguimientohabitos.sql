-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2024 a las 04:55:40
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
-- Base de datos: `seguimientohabitos`
--
CREATE DATABASE IF NOT EXISTS `seguimientohabitos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `seguimientohabitos`;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarComentario` (IN `p_id_comentario_habito` INT, IN `p_comentario` TEXT)   BEGIN
    UPDATE `comentario_habito`
    SET `comentario` = p_comentario
    WHERE `id_comentario_habito` = p_id_comentario_habito;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarDesafio` (IN `p_id_desafio` INT, IN `p_nombre_desafio` VARCHAR(100), IN `p_descripcion_desafio` TEXT, IN `p_fecha_inicio` DATE, IN `p_fecha_finalizacion` DATE, IN `p_num_participantes` INT, IN `p_habito_asociado` INT, IN `p_recompensa_desafio` VARCHAR(255), IN `p_estado` ENUM('activo','finalizado'))   BEGIN
    UPDATE Desafio
    SET nombre_desafio = p_nombre_desafio,
        descripcion_desafio = p_descripcion_desafio,
        fecha_inicio = p_fecha_inicio,
        fecha_finalizacion = p_fecha_finalizacion,
        num_participantes = p_num_participantes,
        habito_asociado = p_habito_asociado,
        recompensa_desafio = p_recompensa_desafio,
        estado = p_estado
    WHERE id_desafio = p_id_desafio;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarEstadisticasUsuario` (IN `p_id_estadistica` INT, IN `p_usuario_id` INT, IN `p_num_habitos_activos` INT, IN `p_porcentaje_habitos_completados` DECIMAL(5,2), IN `p_dias_consecutivos_habitos_completados` INT, IN `p_promedio_habitos_cumplidos` DECIMAL(5,2), IN `p_fechas_mayores_avances` TEXT, IN `p_graficos_progreso` TEXT)   BEGIN
    UPDATE Estadisticas_Usuario
    SET usuario_id = p_usuario_id,
        num_habitos_activos = p_num_habitos_activos,
        porcentaje_habitos_completados = p_porcentaje_habitos_completados,
        dias_consecutivos_habitos_completados = p_dias_consecutivos_habitos_completados,
        promedio_habitos_cumplidos = p_promedio_habitos_cumplidos,
        fechas_mayores_avances = p_fechas_mayores_avances,
        graficos_progreso = p_graficos_progreso
    WHERE id_estadistica = p_id_estadistica;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarHabito` (IN `p_id_habito` INT, IN `p_nombre_habito` VARCHAR(100), IN `p_descripcion_habito` TEXT, IN `p_categoria_habito` VARCHAR(50), IN `p_objetivo_habito` VARCHAR(100), IN `p_frecuencia` ENUM('diaria','semanal','mensual','personalizada'), IN `p_duracion_estimada` INT, IN `p_estado` ENUM('activo','pausado','completado'), IN `p_fecha_inicio` DATE, IN `p_fecha_estimacion_final` DATE)   BEGIN
    UPDATE Habito
    SET nombre_habito = p_nombre_habito,
        descripcion_habito = p_descripcion_habito,
        categoria_habito = p_categoria_habito,
        objetivo_habito = p_objetivo_habito,
        frecuencia = p_frecuencia,
        duracion_estimada = p_duracion_estimada,
        estado = p_estado,
        fecha_inicio = p_fecha_inicio,
        fecha_estimacion_final = p_fecha_estimacion_final
    WHERE id_habito = p_id_habito;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarObjetivo` (IN `p_id_objetivo` INT, IN `p_habito_id` INT, IN `p_descripcion_objetivo` TEXT, IN `p_meta_cuantificable` VARCHAR(100), IN `p_estado` ENUM('pendiente','completado','en_progreso'), IN `p_fecha_inicio` DATE, IN `p_fecha_finalizacion_estimada` DATE, IN `p_notas_adicionales` TEXT)   BEGIN
    UPDATE Objetivo
    SET habito_id = p_habito_id,
        descripcion_objetivo = p_descripcion_objetivo,
        meta_cuantificable = p_meta_cuantificable,
        estado = p_estado,
        fecha_inicio = p_fecha_inicio,
        fecha_finalizacion_estimada = p_fecha_finalizacion_estimada,
        notas_adicionales = p_notas_adicionales
    WHERE id_objetivo = p_id_objetivo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarRecompensa` (IN `p_id_recompensa` INT, IN `p_usuario_id` INT, IN `p_descripcion_recompensa` TEXT, IN `p_condicion_obtencion` VARCHAR(255), IN `p_estado` ENUM('obtenida','pendiente'), IN `p_fecha_obtencion` DATE)   BEGIN
    UPDATE Recompensa
    SET usuario_id = p_usuario_id,
        descripcion_recompensa = p_descripcion_recompensa,
        condicion_obtencion = p_condicion_obtencion,
        estado = p_estado,
        fecha_obtencion = p_fecha_obtencion
    WHERE id_recompensa = p_id_recompensa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarRecordatorio` (IN `p_id_recordatorio` INT, IN `p_habito_id` INT, IN `p_tipo_recordatorio` ENUM('notificacion_push','correo_electronico','mensaje_texto'), IN `p_fecha_hora_recordatorio` DATETIME, IN `p_frecuencia_recordatorio` ENUM('diaria','semanal'), IN `p_estado` ENUM('activo','inactivo'))   BEGIN
    UPDATE Recordatorio
    SET habito_id = p_habito_id,
        tipo_recordatorio = p_tipo_recordatorio,
        fecha_hora_recordatorio = p_fecha_hora_recordatorio,
        frecuencia_recordatorio = p_frecuencia_recordatorio,
        estado = p_estado
    WHERE id_recordatorio = p_id_recordatorio;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarRegistroProgreso` (IN `p_id_registro` INT, IN `p_habito_id` INT, IN `p_fecha_registro` DATE, IN `p_estado_progreso` ENUM('completado','no_completado','parcial'), IN `p_notas_usuario` TEXT, IN `p_recompensas_obtenidas` VARCHAR(255))   BEGIN
    UPDATE Registro_Progreso
    SET habito_id = p_habito_id,
        fecha_registro = p_fecha_registro,
        estado_progreso = p_estado_progreso,
        notas_usuario = p_notas_usuario,
        recompensas_obtenidas = p_recompensas_obtenidas
    WHERE id_registro = p_id_registro;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarRevisionPersonal` (IN `p_id_revision` INT, IN `p_usuario_id` INT, IN `p_fecha_revision` DATE, IN `p_comentarios_personales` TEXT, IN `p_autoevaluacion` VARCHAR(50), IN `p_notas_mejorar` TEXT)   BEGIN
    UPDATE Revisión_Personal
    SET usuario_id = p_usuario_id,
        fecha_revision = p_fecha_revision,
        comentarios_personales = p_comentarios_personales,
        autoevaluacion = p_autoevaluacion,
        notas_mejorar = p_notas_mejorar
    WHERE id_revision = p_id_revision;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarUsuario` (IN `p_id_usuario` INT, IN `p_nombre` VARCHAR(50), IN `p_apellidos` VARCHAR(50), IN `p_correo_electronico` VARCHAR(100), IN `p_contrasena` VARCHAR(255), IN `p_fecha_nacimiento` DATE, IN `p_genero` VARCHAR(10), IN `p_pais_region` VARCHAR(50), IN `p_nivel_suscripcion` ENUM('gratuita','premium'), IN `p_preferencias_notificacion` VARCHAR(255))   BEGIN
    UPDATE Usuario
    SET nombre = p_nombre,
        apellidos = p_apellidos,
        correo_electronico = p_correo_electronico,
        contrasena = p_contrasena,
        fecha_nacimiento = p_fecha_nacimiento,
        genero = p_genero,
        pais_region = p_pais_region,
        nivel_suscripcion = p_nivel_suscripcion,
        preferencias_notificacion = p_preferencias_notificacion
    WHERE id_usuario = p_id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarComentario` (IN `p_id_comentario_habito` INT)   BEGIN
    DELETE FROM `comentario_habito` WHERE `id_comentario_habito` = p_id_comentario_habito;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarDesafio` (IN `p_id_desafio` INT)   BEGIN
    DELETE FROM Desafio WHERE id_desafio = p_id_desafio;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarEstadisticasUsuario` (IN `p_id_estadistica` INT)   BEGIN
    DELETE FROM Estadisticas_Usuario WHERE id_estadistica = p_id_estadistica;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarHabito` (IN `p_id_habito` INT)   BEGIN
    DELETE FROM Habito WHERE id_habito = p_id_habito;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarObjetivo` (IN `p_id_objetivo` INT)   BEGIN
    DELETE FROM Objetivo WHERE id_objetivo = p_id_objetivo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarRecompensa` (IN `p_id_recompensa` INT)   BEGIN
    DELETE FROM Recompensa WHERE id_recompensa = p_id_recompensa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarRecordatorio` (IN `p_id_recordatorio` INT)   BEGIN
    DELETE FROM Recordatorio WHERE id_recordatorio = p_id_recordatorio;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarRegistroProgreso` (IN `p_id_registro` INT)   BEGIN
    DELETE FROM Registro_Progreso WHERE id_registro = p_id_registro;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarRevisionPersonal` (IN `p_id_revision` INT)   BEGIN
    DELETE FROM Revisión_Personal WHERE id_revision = p_id_revision;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarUsuario` (IN `p_id_usuario` INT)   BEGIN
    DELETE FROM Usuario WHERE id_usuario = p_id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarComentario` (IN `p_grupo_id` INT, IN `p_usuario_id` INT, IN `p_comentario` TEXT, IN `p_fecha_comentario` DATE)   BEGIN
    INSERT INTO `comentario_habito` (`grupo_id`, `usuario_id`, `comentario`, `fecha_comentario`)
    VALUES (p_grupo_id, p_usuario_id, p_comentario, p_fecha_comentario);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarDesafio` (IN `p_nombre_desafio` VARCHAR(100), IN `p_fecha_inicio` DATE, IN `p_fecha_finalizacion` DATE, IN `p_num_participantes` INT, IN `p_habito_asociado` INT, IN `p_recompensa_desafio` VARCHAR(255), IN `p_estado` ENUM('activo','finalizado'))   BEGIN
    INSERT INTO Desafio (nombre_desafio,nombre_desafio,fecha_inicio,fecha_finalizacion,num_participantes,habito_asociado,recompensa_desafio,estado)
    Value (p_nombre_desafio,p_nombre_desafio,p_fecha_inicio,p_fecha_finalizacion,p_num_participantes,p_habito_asociado,p_recompensa_desafio,p_estado);
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarEstadisticasUsuario` (IN `p_usuario_id` INT, IN `p_num_habitos_activos` INT, IN `p_porcentaje_habitos_completados` DECIMAL(5,2), IN `p_dias_consecutivos_habitos_completados` INT, IN `p_promedio_habitos_cumplidos` DECIMAL(5,2), IN `p_fechas_mayores_avances` TEXT, IN `p_graficos_progreso` TEXT)   BEGIN
    INSERT INTO Estadisticas_Usuario (usuario_id, num_habitos_activos, porcentaje_habitos_completados, dias_consecutivos_habitos_completados, promedio_habitos_cumplidos, fechas_mayores_avances, graficos_progreso)
    VALUES (p_usuario_id, p_num_habitos_activos, p_porcentaje_habitos_completados, p_dias_consecutivos_habitos_completados, p_promedio_habitos_cumplidos, p_fechas_mayores_avances, p_graficos_progreso);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarHabito` (IN `p_nombre_habito` VARCHAR(100), IN `p_descripcion_habito` TEXT, IN `p_categoria_habito` VARCHAR(50), IN `p_objetivo_habito` VARCHAR(100), IN `p_frecuencia` VARCHAR(20), IN `p_duracion_estimada` INT, IN `p_estado` VARCHAR(20), IN `p_fecha_inicio` DATE, IN `p_fecha_estimacion_final` DATE, IN `p_usuario_id` INT, OUT `p_id_habito` INT)   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;
        -- Validación de parámetros para frecuencia
        IF p_frecuencia NOT IN ('diaria', 'semanal', 'mensual', 'personalizada') THEN
            SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Frecuencia inválida. Debe ser diaria, semanal, mensual o personalizada.';
        END IF;

        -- Validación de parámetros para estado
        IF p_estado NOT IN ('activo', 'pausado', 'completado') THEN
            SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Estado inválido. Debe ser activo, pausado o completado.';
        END IF;

        -- Inserción en la tabla Habito
        INSERT INTO Habito (
            nombre_habito, 
            descripcion_habito, 
            categoria_habito, 
            objetivo_habito, 
            frecuencia, 
            duracion_estimada, 
            estado, 
            fecha_inicio, 
            fecha_estimacion_final
        )
        VALUES (
            p_nombre_habito, 
            p_descripcion_habito, 
            p_categoria_habito, 
            p_objetivo_habito, 
            p_frecuencia, 
            p_duracion_estimada, 
            p_estado, 
            p_fecha_inicio, 
            p_fecha_estimacion_final
        );

        -- Obtener el ID del hábito recién insertado
        SET p_id_habito = LAST_INSERT_ID();

        -- Insertar la relación usuario-hábito
        INSERT INTO usuario_habito (usuario_id, habito_id)
        VALUES (p_usuario_id, p_id_habito);

    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarObjetivo` (IN `p_habito_id` INT, IN `p_descripcion_objetivo` TEXT, IN `p_meta_cuantificable` VARCHAR(100), IN `p_estado` ENUM('pendiente','completado','en_progreso'), IN `p_fecha_inicio` DATE, IN `p_fecha_finalizacion_estimada` DATE, IN `p_notas_adicionales` TEXT)   BEGIN
    INSERT INTO Objetivo (habito_id, descripcion_objetivo, meta_cuantificable, estado, fecha_inicio, fecha_finalizacion_estimada, notas_adicionales)
    VALUES (p_habito_id, p_descripcion_objetivo, p_meta_cuantificable, p_estado, p_fecha_inicio, p_fecha_finalizacion_estimada, p_notas_adicionales);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarRecompensa` (IN `p_usuario_id` INT, IN `p_descripcion_recompensa` TEXT, IN `p_condicion_obtencion` VARCHAR(255), IN `p_estado` ENUM('obtenida','pendiente'), IN `p_fecha_obtencion` DATE)   BEGIN
    INSERT INTO Recompensa (usuario_id, descripcion_recompensa, condicion_obtencion,estado,fecha_obtencion)
     VALUES (p_usuario_id, p_descripcion_recompensa, p_condicion_obtencion, p_estado, p_fecha_obtencion);
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarRecordatorio` (IN `p_habito_id` INT, IN `p_tipo_recordatorio` ENUM('notificacion_push','correo_electronico','mensaje_texto'), IN `p_fecha_hora_recordatorio` DATETIME, IN `p_frecuencia_recordatorio` ENUM('diaria','semanal'), IN `p_estado` ENUM('activo','inactivo'))   BEGIN
    INSERT INTO Recordatorio (habito_id, tipo_recordatorio, fecha_hora_recordatorio, frecuencia_recordatorio, estado)
    VALUES (p_habito_id, p_tipo_recordatorio, p_fecha_hora_recordatorio, p_frecuencia_recordatorio, p_estado);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarRegistroProgreso` (IN `p_habito_id` INT, IN `p_fecha_registro` DATE, IN `p_estado_progreso` ENUM('completado','no_completado','parcial'), IN `p_notas_usuario` TEXT, IN `p_recompensas_obtenidas` VARCHAR(255))   BEGIN
    INSERT INTO Registro_Progreso (habito_id, fecha_registro, estado_progreso, notas_usuario, recompensas_obtenidas)
    VALUES (p_habito_id, p_fecha_registro, p_estado_progreso, p_notas_usuario, p_recompensas_obtenidas);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarRevisionPersonal` (IN `p_usuario_id` INT, IN `p_fecha_revision` DATE, IN `p_comentarios_personales` TEXT, IN `p_autoevaluacion` VARCHAR(50), IN `p_notas_mejorar` TEXT)   BEGIN
    INSERT INTO Revisión_Personal (usuario_id, fecha_revision, comentarios_personales, autoevaluacion, notas_mejorar)
    VALUES (p_usuario_id, p_fecha_revision, p_comentarios_personales, p_autoevaluacion, p_notas_mejorar);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarUsuario` (IN `p_nombre` VARCHAR(50), IN `p_apellidos` VARCHAR(50), IN `p_correo_electronico` VARCHAR(100), IN `p_contrasena` VARCHAR(255), IN `p_fecha_nacimiento` DATE, IN `p_genero` VARCHAR(10), IN `p_pais_region` VARCHAR(50), IN `p_nivel_suscripcion` ENUM('gratuita','premium'), IN `p_preferencias_notificacion` VARCHAR(255))   BEGIN
    INSERT INTO Usuario (nombre, apellidos, correo_electronico, contrasena, fecha_nacimiento, genero, pais_region, nivel_suscripcion, preferencias_notificacion)
    VALUES (p_nombre, p_apellidos, p_correo_electronico, p_contrasena, p_fecha_nacimiento, p_genero, p_pais_region, p_nivel_suscripcion, p_preferencias_notificacion);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerComentariosPorGrupo` (IN `p_grupo_id` INT)   BEGIN
    SELECT * FROM `comentario_habito` WHERE `grupo_id` = p_grupo_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `validar_login` (IN `p_correo_electronico` VARCHAR(100), IN `p_contrasena` VARCHAR(255), OUT `p_resultado` INT, OUT `p_tipo_usuario` VARCHAR(10))   BEGIN
    DECLARE v_contrasena_hash VARCHAR(255);
    DECLARE v_id_usuario INT;

    -- Obtener la contraseña encriptada y el ID del usuario
    SELECT contrasena, id_usuario INTO v_contrasena_hash, v_id_usuario
    FROM Usuario
    WHERE correo_electronico = p_correo_electronico;

    -- Verificar si la contraseña ingresada coincide con la encriptada
    IF v_contrasena_hash IS NOT NULL AND v_contrasena_hash = p_contrasena THEN
        SET p_resultado = 1; -- Login exitoso

        -- Obtener el tipo de usuario
        SELECT tipo INTO p_tipo_usuario
        FROM tipos_usuario
        WHERE id_usuario = v_id_usuario;

    ELSE
        SET p_resultado = 0; -- Login fallido
        SET p_tipo_usuario = NULL; -- No se encontró el usuario o la contraseña es incorrecta
    END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios_usuario`
--

CREATE TABLE `comentarios_usuario` (
  `id_comentario` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_comentario` date DEFAULT NULL,
  `texto_comentario` text DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `estado_comentario` enum('revisado','pendiente') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario_habito`
--

CREATE TABLE `comentario_habito` (
  `id_comentario_habito` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `fecha_comentario` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentario_habito`
--

INSERT INTO `comentario_habito` (`id_comentario_habito`, `grupo_id`, `usuario_id`, `comentario`, `fecha_comentario`) VALUES(1, 1, 1, 'Tomar melatonina me ha ayudado a conciliar mejor el sueño', '2024-12-07');
INSERT INTO `comentario_habito` (`id_comentario_habito`, `grupo_id`, `usuario_id`, `comentario`, `fecha_comentario`) VALUES(2, 2, 1, 'Comer sano es bueno para la Salud', '2024-12-07');
INSERT INTO `comentario_habito` (`id_comentario_habito`, `grupo_id`, `usuario_id`, `comentario`, `fecha_comentario`) VALUES(3, 2, 1, 'Otro comentario de Prueba', '2024-12-07');
INSERT INTO `comentario_habito` (`id_comentario_habito`, `grupo_id`, `usuario_id`, `comentario`, `fecha_comentario`) VALUES(4, 1, 1, 'Por que no se borra el comentario\n', '2024-12-07');
INSERT INTO `comentario_habito` (`id_comentario_habito`, `grupo_id`, `usuario_id`, `comentario`, `fecha_comentario`) VALUES(5, 2, 1, 'Prueba si recarga', '2024-12-07');
INSERT INTO `comentario_habito` (`id_comentario_habito`, `grupo_id`, `usuario_id`, `comentario`, `fecha_comentario`) VALUES(6, 1, 1, 'Prueba de Recarga', '2024-12-07');
INSERT INTO `comentario_habito` (`id_comentario_habito`, `grupo_id`, `usuario_id`, `comentario`, `fecha_comentario`) VALUES(7, 1, 1, 'Prueba de recarga2', '2024-12-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competencia`
--

CREATE TABLE `competencia` (
  `id_competencia` int(11) NOT NULL,
  `nombre_competencia` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `habito_id` int(11) DEFAULT NULL,
  `usuario_ganador_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_usuario`
--

CREATE TABLE `configuracion_usuario` (
  `id_configuracion` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `preferencias_notificacion` varchar(255) DEFAULT NULL,
  `idioma_interfaz` varchar(50) DEFAULT NULL,
  `tema_visual` enum('claro','oscuro') DEFAULT NULL,
  `recordatorios_personalizados` text DEFAULT NULL,
  `sincronizacion_apps` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desafio`
--

CREATE TABLE `desafio` (
  `id_desafio` int(11) NOT NULL,
  `nombre_desafio` varchar(100) DEFAULT NULL,
  `descripcion_desafio` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_finalizacion` date DEFAULT NULL,
  `num_participantes` int(11) DEFAULT NULL,
  `habito_asociado` int(11) DEFAULT NULL,
  `recompensa_desafio` varchar(255) DEFAULT NULL,
  `estado` enum('activo','finalizado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadisticas_usuario`
--

CREATE TABLE `estadisticas_usuario` (
  `id_estadistica` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `num_habitos_activos` int(11) DEFAULT NULL,
  `porcentaje_habitos_completados` decimal(5,2) DEFAULT NULL,
  `dias_consecutivos_habitos_completados` int(11) DEFAULT NULL,
  `promedio_habitos_cumplidos` decimal(5,2) DEFAULT NULL,
  `fechas_mayores_avances` text DEFAULT NULL,
  `graficos_progreso` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_apoyo`
--

CREATE TABLE `grupo_apoyo` (
  `id_grupo` int(11) NOT NULL,
  `nombre_grupo` varchar(100) DEFAULT NULL,
  `tipo_habito` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo_apoyo`
--

INSERT INTO `grupo_apoyo` (`id_grupo`, `nombre_grupo`, `tipo_habito`) VALUES(1, 'Sueño', 'sueno');
INSERT INTO `grupo_apoyo` (`id_grupo`, `nombre_grupo`, `tipo_habito`) VALUES(2, 'Alimentación', 'alimentacion');
INSERT INTO `grupo_apoyo` (`id_grupo`, `nombre_grupo`, `tipo_habito`) VALUES(3, 'Ejercicio', 'ejercicio');
INSERT INTO `grupo_apoyo` (`id_grupo`, `nombre_grupo`, `tipo_habito`) VALUES(4, 'Estudio', 'estudio');
INSERT INTO `grupo_apoyo` (`id_grupo`, `nombre_grupo`, `tipo_habito`) VALUES(5, 'Recreación', 'recreacion');
INSERT INTO `grupo_apoyo` (`id_grupo`, `nombre_grupo`, `tipo_habito`) VALUES(6, 'Trabajo', 'trabajo');
INSERT INTO `grupo_apoyo` (`id_grupo`, `nombre_grupo`, `tipo_habito`) VALUES(7, 'Trabajos del Hogar', 'trabajos_del_hogar');
INSERT INTO `grupo_apoyo` (`id_grupo`, `nombre_grupo`, `tipo_habito`) VALUES(8, 'Cuidado Personal', 'cuidado_personal');
INSERT INTO `grupo_apoyo` (`id_grupo`, `nombre_grupo`, `tipo_habito`) VALUES(9, 'Social', 'social');
INSERT INTO `grupo_apoyo` (`id_grupo`, `nombre_grupo`, `tipo_habito`) VALUES(10, 'Finanzas', 'finanzas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habito`
--

CREATE TABLE `habito` (
  `id_habito` int(11) NOT NULL,
  `nombre_habito` varchar(100) DEFAULT NULL,
  `descripcion_habito` text DEFAULT NULL,
  `categoria_habito` varchar(50) DEFAULT NULL,
  `objetivo_habito` varchar(100) DEFAULT NULL,
  `frecuencia` enum('diaria','semanal','mensual','personalizada') DEFAULT NULL,
  `duracion_estimada` int(11) DEFAULT NULL,
  `estado` enum('activo','pausado','completado') DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_estimacion_final` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habito`
--

INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(1, 'Ejercicio Diario', 'Hacer ejercicio durante 30 minutos cada día', 'Salud', 'Mejorar salud', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(2, 'Leer Libros', 'Leer al menos 20 páginas de un libro cada día', 'Educación', 'Aumentar conocimiento', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(3, 'Meditar', 'Meditar durante 15 minutos cada mañana', 'Bienestar', 'Reducir estrés', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(4, 'Ahorro Semanal', 'Ahorrar una cantidad fija de dinero cada semana', 'Finanzas', 'Mejorar finanzas', 'semanal', 4, 'activo', '2024-01-01', '2024-01-28');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(5, 'Estudiar Programación', 'Estudiar programación durante 1 hora cada día', 'Educación', 'Mejorar habilidades', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(6, 'Correr', 'Correr 5 km cada semana', 'Salud', 'Mejorar condición física', 'semanal', 4, 'activo', '2024-01-01', '2024-01-28');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(7, 'Dieta Saludable', 'Seguir una dieta saludable todos los días', 'Salud', 'Mejorar alimentación', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(8, 'Aprender Inglés', 'Estudiar inglés durante 1 hora cada día', 'Educación', 'Mejorar habilidades lingüísticas', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(9, 'Escribir Diario', 'Escribir en un diario cada noche', 'Bienestar', 'Reflexionar sobre el día', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(10, 'Desarrollo Personal', 'Leer libros de desarrollo personal cada semana', 'Bienestar', 'Mejorar crecimiento personal', 'semanal', 4, 'activo', '2024-01-01', '2024-01-28');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(13, 'Siesta', 'Ir a Dormir', 'sueño', 'descansar', 'diaria', 50, 'activo', '2024-12-05', '2024-12-18');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(14, 'Estudio', 'Estudiar', 'estudio', 'Estudiar', 'semanal', 20, 'activo', '2024-12-07', '2024-12-30');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(15, 'Prueba de Modificacion', 'Ir a Dormir', 'sueño', 'descansar', 'diaria', 50, 'activo', '2024-12-05', '2024-12-18');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(16, 'Probar', 'Trabajar', 'trabajo', 'Terminar Trabajo', 'diaria', 2, 'pausado', '2024-12-13', '2024-12-25');
INSERT INTO `habito` (`id_habito`, `nombre_habito`, `descripcion_habito`, `categoria_habito`, `objetivo_habito`, `frecuencia`, `duracion_estimada`, `estado`, `fecha_inicio`, `fecha_estimacion_final`) VALUES(17, 'Jugar Video Juegos', 'Jugar en mi consola', 'recreacion', 'Pasar el Juego', 'diaria', 20, 'activo', '2024-12-08', '2024-12-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integracion`
--

CREATE TABLE `integracion` (
  `id_integracion` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tipo_integracion` varchar(50) DEFAULT NULL,
  `fecha_sincronizacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivo`
--

CREATE TABLE `objetivo` (
  `id_objetivo` int(11) NOT NULL,
  `habito_id` int(11) DEFAULT NULL,
  `descripcion_objetivo` text DEFAULT NULL,
  `meta_cuantificable` varchar(100) DEFAULT NULL,
  `estado` enum('pendiente','completado','en_progreso') DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_finalizacion_estimada` date DEFAULT NULL,
  `notas_adicionales` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `objetivo`
--

INSERT INTO `objetivo` (`id_objetivo`, `habito_id`, `descripcion_objetivo`, `meta_cuantificable`, `estado`, `fecha_inicio`, `fecha_finalizacion_estimada`, `notas_adicionales`) VALUES(1, 1, 'Completar 30 días de ejercicio', '30 días consecutivos', 'en_progreso', '2024-01-01', '2024-01-31', 'Mantener la constancia');
INSERT INTO `objetivo` (`id_objetivo`, `habito_id`, `descripcion_objetivo`, `meta_cuantificable`, `estado`, `fecha_inicio`, `fecha_finalizacion_estimada`, `notas_adicionales`) VALUES(2, 2, 'Leer 600 páginas en un mes', '600 páginas', 'en_progreso', '2024-01-01', '2024-01-31', 'Disfrutar la lectura');
INSERT INTO `objetivo` (`id_objetivo`, `habito_id`, `descripcion_objetivo`, `meta_cuantificable`, `estado`, `fecha_inicio`, `fecha_finalizacion_estimada`, `notas_adicionales`) VALUES(3, 3, 'Meditar todos los días del mes', '30 días consecutivos', 'en_progreso', '2024-01-01', '2024-01-31', 'Reducir el estrés');
INSERT INTO `objetivo` (`id_objetivo`, `habito_id`, `descripcion_objetivo`, `meta_cuantificable`, `estado`, `fecha_inicio`, `fecha_finalizacion_estimada`, `notas_adicionales`) VALUES(4, 4, 'Ahorrar $1000 en un mes', '1000 dólares', 'en_progreso', '2024-01-01', '2024-01-31', 'Ser constante');
INSERT INTO `objetivo` (`id_objetivo`, `habito_id`, `descripcion_objetivo`, `meta_cuantificable`, `estado`, `fecha_inicio`, `fecha_finalizacion_estimada`, `notas_adicionales`) VALUES(5, 5, 'Estudiar programación 30 horas', '30 horas', 'en_progreso', '2024-01-01', '2024-01-31', 'Mejorar habilidades');
INSERT INTO `objetivo` (`id_objetivo`, `habito_id`, `descripcion_objetivo`, `meta_cuantificable`, `estado`, `fecha_inicio`, `fecha_finalizacion_estimada`, `notas_adicionales`) VALUES(6, 6, 'Correr 20 km en un mes', '20 km', 'en_progreso', '2024-01-01', '2024-01-31', 'Mejorar resistencia');
INSERT INTO `objetivo` (`id_objetivo`, `habito_id`, `descripcion_objetivo`, `meta_cuantificable`, `estado`, `fecha_inicio`, `fecha_finalizacion_estimada`, `notas_adicionales`) VALUES(7, 7, 'Seguir dieta saludable todo el mes', '30 días consecutivos', 'en_progreso', '2024-01-01', '2024-01-31', 'Mejorar alimentación');
INSERT INTO `objetivo` (`id_objetivo`, `habito_id`, `descripcion_objetivo`, `meta_cuantificable`, `estado`, `fecha_inicio`, `fecha_finalizacion_estimada`, `notas_adicionales`) VALUES(8, 8, 'Estudiar inglés 30 horas', '30 horas', 'en_progreso', '2024-01-01', '2024-01-31', 'Mejorar inglés');
INSERT INTO `objetivo` (`id_objetivo`, `habito_id`, `descripcion_objetivo`, `meta_cuantificable`, `estado`, `fecha_inicio`, `fecha_finalizacion_estimada`, `notas_adicionales`) VALUES(9, 9, 'Escribir en el diario todos los días', '30 días consecutivos', 'en_progreso', '2024-01-01', '2024-01-31', 'Escribir Diario');
INSERT INTO `objetivo` (`id_objetivo`, `habito_id`, `descripcion_objetivo`, `meta_cuantificable`, `estado`, `fecha_inicio`, `fecha_finalizacion_estimada`, `notas_adicionales`) VALUES(10, 10, 'Leer libros de desarrollo personal cada semana', '15 días consecutivos', 'en_progreso', '2024-01-01', '2024-01-31', 'Desarrollo Personal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos`
--

CREATE TABLE `puntos` (
  `id_puntos` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `habito_id` int(11) DEFAULT NULL,
  `puntos_obtenidos` int(11) DEFAULT NULL,
  `fecha_obtencion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recompensa`
--

CREATE TABLE `recompensa` (
  `id_recompensa` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `descripcion_recompensa` text DEFAULT NULL,
  `condicion_obtencion` varchar(255) DEFAULT NULL,
  `estado` enum('obtenida','pendiente') DEFAULT NULL,
  `fecha_obtencion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordatorio`
--

CREATE TABLE `recordatorio` (
  `id_recordatorio` int(11) NOT NULL,
  `habito_id` int(11) DEFAULT NULL,
  `tipo_recordatorio` enum('notificacion_push','correo_electronico','mensaje_texto') DEFAULT NULL,
  `fecha_hora_recordatorio` datetime DEFAULT NULL,
  `frecuencia_recordatorio` enum('diaria','semanal') DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_progreso`
--

CREATE TABLE `registro_progreso` (
  `id_registro` int(11) NOT NULL,
  `habito_id` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `estado_progreso` enum('completado','no_completado','parcial') DEFAULT NULL,
  `notas_usuario` text DEFAULT NULL,
  `recompensas_obtenidas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_progreso`
--

INSERT INTO `registro_progreso` (`id_registro`, `habito_id`, `fecha_registro`, `estado_progreso`, `notas_usuario`, `recompensas_obtenidas`) VALUES(1, 1, '2024-01-01', 'completado', 'Buen inicio', 'Medalla de Bronce');
INSERT INTO `registro_progreso` (`id_registro`, `habito_id`, `fecha_registro`, `estado_progreso`, `notas_usuario`, `recompensas_obtenidas`) VALUES(2, 2, '2024-01-01', 'completado', 'Interesante lectura', 'Medalla de Bronce');
INSERT INTO `registro_progreso` (`id_registro`, `habito_id`, `fecha_registro`, `estado_progreso`, `notas_usuario`, `recompensas_obtenidas`) VALUES(3, 3, '2024-01-01', 'completado', 'Relajante', 'Medalla de Bronce');
INSERT INTO `registro_progreso` (`id_registro`, `habito_id`, `fecha_registro`, `estado_progreso`, `notas_usuario`, `recompensas_obtenidas`) VALUES(4, 4, '2024-01-01', 'completado', 'Ahorro realizado', 'Medalla de Bronce');
INSERT INTO `registro_progreso` (`id_registro`, `habito_id`, `fecha_registro`, `estado_progreso`, `notas_usuario`, `recompensas_obtenidas`) VALUES(5, 5, '2024-01-01', 'completado', 'Aprendí algo nuevo', 'Medalla de Bronce');
INSERT INTO `registro_progreso` (`id_registro`, `habito_id`, `fecha_registro`, `estado_progreso`, `notas_usuario`, `recompensas_obtenidas`) VALUES(6, 6, '2024-01-01', 'completado', 'Buena carrera', 'Medalla de Bronce');
INSERT INTO `registro_progreso` (`id_registro`, `habito_id`, `fecha_registro`, `estado_progreso`, `notas_usuario`, `recompensas_obtenidas`) VALUES(7, 7, '2024-01-01', 'completado', 'Dieta seguida', 'Medalla de Bronce');
INSERT INTO `registro_progreso` (`id_registro`, `habito_id`, `fecha_registro`, `estado_progreso`, `notas_usuario`, `recompensas_obtenidas`) VALUES(8, 8, '2024-01-01', 'completado', 'Mejoré mi inglés', 'Medalla de Bronce');
INSERT INTO `registro_progreso` (`id_registro`, `habito_id`, `fecha_registro`, `estado_progreso`, `notas_usuario`, `recompensas_obtenidas`) VALUES(9, 9, '2024-01-01', 'completado', 'Reflexioné sobre el día', 'Medalla de Bronce');
INSERT INTO `registro_progreso` (`id_registro`, `habito_id`, `fecha_registro`, `estado_progreso`, `notas_usuario`, `recompensas_obtenidas`) VALUES(10, 10, '2024-01-01', 'completado', 'Lectura motivadora', 'Medalla de Bronce');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revisión_personal`
--

CREATE TABLE `revisión_personal` (
  `id_revision` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_revision` date DEFAULT NULL,
  `comentarios_personales` text DEFAULT NULL,
  `autoevaluacion` varchar(50) DEFAULT NULL,
  `notas_mejorar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `id_sesion` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_fin` timestamp NOT NULL DEFAULT (current_timestamp() + interval 1 hour)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sesiones`
--

INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_inicio`, `fecha_fin`) VALUES(1, 1, 'token_example_1', '2024-12-04 04:48:14', '2024-12-02 05:59:59');
INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_inicio`, `fecha_fin`) VALUES(2, 2, 'token_example_2', '2024-12-04 04:48:14', '2024-12-02 05:59:59');
INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_inicio`, `fecha_fin`) VALUES(3, 3, 'token_example_3', '2024-12-04 04:48:14', '2024-12-02 05:59:59');
INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_inicio`, `fecha_fin`) VALUES(4, 4, 'token_example_4', '2024-12-04 04:48:14', '2024-12-02 05:59:59');
INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_inicio`, `fecha_fin`) VALUES(5, 5, 'token_example_5', '2024-12-04 04:48:14', '2024-12-02 05:59:59');
INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_inicio`, `fecha_fin`) VALUES(6, 6, 'token_example_6', '2024-12-04 04:48:14', '2024-12-02 05:59:59');
INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_inicio`, `fecha_fin`) VALUES(7, 7, 'token_example_7', '2024-12-04 04:48:14', '2024-12-02 05:59:59');
INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_inicio`, `fecha_fin`) VALUES(8, 8, 'token_example_8', '2024-12-04 04:48:14', '2024-12-02 05:59:59');
INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_inicio`, `fecha_fin`) VALUES(9, 9, 'token_example_9', '2024-12-04 04:48:14', '2024-12-02 05:59:59');
INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_inicio`, `fecha_fin`) VALUES(10, 10, 'token_example_10', '2024-12-04 04:48:14', '2024-12-02 05:59:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripcion`
--

CREATE TABLE `suscripcion` (
  `id_suscripcion` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `nivel_suscripcion` enum('gratuito','premium') DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `estado_pago` enum('pagado','pendiente','gratuito') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_usuario`
--

CREATE TABLE `tipos_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `tipo` enum('admin','usuario') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_usuario`
--

INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(1, 1, 'admin');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(2, 2, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(3, 3, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(4, 4, 'admin');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(5, 5, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(6, 6, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(7, 7, 'admin');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(8, 8, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(9, 9, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(10, 10, 'admin');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(12, 20, 'admin');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(13, 21, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(14, 22, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(15, 23, 'admin');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(16, 24, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(17, 25, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(18, 26, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(19, 28, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(20, 29, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(21, 31, 'usuario');
INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `id_usuario`, `tipo`) VALUES(22, 32, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(10) DEFAULT NULL,
  `pais_region` varchar(50) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `nivel_suscripcion` enum('gratuita','premium') DEFAULT NULL,
  `ultima_fecha_acceso` timestamp NULL DEFAULT NULL,
  `preferencias_notificacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(1, 'Juan', 'Pérez', 'juan.perez@example.com', 'password123', '1990-01-01', 'Masculino', 'México', '2024-11-23 21:28:38', 'gratuita', '0000-00-00 00:00:00', 'correo');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(2, 'María', 'García', 'maria.garcia@example.com', 'password123', '1985-05-15', 'Femenino', 'España', '2024-11-23 21:28:38', 'premium', '0000-00-00 00:00:00', 'push');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(3, 'Carlos', 'López', 'carlos.lopez@example.com', 'password123', '1992-07-20', 'Masculino', 'Argentina', '2024-11-23 21:28:38', 'gratuita', '0000-00-00 00:00:00', 'correo');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(4, 'Ana', 'Martínez', 'ana.martinez@example.com', 'password123', '1988-03-10', 'Femenino', 'Chile', '2024-11-23 21:28:38', 'premium', '0000-00-00 00:00:00', 'push');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(5, 'Luis', 'Rodríguez', 'luis.rodriguez@example.com', 'password123', '1995-11-25', 'Masculino', 'Colombia', '2024-11-23 21:28:38', 'gratuita', '0000-00-00 00:00:00', 'correo');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(6, 'Laura', 'Hernández', 'laura.hernandez@example.com', 'password123', '1991-09-05', 'Femenino', 'Perú', '2024-11-23 21:28:38', 'premium', '0000-00-00 00:00:00', 'push');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(7, 'Jorge', 'González', 'jorge.gonzalez@example.com', 'password123', '1987-12-30', 'Masculino', 'Uruguay', '2024-11-23 21:28:38', 'gratuita', '0000-00-00 00:00:00', 'correo');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(8, 'Sofía', 'Ramírez', 'sofia.ramirez@example.com', 'password123', '1993-04-18', 'Femenino', 'Paraguay', '2024-11-23 21:28:38', 'premium', '0000-00-00 00:00:00', 'push');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(9, 'Miguel', 'Fernández', 'miguel.fernandez@example.com', 'password123', '1990-06-22', 'Masculino', 'Bolivia', '2024-11-23 21:28:38', 'gratuita', '0000-00-00 00:00:00', 'correo');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(10, 'Elena', 'Torres', 'elena.torres@example.com', 'password123', '1989-08-14', 'Femenino', 'Ecuador', '2024-11-23 21:28:38', 'premium', '0000-00-00 00:00:00', 'push');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(11, 'Prueba', 'HTML', 'qs@gmail.com', 'Prueba1@', '2024-12-01', 'masculino', 'Honduras', '2024-12-04 20:23:52', 'gratuita', NULL, 'Push');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(12, 'Pruebas', 'HTML', 'qs2@gmail.com', 'Prueba2@', '2024-12-03', 'femenino', 'Honduras', '2024-12-04 20:43:23', 'gratuita', NULL, 'Push');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(14, 'Prue', 'HT', 'as2@gmail.com', 'Prueba1@', '2024-12-01', 'masculino', 'Honduras', '2024-12-04 20:45:15', 'gratuita', NULL, 'Push');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(15, 'Pa', 'Ca', 'c@gmail.com', 'cajon1@', '2024-12-01', 'masculino', 'Austria', '2024-12-04 21:06:30', 'premium', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(16, 'ps', 'ba', 'sa@gmail.com', 'sdfaa@1', '2024-12-01', 'femenino', 'México', '2024-12-04 21:09:56', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(17, 'psa', 'bas', 'swa@gmail.com', '$2y$10$odRykWTh6UD1L/8ia73huOmVk7EKyOMmWlN/OtwNraNKKrnu6d37O', '2024-11-11', 'masculino', 'México', '2024-12-04 21:29:18', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(18, 'admin', 'istrador', 'admin@gmail.com', '$2y$10$4jRt3k3Y6eVxQa37mqfo6enMIR93O5hoV6bfsQC40Eum2fDnZCprq', '2024-12-04', 'otro', 'Honduras', '2024-12-04 22:12:01', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(20, 'admina', 'istrador', 'admin2@gmail.com', '$2y$10$m9h3JP/bpNI4cZSBnC1RR.d9/dV8S.2phzexCvJgsHAPeRtmgPxuO', '2024-12-01', 'otro', 'Honduras', '2024-12-04 22:16:17', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(21, 'usuario', 'Normal', 'un@gmail.com', '$2y$10$0mNG2zbHLh0xwdp8ge.G9O7t5tsDenFo6RS1.H/n5m4ZdpWgwRP/q', '2024-12-04', 'otro', 'Honduras', '2024-12-04 22:26:29', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(22, 'Pru', 'ba', 'us@gmail.com', '$2y$10$JaCIfUEpzIPVC3.C7SegeeNRoLNpG73LqfI5YciPx9uf12cexNA.y', '2024-12-01', 'masculino', 'Honduras', '2024-12-06 00:13:51', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(23, 'Pru', 'ba', 'use@gmail.com', '$2y$10$rTV8IBURoDWHLoThuNaJ7uNkigLXBtSw09mUqzMaAlFSBqmaolr2G', '2024-12-01', 'otro', 'Honduras', '2024-12-06 00:18:54', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(24, 'Paco', 'Paez', 'pp@gmail.com', '$2y$10$UGqHR8zePOi1wKr7mnmxo.XikK.H5pitrscIPHdQBtZIUgUd2SGaS', '2024-12-01', 'masculino', 'México', '2024-12-06 15:25:46', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(25, 'Paco', 'Paez', 'p2p@gmail.com', '$2y$10$hbTxJ2uGmSJfsRb1Tl.wsuBHepOgwQ54tW/us8eN8vCAIhSZYUYH2', '2024-12-01', 'masculino', 'México', '2024-12-06 15:28:45', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(26, 'Paco', 'Paez', 'p3p@gmail.com', '$2y$10$fZhL6qs.Ck4IOTItEFOwmeejfy3hBEuguCuTW58xgqaB1tdpOP8PS', '2024-12-03', 'masculino', 'México', '2024-12-06 15:31:46', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(28, 'Paco', 'Paez', 'p4p@gmail.com', '$2y$10$RXfq3o1uZwQbcjxT.WkBee5WZJDuz0d3PqGviSrJN6xtlyH5jY8lS', '2024-12-03', 'masculino', 'México', '2024-12-06 15:32:36', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(29, 'Paco', 'Paez', 'p5p@gmail.com', '$2y$10$PmOCRHediaCAW8NeNtxOgudYgjVNjfi.PIxV3d1.CklVxfMBEa1EK', '2024-12-01', 'masculino', 'México', '2024-12-06 15:38:36', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(31, 'Prueba', 'JWT', 'JWT@gmail.com', '$2y$10$xs7VfHTMaO1EX2SmPn7dOu7YE4tVAQZzQ.Nor/lFD4yOeIGCxcTR2', '2024-12-01', 'masculino', 'Honduras', '2024-12-09 03:49:06', 'gratuita', NULL, 'No');
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `genero`, `pais_region`, `fecha_registro`, `nivel_suscripcion`, `ultima_fecha_acceso`, `preferencias_notificacion`) VALUES(32, 'Pruebas', 'jwts', 'pjwt@gmail.com', '$2y$10$v23PJDtjiS6FAOOEu1mbJ.fKF6b/78DTlClUM0mvI1.iExR7hKj1W', '2024-12-01', 'otro', 'Honduras', '2024-12-09 03:52:38', 'gratuita', NULL, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_habito`
--

CREATE TABLE `usuario_habito` (
  `id_usuario_habito` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `habito_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_habito`
--

INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(1, 1, 1);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(2, 2, 2);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(3, 3, 3);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(4, 4, 4);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(5, 5, 5);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(6, 6, 6);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(7, 7, 7);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(8, 8, 8);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(9, 21, 9);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(10, 21, 10);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(13, 29, 13);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(14, 29, 14);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(15, 29, 15);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(16, 29, 16);
INSERT INTO `usuario_habito` (`id_usuario_habito`, `usuario_id`, `habito_id`) VALUES(17, 29, 17);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios_usuario`
--
ALTER TABLE `comentarios_usuario`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `comentario_habito`
--
ALTER TABLE `comentario_habito`
  ADD PRIMARY KEY (`id_comentario_habito`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_grupo_id` (`grupo_id`);

--
-- Indices de la tabla `competencia`
--
ALTER TABLE `competencia`
  ADD PRIMARY KEY (`id_competencia`),
  ADD KEY `habito_id` (`habito_id`),
  ADD KEY `usuario_ganador_id` (`usuario_ganador_id`);

--
-- Indices de la tabla `configuracion_usuario`
--
ALTER TABLE `configuracion_usuario`
  ADD PRIMARY KEY (`id_configuracion`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `desafio`
--
ALTER TABLE `desafio`
  ADD PRIMARY KEY (`id_desafio`),
  ADD KEY `habito_asociado` (`habito_asociado`);

--
-- Indices de la tabla `estadisticas_usuario`
--
ALTER TABLE `estadisticas_usuario`
  ADD PRIMARY KEY (`id_estadistica`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `grupo_apoyo`
--
ALTER TABLE `grupo_apoyo`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `habito`
--
ALTER TABLE `habito`
  ADD PRIMARY KEY (`id_habito`);

--
-- Indices de la tabla `integracion`
--
ALTER TABLE `integracion`
  ADD PRIMARY KEY (`id_integracion`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `objetivo`
--
ALTER TABLE `objetivo`
  ADD PRIMARY KEY (`id_objetivo`),
  ADD KEY `habito_id` (`habito_id`);

--
-- Indices de la tabla `puntos`
--
ALTER TABLE `puntos`
  ADD PRIMARY KEY (`id_puntos`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `habito_id` (`habito_id`);

--
-- Indices de la tabla `recompensa`
--
ALTER TABLE `recompensa`
  ADD PRIMARY KEY (`id_recompensa`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  ADD PRIMARY KEY (`id_recordatorio`),
  ADD KEY `habito_id` (`habito_id`);

--
-- Indices de la tabla `registro_progreso`
--
ALTER TABLE `registro_progreso`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `habito_id` (`habito_id`);

--
-- Indices de la tabla `revisión_personal`
--
ALTER TABLE `revisión_personal`
  ADD PRIMARY KEY (`id_revision`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id_sesion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD PRIMARY KEY (`id_suscripcion`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`);

--
-- Indices de la tabla `usuario_habito`
--
ALTER TABLE `usuario_habito`
  ADD PRIMARY KEY (`id_usuario_habito`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `habito_id` (`habito_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios_usuario`
--
ALTER TABLE `comentarios_usuario`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentario_habito`
--
ALTER TABLE `comentario_habito`
  MODIFY `id_comentario_habito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `competencia`
--
ALTER TABLE `competencia`
  MODIFY `id_competencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion_usuario`
--
ALTER TABLE `configuracion_usuario`
  MODIFY `id_configuracion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `desafio`
--
ALTER TABLE `desafio`
  MODIFY `id_desafio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estadisticas_usuario`
--
ALTER TABLE `estadisticas_usuario`
  MODIFY `id_estadistica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo_apoyo`
--
ALTER TABLE `grupo_apoyo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `habito`
--
ALTER TABLE `habito`
  MODIFY `id_habito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `integracion`
--
ALTER TABLE `integracion`
  MODIFY `id_integracion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `objetivo`
--
ALTER TABLE `objetivo`
  MODIFY `id_objetivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `puntos`
--
ALTER TABLE `puntos`
  MODIFY `id_puntos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recompensa`
--
ALTER TABLE `recompensa`
  MODIFY `id_recompensa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  MODIFY `id_recordatorio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_progreso`
--
ALTER TABLE `registro_progreso`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `revisión_personal`
--
ALTER TABLE `revisión_personal`
  MODIFY `id_revision` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  MODIFY `id_sesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  MODIFY `id_suscripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `usuario_habito`
--
ALTER TABLE `usuario_habito`
  MODIFY `id_usuario_habito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios_usuario`
--
ALTER TABLE `comentarios_usuario`
  ADD CONSTRAINT `comentarios_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `comentario_habito`
--
ALTER TABLE `comentario_habito`
  ADD CONSTRAINT `comentario_habito_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `habito` (`id_habito`),
  ADD CONSTRAINT `comentario_habito_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `fk_grupo_id` FOREIGN KEY (`grupo_id`) REFERENCES `grupo_apoyo` (`id_grupo`);

--
-- Filtros para la tabla `competencia`
--
ALTER TABLE `competencia`
  ADD CONSTRAINT `competencia_ibfk_1` FOREIGN KEY (`habito_id`) REFERENCES `habito` (`id_habito`),
  ADD CONSTRAINT `competencia_ibfk_2` FOREIGN KEY (`usuario_ganador_id`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `configuracion_usuario`
--
ALTER TABLE `configuracion_usuario`
  ADD CONSTRAINT `configuracion_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `desafio`
--
ALTER TABLE `desafio`
  ADD CONSTRAINT `desafio_ibfk_1` FOREIGN KEY (`habito_asociado`) REFERENCES `habito` (`id_habito`);

--
-- Filtros para la tabla `estadisticas_usuario`
--
ALTER TABLE `estadisticas_usuario`
  ADD CONSTRAINT `estadisticas_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `integracion`
--
ALTER TABLE `integracion`
  ADD CONSTRAINT `integracion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `objetivo`
--
ALTER TABLE `objetivo`
  ADD CONSTRAINT `objetivo_ibfk_1` FOREIGN KEY (`habito_id`) REFERENCES `habito` (`id_habito`);

--
-- Filtros para la tabla `puntos`
--
ALTER TABLE `puntos`
  ADD CONSTRAINT `puntos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `puntos_ibfk_2` FOREIGN KEY (`habito_id`) REFERENCES `habito` (`id_habito`);

--
-- Filtros para la tabla `recompensa`
--
ALTER TABLE `recompensa`
  ADD CONSTRAINT `recompensa_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  ADD CONSTRAINT `recordatorio_ibfk_1` FOREIGN KEY (`habito_id`) REFERENCES `habito` (`id_habito`);

--
-- Filtros para la tabla `registro_progreso`
--
ALTER TABLE `registro_progreso`
  ADD CONSTRAINT `registro_progreso_ibfk_1` FOREIGN KEY (`habito_id`) REFERENCES `habito` (`id_habito`);

--
-- Filtros para la tabla `revisión_personal`
--
ALTER TABLE `revisión_personal`
  ADD CONSTRAINT `revisión_personal_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD CONSTRAINT `suscripcion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
  ADD CONSTRAINT `tipos_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `usuario_habito`
--
ALTER TABLE `usuario_habito`
  ADD CONSTRAINT `usuario_habito_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `usuario_habito_ibfk_2` FOREIGN KEY (`habito_id`) REFERENCES `habito` (`id_habito`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
