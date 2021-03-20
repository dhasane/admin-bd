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
    
    <title>Elementos que le pertenecen</title> 
    
</head>
  
<body>

    <?php
        $idUsuario = $_POST['idUsuario'];
        $nombreUsuario = $_POST['nombreUsuario'];
        
        $str_datos = "";
        $str_datos.="<h1>Elementos que le pertenecen: ".$nombreUsuario." codigo: ".$idUsuario."</h1>";
        echo $str_datos;

        echo "<a href='pantallaInicio.php?idUsuario=".$idUsuario."&nombreUsuario=".$nombreUsuario."'>Volver</a><br><br>";
    ?>

    <table border='1' style="width:100%">
        <caption>Lista tablas</caption>
        <thead>
            <tr>
                <th>Nombre tabla</th>
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . '/admin-bd/consultas.php';

                $tablas = lista_tablas_usuario($nombreUsuario);

                while ($fila = oci_fetch_array($tablas, OCI_ASSOC+OCI_RETURN_NULLS)) 
                {
                    echo "<tr>\n";
                        echo "<td>".$fila['TABLE_NAME']."</td>";
                        echo "<td>";
                        echo    "<form action='pantallaElementosQueLePertenecen.php' method='post'>";
                        echo        "<input type='submit' value='Ejecutar'>";
                        echo        "<input type='hidden' name='table_name' value=". $fila['TABLE_NAME'].">";
                        echo        "<input type='hidden' name='idUsuario' value=".$idUsuario.">"; // esto evita que la tabla se borre al oprimir ejecutar
                        echo        "<input type='hidden' name='nombreUsuario' value=".$nombreUsuario.">"; // esto evita que la tabla se borre al oprimir ejecutar
                        echo    "</form>";
                        echo "</td>";
                    echo "</tr>\n";
                }

            ?>
        </tbody>
    </table>

    <table border='1' style="width:100%">
        <caption>Datos de la tablas</caption>
        <thead>
            <tr>
                <th>Nombre tabla</th>
                <th>Dueño</th>
                <th>Restriccion</th>
                <th>Comentario</th>
                <th>Indice</th>
                <th>Tablespace</th>
                <th>Status</th>
                <th>Indexing</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") 
                {
                    if(isset($_POST['table_name']))
                    {
                        $table_name = $_POST['table_name'];
                        $tablas = informacion_tabla($table_name);

                        while ($fila = oci_fetch_array($tablas, OCI_ASSOC+OCI_RETURN_NULLS)) 
                        {
                            echo "<tr>\n";
                                echo "<td>".$fila['TABLA']."</td>";
                                echo "<td>".$fila['OWNER']."</td>";
                                echo "<td>".$fila['RESTRICCION']."</td>";
                                echo "<td>".$fila['TABLA_COMENTARIO']."</td>";
                                echo "<td>".$fila['INDICE']."</td>";
                                echo "<td>".$fila['TABLESPACE']."</td>";
                                echo "<td>".$fila['STATUS']."</td>";
                                echo "<td>".$fila['INDEXING']."</td>";
                            echo "</tr>\n";
                        }   
                    }       
                }
            ?>
        </tbody>
    </table>

    <br><br>

    <table border='1' style="width:100%">
        <caption>Columnas de la tabla</caption>
        <thead>
            <tr>
                <th>Nombre tabla</th>
                <th>Columnas</th>
                <th>Tipo</th>
                <th>Comentario</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") 
                {
                    if(isset($_POST['table_name']))
                    {
                        $tablas_1 = informacion_interna_tabla($table_name);

                        while ($fila_1 = oci_fetch_array($tablas_1, OCI_ASSOC+OCI_RETURN_NULLS)) 
                        {
                            echo "<tr>\n";
                                echo "<td>".$fila_1['TABLA']."</td>";
                                echo "<td>".$fila_1['COLUMNAS']."</td>";
                                echo "<td>".$fila_1['TIPO']."</td>";
                                echo "<td>".$fila_1['COMENTARIO']."</td>";
                            echo "</tr>\n";
                        }   
                    }       
                }
            ?>
        </tbody>
    </table>

  <div class="">
        <div class="login_form">
        </div>
    </div>
</body>
