<?php
//session_start();
include_once 'configuracion.php';

function generar_conexion($usuario, $pass)
{
    $conexion = oci_connect($usuario, $pass, HOST_DB);

    if (!$conexion)
    {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        return "";
    }

    return $conexion;
}

function lista_Usuarios()
{
    $conexion = oci_connect($_SESSION['login'], $_SESSION['password'], HOST_DB);

    if (!$conexion)
    {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Preparar la sentencia
    $stid = oci_parse(
        $conexion,
        "SELECT *
         FROM SYS.VISTA_USUARIOS ");

    if (!$stid)
    {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Realizar la lógica de la consulta
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conexion);
    return $stid;
}

function lista_tablas_usuario($nombreUsuario)
{
    $conexion = oci_connect($_SESSION['login'], $_SESSION['password'], HOST_DB);

    if (!$conexion)
    {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Preparar la sentencia
    $stid = oci_parse(
        $conexion,
        "SELECT TABLE_NAME
         FROM SYS.ALL_TABLES
         WHERE owner = '".$nombreUsuario."'");
    if (!$stid)
    {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Realizar la lógica de la consulta
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conexion);
    return $stid;
}

function lista_tablas_usuario_no_propietario($nombreUsuario)
{

    $conexion = oci_connect($_SESSION['login'], $_SESSION['password'], HOST_DB);

    if (!$conexion)
    {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Preparar la sentencia
    $stid = oci_parse(
        $conexion,
        "SELECT TABLE_NAME, OWNER
         FROM SYS.VISTA_TODAS_LAS_TABLAS
         WHERE owner <> '".$nombreUsuario."' and TABLESPACE_NAME = 'TABLASPROYECTO'
         ORDER BY TABLE_NAME ");
    if (!$stid)
    {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Realizar la lógica de la consulta
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conexion);
    return $stid;
}

function jobs_por_usuario()
{

    $conexion = oci_connect($_SESSION['login'], $_SESSION['password'], HOST_DB);

    if (!$conexion)
    {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Preparar la sentencia
    $stid = oci_parse(
        $conexion,
        "SELECT *
         FROM SYS.VISTA_JOBS ");
    if (!$stid)
    {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Realizar la lógica de la consulta
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conexion);
    return $stid;
}

function tablespaces()
{

    $conexion = oci_connect($_SESSION['login'], $_SESSION['password'], HOST_DB);

    if (!$conexion)
    {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Preparar la sentencia
    $stid = oci_parse(
        $conexion,
        "SELECT *
         FROM sys.VISTA_ESPACIO_TABLESPACE; ");
    if (!$stid)
    {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Realizar la lógica de la consulta
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conexion);
    return $stid;
}

function informacion_tabla($nombreTabla)
{

    $conexion = oci_connect($_SESSION['login'], $_SESSION['password'], HOST_DB);

    if (!$conexion)
    {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Preparar la sentencia
    $stid = oci_parse(
        $conexion,
        "SELECT *
         from sys.informacion_tabla,
         where informacion_tabla.TABLA = '".$nombreTabla."' ");
    if (!$stid)
    {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Realizar la lógica de la consulta
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conexion);
    return $stid;
}

function informacion_interna_tabla($nombreTabla)
{

    $conexion = oci_connect($_SESSION['login'], $_SESSION['password'], HOST_DB);

    if (!$conexion)
    {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Preparar la sentencia
    $stid = oci_parse(
        $conexion,
        "SELECT *
         from sys.informacion_interna_tabla,
         where TABLA = '".$nombreTabla."' ");
    if (!$stid)
    {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Realizar la lógica de la consulta
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conexion);
    return $stid;
}

function activar_job($nombreTabla)
{

    $conexion = oci_connect($_SESSION['login'], $_SESSION['password'], HOST_DB);

    if (!$conexion)
    {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Preparar la sentencia
    $stid = oci_parse(
        $conexion,
        "BEGIN
              DBMS_SCHEDULER.ENABLE('".$nombreTabla."');
         END;
         ");
    if (!$stid)
    {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Realizar la lógica de la consulta
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conexion);
    return true;
}

function desactivar_job($nombreTabla)
{

    $conexion = oci_connect($_SESSION['login'], $_SESSION['password'], HOST_DB);

    if (!$conexion)
    {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Preparar la sentencia
    $stid = oci_parse(
        $conexion,
        "BEGIN
              DBMS_SCHEDULER.DISABLE('".$nombreTabla."');
         END;
         ");
    if (!$stid)
    {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Realizar la lógica de la consulta
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conexion);
    return true;
}
?>
