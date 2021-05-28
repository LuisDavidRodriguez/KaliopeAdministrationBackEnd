<?php 
session_start();

//Comprobamos la sesion, si ay sesion requerimos de la vista de selecciona ruta
if(isset($_SESSION['usuario'])){
    require 'views/selecciona_ruta.view.php';
//Si no ay sesion mandamos a ingresa para crear la sesion
}else{
    header('Location: ingresa.php');
}


 ?>