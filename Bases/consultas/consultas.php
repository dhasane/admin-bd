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
?>
