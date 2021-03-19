alter session set "_ORACLE_SCRIPT"=true;
select privilege from user_sys_privs;


CREATE USER ADMINI IDENTIFIED BY ADMINI DEFAULT TABLESPACE USUARIOSPROYECTO;
GRANT ALL PRIVILEGES TO Administrador;
GRANT EXECUTE ANY PROCEDURE TO Administrador;
GRANT UNLIMITED TABLESPACE TO Administrador;

--DROP TABLESPACE jobsProyecto;
drop tablespace usuariosProyecto including contents and datafiles;
DROP TABLESPACE tablasProyecto including contents and datafiles; 

--create tablespace jobsProyecto DATAFILE 'C:\APP\PROXAR\PRODUCT\18.0.0\ORADATA\XE\jobsProyecto.DBF' SIZE 1M AUTOEXTEND ON;
create tablespace usuariosProyecto DATAFILE 'C:\APP\PROXAR\PRODUCT\18.0.0\ORADATA\XE\usuariosProyecto.DBF' SIZE 1M AUTOEXTEND ON;
create tablespace tablasProyecto DATAFILE 'C:\APP\PROXAR\PRODUCT\18.0.0\ORADATA\XE\tablasProyecto.DBF' SIZE 1M AUTOEXTEND ON;

DROP ROLE GRUPOUSUARIO;
CREATE ROLE GRUPOUSUARIO;

--GRANT select on all_tables to GRUPOUSUARIO;
GRANT CREATE SESSION TO GRUPOUSUARIO;
GRANT CREATE TABLE to GRUPOUSUARIO;
GRANT CREATE ANY JOB TO GRUPOUSUARIO;
GRANT CREATE TABLESPACE to GRUPOUSUARIO;

DROP USER usuario_1 CASCADE;
DROP USER usuario_2 CASCADE;
DROP USER usuario_3 CASCADE;
DROP USER usuario_4 CASCADE;
DROP USER usuario_5 CASCADE;
DROP USER usuario_6 CASCADE;
DROP USER usuario_7 CASCADE;

CREATE USER USUARIO_1 IDENTIFIED BY USUARIO_1 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_2 IDENTIFIED BY USUARIO_2 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_3 IDENTIFIED BY USUARIO_3 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_4 IDENTIFIED BY USUARIO_4 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_5 IDENTIFIED BY USUARIO_5 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_6 IDENTIFIED BY USUARIO_6 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_7 IDENTIFIED BY USUARIO_7 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_9 IDENTIFIED BY USUARIO_7 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_9 IDENTIFIED BY USUARIO_8 DEFAULT TABLESPACE USUARIOSPROYECTO;

GRANT grupousuario to usuario_1;  
GRANT grupousuario to usuario_2;  
GRANT grupousuario to usuario_3;  
GRANT grupousuario to usuario_4;  
GRANT grupousuario to usuario_5;  
GRANT grupousuario to usuario_6;  
GRANT grupousuario to usuario_7;  


DROP TABLESPACE jobsProyecto;
create tablespace jobsProyecto DATAFILE 'C:\APP\PROXAR\PRODUCT\18.0.0\ORADATA\XE\jobsProyecto.DBF' SIZE 1M AUTOEXTEND ON;

--PERMISOS PARA CREAR TABLLESPACE

drop view informacion_tabla;
drop view permisos_usuario;
drop view indices_tabla;
drop view tabla_comentario;
drop view restricciones_tabla;
drop view col_nombre_tipo; 
drop view columna_comentarios; 
drop view informacion_interna_tabla; 

CREATE OR REPLACE VIEW col_nombre_tipo AS
	SELECT col.TABLE_NAME AS tabla, col.COLUMN_NAME AS columnas, col.data_type AS tipo
	FROM sys.all_tab_columns col;
	/

CREATE OR REPLACE VIEW columna_comentarios AS
	SELECT TABLE_NAME AS tabla, comments AS comentario
	FROM sys.all_tab_comments;
	/

