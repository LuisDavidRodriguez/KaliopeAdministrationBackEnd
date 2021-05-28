<?php session_start();

//Comprobamos si ay sesion y ejecutamos instrucciones
if(isset($_SESSION['usuario'])){
    //creamos la coneccion a la base de datos
    try{
        $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
    }catch(PDOException $e){
        echo "Error".$e->getMessage();;
    }

    //Recibimos el agente de selecciona_agente.view por el metodo get
    $unidad = $_GET['unidad'];
    $unidad = filter_var(strtoupper($unidad), FILTER_SANITIZE_STRING);

    $datos_unidad = $conexion->prepare(
        "SELECT * FROM unidades WHERE unidad = '$unidad'"
    );
    $datos_unidad->execute();
    $datos_unidad = $datos_unidad->fetchAll();
    $datos_unidad = $datos_unidad[0];


    $reparaciones_unidad = $conexion->prepare(
        "SELECT * FROM reparaciones WHERE unidad_reparacion = '$unidad'"
    );
    $reparaciones_unidad->execute();
    $reparaciones_unidad = $reparaciones_unidad->fetchAll();


    require 'views/vehiculos.view.php';
 //si no ay session mandamos a ingresa para crear sesion  
} else {
    header('Location: ingresa.php');
}
?>