<?php

session_start();

if(!isset($_SESSION['login'])) {
    header("Location: ./login.php");
} else {
    $GLOBAL['conexion'] = $_SESSION['login'];
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

    <?php
        $idUsuario = $_GET['idUsuario'];
        $nombreUsuario = $_GET['nombreUsuario'];
        
        $str_datos = "";
        $str_datos.="<h1>Bienvenido usuario: ".$nombreUsuario." codigo: ".$idUsuario."</h1>";
        echo $str_datos;

        echo "<a href='../../index.php?idUsuario=".$idUsuario."&nombreUsuario=".$nombreUsuario."'>Volver</a><br>";
    ?>

    <h2>Por favor seleccione la operación que desea realizar</h2>
    <br>

    <h2>Operaciones de usuario</h2>

    <div class="ElementosQueLePertenecen">
        <form action="../pantallaElementosQueLePertenecen/pantallaElementosQueLePertenecen.php" method="post">
        
        <?php
            echo "<input type='hidden' name='idUsuario' value=".$idUsuario.">";
            echo "<input type='hidden' name='nombreUsuario' value=".$nombreUsuario.">";
        ?>

        <input type="submit" value="Elementos que le pertenecen">
        </form>
        <br>
    </div>

    <div class="ElementosRelacionados">
        <form action="../pantallaElementosRelacionados/pantallaElementosRelacionados.php" method="post">
        
        <?php
            echo "<input type='hidden' name='idUsuario' value=".$idUsuario.">";
            echo "<input type='hidden' name='nombreUsuario' value=".$nombreUsuario.">";
        ?>

        <input type="submit" value="Elementos relacionados">
        </form>
        <br>
    </div>

    <div class="PFP">
        <form action="../pantallaPFP/pantallaPFP.php" method="post">
        
        <?php
            echo "<input type='hidden' name='idUsuario' value=".$idUsuario.">";
            echo "<input type='hidden' name='nombreUsuario' value=".$nombreUsuario.">";
        ?>

        <input type="submit" value="Paquetes, funciones y procedimiento">
        </form>
        <br>
    </div>

    <br>
    <br>
    <h2>Operaciones de base de datos</h2>

    <div class="VisualizarYAdministrarJobs">
        <form action="../pantallaVisualizarYAdministrarJobs/pantallaVisualizarYAdministrarJobs.php" method="post">
        
        <?php
            echo "<input type='hidden' name='idUsuario' value=".$idUsuario.">";
            echo "<input type='hidden' name='nombreUsuario' value=".$nombreUsuario.">";
        ?>

        <input type="submit" value="Visualizar Y Administrar Jobs">
        </form>
        <br>
    </div>

    <div class="VisualizarTableSpace">
        <form action="../pantallaVisualizarTableSpace/pantallaVisualizarTableSpace.php" method="post">
        
        <?php
            echo "<input type='hidden' name='idUsuario' value=".$idUsuario.">";
            echo "<input type='hidden' name='nombreUsuario' value=".$nombreUsuario.">";
        ?>

        <input type="submit" value="Visualizar TableSpace">
        </form>
        <br>
    </div>

    <div class="VisualizarEspacioDeUsuarios">
        <form action="../pantallaVisualizarEspacioDeUsuarios/pantallaVisualizarEspacioDeUsuarios.php" method="post">
        
        <?php
            echo "<input type='hidden' name='idUsuario' value=".$idUsuario.">";
            echo "<input type='hidden' name='nombreUsuario' value=".$nombreUsuario.">";
        ?>

        <input type="submit" value="Visualizar Espacio De Usuarios">
        </form>
        <br>
    </div>

</body>
