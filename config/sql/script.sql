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
	ROL_codigo SMALLINT IDENTITY(1,1) PRIMARY KEY,
	ROL_nombre VARCHAR(20)
);
GO

INSERT INTO ROL (ROL_nombre) VALUES ('Administrador');
INSERT INTO ROL (ROL_nombre) VALUES ('Usuario');
INSERT INTO ROL (ROL_nombre) VALUES ('Soporte');

-- CREACION DE LA TABLA PERSONA
CREATE TABLE PERSONA (
	PER_codigo SMALLINT IDENTITY(1,1) PRIMARY KEY,
	PER_dni CHAR(8) UNIQUE NOT NULL,
	PER_nombres VARCHAR(20) NOT NULL,
	PER_apellidoPaterno VARCHAR(15) NOT NULL,
	PER_apellidoMaterno VARCHAR(15) NOT NULL,
	PER_email VARCHAR(45) NOT NULL,
	PER_celular CHAR(9) UNIQUE NOT NULL
);
GO

INSERT INTO PERSONA (PER_dni, PER_nombres, PER_apellidoPaterno, PER_apellidoMaterno, PER_email, PER_celular) VALUES 
('70555743','Jhonatan', 'Mantilla', 'Miñano', 'jhonatanmm.1995@gmail.com', '950212909');
INSERT INTO dbo.PERSONA(PER_dni,PER_nombres,PER_apellidoPaterno,PER_apellidoMaterno,PER_celular,PER_email) VALUES
('70555742','Gustavo','Mantilla','Miñano', '950212913','gammgush@gmail.com');
INSERT INTO dbo.PERSONA(PER_dni,PER_nombres,PER_apellidoPaterno,PER_apellidoMaterno,PER_celular,PER_email) VALUES
('98765423','Maria','Blas','Vera', '975168936','mblasv@gmail.com');

-- CREACION DE LA TABLA AREA
CREATE TABLE AREA (
	ARE_codigo SMALLINT IDENTITY(1,1) PRIMARY KEY,
	ARE_nombre VARCHAR(60) UNIQUE NOT NULL
);
GO


INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Informática y Sistemas');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia Municipal');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Contabilidad');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Alcaldía');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Tesoreria');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Seccion de Almacen');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Abastecimientos y Control Patrimonial');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Unidad de Control Patrimonial');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Caja General');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia de Recursos Humanos');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia de Desarrollo Económico Local');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Area de Liquidación de Obras');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Habilitaciones Urbanas y Catrasto');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Escalafón');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Secretaría General');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Programa del Vaso de Leche - Provale');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Demuna');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Omaped');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Salud');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia de Administración Tributaria');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Servicio Social');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Unidad de Relaciones Públicas y Comunicaciones');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia de Gestión Ambiental');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia de Asesoría Jurídica');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia De Planificación  Y Modernización Institucional');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Gestión y Desarrollo de Recursos Humanos');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia de Desarrollo Social');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Educación');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Programas Sociales');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Licencias');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Policía Municipal');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Registro Civil');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Mantenimiento de Obras Públicas');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia de Desarrollo Urbano');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Ejecutoria Coactiva');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Estudios y Proyectos');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Obras');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Procuraduría Pública Municipal');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia de Administración y Finanzas');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Defensa Civil');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Juventud, Deporte y Cultura');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Áreas Verdes');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Seguridad Ciudadana');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Órgano de Control Institucional');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Unidad Local de Empadronamiento (ULE)');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Unidad de Atención al Usuario y Trámite Documentario');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia de Seguridad Ciudadana');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Aabstecimiento');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Participación Vecinal');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Gerencia de Planeamiento, Presupuesto Y Modernización');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Transporte, Tránsito y Seguridad Vial');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Archivo Central');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Equipo Mecánico y Maestranza');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Subgerencia de Limpieza Pública');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Bienestar social');
INSERT INTO dbo.AREA(ARE_nombre) VALUES ('Orientación Tributaria');

