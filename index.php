<?php
session_start();

if(!isset($_SESSION['login'])) {
    header("Location: ./login.php");
} else {
    $conexion = $_SESSION['login'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:500' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&display=swap" rel="stylesheet">
    
    <title>Inicio</title> 
    
</head>

<body>
    <div class="titulo_pagina">
        <h1>Sistema de administración de bases de datos</h1>
    </div>

    <table border='1' style="width:100%">
        <caption>Lista de usuarios disponibles</caption>
        <thead>
            <tr>
                <th>Usuario id</th>
                <th>Nombre</th>
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once 'consultas.php';
            include_once 'configuracion.php';
            $usuarios = lista_Usuarios($conexion);

            while ($fila = oci_fetch_array($usuarios, OCI_ASSOC+OCI_RETURN_NULLS)) 
            {
                echo "<tr>\n";
                    echo "<td>".$fila['USER_ID']."</td>";
                    echo "<td>".$fila['USERNAME']."</td>";
                    echo "<td><a href='pantallas/pantallaInicio/pantallaInicio.php?idUsuario=".$fila['USER_ID']."&nombreUsuario=".$fila['USERNAME']."'>seleccionar</td>\n";
                echo "</tr>\n";
            }
            ?>
        </tbody>
    </table>


</body>

</html>
