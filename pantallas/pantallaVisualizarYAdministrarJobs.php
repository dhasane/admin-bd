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
    
    <title>Visualizar y administrar jobs</title> 
    
</head>
  
<body>

    <?php
       

        if(isset($_POST['idUsuario']) && isset($_POST['nombreUsuario']))
        {
            $idUsuario = $_POST['idUsuario'];
            $nombreUsuario = $_POST['nombreUsuario'];
        }
        else
        {
            $idUsuario = $_GET['idUsuario'];
            $nombreUsuario = $_GET['nombreUsuario'];
        }
        
        $str_datos = "";
        $str_datos.="<h1>Visualizar y administrar jobs: ".$nombreUsuario." codigo: ".$idUsuario."</h1>";
        echo $str_datos;

        echo "<a href='pantallaVisualizarYAdministrarJobs.php?idUsuario=".$idUsuario."&nombreUsuario=".$nombreUsuario."'>Actualizar</a><br><br>";
        echo "<a href='pantallaInicio.php?idUsuario=".$idUsuario."&nombreUsuario=".$nombreUsuario."'>Volver</a><br><br>";
    ?>

    <form action="pantallaVisualizarYAdministrarJobs.php" method="post">
        <table border="1" style="width:100%">
            <tr>
                <th>Dueño job</th>
                <th>Nombre job</th>
                <th>Job class</th>
                <th>Comments</th>
                <th>Credential name</th>
                <th>Destination</th>
                <th>Program name</th>
                <th>Job type</th>
                <th>Job action</th>
                <th>Number of arguments</th>
                <th>Shedule owner</th>
                <th>Shedule name</th>
                <th>Shedule type</th>
                <th>Start date</th>
                <th>Repeat intervale</th>
                <th>End date</th>
                <th>Activo</th>

                <th>Activar</th>
                <th>Desactivar</th>
            </tr>

            <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . '/admin-bd/consultas.php';
                $tablas = jobs_por_usuario();

                $n = 0;
                while ($fila = oci_fetch_array($tablas, OCI_ASSOC+OCI_RETURN_NULLS)) 
                {
                    echo "<tr>\n";
                        echo "<td>".$fila['OWNER']."</td>";
                        echo "<td>".$fila['JOB_NAME']."</td>";
                        echo "<td>".$fila['JOB_CLASS']."</td>";
                        echo "<td>".$fila['COMMENTS']."</td>";
                        echo "<td>".$fila['CREDENTIAL_NAME']."</td>";
                        echo "<td>".$fila['DESTINATION']."</td>";
                        echo "<td>".$fila['PROGRAM_NAME']."</td>";
                        echo "<td>".$fila['JOB_TYPE']."</td>";
                        echo "<td>".$fila['JOB_ACTION']."</td>";
                        echo "<td>".$fila['NUMBER_OF_ARGUMENTS']."</td>";
                        echo "<td>".$fila['SCHEDULE_OWNER']."</td>";
                        echo "<td>".$fila['SCHEDULE_NAME']."</td>";
                        echo "<td>".$fila['SCHEDULE_TYPE']."</td>";
                        echo "<td>".$fila['START_DATE']."</td>";
                        echo "<td>".$fila['REPEAT_INTERVAL']."</td>";
                        echo "<td>".$fila['END_DATE']."</td>";
                        echo "<td>".$fila['ENABLED']."</td>";

                        if( $fila['ENABLED'] == 'TRUE' )
                        {
                            echo "<td><input type='text'  name='opcionText' value='Desactivar'/></td>";

                            echo "<td><input type='radio'  name='opcion".$n."' value='Desactivar'/></td>";
                            echo "<input type='hidden' name='dueñoJob".$n."' value=".$fila['OWNER'].">"; //
                            echo "<input type='hidden' name='nombreJob".$n."' value=".$fila['JOB_NAME'].">"; //    
                        }
                        else
                        {
                            echo "<td><input type='radio'  name='opcion".$n."' value='Activar'/></td>";
                            echo "<input type='hidden' name='dueñoJob".$n."' value=".$fila['OWNER'].">"; //
                            echo "<input type='hidden' name='nombreJob".$n."' value=".$fila['JOB_NAME'].">"; //

                            echo "<td><input type='text'  name='opcionText' value='Activar'/></td>";  
                        }  
                    echo "</tr>\n";
                    $n = $n + 1;
                }
                echo "<input type='hidden' name='idUsuario' value=".$idUsuario.">"; // esto evita que la tabla se borre al oprimir ejecutar
                echo "<input type='hidden' name='nombreUsuario' value=".$nombreUsuario.">"; // esto evita que la tabla se borre al oprimir ejecutar
                echo "<input type='hidden' name='numeroDeJobs' value=".$n.">"; //
            ?>
        </table>
        <input type="submit" value="Ejecutar">
    </form>
</body>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if(isset($_POST['numeroDeJobs']))
        {
            $n = $_POST['numeroDeJobs'];
            $m = 0;
            while($m < $n)
            {
                if (isset($_POST['opcion'.$m]) && isset($_POST['dueñoJob'.$m]) && isset($_POST['nombreJob'.$m])) 
                {
                    if( $_POST['opcion'.$m] == 'Activar' )
                    {
                        if($_POST['nombreUsuario'] == $_POST['dueñoJob'.$m])
                        {
                            $respuesta = activar_job($_POST['dueñoJob'.$m].".".$_POST['nombreJob'.$m]);
                        }
                        else
                        {
                            $respuesta = activar_job($_POST['dueñoJob'.$m].".".$_POST['nombreJob'.$m]);
                        }
                    }
                    elseif( $_POST['opcion'.$m] == 'Desactivar' )
                    {
                        if($_POST['nombreUsuario'] == $_POST['dueñoJob'.$m])
                        {
                            $respuesta = desactivar_job($_POST['dueñoJob'.$m].".".$_POST['nombreJob'.$m]);
                        }
                        else
                        {
                            $respuesta = desactivar_job($_POST['dueñoJob'.$m].".".$_POST['nombreJob'.$m]);
                        }
                    }
                }   
                $m = $m + 1; 
            }
        } 
    }
?>
