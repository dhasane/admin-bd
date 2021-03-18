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
                                        WHERE default_tablespace='USUARIOS'");
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
                                            WHERE default_tablespace='USUARIOS'
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
                                            f.file_id(+) = d.file_id                    and ( t.tablespace_name like '%PROYECTO%' 
                                                                                        or t.tablespace_name like '%USUARIOS%') 
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
?>
