<?php

$modeloMovil = $_REQUEST["modeloDispositivo"];
$uuid = $_REQUEST["UUID"];

//$modeloMovil = "modeloDispositivo";
//$uuid = "UUID";


$fechaActual = fechaActualToText();


//Creamos la conexion a la base de datos
try {
    $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
} catch(PDOException $e){
    echo "Error" . $e->getMessage();
}





$usuarios = $conexion->prepare(
    "SELECT * FROM dispositivos WHERE uuid = '$uuid'"
    //consultamos si en la tabla ya hay un numero uuid que concuerde
);
$usuarios->execute();
$usuarios = $usuarios->fetchAll();
//print_r($usuarios);



if(empty($usuarios)){
    //si esta vacio añadimos el dispositivo a la tabla por primera vez
    //Ejecutamos la conexion y especificamos la tabla a elegir
    $statement = $conexion->prepare(
        "INSERT INTO dispositivos (modelo_movil, uuid, fecha_hora_solicitud) VALUES ('$modeloMovil', '$uuid','$fechaActual')"        
    );
    $statement->execute();
    echo json_encode(crearArrayRespuestaExitosa($uuid,$fechaActual));
    //le retornamos al movil un json con una respuesta que podemos escojer, para que diga que la conexion fue exitosa
}else {

    echo json_encode($usuarios);
    //si el sistema encuentra que ya hay un uuid registrado en la tabla entonces devuelve los datos de ese dispositivo
}















/*esta es la funcion que cree para generar una respuesta personalizada del servidor hacia el movil
pero en el archivo descarga_catalogo_precios explico que ya entendi lo que es un JSONObject y lo que es un JSONArray
entonces ir a ese archivo para entender mas con los comentarios donde se manejan estas respuestas son en la app kaliope
en la actividad MainActivity.java en el metodo getValidacionDeAppPorServidor() ahi nos damos cuenta que ambas respuestas
la de arriba que se genero con el json_encode y la que generamos manualmente en esta funcion debian de tener los mismos
identificadores o nombres de campos debido a que se manejaran en el mismo onSuccess */
function crearArrayRespuestaExitosa ($uuid1, $horaSolicitud){
    /*creo este metodo porque cuando el movil se conecta por primera ves al servidor, y el servidor
    no encuentra que su uuid este registrado, lo que hace es registrarlo en la base de datos, pero en ese momento
    el celular espera como retorno un objeto json, como ingresamos los datos por primera vez no hay nada que devolvolver
    entonces la app indica que la conexion no se establecio porque no encontro ningun objeto json de retorno
    para ello vamos a crear un array en esta funcion que simulara el retorno de datos.
    
    no estoy muy seguro que sea correcto en la app de kaliope deberia de haber alguna matera pero bueno es lo que tengo por ahora
    los campos del array son iguales a lso que se devolverian de un array en la consulta de la base de datos como esta:

    $usuarios = $conexion->prepare(
    "SELECT * FROM dispositivos WHERE uuid = '$uuid'"    
    );
    $usuarios->execute();
    $usuarios = $usuarios->fetchAll();
    //print_r($usuarios);
    */
    $array = array(
        array(
            "id"=>"",
            "0" => "",  
            "modelo_movil"=>"Se enviaron los datos correctamente, por favor comuniquese con sistemas kaliope para que autorice la aplicacion",
            "1" => "Se enviaron los datos correctamente, por favor comuniquese con sistemas kaliope para que autorice la aplicacion",        
            "uuid"=>"$uuid1",
            "2" =>"$uuid1",
            "ruta_asignada"=>"0",
            "3" => "0",        
            "agente_asignado"=>"0",
            "4" =>"0",
            "autorizado"=>"0",
            "5" =>"0",
            "fecha_hora_solicitud"=>"$horaSolicitud",
            "6" => "$horaSolicitud",        
            "pulsera_asignada"=>"0",
            "7" =>"0",
            "comentarios"=>"0",
            "8" =>"0",

            )       
        
    );

    return $array;
    
}


function fechaActualToText(){
    //funcion para obtener la fecha actual del sistema y retornarla como texto concatenado
    date_default_timezone_set('America/Mexico_City');
    $fechaSolicitud = getdate();
    //print_r ($fechaSolicitud);

    $fechaTexto = $fechaSolicitud["hours"].":".$fechaSolicitud["minutes"].":".$fechaSolicitud["seconds"]." ".$fechaSolicitud["mday"]."-". $fechaSolicitud["mon"]."-". $fechaSolicitud["year"];
    //echo $fechaTexto;
    return $fechaTexto;
}






?>


