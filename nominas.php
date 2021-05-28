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
    $agente = $_GET['agente'];
    $agente = filter_var(strtoupper($agente), FILTER_SANITIZE_STRING);


    //Consultamos las fechas en la base de datos para crear los botones de fecha
    //Y obtener la ultima fecha del movimiento
     $datos_semana=$conexion->prepare(
        "SELECT DISTINCT semana FROM nominas WHERE agente = '$agente'"
    );
    $datos_semana->execute();
    $datos_semana = $datos_semana->fetchAll();
    //print_r($datos_semana);

    //Extraemos la ultima fecha de la consulta
    $ultima_semana = array_pop($datos_semana);
    $ultima_semana2 = $ultima_semana[0];


    //Como se extrae la ultima fecha con este comando volvemos a ingresar la ultima fecha en el array para dejar como al inicio con todos sus datos
    array_push($datos_semana, $ultima_semana);


    //Recibimos la fecha de contenido.view por el metodo get
    if (empty($_GET['semana'])) {
        $semana = $ultima_semana2;
    }else{
        $semana = $_GET['semana'];
    }

    // print_r($semana);

    $datos = $conexion->prepare(
        "SELECT * from nominas WHERE agente = '$agente' AND semana = '$semana'"
    );
    $datos->execute();
    $datos = $datos->fetchAll();
    $datos = $datos[0];
    //print_r($datos);

    require 'views/nominas.view.php';

  
  //si no ay session mandamos a ingresa para crear sesion  
} else {
    header('Location: ingresa.php');
}

?>