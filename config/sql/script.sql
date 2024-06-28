/* 
 DATABASE	:	SISTEMA_INCIDENCIAS
 FECHA		:	16 / 05 /2024
 ORGANIZACION	:	MUNICIPALIDAD DISTRITAL DE LA ESPERANZA
 PROGRAMADOR		:	JHONATAN MANTILLA MIÑANO
 */
-- CREACION DE LA BASE DE DATOS
CREATE DATABASE SISTEMA_INCIDENCIAS
GO
	USE SISTEMA_INCIDENCIAS
GO
	-- CREACION DE LA TABLA ROL
	CREATE TABLE ROL (
		ROL_codigo SMALLINT IDENTITY(1, 1) PRIMARY KEY,
		ROL_nombre VARCHAR(20)
	);

GO
INSERT INTO
	ROL (ROL_nombre)
VALUES
	('Administrador');

INSERT INTO
	ROL (ROL_nombre)
VALUES
	('Usuario');

INSERT INTO
	ROL (ROL_nombre)
VALUES
	('Soporte');

-- CREACION DE LA TABLA PERSONA
CREATE TABLE PERSONA (
	PER_codigo SMALLINT IDENTITY(1, 1) PRIMARY KEY,
	PER_dni CHAR(8) UNIQUE NOT NULL,
	PER_nombres VARCHAR(20) NOT NULL,
	PER_apellidoPaterno VARCHAR(15) NOT NULL,
	PER_apellidoMaterno VARCHAR(15) NOT NULL,
	PER_email VARCHAR(45) NOT NULL,
	PER_celular CHAR(9) UNIQUE NOT NULL
);

GO
INSERT INTO
	PERSONA (
		PER_dni,
		PER_nombres,
		PER_apellidoPaterno,
		PER_apellidoMaterno,
		PER_email,
		PER_celular
	)
VALUES
	(
		'70555743',
		'Jhonatan',
		'Mantilla',
		'Miñano',
		'jhonatanmm.1995@gmail.com',
		'950212909'
	);

INSERT INTO
	PERSONA (
		PER_dni,
		PER_nombres,
		PER_apellidoPaterno,
		PER_apellidoMaterno,
		PER_email,
		PER_celular
	)
VALUES
	(
		'70555742',
		'Gustavo',
		'Mantilla',
		'Miñano',
		'gammgush@gmail.com',
		'950212913'
	);

INSERT INTO
	dbo.PERSONA(
		PER_dni,
		PER_nombres,
		PER_apellidoPaterno,
		PER_apellidoMaterno,
		PER_celular,
		PER_email
	)
VALUES ('98765423','Maria','Blas','Vera','mblasv@gmail.com','975168936');

-- CREACION DE LA TABLA AREA
CREATE TABLE AREA (
	ARE_codigo SMALLINT IDENTITY(1, 1) PRIMARY KEY,
	ARE_nombre VARCHAR(60) UNIQUE NOT NULL
);

GO
INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Informática y Sistemas');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Gerencia Municipal');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Contabilidad');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Alcaldía');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Tesoreria');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Seccion de Almacen');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	(
		'Subgerencia de Abastecimientos y Control Patrimonial'
	);

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Unidad de Control Patrimonial');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Caja General');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Gerencia de Recursos Humanos');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Gerencia de Desarrollo Económico Local');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Area de Liquidación de Obras');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	(
		'Subgerencia de Habilitaciones Urbanas y Catrasto'
	);

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Escalafón');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Secretaría General');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Programa del Vaso de Leche - Provale');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Demuna');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Omaped');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Salud');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Gerencia de Administración Tributaria');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Servicio Social');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Unidad de Relaciones Públicas y Comunicaciones');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Gerencia de Gestión Ambiental');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Gerencia de Asesoría Jurídica');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	(
		'Subgerencia De Planificación  Y Modernización Institucional'
	);

INSERT INTO
	AREA(ARE_nombre)
VALUES
	(
		'Subgerencia de Gestión y Desarrollo de Recursos Humanos'
	);

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Gerencia de Desarrollo Social');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Educación');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Programas Sociales');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Licencias');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Policía Municipal');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Registro Civil');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Mantenimiento de Obras Públicas');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Gerencia de Desarrollo Urbano');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Ejecutoria Coactiva');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Estudios y Proyectos');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Obras');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Procuraduría Pública Municipal');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Gerencia de Administración y Finanzas');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Defensa Civil');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Juventud, Deporte y Cultura');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Áreas Verdes');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Seguridad Ciudadana');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Órgano de Control Institucional');

INSERT INTO
	dbo.AREA(ARE_nombre)
