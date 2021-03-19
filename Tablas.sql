alter session set "_ORACLE_SCRIPT"=true;

CREATE ROLE GRUPOUSUARIO;
/*
BEGIN
   FOR R IN
   (SELECT TABLE_NAME, OWNER FROM ALL_TABLES WHERE TABLESPACE_NAME = 'TABLASPROYECTO') LOOP
      EXECUTE IMMEDIATE 'grant select on '||R.OWNER||'.'||R.TABLE_NAME||' to grupousuario';
   END LOOP;
END;
*/

GRANT CREATE SESSION TO GRUPOUSUARIO;
GRANT CREATE TABLE to GRUPOUSUARIO;

CREATE USER USUARIO_1 IDENTIFIED BY USUARIO_1 DEFAULT TABLESPACE USUARIOS;
CREATE USER USUARIO_2 IDENTIFIED BY USUARIO_2 DEFAULT TABLESPACE USUARIOS;
CREATE USER USUARIO_3 IDENTIFIED BY USUARIO_3 DEFAULT TABLESPACE USUARIOS;
CREATE USER USUARIO_4 IDENTIFIED BY USUARIO_4 DEFAULT TABLESPACE USUARIOS;
CREATE USER USUARIO_5 IDENTIFIED BY USUARIO_5 DEFAULT TABLESPACE USUARIOS;
CREATE USER USUARIO_6 IDENTIFIED BY USUARIO_6 DEFAULT TABLESPACE USUARIOS;
CREATE USER USUARIO_7 IDENTIFIED BY USUARIO_7 DEFAULT TABLESPACE USUARIOS;

GRANT GRUPOUSUARIO TO USUARIO_1;
GRANT GRUPOUSUARIO TO USUARIO_2;
GRANT GRUPOUSUARIO TO USUARIO_3;
GRANT GRUPOUSUARIO TO USUARIO_4;
GRANT GRUPOUSUARIO TO USUARIO_5;
GRANT GRUPOUSUARIO TO USUARIO_6;
GRANT GRUPOUSUARIO TO USUARIO_7;



-- TABLESPACE
-- TABLESPACE PARA USUARIOS = 'USUARIOS'
-- TABLESPACE PARA TABLAS = 'TABLASPROYECTO'



--DROPS 
DROP TABLE Empleado CASCADE CONSTRAINTS;
DROP TABLE Habitaciones CASCADE CONSTRAINTS;
DROP TABLE Camas CASCADE CONSTRAINTS;
DROP TABLE Pacientes CASCADE CONSTRAINTS;

--CREATES
CREATE TABLE Empleado
(
    username VARCHAR2(30),
    email VARCHAR2(30),
    contraseña VARCHAR2(30),
    rol VARCHAR2(30),
    activo CHAR, CHECK (activo in ('S', 'N')),
    PRIMARY KEY (username)
) tablespace tablasProyecto;

CREATE TABLE Habitaciones
(
    numero_hab INT
) tablespace tablasProyecto;

CREATE TABLE Camas
(
    numero INT,
    habitacion_numero INT,
    paciente_id INT,
    disponible CHAR, CHECK (disponible in ('S', 'N'))
) tablespace tablasProyecto;

CREATE TABLE Pacientes
(
    id INT,
    nombre VARCHAR2(30),
    apellido VARCHAR2(30),
    prioridad VARCHAR2(30),
    diagnostico VARCHAR2(30),
    fecha_ingreso DATE,
    duracion_dias INT,
    nombre_medico VARCHAR2(30)
) tablespace tablasProyecto;
 

--Alters
ALTER TABLE Habitaciones ADD CONSTRAINT numero_habitacion_pk PRIMARY KEY (numero_hab);
ALTER TABLE Camas ADD CONSTRAINT numero_camas_pk PRIMARY KEY (numero);
ALTER TABLE Pacientes ADD CONSTRAINT id_pk PRIMARY KEY (id);
ALTER TABLE Camas ADD CONSTRAINT cama_habitacion_fk FOREIGN KEY (habitacion_numero) REFERENCES Habitaciones (numero_hab) ON DELETE CASCADE;
ALTER TABLE Camas ADD CONSTRAINT cama_paciente_fk FOREIGN KEY (paciente_id) REFERENCES Pacientes (id) ON DELETE CASCADE;
ALTER TABLE Pacientes ADD CONSTRAINT pacientes_medico_fk FOREIGN KEY (nombre_medico) REFERENCES Empleado (username) ON DELETE CASCADE;

