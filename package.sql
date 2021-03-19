-- para conseguir todas las tablas se hace un query a all_tables
-- tiene los campos table_name y owner

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
	from sys.ALL_INDEXES;
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

--------------------------------------------------------------------------------------------

CREATE OR REPLACE VIEW permisos_usuario_tabla AS
    select aa.TABLE_NAME AS tabla,
           pr.grantor,
           pr.grantee,
           pr.privilege AS privilegio
    from all_tables aa
    LEFT JOIN sys.all_tab_privs pr on aa.table_name = pr.TABLE_NAME;

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

-- SELECT *
-- from ALL_TABLES T, ALL_TAB_PRIVS P
-- where T.table_name = 'VENTAS';