VALUES
	('Unidad Local de Empadronamiento (ULE)');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	(
		'Unidad de Atención al Usuario y Trámite Documentario'
	);

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Gerencia de Seguridad Ciudadana');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Aabstecimiento');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Participación Vecinal');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	(
		'Gerencia de Planeamiento, Presupuesto Y Modernización'
	);

INSERT INTO
	AREA(ARE_nombre)
VALUES
	(
		'Subgerencia de Transporte, Tránsito y Seguridad Vial'
	);

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Archivo Central');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Equipo Mecánico y Maestranza');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Subgerencia de Limpieza Pública');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Bienestar social');

INSERT INTO
	AREA(ARE_nombre)
VALUES
	('Orientación Tributaria');

-- CREACION DE LA TABLA ESTADO
CREATE TABLE ESTADO (
	EST_codigo SMALLINT IDENTITY(1, 1) PRIMARY KEY,
	EST_descripcion VARCHAR(20)
);

GO
INSERT INTO
	ESTADO (EST_descripcion)
VALUES
	('Activo');

INSERT INTO
	ESTADO (EST_descripcion)
VALUES
	('Inactivo');

INSERT INTO
	ESTADO (EST_descripcion)
VALUES
	('Abierta');

INSERT INTO
	ESTADO (EST_descripcion)
VALUES
	('Recepcionado');

INSERT INTO
	ESTADO (EST_descripcion)
VALUES
	('Cerrado');

GO
	-- CREACION DE LA TABLA USUARIO
	CREATE TABLE USUARIO (
		USU_codigo SMALLINT IDENTITY(1, 1) PRIMARY KEY,
		USU_nombre VARCHAR(20) UNIQUE NOT NULL,
		USU_password VARCHAR(10) NOT NULL,
		PER_codigo SMALLINT,
		ROL_codigo SMALLINT,
		ARE_codigo SMALLINT,
		EST_codigo SMALLINT,
		CONSTRAINT FK_USUARIO_PERSONA FOREIGN KEY (PER_codigo) REFERENCES PERSONA(PER_codigo),
		CONSTRAINT FK_USUARIO_ROL FOREIGN KEY (ROL_codigo) REFERENCES ROL(ROL_codigo),
		CONSTRAINT FK_USUARIO_AREA FOREIGN KEY (ARE_codigo) REFERENCES AREA(ARE_codigo),
		CONSTRAINT FK_USUARIO_ESTADO FOREIGN KEY (EST_codigo) REFERENCES ESTADO(EST_codigo)
	);

GO
INSERT INTO
	USUARIO (
		USU_nombre,
		USU_password,
		PER_codigo,
		ROL_codigo,
		ARE_codigo,
		EST_codigo
	)
VALUES
	('GAMM95', '123456', 1, 3, 1, 1);

INSERT INTO
	USUARIO (
		USU_nombre,
		USU_password,
		PER_codigo,
		ROL_codigo,
		ARE_codigo,
		EST_codigo
	)
VALUES
	('GUSH98', '123456', 2, 2, 2, 1);

GO
	CREATE PROCEDURE SP_Usuario_login(
		@USU_usuario VARCHAR(20),
		@USU_password VARCHAR(10)
	) AS BEGIN
SET
	NOCOUNT ON;

SELECT
	u.USU_nombre,
	u.USU_password,
	p.PER_nombres,
	p.PER_apellidoPaterno,
	r.ROL_nombre,
	a.ARE_nombre
FROM
	USUARIO u
	INNER JOIN PERSONA p ON p.PER_codigo = u.PER_codigo
	INNER JOIN ROL r ON r.ROL_codigo = u.ROL_codigo
	INNER JOIN AREA a ON a.ARE_codigo = u.ARE_codigo
WHERE
	u.USU_nombre = @USU_usuario
	AND u.USU_password = @USU_password;

END;

GO
	CREATE TABLE PRIORIDAD(
		PRI_codigo SMALLINT IDENTITY(1, 1),
		PRI_nombre VARCHAR(15) NOT NULL,
		CONSTRAINT pk_PRI_codigo PRIMARY KEY(PRI_codigo),
		CONSTRAINT uq_PRI_descripcion UNIQUE (PRI_nombre)
	);

GO
INSERT INTO
	PRIORIDAD(PRI_nombre)
VALUES
	('Baja');

INSERT INTO
	PRIORIDAD(PRI_nombre)
VALUES
	('Media');

INSERT INTO
	PRIORIDAD(PRI_nombre)
VALUES
	('Alta');

