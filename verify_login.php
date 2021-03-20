<?php
session_start();

include_once 'consultas.php';

var_dump($_POST);

$user = $_POST["user"];
$pass = $_POST["password"];

$log = generar_conexion($user, $pass);

if ($log != "") {
    $_SESSION['login'] = $user;
    $_SESSION['password'] = $password;
    var_dump($log);
   // header("Location: ./index.php");
}
?>