CREATE OR REPLACE VIEW informacion_interna_tabla AS
	SELECT col.tabla, col.columnas, col.tipo, com.comentario
	FROM col_nombre_tipo col, columna_comentarios com
	WHERE col.tabla = com.tabla;
	/

CREATE OR REPLACE VIEW restricciones_tabla AS
	SELECT owner, CONSTRAINT_NAME AS restriccion, TABLE_NAME AS tabla
	FROM sys.ALL_CONSTRAINTS;
	/

CREATE OR REPLACE VIEW tabla_comentario AS
	SELECT com.TABLE_NAME AS tabla, com.comments AS tabla_comentario
	FROM sys.all_tab_comments com;
	/

CREATE OR REPLACE VIEW indices_tabla AS
	SELECT
		TABLE_NAME AS tabla,
		index_name AS indice,
		table_owner AS owner,
		tablespace_name AS tablespace,
		distinct_keys,
		status,
		indexing
	from ALL_INDEXES;
	/

CREATE OR REPLACE VIEW informacion_tabla AS
	SELECT
		res.tabla,
		res.owner,
		res.restriccion,
		com.tabla_comentario,
		ind.indice,
		ind.tablespace,
		ind.status,
		ind.indexing
	FROM restricciones_tabla res, tabla_comentario com, indices_tabla ind
	WHERE res.tabla = com.tabla AND res.tabla = ind.tabla AND res.owner = ind.owner;

--------------------------------------------------------------------------------------------

--SACAR LA TABLA ESPECIFICA CON SUS ATRIBUTOS
select  informacion_interna_tabla.tabla,
        informacion_interna_tabla.columnas,
        informacion_interna_tabla.tipo,
        informacion_interna_tabla.comentario
from informacion_interna_tabla,
    (
        SELECT TABLE_NAME
        FROM ALL_TABLES
        WHERE TABLESPACE_NAME = 'TABLASPROYECTO' AND TABLE_NAME = 'PRIMERATABLAUSUARIO_1'
        ORDER BY TABLE_NAME
    )tablas
where informacion_interna_tabla.TABLA = tablas.TABLE_NAME;

--SACAR LAS TABLAS DE UN TABLESPACE
SELECT TABLE_NAME
FROM ALL_TABLES
WHERE TABLESPACE_NAME = 'TABLASPROYECTO'
ORDER BY TABLE_NAME;

--SACAR TABLAS Y SUS DUEÑOS
select TABLE_NAME, OWNER
from all_tables 
where owner <>'USUARIO_1' and tablespace_name = 'TABLASPROYECTO'
order by table_name;

-- SACAR JOB, DUEÑO DEL JOB Y SI ESTÁ ACCTIVO O NO
create or replace view vista_Jobs as
    select owner, job_name, enabled 
    from all_scheduler_jobs, (
        SELECT username
        FROM ALL_USERS
    ) usuarios 
    where owner = usuarios.username;

SELECT *
FROM vista_jobs;

-- Sacar usuarios
create or replace view vista_usuarios as
    SELECT username, user_id
    FROM ALL_USERS;

-- Sacar tablespaces y sus tamaños y eso

Select t.tablespace_name,  
    ROUND(MAX(d.bytes)/1024/1024,2) AS Tamaño,
    ROUND((MAX(d.bytes)/1024/1024) - 
    (SUM(decode(f.bytes, NULL,0, f.bytes))/1024/1024),2) AS Usados,   
    ROUND(SUM(decode(f.bytes, NULL,0, f.bytes))/1024/1024,2) AS Libres
FROM DBA_FREE_SPACE f, DBA_DATA_FILES d,  DBA_TABLESPACES t  
WHERE t.tablespace_name = d.tablespace_name     AND 
    f.tablespace_name(+) = d.tablespace_name    AND 
    f.file_id(+) = d.file_id                    and ( t.tablespace_name like '%PROYECTO%') 
GROUP BY t.tablespace_name,   
        d.file_name,   t.pct_increase, t.status 
ORDER BY 1,3 DESC;