CREATE TABLE CATEGORIA (
	CAT_codigo SMALLINT IDENTITY(1, 1),
	CAT_nombre VARCHAR(60) NOT NULL,
	CONSTRAINT pk_CAT_codigo PRIMARY KEY(CAT_codigo),
	CONSTRAINT uq_CAT_nombre UNIQUE (CAT_nombre)
);

GO
INSERT INTO
	CATEGORIA (CAT_nombre)
VALUES
	('Red inaccesible');

INSERT INTO
	CATEGORIA (CAT_nombre)
VALUES
	('Asistencia técnica');

INSERT INTO
	CATEGORIA (CAT_nombre)
VALUES
	('Generacion de usuario');

INSERT INTO
	CATEGORIA (CAT_nombre)
VALUES
	('Fallo de equipo de computo');

INSERT INTO
	CATEGORIA (CAT_nombre)
VALUES
	('Inaccesibilidad a Impresora');

INSERT INTO
	CATEGORIA (CAT_nombre)
VALUES
	('Correo corporativo');

INSERT INTO
	CATEGORIA (CAT_nombre)
VALUES
	('Reportes varios de sistemas informaticos');

INSERT INTO
	CATEGORIA (CAT_nombre)
VALUES
	('Otros');

INSERT INTO
	CATEGORIA (CAT_nombre)
VALUES
	('Inaccesibilidad a Sistemas Informaticos');

GO
	CREATE PROCEDURE SP_Registrar_Usuario @USU_nombre VARCHAR(20),
	@USU_password VARCHAR(10),
	@PER_codigo SMALLINT,
	@ROL_codigo SMALLINT,
	@ARE_codigo SMALLINT AS BEGIN -- Insertar el nuevo usuario con EST_codigo siempre igual a 1
INSERT INTO
	USUARIO (
		USU_nombre,
		USU_password,
		PER_codigo,
		ROL_codigo,
		ARE_codigo,
		EST_codigo
	)
VALUES
	(
		@USU_nombre,
		@USU_password,
		@PER_codigo,
		@ROL_codigo,
		@ARE_codigo,
		1
	);

END;

GO
	CREATE TABLE IMPACTO (
		IMP_codigo SMALLINT IDENTITY(1, 1),
		IMP_descripcion VARCHAR(20) NOT NULL,
		CONSTRAINT pk_impacto PRIMARY KEY (IMP_codigo)
	);

GO
INSERT INTO
	IMPACTO (IMP_descripcion)
VALUES
	('Alto');

INSERT INTO
	IMPACTO (IMP_descripcion)
VALUES
	('Medio');

INSERT INTO
	IMPACTO (IMP_descripcion)
VALUES
	('Bajo');

CREATE TABLE INCIDENCIA (
	INC_numero SMALLINT IDENTITY(1, 1),
	INC_fecha DATE NOT NULL,
	INC_hora TIMe(7) NOT NULL,
	INC_asunto VARCHAR(200) NOT NULL,
	INC_descripcion VARCHAR(500) NOT NULL,
	INC_documento VARCHAR(100) NOT NULL,
	INC_codigoPatrimonial CHAR(12) NOT NULL,
	EST_codigo SMALLINT NOT NULL,
	CAT_codigo SMALLINT NOT NULL,
	ARE_codigo SMALLINT NOT NULL,
	USU_codigo SMALLINT NOT NULL,
	CONSTRAINT pk_incidencia PRIMARY KEY (INC_numero),
	CONSTRAINT fk_estado_incidencia FOREIGN KEY (EST_codigo) REFERENCES ESTADO (EST_codigo),
	CONSTRAINT fk_categoria_incidencia FOREIGN KEY (CAT_codigo) REFERENCES CATEGORIA (CAT_codigo),
	CONSTRAINT fk_area_incidencia FOREIGN KEY (ARE_codigo) REFERENCES AREA (ARE_codigo),
	CONSTRAINT fk_usuario_incidencia FOREIGN KEY (USU_codigo) REFERENCES USUARIO (USU_codigo)
);

GO
	CREATE TABLE RECEPCION (
		REC_numero SMALLINT IDENTITY(1, 1),
		REC_fecha DATETIME NOT NULL,
		REC_hora TIME(7) NOT NULL,
		INC_numero SMALLINT NOT NULL,
		PRI_codigo SMALLINT NOT NULL,
		IMP_codigo SMALLINT NOT NULL,
		USU_codigo SMALLINT NOT NULL,
		EST_codigo SMALLINT NOT NULL,
		CONSTRAINT pk_recepcion PRIMARY KEY (REC_numero),
		CONSTRAINT fk_incidencia_recepcion FOREIGN KEY (INC_numero) REFERENCES INCIDENCIA (INC_numero),
		CONSTRAINT fk_prioridad_recepcion FOREIGN KEY (PRI_codigo) REFERENCES PRIORIDAD (PRI_codigo),
		CONSTRAINT fk_impacto_recepcion FOREIGN KEY (IMP_codigo) REFERENCES IMPACTO (IMP_codigo),
		CONSTRAINT fk_usuario_recepcion FOREIGN KEY (USU_codigo) REFERENCES USUARIO (USU_codigo),
		CONSTRAINT fk_estado_recepcion FOREIGN KEY (EST_codigo) REFERENCES ESTADO (EST_codigo),
	);

