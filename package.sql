-- para conseguir todas las tablas se hace un query a all_tables
-- tiene los campos table_name y owner

CREATE OR REPLACE VIEW col_nombre_tipo AS
	SELECT col.TABLE_NAME AS tabla, col.COLUMN_NAME AS nom_col, col.data_type AS tipo
	FROM sys.all_tab_columns col, sys.all_tab_comments com
	WHERE col.TABLE_NAME = com.TABLE_NAME;
	/

CREATE OR REPLACE VIEW tabla_comentarios AS
	SELECT TABLE_NAME AS tabla, comments AS comentario
	FROM sys.all_tab_comments;
	/

CREATE OR REPLACE VIEW con_nombre_tipo_comentario AS
	SELECT col.TABLE_NAME AS tabla, col.COLUMN_NAME AS nom_col, col.data_type AS tipo, com.comments AS comentario
	FROM sys.all_tab_columns col, sys.all_col_comments com
	WHERE col.TABLE_NAME = com.TABLE_NAME AND col.COLUMN_NAME = com.COLUMN_NAME;
	/

	-- WHERE TABLE_NAME = nombre_tabla;

-- CREATE OR REPLACE
-- 	FUNCTION conseguir_comentario_columna (nombre_tabla varchar2, nombre_columna varchar2)
-- 	RETURN sys_refcursor
-- IS
-- 	cursor_columnas_tabla sys_refcursor;
-- BEGIN
-- 	OPEN cursor_columnas_tabla FOR
-- 		SELECT comments FROM sys.all_col_comments
-- 		WHERE
-- 			TABLE_NAME = nombre_tabla
-- 			AND COLUMN_NAME = nombre_columna;
--
-- 	return cursor_columnas_tabla;
-- END conseguir_comentario_columna;
-- /

-- select col.table_name, col.column_name from sys.all_tab_columns col where table_name = 'VENTAS';

-- CREATE OR REPLACE FUNCTION run_cursor (cursor_vals sys_refcursor)
-- RETURN
-- IS
-- 	v_order_rec sys.all_tab_columns%ROWTYPE;
-- BEGIN
-- 	FOR val IN cursor_vals LOOP
--         dbms_output.put_line (val);
-- 	END LOOP;
-- 	-- LOOP
--
-- 	-- 	FETCH cursor_vals INTO v_order_rec;
-- 	-- 	EXIT WHEN cursor_vals%NOTFOUND;
--     --     dbms_output.put_line(v_order_rec);
--     -- END LOOP;
--
--     RETURN(v_ret_val);
-- END run_cursor;
-- /

-- select col.table_name, col.column_name from sys.all_tab_columns col where table_name = 'VENTAS';
