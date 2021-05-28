<?php

/* * Añadiremos la opcion de los movimientos de almacen, cuando el movil se conecte a este archovo, el servidor
 * revisara si hay movimientos de almacen que pertenescan a este propietario y que aun no se hayan enviado al movil
 * si los hay el servidor los enviara al movil y este debera recibirlos y modificar su inventario, a su ves crear el movimiento
 * y enviarlo en sus mensajes a adminsitracion. de esta manera resolvemos el problema que ocurre cuando el usurio hace un movimiento
 * en la handheld de almacen pero se le olvida sincronizar su inventario. simplemente al llegar a la oficina en la tarde, 
 * se encontraran los movimientos que no se sincronizaron y se enviaran al telefono.
 * 
 * esta es la descripcion del problema que expuse en dispositivo_almacen_recibirMovimiento
 * 
 *  * Haremos un cambio muy importante. El problema es el siguiente: si el usuario no sincroniza el inventario cuando hace
 * el movimiento en la handhend, sale con una version de inventario anterior que la que tiene el servidor, al volver de ruta el movil se sincroniza, pero el servidor
 * desecha el inventario que tiene una version menor el cual si esta real con el trabajo del agente y carga el que no se sincronizo en la mañana de una version mayor
 * perdiendo los datos de trabajo del dia.
 * 
 * Lo que haremos sera guardar en la tabla de los movimientos el movimiento que ingreso el agente en la handheld, pero no modificaremos el inventario del usuario unicamente
 * el inventario de la sucursal. en esta tabla agregaremos 2 cambos mas si ya se envio al movil con 0 o 1, o la fecha, ya sabemos a que hora se realizo el movimiento,
 *  añadiremos otro campo con la fecha en que este movimiento
 * se envio al movil, es decir cuando el movil se sincronice descargara los movimientos donde enviado a movil sea 0, y el telefono es quien realizara la modificacion en su inventario
 * con la informacion del movimiento, tambien de esta manera el movil guardara en sus mensajes que envia a administracion el movimiento que se realizo.
 * De esa manera no importa si el usuario no sincroniza su inventario en la mañana, 
 */

header('Content-type: application/json; charset=utf-8');//incluimos el header para que los datos con formato json los muestre el navegador mas legiblemente

include_once './base_de_datos_Class.php';
$dataBase = new base_de_datos_Class();
$propietario = filter_var ($_REQUEST["alias"], FILTER_SANITIZE_STRING);
$inventario = $_REQUEST["inventario"];
//$propietario = 'Mendez';
$arrayInventario = json_decode($inventario,true);
//print_r($arrayInventario);
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



$arrayDatosNoEnviados = $dataBase->movimientos_inventarios_sucursales_bitacora_consultarMovimientosNoEnviados($propietario);
//print_r($arrayDatosNoEnviados);
/*
 * Array
(
    [0] => Array
        (
            [id] => 20
            [0] => 20
            [propietario] => Mendez
            [1] => Mendez
            [nombre_completo] => Carlos Mendez Cruz
            [2] => Carlos Mendez Cruz
            [usuario_reviso] => Angel
            [3] => Angel
            [nombre_completo_reviso] => Angel Calderon Cortez
            [4] => Angel Calderon Cortez
            [usuario_sucursal] => Morelia
            [5] => Morelia
            [fecha_realizado] => 21-8-2019
            [6] => 21-8-2019
            [hora_realizado] => 7:45:38
            [7] => 7:45:38
            [total_piezas] => 7
            [8] => 7
            [tipo_movimiento] => S
            [9] => S
            [total_importe] => 1888
            [10] => 1888
            [propietario_existencias_antes] => 173
            [11] => 173
            [propietario_existencias_despues] => 166
            [12] => 166
            [almacen_existencias_antes] => 10
            [13] => 10
            [almacen_existencias_despues] => 17
            [14] => 17
            [propietario_version_despues] => 7
            [15] => 7
            [almacen_version_despues] => 5
            [16] => 5
            [jsonPiezas] => [{"Codigo":"399","Cantidad":"3"},{"Codigo":"299","Cantidad":"1"},{"Codigo":"279","Cantidad":"2"},{"Codigo":"209","Cantidad":"1"}]
            [17] => [{"Codigo":"399","Cantidad":"3"},{"Codigo":"299","Cantidad":"1"},{"Codigo":"279","Cantidad":"2"},{"Codigo":"209","Cantidad":"1"}]
            [enviado_al_movil] => 0
            [18] => 0
            [hora_de_envio_al_movil] => 
            [19] => 
        )

    [1] => Array
        (
            [id] => 8
            [0] => 8
            [propietario] => Mendez
            [1] => Mendez
            [nombre_completo] => Carlos Mendez Cruz
            [2] => Carlos Mendez Cruz
            [usuario_reviso] => Ramiro
            [3] => Ramiro
            [nombre_completo_reviso] => Ramiro Guadalupe Ramirez Padilla
            [4] => Ramiro Guadalupe Ramirez Padilla
            [usuario_sucursal] => Morelia
            [5] => Morelia
            [fecha_realizado] => 20-8-2019
            [6] => 20-8-2019
            [hora_realizado] => 21:13:56
            [7] => 21:13:56
            [total_piezas] => 1
            [8] => 1
            [tipo_movimiento] => S
            [9] => S
            [total_importe] => 174
            [10] => 174
            [propietario_existencias_antes] => 174
            [11] => 174
            [propietario_existencias_despues] => 173
            [12] => 173
            [almacen_existencias_antes] => 0
            [13] => 0
            [almacen_existencias_despues] => 0
            [14] => 0
            [propietario_version_despues] => 6
            [15] => 6
            [almacen_version_despues] => 0
            [16] => 0
            [jsonPiezas] => [{"Codigo":"209","Cantidad":"1"}]
            [17] => [{"Codigo":"209","Cantidad":"1"}]
            [enviado_al_movil] => 0
            [18] => 0
            [hora_de_envio_al_movil] => 
            [19] => 
        )
 * )
 */




