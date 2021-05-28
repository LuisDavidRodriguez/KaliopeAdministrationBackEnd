<?php

/* en este archivo solo vamos a obtener de la base de datos de rutas
 * las rutas existentes y con ellas vamos a llenar 
 * un selector de la vista
 */


include_once '../../../app_kaliope/base_de_datos_Class.php';

$dataBase = new base_de_datos_Class();



//consultamos todas las zonas existentes
$arrayRutasExistentes = $dataBase->nombres_zonas_consultaRutasExistentes();
//print_r($arrayRutasExistentes);// este llenara nuestro selector de rutas consultando las rutas existentes en la tabla nombres_zonas
/*
 * Array
(
    [0] => Array
        (
            [ruta] => A1
            [0] => A1
        )

    [1] => Array
        (
            [ruta] => A2
            [0] => A2
        )

    [2] => Array
        (
            [ruta] => A3
            [0] => A3
        )

    [3] => Array
        (
            [ruta] => A4
            [0] => A4
        )

    [4] => Array
        (
            [ruta] => Q1
            [0] => Q1
        )

    [5] => Array
        (
            [ruta] => Q2
            [0] => Q2
        )

    [6] => Array
        (
            [ruta] => Q3
            [0] => Q3
        )

    [7] => Array
        (
            [ruta] => Q4
            [0] => Q4
        )

    [8] => Array
        (
            [ruta] => M1
            [0] => M1
        )

    [9] => Array
        (
            [ruta] => M2
            [0] => M2
        )

    [10] => Array
        (
            [ruta] => M3
            [0] => M3
        )

    [11] => Array
        (
            [ruta] => M4
            [0] => M4
        )

)
 */




require "nuevo_usuario.view.php";

