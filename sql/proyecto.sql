alter session set "_ORACLE_SCRIPT"=true;

select privilege from user_sys_privs;

-- var tablespace_location varchar2(50);
-- exec :tablespace_location := 'C:\APP\PROXAR\PRODUCT\18.0.0\ORADATA\XE\';
-- exec :tablespace_location := '/opt/oracle/oradata/XE/';

-------------------------------------------------------------------------------
--                               inicio DROP                                 --
-------------------------------------------------------------------------------

-- usuarios -------------------------------------------------------------------

DROP USER usuario_1 CASCADE;
DROP USER usuario_2 CASCADE;
DROP USER usuario_3 CASCADE;
DROP USER usuario_4 CASCADE;
DROP USER usuario_5 CASCADE;
DROP USER usuario_6 CASCADE;
DROP USER usuario_7 CASCADE;
DROP USER usuario_8 CASCADE;
DROP USER usuario_9 CASCADE;

DROP USER adm CASCADE;

-- vistas ---------------------------------------------------------------------

DROP VIEW col_nombre_tipo;
DROP VIEW columna_comentarios;
DROP VIEW informacion_interna_tabla;
DROP VIEW restricciones_tabla;
DROP VIEW tabla_comentario;
DROP VIEW indices_tabla;
DROP VIEW informacion_tabla;
DROP VIEW permisos_usuario_tabla;
DROP VIEW espacio_usuario_usado;
DROP VIEW espacio_usuario_libre;
DROP VIEW espacio_usuario;

-- tablespaces ----------------------------------------------------------------
DROP TABLESPACE usuariosProyecto including contents and datafiles;
DROP TABLESPACE tablasProyecto including contents and datafiles;
DROP TABLESPACE jobsProyecto including contents and datafiles;

-- roles ----------------------------------------------------------------------

DROP ROLE GRUPOUSUARIO;

-------------------------------------------------------------------------------
--                                final DROP                                 --
-------------------------------------------------------------------------------

-------------------------------------------------------------------------------
--                                tablespaces                                --
-------------------------------------------------------------------------------

--create tablespace jobsProyecto DATAFILE 'C:\APP\PROXAR\PRODUCT\18.0.0\ORADATA\XE\jobsProyecto.DBF' SIZE 1M AUTOEXTEND ON;
create tablespace usuariosProyecto
    DATAFILE '/opt/oracle/oradata/XE/usuariosProyecto.DBF'
    SIZE 1M
    AUTOEXTEND ON;
create tablespace tablasProyecto
    DATAFILE '/opt/oracle/oradata/XE/tablasProyecto.DBF'
    SIZE 1M
    AUTOEXTEND ON;
create tablespace jobsProyecto
    DATAFILE '/opt/oracle/oradata/XE/jobsProyecto.DBF'
    SIZE 1M
    AUTOEXTEND ON;

-------------------------------------------------------------------------------
--                                   vistas                                  --
-------------------------------------------------------------------------------

-- informacion interna tabla --------------------------------------------------
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

-- informacion tabla ----------------------------------------------------------

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
	WHERE res.tabla = com.tabla
      AND res.tabla = ind.tabla
      AND res.owner = ind.owner;
    /

-- permisos usuario -----------------------------------------------------------

CREATE OR REPLACE VIEW permisos_usuario_tabla AS
    SELECT aa.TABLE_NAME AS tabla,
           pr.grantor,
           pr.grantee,
           pr.privilege AS privilegio
    FROM all_tables aa
    LEFT JOIN sys.all_tab_privs pr ON aa.TABLE_NAME = pr.TABLE_NAME;
    /

-- espacio usuario ------------------------------------------------------------

CREATE OR REPLACE VIEW espacio_usuario_usado AS
    SELECT TABLESPACE_NAME, SUM(BYTES) AS bytes, SUM(BLOCKS) AS bloques
    FROM USER_SEGMENTS
    GROUP BY TABLESPACE_NAME;
    /

CREATE OR REPLACE VIEW espacio_usuario_libre AS
    SELECT TABLESPACE_NAME, SUM(BYTES) AS bytes, SUM(BLOCKS) AS bloques
    FROM USER_FREE_SPACE
    GROUP BY TABLESPACE_NAME;
    /

CREATE OR REPLACE VIEW espacio_usuario AS
    SELECT usado.TABLESPACE_NAME,
           usado.bytes AS bytes_usados,
           usado.bloques AS bloques_usados,
           libre.bytes AS bytes_libres,
           libre.bloques AS bloques_libres
    FROM espacio_usuario_usado usado, espacio_usuario_libre libre
    WHERE usado.tablespace_name = libre.tablespace_name;
    /

