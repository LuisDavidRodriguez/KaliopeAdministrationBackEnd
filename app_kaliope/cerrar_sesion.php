<?php
/*CREADO POR LUISDA 30-07-2019*/
include_once 'base_de_datos_Class.php';
$dataBase = new base_de_datos_Class();


$propietario = filter_var ($_REQUEST["alias"], FILTER_SANITIZE_STRING);
$fechaHoraInicioSesion = filter_var ($_REQUEST["fechaHoraInicioSesion"], FILTER_SANITIZE_STRING);
$uuid = filter_var ($_REQUEST["UUID"], FILTER_SANITIZE_STRING);
$versionInventarioMovil = filter_var ($_REQUEST["versionInventario"], FILTER_SANITIZE_STRING);
$inventario = $_REQUEST["inventario"];
//esta es la cadena en formato json que envia el movil con el inventario
//[{"codigo":"249","existencias":"52"},{"codigo":"299","existencias":"150"},{"codigo":"409","existencias":"5"},{"codigo":"549","existencias":"10"}]
$fechaClientesConsulta1 = filter_var ($_REQUEST["fechaClientesConsulta1"], FILTER_SANITIZE_STRING);
$fechaClientesConsulta2 = filter_var ($_REQUEST["fechaClientesConsulta2"], FILTER_SANITIZE_STRING);
$zona1 = filter_var ($_REQUEST["zona1"], FILTER_SANITIZE_STRING);
$zona2 = filter_var ($_REQUEST["zona2"], FILTER_SANITIZE_STRING);
$mensajesClientes =  $_REQUEST["mensajesClientes"]; 
//el movil envia este jsonObjet
//{"fechaClientesConsulta":"30-07-2019","usuario":"David","zona":"SAN JUAN DEL RIO","cadenaDatos":"SAN JUAN DEL RIO\n6,David,,,,0,0,0,0,0,0,,73,29306,2-369-308 1-199-159 5-499-423 8-699-592 3-139-107 8-129-99 1-139-107 20-339-283 25-699-592 ,30-07-2019,30-07-2019 11:54:34,0,19.795070705004036,-99.87895281985402\n7,David,,,,0,0,0,0,0,0,,73,29306,2-369-308 1-199-159 5-499-423 8-699-592 3-139-107 8-129-99 1-139-107 20-339-283 25-699-592 ,30-07-2019,30-07-2019 11:57:59,0,19.795070705004036,-99.87895281985402\n"}

$arrayInventario = json_decode($inventario,true);
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





