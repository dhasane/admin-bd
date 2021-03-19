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
        $idUsuario = $_POST['idUsuario'];
        $nombreUsuario = $_POST['nombreUsuario'];
        
        $str_datos = "";
        $str_datos.="<h1>Visualizar y administrar jobs: ".$nombreUsuario." codigo: ".$idUsuario."</h1>";
        echo $str_datos;
    ?>

    <form action="pantallaVisualizarYAdministrarJobs.php" method="post">
        <table border="1" style="width:100%">
            <tr>
                <th>Dueño job</th>
                <th>Nombre job</th>
                <th>Activo</th>
                <th>Activar</th>
                <th>Desactivar</th>
            </tr>

            <?php
                include_once dirname(__FILE__) . '../../../consultas/consultas.php';
                $tablas = jobs_por_usuario();

                $n = 0;
                while ($fila = oci_fetch_array($tablas, OCI_ASSOC+OCI_RETURN_NULLS)) 
                {
                    echo "<tr>\n";
                        echo "<td>".$fila['OWNER']."</td>";
                        echo "<td>".$fila['JOB_NAME']."</td>";
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