-- jobs -----------------------------------------------------------------------

create or replace view vista_Jobs as
    select owner, job_name, enabled
    from all_scheduler_jobs, (
        SELECT username
        FROM ALL_USERS
    ) usuarios
    where owner = usuarios.username;


-- utiles ---------------------------------------------------------------------

-- Sacar usuarios
create or replace view vista_usuarios as
    SELECT username, user_id
    FROM ALL_USERS;

-------------------------------------------------------------------------------
--                               permisos grupo                              --
-------------------------------------------------------------------------------

CREATE ROLE GRUPOUSUARIO;

--GRANT select on all_tables to GRUPOUSUARIO;
GRANT CREATE SESSION TO GRUPOUSUARIO;
GRANT CREATE TABLE to GRUPOUSUARIO;
GRANT CREATE ANY JOB TO GRUPOUSUARIO;
GRANT CREATE TABLESPACE to GRUPOUSUARIO;

-------------------------------------------------------------------------------
--                             creacion usuarios                             --
-------------------------------------------------------------------------------

CREATE USER USUARIO_1 IDENTIFIED BY USUARIO_1 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_2 IDENTIFIED BY USUARIO_2 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_3 IDENTIFIED BY USUARIO_3 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_4 IDENTIFIED BY USUARIO_4 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_5 IDENTIFIED BY USUARIO_5 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_6 IDENTIFIED BY USUARIO_6 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_7 IDENTIFIED BY USUARIO_7 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_8 IDENTIFIED BY USUARIO_8 DEFAULT TABLESPACE USUARIOSPROYECTO;
CREATE USER USUARIO_9 IDENTIFIED BY USUARIO_9 DEFAULT TABLESPACE USUARIOSPROYECTO;

GRANT grupousuario to usuario_1;
GRANT grupousuario to usuario_2;
GRANT grupousuario to usuario_3;
GRANT grupousuario to usuario_4;
GRANT grupousuario to usuario_5;
GRANT grupousuario to usuario_6;
GRANT grupousuario to usuario_7;

-- admin ----------------------------------------------------------------------
CREATE USER adm IDENTIFIED BY adm DEFAULT TABLESPACE USUARIOSPROYECTO;

GRANT ALL PRIVILEGES TO adm;
GRANT EXECUTE ANY PROCEDURE TO adm;
GRANT UNLIMITED TABLESPACE TO adm;


--SACAR LA TABLA ESPECIFICA CON SUS ATRIBUTOS
-- select  informacion_interna_tabla.tabla,
--         informacion_interna_tabla.columnas,
--         informacion_interna_tabla.tipo,
--         informacion_interna_tabla.comentario
-- from informacion_interna_tabla,
--     (
--         SELECT TABLE_NAME
--         FROM ALL_TABLES
--         WHERE TABLESPACE_NAME = 'TABLASPROYECTO' AND TABLE_NAME = 'PRIMERATABLAUSUARIO_1'
--         ORDER BY TABLE_NAME
--     )tablas
-- where informacion_interna_tabla.TABLA = tablas.TABLE_NAME;

--SACAR LAS TABLAS DE UN TABLESPACE
-- SELECT TABLE_NAME
-- FROM ALL_TABLES
-- WHERE TABLESPACE_NAME = 'TABLASPROYECTO'
-- ORDER BY TABLE_NAME;

--SACAR TABLAS Y SUS DUEÑOS
-- select TABLE_NAME, OWNER
-- from all_tables
-- where owner <>'USUARIO_1' and tablespace_name = 'TABLASPROYECTO'
-- order by table_name;

-- SACAR JOB, DUEÑO DEL JOB Y SI ESTÁ ACCTIVO O NO

-- SELECT *
-- FROM vista_jobs;


-- Sacar tablespaces y sus tamaños y eso

-- Select t.tablespace_name,
--     ROUND(MAX(d.bytes)/1024/1024,2) AS Tamaño,
--     ROUND((MAX(d.bytes)/1024/1024) -
--     (SUM(decode(f.bytes, NULL,0, f.bytes))/1024/1024),2) AS Usados,
--     ROUND(SUM(decode(f.bytes, NULL,0, f.bytes))/1024/1024,2) AS Libres
-- FROM DBA_FREE_SPACE f, DBA_DATA_FILES d,  DBA_TABLESPACES t
-- WHERE t.tablespace_name = d.tablespace_name     AND
--     f.tablespace_name(+) = d.tablespace_name    AND
--     f.file_id(+) = d.file_id                    and ( t.tablespace_name like '%PROYECTO%')
-- GROUP BY t.tablespace_name,
--         d.file_name,   t.pct_increase, t.status
-- ORDER BY 1,3 DESC;

