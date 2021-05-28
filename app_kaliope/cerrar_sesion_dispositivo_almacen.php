<?php
/*Creamos este archivo que es casi una copia del de cerrar sesion, exepto de que a este se conectaran los dispositivos
de los almacenes para enviar su informacion, hago esto porque los dispositivos de almacen enviara informacion diferente
 * a la de los agentes entonces para aislar las modificaciones prefiero hacer este archivo
 * no vamos a recibir deecho nada de informacion, la handheld no va a enviar inventario solo es un visualizador 
    la handheld no midificara su inventario y luego lo enviara, sino que enviara la informacion del movimiento
 * realizado y el servidor los modificara */
include_once 'base_de_datos_Class.php';
$dataBase = new base_de_datos_Class();


$propietario = filter_var ($_REQUEST["alias"], FILTER_SANITIZE_STRING);
$fechaHoraInicioSesion = filter_var ($_REQUEST["fechaHoraInicioSesion"], FILTER_SANITIZE_STRING);
$uuid = filter_var ($_REQUEST["UUID"], FILTER_SANITIZE_STRING);
//$versionInventarioMovil = filter_var ($_REQUEST["versionInventario"], FILTER_SANITIZE_STRING);
//$inventario = $_REQUEST["inventario"];
//esta es la cadena en formato json que envia el movil con el inventario
//[{"codigo":"249","existencias":"52"},{"codigo":"299","existencias":"150"},{"codigo":"409","existencias":"5"},{"codigo":"549","existencias":"10"}]

//$arrayInventario = json_decode($inventario,true);
//en esta linea lo convertimos a algo como esto
/*
 * array(
 *  [0]=>Array
 *      (
 *       [codigo]=>249
 *       [existencias]=>52     
 *      )
 *  [1]=>Array
 *      (
 *       [codigo]=>299
 *       [existencias]=>150  
 *      )
 *  [2]=>Array
 *      (
 *       [codigo]=>409
 *       [existencias]=>5  
 *      ) * 
 * )
 */





echo '{"resultado":"conexion Establecida exitosamente"}';


