<?php

/* Este archivo recibira el parametro del id del movimiento que se escogio en la vista de todos los movimientos
 * seleccionamos de el todos los datos, y seleccionamos la cadena de json que incluye las piezas y las convertimos a un array
 */

include_once '../../../../app_kaliope/base_de_datos_Class.php';

$id = $_GET['id'];


$dataBase = new base_de_datos_Class();

$arrayDetalleMovimiento = $dataBase->movimientos_inventarios_sucursales_bitacora_consultarMovimientoPorId($id);
$arrayDetalleMovimientoPiezas = json_decode($arrayDetalleMovimiento['jsonPiezas'], true) ;

require './mostrar_detalle.view.php';



