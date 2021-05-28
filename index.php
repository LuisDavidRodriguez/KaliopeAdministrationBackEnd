<?php
session_start();

//Comprobamos que se inicio sesion
if(isset($_SESSION['usuario'])){
    header('Location: selecciona_ruta.php');
//Si no se inicio sesion enviamos a pagina ingresa
}else{
    header('Location: ingresa.php');
}

 ?>