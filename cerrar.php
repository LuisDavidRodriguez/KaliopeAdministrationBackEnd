<?php session_start();

//Solamente matamos la sesion
session_destroy();
$_SESSION = array();

header('Location: ingresa.php');

?>