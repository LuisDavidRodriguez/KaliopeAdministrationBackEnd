<?php

/* 
 * En este archivo sacamos de la base de datos movimientos_inventarios_sucursales_bitacora
 * todos los registros de las tablas, los movimientos que se crearon desde una HANDEL de almacen
 * o sucursal, y lo mostraremos en la vista
 */

include_once '../../../../app_kaliope/base_de_datos_Class.php';

$dataBase = new base_de_datos_Class();

$arrayTodosLosMovimientos = $dataBase->movimientos_inventarios_sucursales_bitacora_consultarTodosLosMovimientos();

$arrayUsuariosConMovimientos = $dataBase->movimientos_inventarios_sucursales_bitacora_consultarUsuariosConMovimientos();
$arraySucursales = $dataBase->movimientos_inventarios_sucursales_bitacora_consultarSucursal();
$arrayFiltroDeFechas = $dataBase->movimientos_inventarios_sucursales_bitacora_consultarFechasMovimientos();

$filtroDePropietario = "sinFiltro";
$filtroDeSucursal = "sinFiltro";
$filtroDeFecha = "sinFiltro";



//recogemos el array del formulario
$filtros = $_POST;
//print_r($filtros);
/*si es la primera vez que se ingresa a la pagina solo se recibe un array () vacio;
 * si se le da clic en el boton del formulario que filtra envia esto
 * Array
(
    [filtroPropietario] => sinFiltro
    [filtroSucursal] => sinFiltro
    [filtroFecha] => sinFiltro
    [enviar] => filtrar
)
 */



if(!empty($filtros)){
    
    $filtroDePropietario = $filtros['filtroPropietario'];
    //$filtroDeSucursal = $filtros['filtroSucursal'];
    //$filtroDeFecha = $filtros['filtroFecha'];
    
    
    if($filtroDePropietario!="sinFiltro"){
       $arrayTodosLosMovimientos = $dataBase->movimientos_inventarios_sucursales_bitacora_consultarMovimientosPorFiltro($filtroDePropietario);
    }
    
    
    
}


require './MA_movimientos_inventarios_mostrar.view.php';
