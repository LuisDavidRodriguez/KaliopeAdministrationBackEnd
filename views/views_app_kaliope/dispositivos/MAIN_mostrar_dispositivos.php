<?php

/* Consultamos la lista de todos los dispositivos para mostrarla en la vista
 * 
 */

include_once '../../../app_kaliope/base_de_datos_Class.php';

$dataBase = new base_de_datos_Class();

$arrayTodosLosDispositivos = $dataBase->dispositivos_consultaroTodosLosDispositivos_returnArray();

require './MA_mostrar_dispositivos.view.php';



