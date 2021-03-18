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
                <th>nombre job</th>
                <th>dueño del job</th>
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
                        echo "<td><input type='radio'  name='opcion".$n."' value='Activar'/></td>";  
                        echo "<td><input type='radio'  name='opcion".$n."' value='Desactivar'/></td>";    
                        #echo "<td><a href='pantallas/pantallaInicio/pantallaInicio.php?idUsuario=".$fila['USER_ID']."&nombreUsuario=".$fila['USERNAME']."'>seleccionar</td>\n";
                    echo "</tr>\n";
                    $n = $n + 1;
                }
            ?>
            <input type="submit" value="Ejecutar">
        </form>

  <div class="">
        <div class="login_form">
        </div>
    </div>
</body>