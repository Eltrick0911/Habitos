Create database Seguimiento_habitos
Use Seguimiento_habitos
go
--//Usuario
CREATE TABLE Usuario (
    id_usuario INT identity PRIMARY KEY
);

CREATE TABLE DetallesPersonalesUsuario (
    id_usuario INT,
    nombre VARCHAR(50),
    apellidos VARCHAR(50),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE ContactoUsuario (
    id_usuario INT,
    correo_electronico VARCHAR(100),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE CredencialesUsuario (
    id_usuario INT,
    contrasena VARCHAR(255),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE PerfilUsuario (
    id_usuario INT,
    fecha_nacimiento DATE,
    genero VARCHAR(20),
    pais_region VARCHAR(100),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE SuscripcionUsuario (
    id_usuario INT,
    nivel_suscripcion VARCHAR(20),
    fecha_registro DATE,
    ultima_fecha_acceso DATE,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE PreferenciasUsuario (
    id_usuario INT,
    preferencias_notificacion VARCHAR(100),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);go
--//H�bito
CREATE TABLE Habito (
    id_habito INT identity PRIMARY KEY,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE DetallesHabito (
    id_habito INT,
    nombre_habito VARCHAR(100),
    descripcion_habito TEXT,
    FOREIGN KEY (id_habito) REFERENCES Habito(id_habito)
);

alter TABLE ClasificacionHabito (
    id_habito INT,
    categoria_habito VARCHAR(50),
    objetivo_habito VARCHAR(100),
    FOREIGN KEY (id_habito) REFERENCES Habito(id_habito)
);


CREATE TABLE PlanificacionHabito (
    id_habito INT,
    frecuencia VARCHAR(20),
    duracion_estimada INT,
    estado VARCHAR(20),
    fecha_inicio DATE,
    fecha_estimada_finalizacion DATE,
    FOREIGN KEY (id_habito) REFERENCES Habito(id_habito)
); go
--//Recompensa
CREATE TABLE Recompensa (
    id_recompensa INT identity PRIMARY KEY,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE DetallesRecompensa (
    id_recompensa INT,
    descripcion_recompensa TEXT,
    condicion_obtencion TEXT,
    estado VARCHAR(20),
    fecha_obtencion DATE,
    FOREIGN KEY (id_recompensa) REFERENCES Recompensa(id_recompensa)
);go
--//Recordatorio
CREATE TABLE Recordatorio (
    id_recordatorio INT identity PRIMARY KEY,
    id_habito INT,
    FOREIGN KEY (id_habito) REFERENCES Habito(id_habito)
);

CREATE TABLE DetallesRecordatorio (
    id_recordatorio INT,
    tipo_recordatorio VARCHAR(50),
    fecha_hora_recordatorio DATETIME,
    frecuencia_recordatorio VARCHAR(50),
    estado VARCHAR(20),
    FOREIGN KEY (id_recordatorio) REFERENCES Recordatorio(id_recordatorio)
);go
--//Categor�a de H�bito
CREATE TABLE CategoriaHabito (
    id_categoria INT identity PRIMARY KEY,
    nombre_categoria VARCHAR(50),
    descripcion_categoria TEXT,
    color_icono VARCHAR(50)
);go
--//Estad�sticas de Usuario
CREATE TABLE EstadisticasUsuario (
    id_estadistica INT identity PRIMARY KEY,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE DetallesEstadisticas (
    id_estadistica INT,
    numero_habitos_activos INT,
    porcentaje_habitos_completados FLOAT,
    dias_consecutivos_habitos_completados INT,
    promedio_habitos_cumplidos FLOAT,
    fechas_mayores_avances TEXT,
    graficos_progreso TEXT,
    FOREIGN KEY (id_estadistica) REFERENCES EstadisticasUsuario(id_estadistica)
);go
--//Grupo de Apoyo
CREATE TABLE GrupoApoyo (
    id_grupo INT identity PRIMARY KEY,
    nombre_grupo VARCHAR(100),
    descripcion_grupo TEXT,
    fecha_creacion DATE
);

CREATE TABLE MiembrosGrupo (
    id_grupo INT,
    id_usuario INT,
    FOREIGN KEY (id_grupo) REFERENCES GrupoApoyo(id_grupo),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);go
--//Revisi�n Personal
CREATE TABLE RevisionPersonal (
    id_revision INT identity PRIMARY KEY,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE DetallesRevision (
    id_revision INT,
    fecha_revision DATE,
    comentarios_personales TEXT,
    autoevaluacion VARCHAR(20),
    notas_mejorar TEXT,
    FOREIGN KEY (id_revision) REFERENCES RevisionPersonal(id_revision)
);go
--//Desaf�o
CREATE TABLE Desafio (
    id_desafio INT identity PRIMARY KEY
);

CREATE TABLE DetallesDesafio (
    id_desafio INT,
    nombre_desafio VARCHAR(100),
    descripcion_desafio TEXT,
    fecha_inicio DATE,
    fecha_finalizacion DATE,
    numero_participantes INT,
    habito_asociado INT,
    recompensa_desafio TEXT,
    estado VARCHAR(20),
    FOREIGN KEY (id_desafio) REFERENCES Desafio(id_desafio)
);go
--//Suscripci�n
CREATE TABLE Suscripcion (
    id_suscripcion INT identity PRIMARY KEY,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE DetallesSuscripcion (
    id_suscripcion INT,
    nivel_suscripcion VARCHAR(20),
    fecha_inicio DATE,
    fecha_expiracion DATE,
    estado_pago VARCHAR(20),
    FOREIGN KEY (id_suscripcion) REFERENCES Suscripcion(id_suscripcion)
);go
--//Comentarios o Retroalimentaci�n del Usuario
CREATE TABLE Comentario (
    id_comentario INT identity PRIMARY KEY,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE DetallesComentario (
    id_comentario INT,
    fecha_comentario DATE,
    texto_comentario TEXT,
    calificacion INT,
    estado_comentario VARCHAR(20),
    FOREIGN KEY (id_comentario) REFERENCES Comentario(id_comentario)
);go
--//Configuraci�n del Usuario
CREATE TABLE ConfiguracionUsuario (
    id_configuracion INT identity PRIMARY KEY,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE DetallesConfiguracion (
    id_configuracion INT,
    preferencias_notificacion VARCHAR(100),
    idioma_interfaz VARCHAR(50),
    tema_visual VARCHAR(50),
    recordatorios_personalizados TEXT,
    sincronizacion_otras_apps TEXT,
    FOREIGN KEY (id_configuracion) REFERENCES ConfiguracionUsuario(id_configuracion)
);
go

select * database Seguimiento_habitos