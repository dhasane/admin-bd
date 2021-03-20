<?php
session_start();

include_once 'consultas.php';

var_dump($_POST);

$user =  $_POST["user"];
$pass = $_POST["password"];

$log = generar_conexion($user, $pass);

if ($log != "") {
    var_dump($log);
    $_SESSION['login'] = $log;
}



?>
