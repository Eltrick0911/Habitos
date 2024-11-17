CREATE DATABASE SeguimientoHabitos;
USE SeguimientoHabitos;

CREATE TABLE Usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellidos VARCHAR(50),
    correo_electronico VARCHAR(100) UNIQUE,
    contrasena VARCHAR(255),
    fecha_nacimiento DATE,
    genero VARCHAR(10),
    pais_region VARCHAR(50),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nivel_suscripcion ENUM('gratuita', 'premium'),
    ultima_fecha_acceso TIMESTAMP,
    preferencias_notificacion VARCHAR(255)
);

CREATE TABLE Habito (
    id_habito INT AUTO_INCREMENT PRIMARY KEY,
    nombre_habito VARCHAR(100),
    descripcion_habito TEXT,
    categoria_habito VARCHAR(50),
    objetivo_habito VARCHAR(100),
    frecuencia ENUM('diaria', 'semanal', 'mensual', 'personalizada'),
    duracion_estimada INT,
    estado ENUM('activo', 'pausado', 'completado'),
    fecha_inicio DATE,
    fecha_estimacion_final DATE
);

CREATE TABLE Usuario_Habito (
    id_usuario_habito INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    habito_id INT,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (habito_id) REFERENCES Habito(id_habito)
);

CREATE TABLE Registro_Progreso (
    id_registro INT AUTO_INCREMENT PRIMARY KEY,
    habito_id INT,
    fecha_registro DATE,
    estado_progreso ENUM('completado', 'no_completado', 'parcial'),
    notas_usuario TEXT,
    recompensas_obtenidas VARCHAR(255),
    FOREIGN KEY (habito_id) REFERENCES Habito(id_habito)
);

CREATE TABLE Objetivo (
    id_objetivo INT AUTO_INCREMENT PRIMARY KEY,
    habito_id INT,
    descripcion_objetivo TEXT,
    meta_cuantificable VARCHAR(100),
    estado ENUM('pendiente', 'completado', 'en_progreso'),
    fecha_inicio DATE,
    fecha_finalizacion_estimada DATE,
    notas_adicionales TEXT,
    FOREIGN KEY (habito_id) REFERENCES Habito(id_habito)
);

