<?php

/* 
 * con este archivo cargaremos de la base de datos los datos del dispositivo la vista 
 * para posteriormente poder editarlos
 */
include_once '../../../app_kaliope/base_de_datos_Class.php';

$id = $_GET['id'];


$dataBase = new base_de_datos_Class();

//consultamos los datos del usuario
$arrayDatosDispositivo = $dataBase->dispositivos_consultaDispositivoPorId($id);
//print_r($arrayDatosDispositivo);
        /*
         * 
            [0] => Array
            (
                [id] => 82
                [0] => 82
                [modelo_movil] => SM-J250M
                [1] => SM-J250M
                [uuid] => 8749e640-0f73-47ec-9162-f3b1201a737d
                [2] => 8749e640-0f73-47ec-9162-f3b1201a737d
                [autorizado] => 1
                [3] => 1
                [fecha_hora_solicitud] => 8:10:35 20-7-2019
                [4] => 8:10:35 20-7-2019
                [comentarios] => Cambio de pantalla
                [5] => Cambio de pantalla
            )

        
         */





require "./editar_dispositivo_mostrar.view.php";