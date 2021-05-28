<?php

/* 
 * En este archivo consultaremos todos los reportes de fisico contra sistema registrados
 * y los mostraremos en la vista
 * 
 */

include_once '../../../../app_kaliope/base_de_datos_Class.php';
include_once '../../../../app_kaliope/utilitarios_Class.php';
$database = new base_de_datos_Class();


$arrayTodosLosReportes = $database->fisico_vs_sistema_inventario_consultarReportes();
$arrayPropietariosConFisicoVsSistema = $database->fisico_vs_sistema_inventario_consultarPropietariosConReportes();


$filtroDePropietario = "sinFiltro";


$filtros = $_POST;  
//print_r($filtros);
/*
 * Array
(
    [filtroPropietario] => Carlitos
    [enviar] => filtrar
)
 */

if(!empty($filtros)){
    $filtroDePropietario = $filtros['filtroPropietario'];
    
    if($filtroDePropietario!="sinFiltro"){
        $arrayTodosLosReportes = $database->fisico_vs_sistema_inventario_consultarReportesPorPropietario($filtroDePropietario);
    }
}

require_once 'reportes_fisico_vs_sistema_mostrar.view.php';

