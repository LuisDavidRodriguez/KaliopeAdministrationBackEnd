<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './base_de_datos_Class.php';
header('Content-type: application/json; charset=utf-8');//incluimos el header para que los datos con formato json los muestre el navegador mas legiblemente


$dataBase = new base_de_datos_Class();

//print_r($dataBase->nombres_zonas_getIdZonaActual('A1'));

$dataBase->cadenas_info_app_kaliope_consultaTodasLasCadenas();

//echo '<br>';

//echo $dataBase->movimientos_consultarCuentas('Eduardo');