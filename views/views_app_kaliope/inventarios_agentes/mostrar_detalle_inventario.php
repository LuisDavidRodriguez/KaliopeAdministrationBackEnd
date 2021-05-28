<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../../../app_kaliope/base_de_datos_Class.php';

//recibimos la variable del propietario que enviamos por get cuando se preciono el linkl mostrar detalle
$propietario = $_GET['propietario'];

$dataBase = new base_de_datos_Class();


//consultamos el detalle del inventario el array detalleInventario es la que se enviara a la vista de detalle
$detalleInventario = $dataBase->inventarios_agentes_consultarInventarioExistenciasArray($propietario);

//print_r($detalleInventario);

require 'mostrar_detalle_inventario.view.php';


