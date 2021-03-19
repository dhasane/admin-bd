select TABLE_NAME, OWNER
from all_tables 
where owner <>'USUARIO_1' and tablespace_name = 'TABLASPROYECTO'
order by table_name;


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

-----------------------------------------------------------------------------------------

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

SELECT owner, SUM(BYTES)/1024/1024 
  FROM DBA_SEGMENTS
 GROUP BY owner;

select owner
from restricciones_tabla
group by owner;

drop view informacion_tabla;
drop view permisos_usuario;
drop view indices_tabla;

drop view tabla_comentario;
drop view restricciones_tabla;
drop view col_nombre_tipo; 
drop view columna_comentarios; 
drop view informacion_interna_tabla; 


-- CREATE OR REPLACE VIEW informacion_tabla AS
-- 	SELECT col.tabla, col.columnas, col.tipo, col.comentario
-- 	FROM RESTRICCIONES_TABLA res, TABLA_COMENTARIO tab, CON_NOMBRE_TIPO_COMENTARIO col
-- 	WHERE res.tabla = tab.tabla AND res.tabla = com.tabla;
-- 	/

-- BEGIN
--    FOR R IN
--    (SELECT TABLE_NAME, OWNER FROM ALL_TABLES WHERE TABLESPACE_NAME = 'TABLASPROYECTO') LOOP
--       EXECUTE IMMEDIATE 'grant select on '||R.OWNER||'.'||R.TABLE_NAME||' to grupousuario';
--    END LOOP;
-- END;
    

GRANT grupousuario to usuario_1;  
GRANT grupousuario to usuario_2;  
GRANT grupousuario to usuario_3;  
GRANT grupousuario to usuario_4;  
GRANT grupousuario to usuario_5;  
GRANT grupousuario to usuario_6;  

GRANT select on all_tables to grupousuario;

alter session set "_ORACLE_SCRIPT"=true;

GRANT CREATE SESSION TO usuario_1;
GRANT CREATE SESSION TO usuario_2;
GRANT CREATE SESSION TO usuario_3;
GRANT CREATE SESSION TO usuario_4;
GRANT CREATE SESSION TO usuario_5;
GRANT CREATE SESSION TO usuario_6;
GRANT CREATE SESSION TO usuario_7;
GRANT CREATE SESSION TO usuario_8;


GRANT CREATE TABLE to usuario_1;
GRANT CREATE TABLE to usuario_2;
GRANT CREATE TABLE to usuario_3;
GRANT CREATE TABLE to usuario_4;
GRANT CREATE TABLE to usuario_5;
GRANT CREATE TABLE to usuario_6;
GRANT CREATE TABLE to usuario_7;
GRANT CREATE TABLE to usuario_8;


SELECT TABLE_NAME
FROM ALL_TABLES
WHERE TABLESPACE_NAME = 'TABLASPROYECTO'
ORDER BY TABLE_NAME;



BEGIN
   FOR R IN
   (SELECT TABLE_NAME, OWNER FROM ALL_TABLES WHERE TABLESPACE_NAME = 'TABLASPROYECTO') LOOP
      EXECUTE IMMEDIATE 'grant select on '||R.OWNER||'.'||R.TABLE_NAME||' to grupousuario';
   END LOOP;
END;


GRANT CREATE TABLESPACE to USUARIO_1;
GRANT CREATE TABLESPACE to USUARIO_3;


create tablespace jobsProyecto DATAFILE 'C:\APP\PROXAR\PRODUCT\18.0.0\ORADATA\XE\jobsProyecto.DBF' SIZE 1M AUTOEXTEND ON;

GRANT CREATE ANY JOB TO usuario_1;
GRANT CREATE ANY JOB TO usuario_2;
GRANT CREATE ANY JOB TO usuario_3;
GRANT CREATE ANY JOB TO usuario_4;
GRANT CREATE ANY JOB TO usuario_5;

BEGIN
DBMS_SCHEDULER.DISABLE('MI_PRIMER_JOB_USUARIO_3');
END;
/

BEGIN
DBMS_SCHEDULER.ENABLE('MI_PRIMER_JOB_USUARIO_1');
END;
/

-- SACAR JOB, DUEÑO DEL JOB Y SI ESTÁ ACCTIVO O NO
select owner, job_name, enabled 
from all_scheduler_jobs, (
    SELECT username
    FROM DBA_USERS
    WHERE default_tablespace='USUARIOS'
) usuarios 
where owner = usuarios.username;

-- Sacar usuarios
SELECT username, user_id
FROM DBA_USERS
WHERE default_tablespace='USUARIOS';


-- Sacar tablespaces y sus tamaños y eso
Select t.tablespace_name,  
    ROUND(MAX(d.bytes)/1024/1024,2) AS Tamaño,
    ROUND((MAX(d.bytes)/1024/1024) - 
    (SUM(decode(f.bytes, NULL,0, f.bytes))/1024/1024),2) AS Usados,   
    ROUND(SUM(decode(f.bytes, NULL,0, f.bytes))/1024/1024,2) AS Libres
FROM DBA_FREE_SPACE f, DBA_DATA_FILES d,  DBA_TABLESPACES t  
WHERE t.tablespace_name = d.tablespace_name     AND 
    f.tablespace_name(+) = d.tablespace_name    AND 
    f.file_id(+) = d.file_id                    and ( t.tablespace_name like '%PROYECTO%' 
                                                or t.tablespace_name like '%USUARIOS%') 
    GROUP BY t.tablespace_name,   
        d.file_name,   t.pct_increase, t.status 
    ORDER BY 1,3 DESC;




