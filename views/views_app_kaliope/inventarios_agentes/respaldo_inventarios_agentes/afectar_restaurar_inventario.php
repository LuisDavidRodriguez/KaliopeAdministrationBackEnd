<?php

/* Recibimos el parametro del id que nos llega por get del link
 * y lo que haremos sera obtener los datos de ese respaldo con el id
 * buscar que exista en la tabla de los inventarios de los agentes un inventario con el nombre de usuario
 * si existe entonces reiniciaremos el inventario a 0 y lo llenaremos con los codigos encontrados en el respaldo
 * la version se quedara igual a la que esta corriendo. la hora de enviado al movil se borrara
 */

include_once '../../../../app_kaliope/base_de_datos_Class.php';
$dataBase = new base_de_datos_Class();

$id = $_GET['id'];


$datosDelRespaldo = $dataBase->respaldo_inventarios_agentes_consultarRespaldosPorId($id);
//print_r($datosDelRespaldo);

$propietarioDelRespaldo = $datosDelRespaldo[0]['propietario'];

$existeInventarioConUsuario = $dataBase->inventarios_agentes_consultarInventarioArray($propietarioDelRespaldo);

if(empty($existeInventarioConUsuario)){
    echo "<H2> Error no existe algun inventario actual al nombre del propietario del respaldo $propietarioDelRespaldo </H2>";
} else {
    //ahora recuperamos el array del detalle del inventario
    $arrayDetalle = json_decode($datosDelRespaldo[0]['json_inventario'],true);
    //print_r($arrayDetalle);
    /*
     * Array
(
    [0] => Array
        (
            [id] => 4014
            [0] => 4014
            [propietario] => Luisda
            [1] => Luisda
            [codigo] => 139
            [2] => 139
            [existencia] => 2
            [3] => 2
            [precio] => 139
            [4] => 139
            [vendedora] => 107
            [5] => 107
            [socia] => 103
            [6] => 103
            [empresaria] => 99
            [7] => 99
            [version] => 5
            [8] => 5
            [enviado_al_movil] => 1
            [9] => 1
            [hora_de_envio_al_movil] => 3-9-2019  11:44:53
            [10] => 3-9-2019  11:44:53
            [hora_sincronizado_desde_el_movil] => 3-9-2019  11:53:18
            [11] => 3-9-2019  11:53:18
        )

    [1] => Array
        (
            [id] => 4015
            [0] => 4015
            [propietario] => Luisda
            [1] => Luisda
            [codigo] => 149
            [2] => 149
            [existencia] => 2
            [3] => 2
            [precio] => 149
            [4] => 149
            [vendedora] => 115
            [5] => 115
            [socia] => 110
            [6] => 110
            [empresaria] => 106
            [7] => 106
            [version] => 5
            [8] => 5
            [enviado_al_movil] => 1
            [9] => 1
            [hora_de_envio_al_movil] => 3-9-2019  11:44:53
            [10] => 3-9-2019  11:44:53
            [hora_sincronizado_desde_el_movil] => 3-9-2019  11:53:18
            [11] => 3-9-2019  11:53:18
        )

    [2] => Array
        (
            [id] => 4019
            [0] => 4019
            [propietario] => Luisda
            [1] => Luisda
            [codigo] => 189
            [2] => 189
            [existencia] => 6
            [3] => 6
            [precio] => 189
            [4] => 189
            [vendedora] => 145
            [5] => 145
            [socia] => 140
            [6] => 140
            [empresaria] => 135
            [7] => 135
            [version] => 5
            [8] => 5
            [enviado_al_movil] => 1
            [9] => 1
            [hora_de_envio_al_movil] => 3-9-2019  11:44:53
            [10] => 3-9-2019  11:44:53
            [hora_sincronizado_desde_el_movil] => 3-9-2019  11:53:18
            [11] => 3-9-2019  11:53:18
        )

    [3] => Array
        (
            [id] => 4033
            [0] => 4033
            [propietario] => Luisda
            [1] => Luisda
            [codigo] => 329
            [2] => 329
            [existencia] => 2
            [3] => 2
            [precio] => 329
            [4] => 329
            [vendedora] => 274
            [5] => 274
            [socia] => 270
            [6] => 270
            [empresaria] => 263
            [7] => 263
            [version] => 5
            [8] => 5
            [enviado_al_movil] => 1
            [9] => 1
            [hora_de_envio_al_movil] => 3-9-2019  11:44:53
            [10] => 3-9-2019  11:44:53
            [hora_sincronizado_desde_el_movil] => 3-9-2019  11:53:18
            [11] => 3-9-2019  11:53:18
        )

    [4] => Array
        (
            [id] => 4050
            [0] => 4050
            [propietario] => Luisda
            [1] => Luisda
            [codigo] => 499
            [2] => 499
            [existencia] => 2
            [3] => 2
            [precio] => 499
            [4] => 499
            [vendedora] => 423
            [5] => 423
            [socia] => 416
            [6] => 416
            [empresaria] => 409
            [7] => 409
            [version] => 5
            [8] => 5
            [enviado_al_movil] => 1
            [9] => 1
            [hora_de_envio_al_movil] => 3-9-2019  11:44:53
            [10] => 3-9-2019  11:44:53
            [hora_sincronizado_desde_el_movil] => 3-9-2019  11:53:18
            [11] => 3-9-2019  11:53:18
        )

    [5] => Array
        (
            [id] => 4070
            [0] => 4070
            [propietario] => Luisda
            [1] => Luisda
            [codigo] => 699
            [2] => 699
            [existencia] => 1
            [3] => 1
            [precio] => 699
            [4] => 699
            [vendedora] => 592
            [5] => 592
            [socia] => 583
            [6] => 583
            [empresaria] => 573
            [7] => 573
            [version] => 5
            [8] => 5
            [enviado_al_movil] => 1
            [9] => 1
            [hora_de_envio_al_movil] => 3-9-2019  11:44:53
            [10] => 3-9-2019  11:44:53
            [hora_sincronizado_desde_el_movil] => 3-9-2019  11:53:18
            [11] => 3-9-2019  11:53:18
        )

)
     */
    
    $dataBase->inventarios_agentes_reiniciarInventarioA0($propietarioDelRespaldo);
    
    foreach ($arrayDetalle as $value) {
        $dataBase->inventarios_agentes_incrementaInventario($propietarioDelRespaldo, $value['codigo'], $value['existencia']);        
    }
    
    $dataBase->inventarios_agentes_actualizaVersion($propietarioDelRespaldo);
    
    
    echo "<H2> Exito!!! Se a restaurado el inventario del propietario $propietarioDelRespaldo </H2>";

    echo "<a href=../MAIN_mostrar_inventarios.php?>Ir a Los Inventarios</a> ";
    
}