GO
	CREATE PROCEDURE SP_Registrar_Incidencia_Admin @INC_fecha DATE,
	@INC_hora TIMe(7),
	@INC_asunto VARCHAR(200),
	@INC_descripcion VARCHAR(500),
	@INC_documento VARCHAR(100),
	@INC_codigoPatrimonial CHAR(12),
	@EST_codigo SMALLINT,
	@CAT_codigo SMALLINT,
	@ARE_codigo SMALLINT,
	@USU_codigo SMALLINT AS BEGIN -- Insertar el nuevo usuario con EST_codigo siempre igual a 1
INSERT INTO
	INCIDENCIA (
		INC_fecha,
		INC_hora,
		INC_asunto,
		INC_descripcion,
		INC_documento,
		INC_codigoPatrimonial,
		EST_codigo,
		CAT_codigo,
		ARE_codigo,
		USU_codigo
	)
VALUES
	(
		@INC_fecha,
		@INC_hora,
		@INC_asunto,
		@INC_descripcion,
		@INC_documento,
		@INC_codigoPatrimonial,
		3,
		@CAT_codigo,
		@ARE_codigo,
		@USU_codigo
	);

END;

GO
	EXEC SP_Registrar_Incidencia_Admin '2024-06-07',
	'23:02',
	'No enciende',
	'averia',
	'S/D',
	'740899500326',
	3,
	2,
	5,
	1
SELECT
	INC_numero,
	INC_fecha,
	INC_hora,
	INC_asunto,
	INC_descripcion,
	INC_documento,
	INC_codigoPatrimonial,
	e.EST_descripcion,
	c.CAT_nombre,
	a.ARE_nombre,
	u.USU_nombre
FROM
	INCIDENCIA i
	INNER JOIN ESTADO e ON e.EST_codigo = i.EST_codigo
	INNER JOIN CATEGORIA c ON c.CAT_codigo = i.CAT_codigo
	INNER JOIN AREA a ON a.ARE_codigo = i.ARE_codigo
	INNER JOIN USUARIO u ON u.USU_codigo = i.USU_codigo
SELECT
	INC_numero,
	INC_fecha,
	INC_hora,
	INC_asunto,
	INC_descripcion,
	INC_documento,
	INC_codigoPatrimonial,
	c.CAT_nombre,
	a.ARE_nombre
FROM
	INCIDENCIA i
	INNER JOIN CATEGORIA c ON c.CAT_codigo = i.CAT_codigo
	INNER JOIN AREA a ON a.ARE_codigo = i.ARE_codigo
SELECT
	INC_numero,
	INC_fecha,
	CONVERT(VARCHAR(5), INC_hora, 108) AS INC_hora,
	INC_asunto,
	INC_descripcion,
	INC_documento,
	INC_codigoPatrimonial,
	EST_codigo,
	CAT_codigo,
	ARE_codigo,
	USU_codigo
FROM
	INCIDENCIA;

GO
	CREATE PROCEDURE sp_InsertarRecepcionActualizarIncidencia @REC_fecha DATE,
	@REC_hora TIME,
	@INC_numero INT,
	@PRI_codigo INT,
	@IMP_codigo INT,
	@USU_codigo INT AS BEGIN
SET
	NOCOUNT ON;

BEGIN TRY BEGIN TRANSACTION;

-- Insertar la nueva recepción
INSERT INTO
	RECEPCION (
		REC_fecha,
		REC_hora,
		INC_numero,
		PRI_codigo,
		IMP_codigo,
		USU_codigo,
		EST_codigo
	)
VALUES
	(
		@REC_fecha,
		@REC_hora,
		@INC_numero,
		@PRI_codigo,
		@IMP_codigo,
		@USU_codigo,
		4
	);

-- Actualizar el estado de la incidencia
UPDATE
	INCIDENCIA
SET
	EST_codigo = 4
WHERE
	INC_numero = @INC_numero;

COMMIT TRANSACTION;

END TRY BEGIN CATCH ROLLBACK TRANSACTION;

THROW;

END CATCH
END;