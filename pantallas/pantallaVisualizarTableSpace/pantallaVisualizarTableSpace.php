<?php

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
    
    <title>Visualizar table space</title> 
    
</head>
  
<body>

    <?php
        $idUsuario = $_POST['idUsuario'];
        $nombreUsuario = $_POST['nombreUsuario'];
        
        $str_datos = "";
        $str_datos.="<h1>Visualizar table space: ".$nombreUsuario." codigo: ".$idUsuario."</h1>";
        echo $str_datos;

        echo "<a href='../pantallaInicio/pantallaInicio.php?idUsuario=".$idUsuario."&nombreUsuario=".$nombreUsuario."'>Volver</a><br><br>";
    ?>

    <table border='1' style="width:100%">
        <caption>Lista tablas</caption>
        <thead>
            <tr>
                <th>Nombre tablespace</th>
                <th>Tamaño</th>
                <th>Espacio usado MB</th>
                <th>Espacio libre MB</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include_once dirname(__FILE__) . '../../../consultas/consultas.php';
                $tablas = tablespaces($nombreUsuario);

                while ($fila = oci_fetch_array($tablas, OCI_ASSOC+OCI_RETURN_NULLS)) 
                {
                    echo "<tr>\n";
                        echo "<td>".$fila['TABLESPACE_NAME']."</td>";
                        echo "<td>".$fila['TAM']."</td>";
                        echo "<td>".$fila['USADOS']."</td>";
                        echo "<td>".$fila['LIBRES']."</td>";
                        #echo "<td><a href='pantallas/pantallaInicio/pantallaInicio.php?idUsuario=".$fila['USER_ID']."&nombreUsuario=".$fila['USERNAME']."'>seleccionar</td>\n";
                    echo "</tr>\n";
                }

            ?>
        </tbody>
    </table>

  <div class="">
        <div class="login_form">
        </div>
    </div>
</body>
