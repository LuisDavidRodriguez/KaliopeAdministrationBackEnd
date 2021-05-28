<?php
include_once "app_kaliope/base_de_datos_Class.php";
include_once './app_kaliope/utilitarios_Class.php';

$database = new base_de_datos_Class();

echo $database->obtenerSemanaKaliopePorFecha('19-08-2020');