/*
 * Consultamos las versiones del inventario en el cierre de sesion, hay un problema que debo corregir. Supongamos que es viernes, en la noche se sincronizaron
 * los datos del movil al servidor, ya hisimos nominas y terminamos todo el trabajo, pero a los chicos de queretaro se les olvida cerrar su sesion del viernes
 * el dia sabado, se hacen los cambios en el sistema de kaliope en la nube, por ejempolo se intercambian los inventarios de un agente con el de otro, o se
 * se hacen modificaciones en el inventario. que ocurriria el lunes cuando el otro usuario abra la app kaliope? La app identificara que el dia ya es uno futuro
 * entonces forzara al usuario a cerrar sesion, pero durante ese dialogo la app en segundo plano se conecta al servidor y compara las versiones del inventario
 * por lo tanto en ese momento si ubo un intercambio de inventario la app kaliope deberia de cargarlo sin rpoblemas al nuevo, pero que pasaria si por alguna
 * razon no se sincroniza, y se llama directo a este archivo cerrar sesion?, lo que pasaria es que como aqui no preguntamos si la version del inventario es igual,
 * la app enviaria su inventario que no esta actualizado, al servidor y el servidor lo recibira y afectara todo el inventario que nosotros ya intercambiamos o modificamos
 * 
 * Entonces para poder recibir el inventario del movil y sobre escribir el que esta en el servidor, la version del inventario que tiene el movil y la del servidor
 * deberan de ser iguales!!!, la version del inventario en el telefono no puede ser cambiada de ninguna manera, solo se puede cambiar en el del servidor.
 * 
 * Entonces hay que tenener en cuenta los siguientes aspectos:
 * Si algun administrador hace una modificacion en el inventario, este cambiara de version, y la app kaliope solo lo cargara durante su sincronizacion, es decir en el menu principal
 * cada 2 segundos.
 * 
 * Si se hace un cambio mientras el telefono no tiene conexion y por alguna razon no se sincroniza el movil, y se llama directo a cerrar sesion, entonces el inventario que tiene la app
 * no se cargara al servidor porque son diferentes versiones sino que se perdera, bueno no del todo debido a que la app Kaliope cada que elimina el inventario, antes lo exporta a su memoria
 * en un archivo de texto
 * 
 * En teoria no deberia de ocurrir que falle la sincronizacion
 * 
 * Para la sincronizacion del movil, este se conecta al archivo ping si hay respuesta entonces sabe que hay coneccion a internet y al servidor, en ese momento se sincronizan los datos
 * llamando a este archivo cerrar sesion, pero el movil no cierra su sesion solo envia los datos a este archivo, cuando se sincroniza el movil cambia una variable la cual evita que 
 * cuando se haga ping que es cada 2 segundos, sincronice los datos, hasta que ocurra algun movimiento en la app, se volveran a sincronizar.
 * 
 * 
 * Cuando se actualice el inventario primero lo vamos a reiniciar todo completamente a 0 y despues vamos a cargar el nuevo inventario que nos envio el celular esto porque?
 * Bueno el telefono movil cuando envia el inventario solo envia los codigos que en sus existencias son diferentes a 0, el servidor recibe esos codigos y los actualiza, que pasa entonces
 * que hay de malo? bueno pues el la practica ya ocurrio que el inventario del movil y del servidor eran diferentes, el movil marcaba 182 de existencia y el inventario del servidor 184
 * los sincronizamos una y otra y otra vez y aun marcaba lo mismo, entonces el problema es el siguiente
 * 
 * Si la app en el inventario movil tiene por ejemplo 329-1 139-2, ese inventario se sincroniza con el servidor entonces el servidor tambien tiene 329-1 139-2
 * pero ahora en el telefono movil el agente hace una salida de 329 1 pieza, entonces el inventario del agente ya solo tiene 329-0 139-2, cuando el celular
 * envia los datos de su inventario al servidor este solo envia las piezas donde su existencia son diferentes de 0, es decir solo manda 139-2, el servidor recibe eso
 * y solo actualiza las piezas de 139, pero como nunca recibio el codigo de 329, el servidor sigue teniendo existencias en 329 de 1 pz. 
 * 
 * Las opciones para resolver esto son:
 * 1.- que el movil envie por completo todos sus codigos sin existencias o sin existencias, pero igualmente el servidor tiene que trabajar recorriendo todos los codigos y actualizando
 * 2.- Que el servidor al recibir la actualizacion de su inventario primero borre todas las existencias a 0 y despues carge el inventario.
 * 
 * Por ahora opto por la opcion dos, porque si no tendria que modificar el codigo de la app kaliopem subirla a la playstore y despues actualizar todos los telefonos
 * 
 */


if($dataBase->inventarios_agentes_consultaVersionInventario($propietario)==$versionInventarioMovil){
    
    $dataBase->respaldo_inventarios_agentes_insertarRespaldo($propietario);
    
    $dataBase->inventarios_agentes_reiniciarInventarioA0($propietario);
    
    $dataBase->inventarios_agentes_actualizaInventario($propietario, $arrayInventario);
    
    //ponemos la ultima hora en la que el servidor sustituyo su inventario por el del movil 
    $dataBase->inventarios_agentes_ponerSincronizadoDesdeElMovil($propietario);
}

$dataBase->cadenas_info_app_kaliope_insertaActualizaMensajesClientes2Rutas ($fechaClientesConsulta1,$fechaClientesConsulta2,$zona1,$zona2,$mensajesClientes,$fechaHoraInicioSesion,$propietario);



echo '{"resultado":"conexion Establecida exitosamente"}'; 














