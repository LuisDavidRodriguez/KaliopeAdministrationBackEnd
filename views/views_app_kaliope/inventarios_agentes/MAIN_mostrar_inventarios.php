<?php

include_once '../../../app_kaliope/base_de_datos_Class.php';


$dataBase = new base_de_datos_Class();


/*
 * buscamos en la tabla inventarios_agentes y seleccionamos los usuarios
 */


$arrayPropietarios  = $dataBase->inventarios_agentes_consultarUsuariosConInventario();


$arrayDatosFinales = array();
//consultar las piezas totales de cada usuario
foreach ($arrayPropietarios as $propietario) {
    
    $existencias = $dataBase->inventarios_agentes_consultarPiezasTotalesPropietario($propietario[0]);
    $version = $dataBase->inventarios_agentes_consultaVersionInventario($propietario[0]);
    $importe = $dataBase->inventarios_agentes_consultarImporteTotalPropietario($propietario[0]);
    
    //obtenemos si ya se envio al movil, y la hora en que lo hiso. y tambien obtenemos la hora en la que el inventario del movil se sincronizo por ultima vez
    $arrayDatosEnviadoAlMovil = $dataBase->inventarios_agentes_consultaEnviadoAlMovil($propietario[0]);
    /*
     * en ese array tenemos esto
     * Array
            (
                [enviado_al_movil] => 1
                [0] => 1
                [hora_de_envio_al_movil] => 23:4:29 21-8-2019
                [1] => 23:4:29 21-8-2019
                [hora_sincronizado_desde_el_movil] => 23:4:29 21-8-2019
                [2] => 23:4:29 21-8-2019
            )
     */
    
    
    $arrayInfo = array (
        "propietario"=>$propietario[0],
        "existencias"=>$existencias,
        "importe"=>$importe,
        "version"=>$version,
        "enviado_al_movil"=>$arrayDatosEnviadoAlMovil[0],
        "hora_de_envio_al_movil"=>$arrayDatosEnviadoAlMovil[1],
        "hora_sincronizado_desde_el_movil"=>$arrayDatosEnviadoAlMovil[2]
    );
    
    //print_r($arrayInfo);
    
    array_push($arrayDatosFinales, $arrayInfo);
    
}




/*EL ARRAY DATOS FINALES ES EL QUE MANEJARA LA VISTA
 * 
 */
//print_r($arrayDatosFinales);




require 'MA_mostrar_inventarios.view.php';



