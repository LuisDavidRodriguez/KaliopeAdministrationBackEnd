<?php

/* 
 * Generamos este archivo para poder ver todas las cadenas generadas en la app de kaliope. los mensajes de los clientes
 */



include_once '../../../app_kaliope/base_de_datos_Class.php';


$dataBase = new base_de_datos_Class();

$cadenasInfoApp = $dataBase->cadenas_info_app_kaliope_consultaTodasLasCadenas();

/*
Array
(
    [0] => Array
        (
            [id] => 1355
            [0] => 1355
            [fecha_clientes_consulta1] => 19-12-2019
            [1] => 19-12-2019
            [fecha_clientes_consulta2] => 20-12-2019
            [2] => 20-12-2019
            [usuario] => Luisda
            [3] => Luisda
            [fecha_hora_inicio_sesion] => 19-12-2019 00:07:25
            [4] => 19-12-2019 00:07:25
            [zona1] => CANALEJAS
            [5] => CANALEJAS
            [zona2] => TARIMORO
            [6] => TARIMORO
            [fecha_subida] => 11:6:38 19-12-2019
            [7] => 11:6:38 19-12-2019
            [cadena_datos] => ?
CANALEJAS
?
            [8] => ?
CANALEJAS
?
        )

    [1] => Array
        (
            [id] => 1354
            [0] => 1354
            [fecha_clientes_consulta1] => 19-12-2019*16-12-201
            [1] => 19-12-2019*16-12-201
            [fecha_clientes_consulta2] => 
            [2] => 
            [usuario] => Luisda
            [3] => Luisda
            [fecha_hora_inicio_sesion] => 19-12-2019 00:07:25
            [4] => 19-12-2019 00:07:25
            [zona1] => CANALEJAS*TARIMORO*
            [5] => CANALEJAS*TARIMORO*
            [zona2] => 0
            [6] => 0
            [fecha_subida] => 10:31:16 19-12-2019
            [7] => 10:31:16 19-12-2019
            [cadena_datos] => ?
CANALEJAS
?
            [8] => ?
CANALEJAS
?
        )
    */

require './MA_cadenas_info_app_mostrar.view.php';





