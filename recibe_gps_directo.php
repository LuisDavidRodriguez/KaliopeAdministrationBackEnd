<?php

include_once './app_kaliope/base_de_datos_Class.php';
$dataBase = new base_de_datos_Class();

$datos = $_POST;
$datosGet = $_GET;


if (!empty($datos)){
    $dataBase->datos_gps_recibidos_directo_insertarRegistro("POST--".$datos);
}

if (!empty($datosGet)){
    $dataBase->datos_gps_recibidos_directo_insertarRegistro("GET--".$datosGet);
}

$dataBase->datos_gps_recibidos_directo_insertarRegistro("prueba");