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
    
    <title>Visualizar espacio de usuarios</title> 
    
</head>
  
<body>

    <?php
        $idUsuario = $_POST['idUsuario'];
        $nombreUsuario = $_POST['nombreUsuario'];
        
        $str_datos = "";
        $str_datos.="<h1>Visualizar espacio de usuarios: ".$nombreUsuario." codigo: ".$idUsuario."</h1>";
        echo $str_datos;

        echo "<a href='../pantallaInicio/pantallaInicio.php?idUsuario=".$idUsuario."&nombreUsuario=".$nombreUsuario."'>Volver</a><br><br>";
    ?>

  <div class="">
        <div class="login_form">
        </div>
    </div>
</body>