//Ok en el anterior codigo agrupabamos todos los movimientos encontrados en un solo
//(array porque los enviabamos de una sola vez al movil, tambien por eso nos enfrentabamos al problema
//que al codificar el json array de una sola vez nos aparecian las barras, en este caso
//tenemos solo tenemos que hacer que en cada iteracion del bucle tome el json encode de las piezas
//y las convierta en un nuevo array para afectar el inventario)


if (!empty($arrayDatosNoEnviados)) {



    $dataBase->inventarios_agentes_ponerSincronizadoDesdeElMovil($propietario);
    $dataBase->respaldo_inventarios_agentes_insertarRespaldo($propietario);
    $dataBase->inventarios_agentes_reiniciarInventarioA0($propietario);
    $dataBase->inventarios_agentes_actualizaInventario($propietario, $arrayInventario);











    foreach ($arrayDatosNoEnviados as $value) {
        //para cada movimiento no enviado
        //ahora afectamos el inventario del usuario
            $piezasInventarioAntesDeActualizar = $dataBase->inventarios_agentes_consultarPiezasTotalesPropietario($propietario);
            $importeTotalAntesDeActualizar = $dataBase->inventarios_agentes_consultarImporteTotalPropietario($propietario);
            //echo "$importeTotalAntesDeActualizar";
            //echo "$piezasInventarioAntesDeActualizar";
        
        
        
        
        $arrayPiezas = json_decode($value['jsonPiezas'], true);
        //print_r($arrayPiezas);
        /*
         * Array
          (
          [0] => Array
          (
          [Codigo] => 399
          [Cantidad] => 3
          )

          [1] => Array
          (
          [Codigo] => 299
          [Cantidad] => 1
          )

          [2] => Array
          (
          [Codigo] => 279
          [Cantidad] => 2
          )

          [3] => Array
          (
          [Codigo] => 209
          [Cantidad] => 1
          )

          )
         */
        
        
        foreach ($arrayPiezas as $valuePz) {
            /*in value we have this 
             * [Codigo] => 399
               [Cantidad] => 3
             * 
             */
            
            if ($value['tipo_movimiento'] == 'S'){             
                
                $dataBase->inventarios_agentes_decrementaInventario($propietario, $valuePz['Codigo'], $valuePz['Cantidad']);       
                
             }else if ($value['tipo_movimiento'] == 'E'){
                 
                $dataBase->inventarios_agentes_incrementaInventario($propietario, $valuePz['Codigo'], $valuePz['Cantidad']);  
            
            }
            
            
        }
        
        
        //(in this moment we can consult the total of pcs and the quantity, 
        //and also put the moviment like "enviado" next the "foreach" will continue
        //with the next movement)
        
        $dataBase->movimientos_inventarios_sucursales_bitacora_finalizarMovimientoSucursal(
                $value['id'], 
                $piezasInventarioAntesDeActualizar,
                $dataBase->inventarios_agentes_consultarPiezasTotalesPropietario($propietario),
                $dataBase->inventarios_agentes_consultaVersionInventario($propietario));
        
        
        

        }

    
//and at the end we return the new inventary to the movil
echo $dataBase->inventarios_agentes_consultarInventarioJsonEncode($propietario);

}


//if there are no any user's movements this code doesn't return anything


