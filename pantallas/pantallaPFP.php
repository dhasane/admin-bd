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
    
    <title>Paquetes, funciones y procedimientos</title> 
    
</head>
  
<body>

    <?php
        $idUsuario = $_POST['idUsuario'];
        $nombreUsuario = $_POST['nombreUsuario'];
        
        $str_datos = "";
        $str_datos.="<h1>Paquetes, funciones y procedimientos: ".$nombreUsuario." codigo: ".$idUsuario."</h1>";
        echo $str_datos;

        echo "<a href='pantallaInicio.php?idUsuario=".$idUsuario."&nombreUsuario=".$nombreUsuario."'>Volver</a><br><br>";
    ?>

    <table border='1' style="width:100%">
        <caption>Lista procedimientos</caption>
        <thead>
            <tr>
                <th>Owner</th>
                <th>Procedmiento</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . '/admin-bd/consultas.php';

                $tablas = procedimientos_usuarios($nombreUsuario);

                while ($fila = oci_fetch_array($tablas, OCI_ASSOC+OCI_RETURN_NULLS)) 
                {
                    echo "<tr>\n";
                        echo "<td>".$fila['OWNER']."</td>";
                        echo "<td>".$fila['PROCEDIMIENTO']."</td>";
                    echo "</tr>\n";
                }

            ?>
        </tbody>
    </table>

    <table border='1' style="width:100%">
        <caption>Lista funciones</caption>
        <thead>
            <tr>
                <th>Owner</th>
                <th>Funcion</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . '/admin-bd/consultas.php';

                $tablas = funciones_usuarios($nombreUsuario);

                while ($fila = oci_fetch_array($tablas, OCI_ASSOC+OCI_RETURN_NULLS)) 
                {
                    echo "<tr>\n";
                        echo "<td>".$fila['OWNER']."</td>";
                        echo "<td>".$fila['FUNCION']."</td>";
                    echo "</tr>\n";
                }

            ?>
        </tbody>
    </table>

    <table border='1' style="width:100%">
        <caption>Lista paquetes</caption>
        <thead>
            <tr>
                <th>Owner</th>
                <th>Paquete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . '/admin-bd/consultas.php';

                $tablas =paquetes_usuarios($nombreUsuario);

                while ($fila = oci_fetch_array($tablas, OCI_ASSOC+OCI_RETURN_NULLS)) 
                {
                    echo "<tr>\n";
                        echo "<td>".$fila['OWNER']."</td>";
                        echo "<td>".$fila['PAQUETE']."</td>";
                    echo "</tr>\n";
                }

            ?>
        </tbody>
    </table>
</body>