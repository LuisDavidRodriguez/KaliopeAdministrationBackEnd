<?php
include_once 'base_de_datos_Class.php';

/* 
 * en este archivo el movil enviara
 * la version del inventario
 * 
 * 
 * el telefono se conectara a este archivo cada 5 segundos cuando se haga ping, si hay cambios en las versiones
 * el servidor enviara los datos al movil y este sobreescribira sus datos
 * El movil solo enviara su informacion cuando el reconosca que hay cambios que sincronizar
 * si no solo hara "ping" o prueba de conexion. 
 *
 * 
 * 
 * 
 * Si la version del inventario que tiene el servidor es la 3 por ejemplo y el movil envia la version 3
 * entonces el servidor sobreescribe su inventario con la informacion del movil
 * Cundo se haga un cambio en el inventario del servidor por alguna correccion, la version cambiara a 4
 * cuando el movil se conecte para sincronizar sus datos, el servidor reconoce que las versiones son diferentes
 * y en ese momento envia su inventario al telefono y el telefono reescribe este inventario. 
 * 
 *  
 * 
 */

$dataBase = new base_de_datos_Class();


$propietario = filter_var ($_REQUEST["alias"], FILTER_SANITIZE_STRING);
$versionInventarioMovil = filter_var ($_REQUEST["versionInventario"], FILTER_SANITIZE_STRING);

//consultamos la version del inventairo por usuario y la comparamos con la que envia el movil
//si la version de la base de datos del servidor es diferente a la del movil entonces enviamos el inventario para que
//el movil lo carge y ponemos que el inventario se envio al movil a la fecha actual

if($dataBase->inventarios_agentes_consultaVersionInventario($propietario)!=$versionInventarioMovil){
    
 
    
    echo '{"estado":"Prueba Ping Exitosa",'
    . '"inventario":'.$dataBase->inventarios_agentes_consultarInventarioJsonEncode($propietario).'}';
    
    $dataBase->inventarios_agentes_ponerEnviadoAlMovil($propietario);
}