-- CREACION DE LA TABLA ESTADO
CREATE TABLE ESTADO (
	EST_codigo SMALLINT IDENTITY(1,1) PRIMARY KEY,
	EST_descripcion VARCHAR(20)
);
GO

INSERT INTO ESTADO (EST_descripcion) VALUES ('Activo');
INSERT INTO ESTADO (EST_descripcion) VALUES ('Inactivo');
INSERT INTO ESTADO (EST_descripcion) VALUES ('Abierta');
INSERT INTO ESTADO (EST_descripcion) VALUES ('Recepcionado');
INSERT INTO ESTADO (EST_descripcion) VALUES ('Cerrado');
GO

-- CREACION DE LA TABLA USUARIO
CREATE TABLE USUARIO (
	USU_codigo SMALLINT IDENTITY(1,1) PRIMARY KEY,
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

INSERT INTO USUARIO (USU_nombre, USU_password, PER_codigo, ROL_codigo, ARE_codigo, EST_codigo) 
VALUES ('GAMM95','123456', 1,3,1,1);
INSERT INTO USUARIO (USU_nombre, USU_password, PER_codigo, ROL_codigo, ARE_codigo, EST_codigo) 
VALUES ('GUSH98','123456',2,2,2,1);
GO

CREATE PROCEDURE SP_Usuario_login(
	@USU_usuario VARCHAR(20),
  @USU_password VARCHAR(10)
)
AS
BEGIN
    SET NOCOUNT ON;

    SELECT u.USU_nombre, u.USU_password, p.PER_nombres, p.PER_apellidoPaterno, r.ROL_nombre, a.ARE_nombre
    FROM USUARIO u
        INNER JOIN PERSONA p ON p.PER_codigo = u.PER_codigo
        INNER JOIN ROL r ON r.ROL_codigo = u.ROL_codigo
        INNER JOIN AREA a ON a.ARE_codigo = u.ARE_codigo
    WHERE u.USU_nombre = @USU_usuario AND u.USU_password = @USU_password;
END;
GO

CREATE TABLE PRIORIDAD(
	PRI_codigo INT IDENTITY(1,1),
	PRI_nombre VARCHAR(15) NOT NULL,
	CONSTRAINT pk_PRI_codigo PRIMARY KEY(PRI_codigo),
	CONSTRAINT uq_PRI_descripcion UNIQUE (PRI_nombre)
);
GO

INSERT INTO dbo.PRIORIDAD(PRI_nombre) VALUES ('Baja');
INSERT INTO dbo.PRIORIDAD(PRI_nombre) VALUES ('Media');
INSERT INTO dbo.PRIORIDAD(PRI_nombre) VALUES ('Alta');

CREATE TABLE dbo.CATEGORIA
(
	CAT_codigo INT IDENTITY(1,1),
	CAT_nombre VARCHAR(60) NOT NULL,
	CONSTRAINT pk_CAT_codigo PRIMARY KEY(CAT_codigo),
	CONSTRAINT uq_CAT_nombre UNIQUE (CAT_nombre)
);
GO

INSERT INTO dbo.CATEGORIA (CAT_nombre) VALUES ('Red inaccesible');
INSERT INTO dbo.CATEGORIA (CAT_nombre) VALUES ('Asistencia técnica');
INSERT INTO dbo.CATEGORIA (CAT_nombre) VALUES ('Generacion de usuario');
INSERT INTO dbo.CATEGORIA (CAT_nombre) VALUES ('Fallo de equipo de computo');
INSERT INTO dbo.CATEGORIA (CAT_nombre) VALUES ('Inaccesibilidad a Impresora');
INSERT INTO dbo.CATEGORIA (CAT_nombre) VALUES ('Correo corporativo');
INSERT INTO dbo.CATEGORIA (CAT_nombre) VALUES ('Reportes varios de sistemas informaticos');
INSERT INTO dbo.CATEGORIA (CAT_nombre) VALUES ('Otros');
INSERT INTO dbo.CATEGORIA (CAT_nombre) VALUES ('Inaccesibilidad a Sistemas Informaticos');




