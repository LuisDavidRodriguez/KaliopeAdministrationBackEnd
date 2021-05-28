<?php 
session_start();

//Comprobamos la sesion, si ay sesion requerimos de la vista de selecciona ruta
if(isset($_SESSION['usuario'])){

    //Creamos la conexion a la base de datos para utilizarla mas adelante.
		try {
			$conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
		} catch(PDOException $e){
			echo "Error" . $e->getMessage();;
        }

    $agentes = $conexion->prepare(
        "SELECT DISTINCT agente FROM nominas"
    );
    $agentes->execute();
    $agentes = $agentes->fetchAll();

    require 'views/selecciona_agente.view.php';
//Si no ay sesion mandamos a ingresa para crear la sesion
}else{
    header('Location: ingresa.php');
}


 ?>