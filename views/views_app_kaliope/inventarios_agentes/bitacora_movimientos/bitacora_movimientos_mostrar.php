<?php

/* 
 * Consultamos todos los movimientos de la tabla modificar_inventarios_bitacora
 * para mostrarlos en la vista
 */

include_once '../../../../app_kaliope/base_de_datos_Class.php';
include_once '../../../../app_kaliope/utilitarios_Class.php';
$database = new base_de_datos_Class();


$arrayTodasLasBitacoras = $database->modificar_inventarios_bitacora_consultarBitacoras();
$arrayUsuariosConModificaciones = $database->modificar_inventarios_bitacora_consultarPropietariosBitacoras();

$filtroDePropietario = "sinFiltro";





//recibimos nuestro formulario de filtros
$filtros = $_POST;
//print_r($filtros);
/*
 * Array
(
    [filtroPropietario] => Atlacomulco
    [enviar] => filtrar
)
 */

if(!empty($filtros)){
    $filtroDePropietario = $filtros['filtroPropietario'];
    
    if($filtroDePropietario!="sinFiltro"){
        $arrayTodasLasBitacoras = $database->modificar_inventarios_bitacora_consultarBitacorasPorPropietario($filtroDePropietario);
    }
    
}

require_once 'bitacora_movimientos_mostrar.view.php';



