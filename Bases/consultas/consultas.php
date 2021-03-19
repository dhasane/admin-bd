<?php
    include_once dirname(__FILE__) . '/../configuracion/configuracion.php';
    
    function lista_Usuarios()
    {
        $conexión = oci_connect(USUARIO_DB,USUARIO_PASS,HOST_DB);

        if (!$conexión) 
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Preparar la sentencia
        $stid = oci_parse($conexión, "  SELECT username, user_id
                                        FROM DBA_USERS
                                        WHERE default_tablespace='USUARIOSPROYECTO'");
        if (!$stid) 
        {
            $e = oci_error($conexión);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Realizar la lógica de la consulta
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_close($conexión);
        return $stid;  
    }

    function lista_tablas_usuario($nombreUsuario)
    {
        $conexión = oci_connect(USUARIO_DB,USUARIO_PASS,HOST_DB);

        if (!$conexión) 
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Preparar la sentencia
        $stid = oci_parse($conexión, "  SELECT TABLE_NAME
                                        FROM ALL_TABLES
                                        WHERE owner = '".$nombreUsuario."'");
        if (!$stid) 
        {
            $e = oci_error($conexión);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Realizar la lógica de la consulta
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_close($conexión);
        return $stid;  
    }

    function lista_tablas_usuario_no_propietario($nombreUsuario)
    {
        $conexión = oci_connect(USUARIO_DB,USUARIO_PASS,HOST_DB);

        if (!$conexión) 
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Preparar la sentencia
        $stid = oci_parse($conexión, "  SELECT TABLE_NAME, OWNER
                                        FROM ALL_TABLES
                                        WHERE owner <> '".$nombreUsuario."' and TABLESPACE_NAME = 'TABLASPROYECTO'
                                        ORDER BY TABLE_NAME ");
        if (!$stid) 
        {
            $e = oci_error($conexión);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Realizar la lógica de la consulta
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_close($conexión);
        return $stid;  
    }

    function jobs_por_usuario()
    {
        $conexión = oci_connect(USUARIO_DB,USUARIO_PASS,HOST_DB);

        if (!$conexión) 
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Preparar la sentencia
        $stid = oci_parse($conexión, "  SELECT owner, job_name, enabled 
                                        FROM all_scheduler_jobs, 
                                        (
                                            SELECT username
                                            FROM DBA_USERS
                                            WHERE default_tablespace='USUARIOSPROYECTO'
                                        ) usuarios 
                                        WHERE owner = usuarios.username ");
        if (!$stid) 
        {
            $e = oci_error($conexión);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Realizar la lógica de la consulta
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_close($conexión);
        return $stid;  
    }

    function tablespaces()
    {
        $conexión = oci_connect(USUARIO_DB,USUARIO_PASS,HOST_DB);

        if (!$conexión) 
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Preparar la sentencia
        $stid = oci_parse($conexión, "  SELECT t.tablespace_name,  
                                            ROUND(MAX(d.bytes)/1024/1024,2) AS Tam,
                                            ROUND((MAX(d.bytes)/1024/1024) - 
                                            (SUM(decode(f.bytes, NULL,0, f.bytes))/1024/1024),2) AS Usados,   
                                            ROUND(SUM(decode(f.bytes, NULL,0, f.bytes))/1024/1024,2) AS Libres
                                        FROM DBA_FREE_SPACE f, DBA_DATA_FILES d,  DBA_TABLESPACES t  
                                        WHERE t.tablespace_name = d.tablespace_name     AND 
                                            f.tablespace_name(+) = d.tablespace_name    AND 
                                            f.file_id(+) = d.file_id                    and ( t.tablespace_name like '%PROYECTO%') 
                                            GROUP BY t.tablespace_name,   
                                                d.file_name,   t.pct_increase, t.status 
                                            ORDER BY 1,3 DESC ");
        if (!$stid) 
        {
            $e = oci_error($conexión);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Realizar la lógica de la consulta
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_close($conexión);
        return $stid;  
    }

    function informacion_tabla($nombreTabla)
    {
        $conexión = oci_connect(USUARIO_DB,USUARIO_PASS,HOST_DB);

        if (!$conexión) 
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Preparar la sentencia
        $stid = oci_parse($conexión, "  SELECT  informacion_tabla.TABLA,
                                                informacion_tabla.owner,
                                                informacion_tabla.RESTRICCION,
                                                informacion_tabla.TABLA_COMENTARIO,
                                                informacion_tabla.INDICE,
                                                informacion_tabla.tablespace,
                                                informacion_tabla.status,
                                                informacion_tabla.indexing
                                        from informacion_tabla,
                                            (
                                                SELECT TABLE_NAME
                                                FROM ALL_TABLES
                                                WHERE TABLESPACE_NAME = 'TABLASPROYECTO' AND TABLE_NAME = '".$nombreTabla."'
                                                ORDER BY TABLE_NAME
                                            )tablas
                                        where informacion_tabla.TABLA = tablas.TABLE_NAME ");
        if (!$stid) 
        {
            $e = oci_error($conexión);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Realizar la lógica de la consulta
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_close($conexión);
        return $stid;  
    }

    function informacion_interna_tabla($nombreTabla)
    {
        $conexión = oci_connect(USUARIO_DB,USUARIO_PASS,HOST_DB);

        if (!$conexión) 
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Preparar la sentencia
        $stid = oci_parse($conexión, "  SELECT  informacion_interna_tabla.tabla,
                                                informacion_interna_tabla.columnas,
                                                informacion_interna_tabla.tipo,
                                                informacion_interna_tabla.comentario
                                        from informacion_interna_tabla,
                                            (
                                                SELECT TABLE_NAME
                                                FROM ALL_TABLES
                                                WHERE TABLESPACE_NAME = 'TABLASPROYECTO' AND TABLE_NAME = '".$nombreTabla."'
                                                ORDER BY TABLE_NAME
                                            )tablas
                                        where informacion_interna_tabla.TABLA = tablas.TABLE_NAME ");
        if (!$stid) 
        {
            $e = oci_error($conexión);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Realizar la lógica de la consulta
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_close($conexión);
        return $stid;  
    }

    function activar_job($nombreTabla)
    {
        $conexión = oci_connect(USUARIO_DB,USUARIO_PASS,HOST_DB);

        if (!$conexión) 
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Preparar la sentencia
        $stid = oci_parse($conexión, "  BEGIN
                                        DBMS_SCHEDULER.ENABLE('".$nombreTabla."');
                                        END;
                                        ");
        if (!$stid) 
        {
            $e = oci_error($conexión);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Realizar la lógica de la consulta
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_close($conexión);
        return true;  
    }

    function desactivar_job($nombreTabla)
    {
        $conexión = oci_connect(USUARIO_DB,USUARIO_PASS,HOST_DB);

        if (!$conexión) 
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Preparar la sentencia
        $stid = oci_parse($conexión, "  BEGIN
                                        DBMS_SCHEDULER.DISABLE('".$nombreTabla."');
                                        END;
                                        ");
        if (!$stid) 
        {
            $e = oci_error($conexión);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Realizar la lógica de la consulta
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_close($conexión);
        return true;  
    }
?>