CREATE TABLE Recompensa (
    id_recompensa INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    descripcion_recompensa TEXT,
    condicion_obtencion VARCHAR(255),
    estado ENUM('obtenida', 'pendiente'),
    fecha_obtencion DATE,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Recordatorio (
    id_recordatorio INT AUTO_INCREMENT PRIMARY KEY,
    habito_id INT,
    tipo_recordatorio ENUM('notificacion_push', 'correo_electronico', 'mensaje_texto'),
    fecha_hora_recordatorio DATETIME,
    frecuencia_recordatorio ENUM('diaria', 'semanal'),
    estado ENUM('activo', 'inactivo'),
    FOREIGN KEY (habito_id) REFERENCES Habito(id_habito)
);

CREATE TABLE Estadisticas_Usuario (
    id_estadistica INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    num_habitos_activos INT,
    porcentaje_habitos_completados DECIMAL(5,2),
    dias_consecutivos_habitos_completados INT,
    promedio_habitos_cumplidos DECIMAL(5,2),
    fechas_mayores_avances TEXT,
    graficos_progreso TEXT,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Grupo_Apoyo (
    id_grupo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_grupo VARCHAR(100),
    descripcion_grupo TEXT,
    fecha_creacion DATE,
    habito_compartido INT,
    mensajes_interacciones TEXT,
    FOREIGN KEY (habito_compartido) REFERENCES Habito(id_habito)
);

CREATE TABLE Revisión_Personal (
    id_revision INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    fecha_revision DATE,
    comentarios_personales TEXT,
    autoevaluacion VARCHAR(50),
    notas_mejorar TEXT,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Desafio (
    id_desafio INT AUTO_INCREMENT PRIMARY KEY,
    nombre_desafio VARCHAR(100),
    descripcion_desafio TEXT,
    fecha_inicio DATE,
    fecha_finalizacion DATE,
    num_participantes INT,
    habito_asociado INT,
    recompensa_desafio VARCHAR(255),
    estado ENUM('activo', 'finalizado'),
    FOREIGN KEY (habito_asociado) REFERENCES Habito(id_habito)
);

CREATE TABLE Suscripcion (
    id_suscripcion INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    nivel_suscripcion ENUM('gratuito', 'premium'),
    fecha_inicio DATE,
    fecha_expiracion DATE,
    estado_pago ENUM('pagado', 'pendiente', 'gratuito'),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Comentarios_Usuario (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    fecha_comentario DATE,
    texto_comentario TEXT,
    calificacion INT,
    estado_comentario ENUM('revisado', 'pendiente'),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Configuracion_Usuario (
    id_configuracion INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    preferencias_notificacion VARCHAR(255),
    idioma_interfaz VARCHAR(50),
    tema_visual ENUM('claro', 'oscuro'),
    recordatorios_personalizados TEXT,
    sincronizacion_apps VARCHAR(255),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Puntos (
    id_puntos INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    habito_id INT,
    puntos_obtenidos INT,
    fecha_obtencion DATE,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (habito_id) REFERENCES Habito(id_habito)
);

CREATE TABLE Comentario_Habito (
    id_comentario_habito INT AUTO_INCREMENT PRIMARY KEY,
    habito_id INT,
    usuario_id INT,
    comentario TEXT,
    fecha_comentario DATE,
    FOREIGN KEY (habito_id) REFERENCES Habito(id_habito),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Competencia (
    id_competencia INT AUTO_INCREMENT PRIMARY KEY,
    nombre_competencia VARCHAR(100),
    descripcion TEXT,
    fecha_inicio DATE,
    fecha_fin DATE,
    habito_id INT,
    usuario_ganador_id INT,
    FOREIGN KEY (habito_id) REFERENCES Habito(id_habito),
    FOREIGN KEY (usuario_ganador_id) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Integracion (
    id_integracion INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    tipo_integracion VARCHAR(50),
    fecha_sincronizacion DATE,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario)
);


Procedimientos Almacenados
Insertar Usuario
DELIMITER //

CREATE PROCEDURE InsertarUsuario (
    IN p_nombre VARCHAR(50),
    IN p_apellidos VARCHAR(50),
    IN p_correo_electronico VARCHAR(100),
    IN p_contrasena VARCHAR(255),
    IN p_fecha_nacimiento DATE,
    IN p_genero VARCHAR(10),
    IN p_pais_region VARCHAR(50),
    IN p_nivel_suscripcion ENUM('gratuita', 'premium'),
    IN p_preferencias_notificacion VARCHAR(255)
)
BEGIN
    INSERT INTO Usuario (nombre, apellidos, correo_electronico, contrasena, fecha_nacimiento, genero, pais_region, nivel_suscripcion, preferencias_notificacion)
    VALUES (p_nombre, p_apellidos, p_correo_electronico, p_contrasena, p_fecha_nacimiento, p_genero, p_pais_region, p_nivel_suscripcion, p_preferencias_notificacion);
END //

DELIMITER ;
Actualizar Usuario
DELIMITER //

CREATE PROCEDURE ActualizarUsuario (
    IN p_id_usuario INT,
    IN p_nombre VARCHAR(50),
    IN p_apellidos VARCHAR(50),
    IN p_correo_electronico VARCHAR(100),
    IN p_contrasena VARCHAR(255),
    IN p_fecha_nacimiento DATE,
    IN p_genero VARCHAR(10),
    IN p_pais_region VARCHAR(50),
    IN p_nivel_suscripcion ENUM('gratuita', 'premium'),
    IN p_preferencias_notificacion VARCHAR(255)
)
BEGIN
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
END //

DELIMITER ;
Eliminar Usuario
DELIMITER //

CREATE PROCEDURE EliminarUsuario (
    IN p_id_usuario INT
)
BEGIN
    DELETE FROM Usuario WHERE id_usuario = p_id_usuario;
END //

DELIMITER ;
Insertar Hábito
DELIMITER //

CREATE PROCEDURE InsertarHabito (
    IN p_nombre_habito VARCHAR(100),
    IN p_descripcion_habito TEXT,
    IN p_categoria_habito VARCHAR(50),
    IN p_objetivo_habito VARCHAR(100),
    IN p_frecuencia ENUM('diaria', 'semanal', 'mensual', 'personalizada'),
    IN p_duracion_estimada INT,
    IN p_estado ENUM('activo', 'pausado', 'completado'),
    IN p_fecha_inicio DATE,
    IN p_fecha_estimacion_final DATE
)
BEGIN
    INSERT INTO Habito (nombre_habito, descripcion_habito, categoria_habito, objetivo_habito, frecuencia, duracion_estimada, estado, fecha_inicio, fecha_estimacion_final)
    VALUES (p_nombre_habito, p_descripcion_habito, p_categoria_habito, p_objetivo_habito, p_frecuencia, p_duracion_estimada, p_estado, p_fecha_inicio, p_fecha_estimacion_final);
END //

DELIMITER ;
Actualizar Hábito
DELIMITER //

CREATE PROCEDURE ActualizarHabito (
    IN p_id_habito INT,
    IN p_nombre_habito VARCHAR(100),
    IN p_descripcion_habito TEXT,
    IN p_categoria_habito VARCHAR(50),
    IN p_objetivo_habito VARCHAR(100),
    IN p_frecuencia ENUM('diaria', 'semanal', 'mensual', 'personalizada'),
    IN p_duracion_estimada INT,
    IN p_estado ENUM('activo', 'pausado', 'completado'),
    IN p_fecha_inicio DATE,
    IN p_fecha_estimacion_final DATE
)
BEGIN
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
END //

DELIMITER ;
Eliminar Hábito
DELIMITER //

CREATE PROCEDURE EliminarHabito (
    IN p_id_habito INT
)
BEGIN
    DELETE FROM Habito WHERE id_habito = p_id_habito;
END //

DELIMITER ;
Insertar Registro de Progreso
DELIMITER //

CREATE PROCEDURE InsertarRegistroProgreso (
    IN p_habito_id INT,
    IN p_fecha_registro DATE,
    IN p_estado_progreso ENUM('completado', 'no_completado', 'parcial'),
    IN p_notas_usuario TEXT,
    IN p_recompensas_obtenidas VARCHAR(255)
)
BEGIN
    INSERT INTO Registro_Progreso (habito_id, fecha_registro, estado_progreso, notas_usuario, recompensas_obtenidas)
    VALUES (p_habito_id, p_fecha_registro, p_estado_progreso, p_notas_usuario, p_recompensas_obtenidas);
END //

DELIMITER ;
Actualizar Registro de Progreso
DELIMITER //

CREATE PROCEDURE ActualizarRegistroProgreso (
    IN p_id_registro INT,
    IN p_habito_id INT,
    IN p_fecha_registro DATE,
    IN p_estado_progreso ENUM('completado', 'no_completado', 'parcial'),
    IN p_notas_usuario TEXT,
    IN p_recompensas_obtenidas VARCHAR(255)
)
BEGIN
    UPDATE Registro_Progreso
    SET habito_id = p_habito_id,
        fecha_registro = p_fecha_registro,
        estado_progreso = p_estado_progreso,
        notas_usuario = p_notas_usuario,
        recompensas_obtenidas = p_recompensas_obtenidas
    WHERE id_registro = p_id_registro;
END //

DELIMITER ;
Eliminar Registro de Progreso
DELIMITER //

CREATE PROCEDURE EliminarRegistroProgreso (
    IN p_id_registro INT
)
BEGIN
    DELETE FROM Registro_Progreso WHERE id_registro = p_id_registro;
END //

DELIMITER ;
Insertar Objetivo
DELIMITER //

CREATE PROCEDURE InsertarObjetivo (
    IN p_habito_id INT,
    IN p_descripcion_objetivo TEXT,
    IN p_meta_cuantificable VARCHAR(100),
    IN p_estado ENUM('pendiente', 'completado', 'en_progreso'),
    IN p_fecha_inicio DATE,
    IN p_fecha_finalizacion_estimada DATE,
    IN p_notas_adicionales TEXT
)
BEGIN
    INSERT INTO Objetivo (habito_id, descripcion_objetivo, meta_cuantificable, estado, fecha_inicio, fecha_finalizacion_estimada, notas_adicionales)
    VALUES (p_habito_id, p_descripcion_objetivo, p_meta_cuantificable, p_estado, p_fecha_inicio, p_fecha_finalizacion_estimada, p_notas_adicionales);
END //

DELIMITER ;
Actualizar Objetivo
DELIMITER //

CREATE PROCEDURE ActualizarObjetivo (
    IN p_id_objetivo INT,
    IN p_habito_id INT,
    IN p_descripcion_objetivo TEXT,
    IN p_meta_cuantificable VARCHAR(100),
    IN p_estado ENUM('pendiente', 'completado', 'en_progreso'),
    IN p_fecha_inicio DATE,
    IN p_fecha_finalizacion_estimada DATE,
    IN p_notas_adicionales TEXT
)
BEGIN
    UPDATE Objetivo
    SET habito_id = p_habito_id,
        descripcion_objetivo = p_descripcion_objetivo,
        meta_cuantificable = p_meta_cuantificable,
        estado = p_estado,
        fecha_inicio = p_fecha_inicio,
        fecha_finalizacion_estimada = p_fecha_finalizacion_estimada,
        notas_adicionales = p_notas_adicionales
    WHERE id_objetivo = p_id_objetivo;
END //

DELIMITER ;
Eliminar Objetivo
DELIMITER //

CREATE PROCEDURE EliminarObjetivo (
    IN p_id_objetivo INT
)
BEGIN
    DELETE FROM Objetivo WHERE id_objetivo = p_id_objetivo;
END //

DELIMITER ;
Insertar Recompensa
DELIMITER //

CREATE PROCEDURE InsertarRecompensa (
    IN p_usuario_id INT,
    IN p_descripcion_recompensa TEXT,
    IN p_condicion_obtencion VARCHAR(255),
    IN p_estado ENUM('obtenida', 'pendiente'),
    IN p_fecha_obtencion DATE
)
BEGIN
    INSERT INTO Recompensa (usuario_id, descripcion_recompensa, condicion_obtencion,estado,fecha_obtencion)
     VALUES (p_usuario_id, p_descripcion_recompensa, p_condicion_obtencion, p_estado, p_fecha_obtencion);
    END //
    
    Actualizar Recompensa
DELIMITER //

CREATE PROCEDURE ActualizarRecompensa (
    IN p_id_recompensa INT,
    IN p_usuario_id INT,
    IN p_descripcion_recompensa TEXT,
    IN p_condicion_obtencion VARCHAR(255),
    IN p_estado ENUM('obtenida', 'pendiente'),
    IN p_fecha_obtencion DATE
)
BEGIN
    UPDATE Recompensa
    SET usuario_id = p_usuario_id,
        descripcion_recompensa = p_descripcion_recompensa,
        condicion_obtencion = p_condicion_obtencion,
        estado = p_estado,
        fecha_obtencion = p_fecha_obtencion
    WHERE id_recompensa = p_id_recompensa;
END //

DELIMITER ;
Eliminar Recompensa
DELIMITER //

CREATE PROCEDURE EliminarRecompensa (
    IN p_id_recompensa INT
)
BEGIN
    DELETE FROM Recompensa WHERE id_recompensa = p_id_recompensa;
END //

DELIMITER ;
Insertar Recordatorio
DELIMITER //

CREATE PROCEDURE InsertarRecordatorio (
    IN p_habito_id INT,
    IN p_tipo_recordatorio ENUM('notificacion_push', 'correo_electronico', 'mensaje_texto'),
    IN p_fecha_hora_recordatorio DATETIME,
    IN p_frecuencia_recordatorio ENUM('diaria', 'semanal'),
    IN p_estado ENUM('activo', 'inactivo')
)
BEGIN
    INSERT INTO Recordatorio (habito_id, tipo_recordatorio, fecha_hora_recordatorio, frecuencia_recordatorio, estado)
    VALUES (p_habito_id, p_tipo_recordatorio, p_fecha_hora_recordatorio, p_frecuencia_recordatorio, p_estado);
END //

DELIMITER ;
Actualizar Recordatorio
DELIMITER //

CREATE PROCEDURE ActualizarRecordatorio (
    IN p_id_recordatorio INT,
    IN p_habito_id INT,
    IN p_tipo_recordatorio ENUM('notificacion_push', 'correo_electronico', 'mensaje_texto'),
    IN p_fecha_hora_recordatorio DATETIME,
    IN p_frecuencia_recordatorio ENUM('diaria', 'semanal'),
    IN p_estado ENUM('activo', 'inactivo')
)
BEGIN
    UPDATE Recordatorio
    SET habito_id = p_habito_id,
        tipo_recordatorio = p_tipo_recordatorio,
        fecha_hora_recordatorio = p_fecha_hora_recordatorio,
        frecuencia_recordatorio = p_frecuencia_recordatorio,
        estado = p_estado
    WHERE id_recordatorio = p_id_recordatorio;
END //

DELIMITER ;
Eliminar Recordatorio
DELIMITER //

CREATE PROCEDURE EliminarRecordatorio (
    IN p_id_recordatorio INT
)
BEGIN
    DELETE FROM Recordatorio WHERE id_recordatorio = p_id_recordatorio;
END //

DELIMITER ;
Insertar Estadísticas de Usuario
DELIMITER //

CREATE PROCEDURE InsertarEstadisticasUsuario (
    IN p_usuario_id INT,
    IN p_num_habitos_activos INT,
    IN p_porcentaje_habitos_completados DECIMAL(5,2),
    IN p_dias_consecutivos_habitos_completados INT,
    IN p_promedio_habitos_cumplidos DECIMAL(5,2),
    IN p_fechas_mayores_avances TEXT,
    IN p_graficos_progreso TEXT
)
BEGIN
    INSERT INTO Estadisticas_Usuario (usuario_id, num_habitos_activos, porcentaje_habitos_completados, dias_consecutivos_habitos_completados, promedio_habitos_cumplidos, fechas_mayores_avances, graficos_progreso)
    VALUES (p_usuario_id, p_num_habitos_activos, p_porcentaje_habitos_completados, p_dias_consecutivos_habitos_completados, p_promedio_habitos_cumplidos, p_fechas_mayores_avances, p_graficos_progreso);
END //

DELIMITER ;
Actualizar Estadísticas de Usuario
DELIMITER //

CREATE PROCEDURE ActualizarEstadisticasUsuario (
    IN p_id_estadistica INT,
    IN p_usuario_id INT,
    IN p_num_habitos_activos INT,
    IN p_porcentaje_habitos_completados DECIMAL(5,2),
    IN p_dias_consecutivos_habitos_completados INT,
    IN p_promedio_habitos_cumplidos DECIMAL(5,2),
    IN p_fechas_mayores_avances TEXT,
    IN p_graficos_progreso TEXT
)
BEGIN
    UPDATE Estadisticas_Usuario
    SET usuario_id = p_usuario_id,
        num_habitos_activos = p_num_habitos_activos,
        porcentaje_habitos_completados = p_porcentaje_habitos_completados,
        dias_consecutivos_habitos_completados = p_dias_consecutivos_habitos_completados,
        promedio_habitos_cumplidos = p_promedio_habitos_cumplidos,
        fechas_mayores_avances = p_fechas_mayores_avances,
        graficos_progreso = p_graficos_progreso
    WHERE id_estadistica = p_id_estadistica;
END //

DELIMITER ;
Eliminar Estadísticas de Usuario
DELIMITER //

CREATE PROCEDURE EliminarEstadisticasUsuario (
    IN p_id_estadistica INT
)
BEGIN
    DELETE FROM Estadisticas_Usuario WHERE id_estadistica = p_id_estadistica;
END //

DELIMITER ;
Insertar Grupo de Apoyo
DELIMITER //

CREATE PROCEDURE InsertarGrupoApoyo (
    IN p_nombre_grupo VARCHAR(100),
    IN p_descripcion_grupo TEXT,
    IN p_fecha_creacion DATE,
    IN p_habito_compartido INT,
    IN p_mensajes_interacciones TEXT
)
BEGIN
    INSERT INTO Grupo_Apoyo (nombre_grupo, descripcion_grupo, fecha_creacion, habito_compartido, mensajes_interacciones)
    VALUES (p_nombre_grupo, p_descripcion_grupo, p_fecha_creacion, p_habito_compartido, p_mensajes_interacciones);
END //

DELIMITER ;
Actualizar Grupo de Apoyo
DELIMITER //

CREATE PROCEDURE ActualizarGrupoApoyo (
    IN p_id_grupo INT,
    IN p_nombre_grupo VARCHAR(100),
    IN p_descripcion_grupo TEXT,
    IN p_fecha_creacion DATE,
    IN p_habito_compartido INT,
    IN p_mensajes_interacciones TEXT
)
BEGIN
    UPDATE Grupo_Apoyo
    SET nombre_grupo = p_nombre_grupo,
        descripcion_grupo = p_descripcion_grupo,
        fecha_creacion = p_fecha_creacion,
        habito_compartido = p_habito_compartido,
        mensajes_interacciones = p_mensajes_interacciones
    WHERE id_grupo = p_id_grupo;
END //

DELIMITER ;
Eliminar Grupo de Apoyo
DELIMITER //

CREATE PROCEDURE EliminarGrupoApoyo (
    IN p_id_grupo INT
)
BEGIN
    DELETE FROM Grupo_Apoyo WHERE id_grupo = p_id_grupo;
END //

DELIMITER ;
Insertar Revisión Personal
DELIMITER //

CREATE PROCEDURE InsertarRevisionPersonal (
    IN p_usuario_id INT,
    IN p_fecha_revision DATE,
    IN p_comentarios_personales TEXT,
    IN p_autoevaluacion VARCHAR(50),
    IN p_notas_mejorar TEXT
)
BEGIN
    INSERT INTO Revisión_Personal (usuario_id, fecha_revision, comentarios_personales, autoevaluacion, notas_mejorar)
    VALUES (p_usuario_id, p_fecha_revision, p_comentarios_personales, p_autoevaluacion, p_notas_mejorar);
END //

DELIMITER ;
Actualizar Revisión Personal
DELIMITER //

CREATE PROCEDURE ActualizarRevisionPersonal (
    IN p_id_revision INT,
    IN p_usuario_id INT,
    IN p_fecha_revision DATE,
    IN p_comentarios_personales TEXT,
    IN p_autoevaluacion VARCHAR(50),
    IN p_notas_mejorar TEXT
)
BEGIN
    UPDATE Revisión_Personal
    SET usuario_id = p_usuario_id,
        fecha_revision = p_fecha_revision,
        comentarios_personales = p_comentarios_personales,
        autoevaluacion = p_autoevaluacion,
        notas_mejorar = p_notas_mejorar
    WHERE id_revision = p_id_revision;
END //

DELIMITER ;
Eliminar Revisión Personal
DELIMITER //

CREATE PROCEDURE EliminarRevisionPersonal (
    IN p_id_revision INT
)
BEGIN
    DELETE FROM Revisión_Personal WHERE id_revision = p_id_revision;
END //

DELIMITER ;
Insertar Desafío
DELIMITER //

CREATE PROCEDURE InsertarDesafio (
    IN p_nombre_desafio VARCHAR(100),
    IN p_fecha_inicio DATE,
    IN p_fecha_finalizacion DATE,
    IN p_num_participantes INT,
    IN p_habito_asociado INT,
    IN p_recompensa_desafio VARCHAR(255),
    IN p_estado ENUM('activo', 'finalizado')
)
BEGIN
    INSERT INTO Desafio (nombre_desafio,nombre_desafio,fecha_inicio,fecha_finalizacion,num_participantes,habito_asociado,recompensa_desafio,estado)
    Value (p_nombre_desafio,p_nombre_desafio,p_fecha_inicio,p_fecha_finalizacion,p_num_participantes,p_habito_asociado,p_recompensa_desafio,p_estado);
    END //
    
 Insertar Desafío
DELIMITER //

CREATE PROCEDURE InsertarDesafio (
    IN p_nombre_desafio VARCHAR(100),
    IN p_descripcion_desafio TEXT,
    IN p_fecha_inicio DATE,
    IN p_fecha_finalizacion DATE,
    IN p_num_participantes INT,
    IN p_habito_asociado INT,
    IN p_recompensa_desafio VARCHAR(255),
    IN p_estado ENUM('activo', 'finalizado')
)
BEGIN
    INSERT INTO Desafio (nombre_desafio, descripcion_desafio, fecha_inicio, fecha_finalizacion, num_participantes, habito_asociado, recompensa_desafio, estado)
    VALUES (p_nombre_desafio, p_descripcion_desafio, p_fecha_inicio, p_fecha_finalizacion, p_num_participantes, p_habito_asociado, p_recompensa_desafio, p_estado);
END //

DELIMITER ;
Actualizar Desafío
DELIMITER //

CREATE PROCEDURE ActualizarDesafio (
    IN p_id_desafio INT,
    IN p_nombre_desafio VARCHAR(100),
    IN p_descripcion_desafio TEXT,
    IN p_fecha_inicio DATE,
    IN p_fecha_finalizacion DATE,
    IN p_num_participantes INT,
    IN p_habito_asociado INT,
    IN p_recompensa_desafio VARCHAR(255),
    IN p_estado ENUM('activo', 'finalizado')
)
BEGIN
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
END //

DELIMITER ;
Eliminar Desafío
DELIMITER //

CREATE PROCEDURE EliminarDesafio (
    IN p_id_desafio INT
)
BEGIN
    DELETE FROM Desafio WHERE id_desafio = p_id_desafio;
END //

DELIMITER ;
Insertar Suscripción
DELIMITER //

CREATE PROCEDURE InsertarSuscripcion (
    IN p_usuario_id INT,
    IN p_nivel_suscripcion ENUM('gratuito', 'premium'),
    IN p_fecha_inicio DATE,
    IN p_fecha_expiracion DATE,
    IN p_estado_pago ENUM('pagado', 'pendiente', 'gratuito')
)
BEGIN
    INSERT INTO Suscripcion (usuario_id, nivel_suscripcion, fecha_inicio, fecha_expiracion, estado_pago)
    VALUES (p_usuario_id, p_nivel_suscripcion, p_fecha_inicio, p_fecha_expiracion, p_estado_pago);
END //

DELIMITER ;
Actualizar Suscripción
DELIMITER //

CREATE PROCEDURE ActualizarSuscripcion (
    IN p_id_suscripcion INT,
    IN p_usuario_id INT,
    IN p_nivel_suscripcion ENUM('gratuito', 'premium'),
    IN p_fecha_inicio DATE,
    IN p_fecha_expiracion DATE,
    IN p_estado_pago ENUM('pagado', 'pendiente', 'gratuito')
)
BEGIN
    UPDATE Suscripcion
    SET usuario_id = p_usuario_id,
        nivel_suscripcion = p_nivel_suscripcion,
        fecha_inicio = p_fecha_inicio,
        fecha_expiracion = p_fecha_expiracion,
        estado_pago = p_estado_pago
    WHERE id_suscripcion = p_id_suscripcion;
END //

DELIMITER ;
Eliminar Suscripción
DELIMITER //

CREATE PROCEDURE EliminarSuscripcion (
    IN p_id_suscripcion INT
)
BEGIN
    DELETE FROM Suscripcion WHERE id_suscripcion = p_id_suscripcion;
END //

DELIMITER ;
Insertar Comentario de Usuario
DELIMITER //

CREATE PROCEDURE InsertarComentarioUsuario (
    IN p_usuario_id INT,
    IN p_fecha_comentario DATE,
    IN p_texto_comentario TEXT,
    IN p_calificacion INT,
    IN p_estado_comentario ENUM('revisado', 'pendiente')
)
BEGIN
    INSERT INTO Comentarios_Usuario (usuario_id, fecha_comentario, texto_comentario, calificacion, estado_comentario)
    VALUES (p_usuario_id, p_fecha_comentario, p_texto_comentario, p_calificacion, p_estado_comentario);
END //

DELIMITER ;
Actualizar Comentario de Usuario
DELIMITER //

CREATE PROCEDURE ActualizarComentarioUsuario (
    IN p_id_comentario INT,
    IN p_usuario_id INT,
    IN p_fecha_comentario DATE,
    IN p_texto_comentario TEXT,
    IN p_calificacion INT,
    IN p_estado_comentario ENUM('revisado', 'pendiente')
)
BEGIN
    UPDATE Comentarios_Usuario
    SET usuario_id = p_usuario_id,
        fecha_comentario = p_fecha_comentario,
        texto_comentario = p_texto_comentario,
        calificacion = p_calificacion,
        estado_comentario = p_estado_comentario
    WHERE id_comentario = p_id_comentario;
END //

DELIMITER ;
Eliminar Comentario de Usuario
DELIMITER //

CREATE PROCEDURE EliminarComentarioUsuario (
    IN p_id_comentario INT
)
BEGIN
    DELETE FROM Comentarios_Usuario WHERE id_comentario = p_id_comentario;
END //

DELIMITER ;
Insertar Configuración de Usuario
DELIMITER //

CREATE PROCEDURE InsertarConfiguracionUsuario (
    IN p_usuario_id INT,
    IN p_preferencias_notificacion VARCHAR(255),
    IN p_idioma_interfaz VARCHAR(50),
    IN p_tema_visual ENUM('claro', 'oscuro'),
    IN p_recordatorios_personalizados TEXT,
    IN p_sincronizacion_apps VARCHAR(255)
)
BEGIN
    INSERT INTO Configuracion_Usuario (usuario_id, preferencias_notificacion, idioma_interfaz, tema_visual, recordatorios_personalizados, sincronizacion_apps)
    VALUES (p_usuario_id, p_preferencias_notificacion, p_idioma_interfaz, p_tema_visual, p_recordatorios_personalizados, p_sincronizacion_apps);
END //

DELIMITER ;
Actualizar Configuración de Usuario
DELIMITER //

CREATE PROCEDURE ActualizarConfiguracionUsuario (
    IN p_id_configuracion INT,
    IN p_usuario_id INT,
    IN p_preferencias_notificacion VARCHAR(255),
    IN p_idioma_interfaz VARCHAR(50),
    IN p_tema_visual ENUM('claro', 'oscuro'),
    IN p_recordatorios_personalizados TEXT,
    IN p_sincronizacion_apps VARCHAR(255)
)
BEGIN
    UPDATE Configuracion_Usuario
    SET usuario_id = p_usuario_id,
        preferencias_notificacion = p_preferencias_notificacion,
        idioma_interfaz = p_idioma_interfaz,
        tema_visual = p_tema_visual,
        recordatorios_personalizados = p_recordatorios_personalizados,
        sincronizacion_apps = p_sincronizacion_apps
    WHERE id_configuracion = p_id_configuracion;
END //

DELIMITER ;
Eliminar Configuración de Usuario
DELIMITER //

CREATE PROCEDURE EliminarConfiguracionUsuario (
    IN p_id_configuracion INT
)
BEGIN
    DELETE FROM Configuracion_Usuario WHERE id_configuracion = p_id_configuracion;
END //

DELIMITER ;
Insertar Puntos
DELIMITER //

CREATE PROCEDURE InsertarPuntos (
    IN p_usuario_id INT,
    IN p_habito_id INT,
    IN p_puntos_obtenidos INT,
    IN p_fecha_obtencion DATE
)
BEGIN
    INSERT INTO Puntos (usuario_id, habito_id, puntos_obtenidos, fecha_obtencion)
    VALUES (p_usuario_id, p_habito_id, p_puntos_obtenidos, p_fecha_obtencion);
END //

DELIMITER ;
Actualizar Puntos
DELIMITER //

CREATE PROCEDURE ActualizarPuntos (
    IN p_id_puntos INT,
    IN p_usuario_id INT,
    IN p_habito_id INT,
    IN p_puntos_obtenidos INT,
    IN p_fecha_obtencion DATE
)
BEGIN
    UPDATE Puntos
    SET usuario_id = p_usuario_id,
        habito_id = p_habito_id,
        puntos_obtenidos = p_puntos_obtenidos,
        fecha_obtencion = p_fecha_obtencion
    WHERE id_puntos = p_id_puntos;
END //

DELIMITER ;
Eliminar Puntos
DELIMITER //

CREATE PROCEDURE EliminarPuntos (
    IN p_id_puntos INT
)
BEGIN
    DELETE FROM Puntos WHERE id_puntos = p_id_puntos;
END //

DELIMITER ;

##laro! Aquí tienes un conjunto de datos de ejemplo para al menos 10 usuarios que puedes insertar en tu base de datos. Estos datos incluyen información básica de los usuarios, hábitos, registros de progreso, objetivos, recompensas, recordatorios, estadísticas de usuario, grupos de apoyo, revisiones personales, desafíos, suscripciones, comentarios de usuario, configuraciones de usuario, puntos, comentarios en hábitos, competencias e integraciones.

### Datos de Ejemplo para la Tabla `Usuario`
```sql
INSERT INTO Usuario (nombre, apellidos, correo_electronico, contrasena, fecha_nacimiento, genero, pais_region, nivel_suscripcion, preferencias_notificacion)
VALUES
('Juan', 'Pérez', 'juan.perez@example.com', 'password123', '1990-01-01', 'Masculino', 'México', 'gratuita', 'correo'),
('María', 'García', 'maria.garcia@example.com', 'password123', '1985-05-15', 'Femenino', 'España', 'premium', 'push'),
('Carlos', 'López', 'carlos.lopez@example.com', 'password123', '1992-07-20', 'Masculino', 'Argentina', 'gratuita', 'correo'),
('Ana', 'Martínez', 'ana.martinez@example.com', 'password123', '1988-03-10', 'Femenino', 'Chile', 'premium', 'push'),
('Luis', 'Rodríguez', 'luis.rodriguez@example.com', 'password123', '1995-11-25', 'Masculino', 'Colombia', 'gratuita', 'correo'),
('Laura', 'Hernández', 'laura.hernandez@example.com', 'password123', '1991-09-05', 'Femenino', 'Perú', 'premium', 'push'),
('Jorge', 'González', 'jorge.gonzalez@example.com', 'password123', '1987-12-30', 'Masculino', 'Uruguay', 'gratuita', 'correo'),
('Sofía', 'Ramírez', 'sofia.ramirez@example.com', 'password123', '1993-04-18', 'Femenino', 'Paraguay', 'premium', 'push'),
('Miguel', 'Fernández', 'miguel.fernandez@example.com', 'password123', '1990-06-22', 'Masculino', 'Bolivia', 'gratuita', 'correo'),
('Elena', 'Torres', 'elena.torres@example.com', 'password123', '1989-08-14', 'Femenino', 'Ecuador', 'premium', 'push');
```

### Datos de Ejemplo para la Tabla `Habito`
```sql
INSERT INTO Habito (nombre_habito, descripcion_habito, categoria_habito, objetivo_habito, frecuencia, duracion_estimada, estado, fecha_inicio, fecha_estimacion_final)
VALUES
('Ejercicio Diario', 'Hacer ejercicio durante 30 minutos cada día', 'Salud', 'Mejorar salud', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31'),
('Leer Libros', 'Leer al menos 20 páginas de un libro cada día', 'Educación', 'Aumentar conocimiento', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31'),
('Meditar', 'Meditar durante 15 minutos cada mañana', 'Bienestar', 'Reducir estrés', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31'),
('Ahorro Semanal', 'Ahorrar una cantidad fija de dinero cada semana', 'Finanzas', 'Mejorar finanzas', 'semanal', 4, 'activo', '2024-01-01', '2024-01-28'),
('Estudiar Programación', 'Estudiar programación durante 1 hora cada día', 'Educación', 'Mejorar habilidades', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31'),
('Correr', 'Correr 5 km cada semana', 'Salud', 'Mejorar condición física', 'semanal', 4, 'activo', '2024-01-01', '2024-01-28'),
('Dieta Saludable', 'Seguir una dieta saludable todos los días', 'Salud', 'Mejorar alimentación', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31'),
('Aprender Inglés', 'Estudiar inglés durante 1 hora cada día', 'Educación', 'Mejorar habilidades lingüísticas', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31'),
('Escribir Diario', 'Escribir en un diario cada noche', 'Bienestar', 'Reflexionar sobre el día', 'diaria', 30, 'activo', '2024-01-01', '2024-01-31'),
('Desarrollo Personal', 'Leer libros de desarrollo personal cada semana', 'Bienestar', 'Mejorar crecimiento personal', 'semanal', 4, 'activo', '2024-01-01', '2024-01-28');
```

### Datos de Ejemplo para la Tabla `Usuario_Habito`
```sql
INSERT INTO Usuario_Habito (usuario_id, habito_id)
VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);
```

### Datos de Ejemplo para la Tabla `Registro_Progreso`
```sql
INSERT INTO Registro_Progreso (habito_id, fecha_registro, estado_progreso, notas_usuario, recompensas_obtenidas)
VALUES
(1, '2024-01-01', 'completado', 'Buen inicio', 'Medalla de Bronce'),
(2, '2024-01-01', 'completado', 'Interesante lectura', 'Medalla de Bronce'),
(3, '2024-01-01', 'completado', 'Relajante', 'Medalla de Bronce'),
(4, '2024-01-01', 'completado', 'Ahorro realizado', 'Medalla de Bronce'),
(5, '2024-01-01', 'completado', 'Aprendí algo nuevo', 'Medalla de Bronce'),
(6, '2024-01-01', 'completado', 'Buena carrera', 'Medalla de Bronce'),
(7, '2024-01-01', 'completado', 'Dieta seguida', 'Medalla de Bronce'),
(8, '2024-01-01', 'completado', 'Mejoré mi inglés', 'Medalla de Bronce'),
(9, '2024-01-01', 'completado', 'Reflexioné sobre el día', 'Medalla de Bronce'),
(10, '2024-01-01', 'completado', 'Lectura motivadora', 'Medalla de Bronce');
```

### Datos de Ejemplo para la Tabla `Objetivo`
```sql
INSERT INTO Objetivo (habito_id, descripcion_objetivo, meta_cuantificable, estado, fecha_inicio, fecha_finalizacion_estimada, notas_adicionales)
VALUES
(1, 'Completar 30 días de ejercicio', '30 días consecutivos', 'en_progreso', '2024-01-01', '2024-01-31', 'Mantener la constancia'),
(2, 'Leer 600 páginas en un mes', '600 páginas', 'en_progreso', '2024-01-01', '2024-01-31', 'Disfrutar la lectura'),
(3, 'Meditar todos los días del mes', '30 días consecutivos', 'en_progreso', '2024-01-01', '2024-01-31', 'Reducir el estrés'),
(4, 'Ahorrar $1000 en un mes', '1000 dólares', 'en_progreso', '2024-01-01', '2024-01-31', 'Ser constante'),
(5, 'Estudiar programación 30 horas', '30 horas', 'en_progreso', '2024-01-01', '2024-01-31', 'Mejorar habilidades'),
(6, 'Correr 20 km en un mes', '20 km', 'en_progreso', '2024-01-01', '2024-01-31', 'Mejorar resistencia'),
(7, 'Seguir dieta saludable todo el mes', '30 días consecutivos', 'en_progreso', '2024-01-01', '2024-01-31', 'Mejorar alimentación'),
(8, 'Estudiar inglés 30 horas', '30 horas', 'en_progreso', '2024-01-01', '2024-01-31', 'Mejorar inglés'),
(9, 'Escribir en el diario todos los días', '30 días consecutivos', 'en_progreso', '2024-01-01', '2024-01-31, 'Escribir Diario');
(10, 'Leer libros de desarrollo personal cada semana', '15 días consecutivos', 'en_progreso', '2024-01-01', '2024-01-31, 'Desarrollo Personal');
```


### Ver Usuarios y sus Hábitos
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Habito.id_habito, 
    Habito.nombre_habito
FROM 
    Usuario
JOIN 
    Usuario_Habito ON Usuario.id_usuario = Usuario_Habito.usuario_id
JOIN 
    Habito ON Usuario_Habito.habito_id = Habito.id_habito;
### Ver Progreso de los Hábitos de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Habito.id_habito, 
    Habito.nombre_habito, 
    Registro_Progreso.fecha_registro, 
    Registro_Progreso.estado_progreso
FROM 
    Usuario
JOIN 
    Usuario_Habito ON Usuario.id_usuario = Usuario_Habito.usuario_id
JOIN 
    Habito ON Usuario_Habito.habito_id = Habito.id_habito
JOIN 
    Registro_Progreso ON Habito.id_habito = Registro_Progreso.habito_id;
### Ver Objetivos de los Hábitos de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Habito.id_habito, 
    Habito.nombre_habito, 
    Objetivo.descripcion_objetivo, 
    Objetivo.meta_cuantificable, 
    Objetivo.estado
FROM 
    Usuario
JOIN 
    Usuario_Habito ON Usuario.id_usuario = Usuario_Habito.usuario_id
JOIN 
    Habito ON Usuario_Habito.habito_id = Habito.id_habito
JOIN 
    Objetivo ON Habito.id_habito = Objetivo.habito_id;
### Ver Recompensas de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Recompensa.descripcion_recompensa, 
    Recompensa.condicion_obtencion, 
    Recompensa.estado
FROM 
    Usuario
JOIN 
    Recompensa ON Usuario.id_usuario = Recompensa.usuario_id;
### Ver Recordatorios de los Hábitos de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Habito.id_habito, 
    Habito.nombre_habito, 
    Recordatorio.tipo_recordatorio, 
    Recordatorio.fecha_hora_recordatorio, 
    Recordatorio.frecuencia_recordatorio
FROM 
    Usuario
JOIN 
    Usuario_Habito ON Usuario.id_usuario = Usuario_Habito.usuario_id
JOIN 
    Habito ON Usuario_Habito.habito_id = Habito.id_habito
JOIN 
    Recordatorio ON Habito.id_habito = Recordatorio.habito_id;
### Ver Estadísticas de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Estadisticas_Usuario.num_habitos_activos, 
    Estadisticas_Usuario.porcentaje_habitos_completados, 
    Estadisticas_Usuario.dias_consecutivos_habitos_completados, 
    Estadisticas_Usuario.promedio_habitos_cumplidos
FROM 
    Usuario
JOIN 
    Estadisticas_Usuario ON Usuario.id_usuario = Estadisticas_Usuario.usuario_id;
###Ver Grupos de Apoyo y sus Miembros
SELECT 
    Grupo_Apoyo.id_grupo, 
    Grupo_Apoyo.nombre_grupo, 
    Grupo_Apoyo.descripcion_grupo, 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos
FROM 
    Grupo_Apoyo
JOIN 
    Usuario_Habito ON Grupo_Apoyo.habito_compartido = Usuario_Habito.habito_id
JOIN 
    Usuario ON Usuario_Habito.usuario_id = Usuario.id_usuario;
### Ver Revisiones Personales de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Revision_Personal.fecha_revision, 
    Revision_Personal.comentarios_personales, 
    Revision_Personal.autoevaluacion
FROM 
    Usuario
JOIN 
    Revision_Personal ON Usuario.id_usuario = Revision_Personal.usuario_id;
### Ver Desafíos y Participantes
SELECT 
    Desafio.id_desafio, 
    Desafio.nombre_desafio, 
    Desafio.descripcion_desafio, 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos
FROM 
    Desafio
JOIN 
    Usuario_Habito ON Desafio.habito_asociado = Usuario_Habito.habito_id
JOIN 
    Usuario ON Usuario_Habito.usuario_id = Usuario.id_usuario;
### Ver Suscripciones de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Suscripcion.nivel_suscripcion, 
    Suscripcion.fecha_inicio, 
    Suscripcion.fecha_expiracion, 
    Suscripcion.estado_pago
FROM 
    Usuario
JOIN 
    Suscripcion ON Usuario.id_usuario = Suscripcion.usuario_id;
### Ver Comentarios de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Comentarios_Usuario.fecha_comentario, 
    Comentarios_Usuario.texto_comentario, 
    Comentarios_Usuario.calificacion
FROM 
    Usuario
JOIN 
    Comentarios_Usuario ON Usuario.id_usuario = Comentarios_Usuario.usuario_id;
### Ver Configuraciones de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Configuracion_Usuario.preferencias_notificacion, 
    Configuracion_Usuario.idioma_interfaz, 
    Configuracion_Usuario.tema_visual
FROM 
    Usuario
JOIN 
    Configuracion_Usuario ON Usuario.id_usuario = Configuracion_Usuario.usuario_id;
### Ver Puntos de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Habito.nombre_habito, 
    Puntos.puntos_obtenidos, 
    Puntos.fecha_obtencion
FROM 
    Usuario
JOIN 
    Puntos ON Usuario.id_usuario = Puntos.usuario_id
JOIN 
    Habito ON Puntos.habito_id = Habito.id_habito;
### Ver Comentarios en Hábitos
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Habito.nombre_habito, 
    Comentario_Habito.comentario, 
    Comentario_Habito.fecha_comentario
FROM 
    Usuario
JOIN 
    Comentario_Habito ON Usuario.id_usuario = Comentario_Habito.usuario_id
JOIN 
    Habito ON Comentario_Habito.habito_id = Habito.id_habito;
### Ver Competencias y Ganadores
SELECT 
    Competencia.id_competencia, 
    Competencia.nombre_competencia, 
    Competencia.descripcion, 
    Usuario.id_usuario AS ganador_id, 
    Usuario.nombre AS ganador_nombre, 
    Usuario.apellidos AS ganador_apellidos
FROM 
    Competencia
LEFT JOIN 
    Usuario ON Competencia.usuario_ganador_id = Usuario.id_usuario;
### Ver Integraciones de los Usuarios
SELECT 
    Usuario.id_usuario, 
    Usuario.nombre, 
    Usuario.apellidos, 
    Integracion.tipo_integracion, 
    Integracion.fecha_sincronizacion
FROM 
    Usuario
JOIN 
    Integracion ON Usuario.id_usuario = Integracion.usuario_id;

  