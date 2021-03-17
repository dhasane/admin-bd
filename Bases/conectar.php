<?php

include_once dirname(__FILE__) . '/configuracion/configuracion.php';
$conexión = oci_connect(USUARIO_DB,USUARIO_PASS,HOST_DB);

if (!$conexión) 
{
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Preparar la sentencia
$stid = oci_parse($conexión, 'SELECT * FROM ciudad');
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

// Obtener los resultados de la consulta
print "<table border='1'>\n";
while ($fila = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    print "<tr>\n";
    foreach ($fila as $elemento) {
        print "    <td>" . ($elemento !== null ? htmlentities($elemento, ENT_QUOTES) : "") . "</td>\n";
    }
    print "</tr>\n";
}
print "</table>\n";

oci_free_statement($stid);
oci_close($conexión);

?>