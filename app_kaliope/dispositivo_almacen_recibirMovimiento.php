<?php

/* 
 * En este documento enviaremos el movimiento finalizado de la handheld de almacen
 * afectaremos el inventario del usuario, y tambien afectaremos el inventario del almacen
 * guardaremos el movimiento en una bitacora.
 * 
 * Haremos un cambio muy importante. El problema es el siguiente: si el usuario no sincroniza el inventario cuando hace
 * el movimiento en la handhend, sale con una version de inventario anterior que la que tiene el servidor, al volver de ruta el movil se sincroniza, pero el servidor
 * desecha el inventario que tiene una version menor el cual si esta real con el trabajo del agente y carga el que no se sincronizo en la mañana de una version mayor
 * perdiendo los datos de trabajo del dia.
 * 
 * Lo que haremos sera guardar en la tabla de los movimientos el movimiento que ingreso el agente en la handheld, pero no modificaremos el inventario del usuario unicamente
 * el inventario de la sucursal. en esta tabla agregaremos 2 cambos mas si ya se envio al movil con 0 o 1, o la fecha, ya sabemos a que hora se realizo el movimiento,
 *  añadiremos otro campo con la fecha en que este movimiento
 * se envio al movil, es decir cuando el movil se sincronice descargara los movimientos donde enviado a movil sea 0, y el telefono es quien realizara la modificacion en su inventario
 * con la informacion del movimiento, tambien de esta manera el movil guardara en sus mensajes que envia a administracion el movimiento que se realizo.
 * De esa manera no importa si el usuario no sincroniza su inventario en la mañana. Creamos un nuevo archivo llamado, buscar_movimientos_almacen_no_enviados
 */

include_once './base_de_datos_Class.php';
include_once './utilitarios_Class.php';

$dataBase = new base_de_datos_Class();

$propietario = filter_var ($_REQUEST["alias"], FILTER_SANITIZE_STRING);
$nombreCompleto = filter_var ($_REQUEST["nombreCompleto"], FILTER_SANITIZE_STRING);
$usuarioReviso = filter_var ($_REQUEST["aliasSupervisor"], FILTER_SANITIZE_STRING);
$nombreCompletoReviso = filter_var ($_REQUEST["nombreSupervisor"], FILTER_SANITIZE_STRING);
$tipoMovimiento = filter_var ($_REQUEST["tipoMovimiento"], FILTER_SANITIZE_STRING); // "S" o "E" para salidas y entradas, Hacen referencia al inventario del agente, si marca E quiere decir que entraran piezas a su inventario y saldran del de la sucursal
$usuarioSucursal = filter_var ($_REQUEST["usuarioSucursal"], FILTER_SANITIZE_STRING);
$totalPiezas = filter_var ($_REQUEST["totalPiezas"], FILTER_SANITIZE_STRING);
$totalImporte = filter_var ($_REQUEST["totalImporte"], FILTER_SANITIZE_STRING);
$movimientoJson = $_REQUEST["movimientosJsonArray"];
//[{"Codigo":"139","Cantidad":"4"},{"Codigo":"149","Cantidad":"1"}]


$arrayMovimientos = json_decode($movimientoJson,true);
//print_r($arrayMovimientos);
/*
 * Array(
 * [0]=>Array
 * (
 *  [Codigo]=>139
 *  [Cantidad]=>4
 * )
 * 
 *  [1]=>Array
 * (
 *  [Codigo]=>149
 *  [Cantidad]=>1
 * )
 * 
 * 
 *
 * )
 */

//echo "$alias $nombreCompleto, aliasSupervisor $aliasSupervisor, nombreSupervisor $nombreSupervisor, tipoMovimiento $tipoMovimiento, usuarioSucursal $usuarioSucursal, arrayJson $movimientoJson";


//ya no validamos el usuario ni el paswword porque se supone que la handhel se conecto anteriormente para obtener estos datos
//y reenviarlos aqui. Tampoco validamos si el codigo existe o no poruqe la handheld descarga ya los codigos existentes

$almacenExistenciasAntes = $dataBase->inventarios_agentes_consultarPiezasTotalesPropietario($usuarioSucursal);


foreach ($arrayMovimientos as $value) {
    $codigo = $value['Codigo'];
    $cantidad = $value['Cantidad'];
    
    if($tipoMovimiento=="S"){
        //$dataBase->inventarios_agentes_decrementaInventario($propietario, $codigo, $cantidad);//-------------------------Se va para la nueva version
        $dataBase->inventarios_agentes_incrementaInventario($usuarioSucursal, $codigo, $cantidad);

    }
    
    if($tipoMovimiento=="E"){
        //$dataBase->inventarios_agentes_incrementaInventario($propietario, $codigo, $cantidad);//-------------------------Se va para la nueva version
        $dataBase->inventarios_agentes_decrementaInventario($usuarioSucursal,$codigo, $cantidad);
    }   
    
    
    
}





//$dataBase->inventarios_agentes_actualizaVersion($propietario);//---------------------------Se va para la nueva version
$dataBase->inventarios_agentes_actualizaVersion($usuarioSucursal);


$almacenExistenciasDespues = $dataBase->inventarios_agentes_consultarPiezasTotalesPropietario($usuarioSucursal);
$propietarioVersionDespues = $dataBase->inventarios_agentes_consultaVersionInventario($propietario);
$almacenVersionDespues = $dataBase->inventarios_agentes_consultaVersionInventario($usuarioSucursal);


//Guardamos el movimiento en la bitacora

$horaRealizado = utilitarios_Class::horaActual_hh_mm_ss_ToText();
$fechaRealizado = utilitarios_Class::dameFecha_dd_mm_aaaa_ToText();

$dataBase->movimientos_inventarios_sucursales_bitacora_insertarBitacora
        ($propietario, $nombreCompleto, $usuarioReviso, $nombreCompletoReviso, $usuarioSucursal, $fechaRealizado,
        $horaRealizado, $totalPiezas, $tipoMovimiento, $totalImporte, 
        $almacenExistenciasAntes, $almacenExistenciasDespues,0,0, $propietarioVersionDespues, $almacenVersionDespues, $movimientoJson, 0, "");




//enviamos una respuesta al movil

echo '{"estado":"Movimiento Finalizado Exitosamente",'
        .'"piezasFinales":"'.$propietarioExistenciasDespues.'",'
        .'"versionFinal":"'.$propietarioVersionDespues.'"'
        .'}';