<?php

session_start();

if(!isset($_SESSION['login'])) {
    header("Location: ./login.php");
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
    
    <title>Espacio usuarios</title> 
    
</head>
  
<body>

    <?php
        $idUsuario = $_POST['idUsuario'];
        $nombreUsuario = $_POST['nombreUsuario'];
        
        $str_datos = "";
        $str_datos.="<h1>Espacio usuarios: ".$nombreUsuario." codigo: ".$idUsuario."</h1>";
        echo $str_datos;

        echo "<a href='pantallaInicio.php?idUsuario=".$idUsuario."&nombreUsuario=".$nombreUsuario."'>Volver</a><br><br>";
    ?>

    <table border='1' style="width:100%">
        <caption>Lista tablas</caption>
        <thead>
            <tr>
                <th>Nombre tabla</th>
                <th>Dueño</th>
                <th>Bytes usados</th>
                <th>Bloques usados</th>
                <th>Bytes libres</th>
                <th>Bloques libres</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . '/admin-bd/consultas.php';

                $tablas = espacio_usuarios();

                while ($fila = oci_fetch_array($tablas, OCI_ASSOC+OCI_RETURN_NULLS)) 
                {
                    echo "<tr>\n";
                        echo "<td>".$fila['TABLESPACE_NAME']."</td>";
                        echo "<td>".$fila['OWNER']."</td>";
                        echo "<td>".$fila['BYTES_USADOS']."</td>";
                        echo "<td>".$fila['BLOQUES_USADOS']."</td>";
                        echo "<td>".$fila['BYTES_LIBRES']."</td>";
                        echo "<td>".$fila['BLOQUES_LIBRES']."</td>";
                    echo "</tr>\n";
                }

            ?>
        </tbody>
    </table>
</body>