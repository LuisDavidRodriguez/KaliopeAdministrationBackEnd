<?php session_start();
    
//Comprobamos si ay sesion y ejecutamos instrucciones
if(isset($_SESSION['usuario'])){
    //creamos la coneccion a la base de datos
    try{
        $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
    }catch(PDOException $e){
        echo "Error".$e->getMessage();;
    }

    //Recibimos la zona de selecciona_ruta.view por el metodo get
    $zona = $_GET['zona'];
    $zona = filter_var(strtoupper($zona), FILTER_SANITIZE_STRING);


     //Consultamos las fechas en la base de datos para crear los botones de fecha
     //Y obtener la ultima fecha del movimiento
    $fechas=$conexion->prepare(
        "SELECT DISTINCT fecha FROM movimientos WHERE zona = '$zona'"
    );
    $fechas->execute();
    $datos_fecha = $fechas->fetchAll();
    //print_r($datos_fecha);

    //Extraemos la ultima fecha de la consulta
    $ultima_fecha = array_pop($datos_fecha);
    $ultima_fecha2 = $ultima_fecha[0];


    //Como se extrae la ultima fecha con este comando volvemos a ingresar la ultima fecha en el array para dejar como al inicio con todos sus datos
    array_push($datos_fecha, $ultima_fecha);


    //Recibimos la fecha de contenido.view por el metodo get
    if (empty($_GET['fecha'])) {
        $fecha = $ultima_fecha2;
    }else{
        $fecha = $_GET['fecha'];
    }

    //Consultamos vehiculos en bd para mostrar en formulario.
    $vehiculo=$conexion->prepare(
        "SELECT * FROM vehiculos WHERE zona = '$zona' AND fecha = '$fecha'"
    );
    $vehiculo->execute();
    $vehiculo = $vehiculo->fetchAll();

    //Consultamos inventarios en bd para mostrar en formulario.
    $inventario=$conexion->prepare(
        "SELECT * FROM inventarios WHERE zona = '$zona' AND fecha = '$fecha'"
    );
    $inventario->execute();
    $inventario = $inventario->fetchAll();

    //Consultamos en bd las devoluciones.
    $devolucion = $conexion->prepare(
        "SELECT pz_devueltas FROM movimientos WHERE zona = '$zona' AND fecha = '$fecha'"
    );
    $devolucion->execute();
    $devolucion = $devolucion->fetchAll();
    $devolucion = array_map("array_sum",$devolucion);
    $devolucion = (array_sum($devolucion))/2;

    //Consultamos en bd las entregas.
    $entregadas = $conexion->prepare(
        "SELECT piezas_entregadas FROM movimientos WHERE zona = '$zona' AND fecha = '$fecha'"
    );
    $entregadas->execute();
    $entregadas = $entregadas->fetchAll();
    $entregadas = array_map("array_sum", $entregadas);
    $entregadas = (array_sum($entregadas))/2;

    $piezas_finales = $inventario[0]['total_piezas'];
    $piezas_finales = $piezas_finales - $entregadas + $devolucion;

    //Consultamos base de datos para verificar clientas nuevas.
    $nuevas = $conexion->prepare(
        "SELECT * FROM movimientos WHERE zona = '$zona' AND fecha = '$fecha' AND piezas_cargo = 0 AND adeudo_cargo = 0 AND mercancia_entregada != 0"
    );
    $nuevas->execute();
    $clientes_nuevos = count($nuevas->fetchAll());

    //Consultamos bd para saber el total del cobro
    $cobro = $conexion->prepare(
        "SELECT total_pagos FROM movimientos WHERE zona = '$zona' AND fecha = '$fecha'"
    );
    $cobro->execute();
    $cobro = $cobro->fetchAll();
    $cobro = array_map("array_sum",$cobro);
    $cobro = (array_sum($cobro))/2;


    //Consultamos los clientes para mostrar los formularios en contenido.view.php
    $clientes=$conexion->prepare(
        "SELECT * FROM movimientos WHERE zona = '$zona' AND fecha = '$fecha'"
    );
    $clientes->execute();
    $datos_clientes = $clientes->fetchAll();
    
    $clientes_totales = count($datos_clientes);
    

    require 'views/contenido.view.php';
  
  //si no ay session mandamos a ingresa para crear sesion  
} else {
    header('Location: ingresa.php');
}


?>