--Inserts
--Empleado
INSERT INTO Empleado VALUES ('doctor_javier', 'doctor_javier@gmail.com', 'doctor_javier', 'medico', 'S' ); 
INSERT INTO Empleado VALUES ('doctora_estela', 'doctora_estela@gmail.com', 'doctora_estela', 'gerente', 'S' ); 
INSERT INTO Empleado VALUES ('doctora_monica', 'doctora_monica@gmail.com', 'doctora_monica', 'medico', 'N' ); 
INSERT INTO Empleado VALUES ('doctor_esteban', 'doctor_esteban@gmail.com', 'doctor_esteban', 'enfermero', 'N' ); 
INSERT INTO Empleado VALUES ('doctor_miguel', 'doctor_miguel@gmail.com', 'doctor_miguel', 'medico', 'S' ); 
INSERT INTO Empleado VALUES ('doctora_diana', 'doctora_diana@gmail.com', 'doctora_diana', 'enfermera', 'N' ); 
INSERT INTO Empleado VALUES ('doctora_ana', 'doctora_ana@gmail.com', 'doctora_ana', 'medica', 'S' );
INSERT INTO Empleado VALUES ('doctor_juan', 'doctor_juan@gmail.com', 'doctor_juan', 'enfermero', 'S' );
INSERT INTO Empleado VALUES ('doctora_marcela', 'doctora_marcela@gmail.com', 'doctora_marcela', 'enfermera', 'N' );
INSERT INTO Empleado VALUES ('doctor_cristian', 'doctor_cristian@gmail.com', 'doctor_cristian', 'gerente', 'S' );

--Habitaciones
INSERT INTO Habitaciones VALUES (100); 
INSERT INTO Habitaciones VALUES (101); 
INSERT INTO Habitaciones VALUES (102); 
INSERT INTO Habitaciones VALUES (103); 
INSERT INTO Habitaciones VALUES (104); 
INSERT INTO Habitaciones VALUES (105); 
INSERT INTO Habitaciones VALUES (106); 
INSERT INTO Habitaciones VALUES (107); 
INSERT INTO Habitaciones VALUES (108); 
INSERT INTO Habitaciones VALUES (109); 

--Pacientes
INSERT INTO Pacientes VALUES (001, 'Amelia', 'Arias', 'Alta', 'COVID-19', TO_DATE('10/01/21', 'DD/MM/YYYY'), 30, 'doctor_javier'); 
INSERT INTO Pacientes VALUES (002, 'Oscar', 'Barrera', 'Baja', 'Amigdalitis', TO_DATE('18/02/21', 'DD/MM/YYYY'), 8, 'doctora_monica'); 
INSERT INTO Pacientes VALUES (003, 'Pablo', 'Quintero', 'Media', 'Varicela', TO_DATE('05/03/21', 'DD/MM/YYYY'), 15, 'doctor_miguel'); 
INSERT INTO Pacientes VALUES (004, 'Andrea', 'Casas', 'Baja', 'Conjuntivitis', TO_DATE('10/01/21', 'DD/MM/YYYY'), 3, 'doctor_javier'); 
INSERT INTO Pacientes VALUES (005, 'Victoria', 'Zapata', 'Media', 'Apendicitis', TO_DATE('31/01/21', 'DD/MM/YYYY'), 10, 'doctora_ana'); 
INSERT INTO Pacientes VALUES (006, 'Felipe', 'Herrera', 'Alta', 'Derrame', TO_DATE('20/03/21', 'DD/MM/YYYY'), 30, 'doctora_monica'); 
INSERT INTO Pacientes VALUES (007, 'Margarita', 'Diaz', 'Media', 'Torcedura', TO_DATE('14/02/21', 'DD/MM/YYYY'), 2, 'doctor_miguel'); 
INSERT INTO Pacientes VALUES (008, 'Kevin', 'Iturriaga', 'Media', 'Espasmos', TO_DATE('03/03/21', 'DD/MM/YYYY'), 2, 'doctora_ana'); 
INSERT INTO Pacientes VALUES (009, 'Susana', 'Sabogal', 'Media', 'Otitis', TO_DATE('02/04/21', 'DD/MM/YYYY'), 4, 'doctora_monica'); 
INSERT INTO Pacientes VALUES (010, 'Salome', 'Carmona', 'Alta', 'Cancer', TO_DATE('27/12/20', 'DD/MM/YYYY'), 60, 'doctor_javier'); 

--Camas
INSERT INTO Camas VALUES (200, 102, 001, 'S'); 
INSERT INTO Camas VALUES (201, 109, 002, 'N'); 
INSERT INTO Camas VALUES (202, 104, 003, 'S'); 
INSERT INTO Camas VALUES (203, 107, 004, 'N'); 
INSERT INTO Camas VALUES (204, 106, 005, 'S'); 
INSERT INTO Camas VALUES (205, 105, 006, 'S'); 
INSERT INTO Camas VALUES (206, 108, 007, 'S'); 
INSERT INTO Camas VALUES (207, 103, 008, 'S'); 
INSERT INTO Camas VALUES (208, 100, 009, 'N'); 
INSERT INTO Camas VALUES (209, 101, 010, 'N'); 


