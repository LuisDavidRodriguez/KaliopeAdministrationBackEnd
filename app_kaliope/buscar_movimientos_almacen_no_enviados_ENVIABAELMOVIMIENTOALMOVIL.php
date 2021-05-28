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
//$propietario = 'Mendez';

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

//tenemos un problema, las piezas estan guardadas en la base de datos como un json, si tratamos de usar el json_decode para enviar los datos directamente del array
//todo lo demas se envia bien, excepto por las piezas que se codifican asi : [{\"Codigo\":\"399\",\"Cantidad\":\"3\"},{\"Codigo\":\"299\",\"Cantidad\":\"1\"},{\"Codigo\":\"279\",\"Cantidad\":\"2\"},{\"Codigo\":\"209\",\"Cantidad\":\"1\"}]
//lo cula esta mal las \ no deberian de estar. 
//tendremos que armar manualmente el json para esto crearemos arrays con la informacion a codificar en json
//sirve que tambien enviamos solo los datos que necesitamos y no tantos datos que no son necesarios


if(!empty($arrayDatosNoEnviados)){
    
    $arrayMov = array();
    foreach ($arrayDatosNoEnviados as $value) {
        //para cada movimiento no enviado
        //primero obtenemos el json de las piezas y lo pasamos a un array
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

        $arrayTemporal = array(
            "usuario" => $value['propietario'],
            "nombreCompleto" => $value['nombre_completo'],
            "fechaRealizado" => $value['fecha_realizado'],
            "horaRealizado" => $value['hora_realizado'],
            "totalPiezas" => $value['total_piezas'],
            "tipoMovimiento" => $value['tipo_movimiento'],
            "totalImporte" => $value['total_importe'],
            "piezas" => $arrayPiezas
        );

        //print_r($arrayTemporal);    
        /* Tendriamos algo como esto
         * Array
          (
          [usuario] => Mendez
          [nombreCompleto] => Carlos Mendez Cruz
          [fechaRealizado] => 21-8-2019
          [horaRealizado] => 7:45:38
          [totalPiezas] => 7
          [tipoMovimiento] => S
          [totalImporte] => 1888
          [piezas] => Array
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

          )
         */


        //colocaremos el array temporal en el array de que contendra todos los movimientos del usuario no entregados
        array_push($arrayMov, $arrayTemporal);
    }

//print_r($arrayMov);
    /*
     * Array
      (
      [0] => Array
      (
      [usuario] => Mendez
      [nombreCompleto] => Carlos Mendez Cruz
      [fechaRealizado] => 21-8-2019
      [horaRealizado] => 7:45:38
      [totalPiezas] => 7
      [tipoMovimiento] => S
      [totalImporte] => 1888
      [piezas] => Array
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

      )

      [1] => Array
      (
      [usuario] => Mendez
      [nombreCompleto] => Carlos Mendez Cruz
      [fechaRealizado] => 20-8-2019
      [horaRealizado] => 21:13:56
      [totalPiezas] => 1
      [tipoMovimiento] => S
      [totalImporte] => 174
      [piezas] => Array
      (
      [0] => Array
      (
      [Codigo] => 209
      [Cantidad] => 1
      )

      )

      )

      [2] => Array
      (
      [usuario] => Mendez
      [nombreCompleto] => Carlos Mendez Cruz
      [fechaRealizado] => 21-8-2019
      [horaRealizado] => 7:58:26
      [totalPiezas] => 34
      [tipoMovimiento] => E
      [totalImporte] => 9762
      [piezas] => Array
      (
      [0] => Array
      (
      [Codigo] => 279
      [Cantidad] => 3
      )

      [1] => Array
      (
      [Codigo] => 299
      [Cantidad] => 3
      )

      [2] => Array
      (
      [Codigo] => 339
      [Cantidad] => 11
      )

      [3] => Array
      (
      [Codigo] => 349
      [Cantidad] => 6
      )

      [4] => Array
      (
      [Codigo] => 359
      [Cantidad] => 5
      )

      [5] => Array
      (
      [Codigo] => 389
      [Cantidad] => 4
      )

      [6] => Array
      (
      [Codigo] => 399
      [Cantidad] => 2
      )

      )

      )

      [3] => Array
      (
      [usuario] => Mendez
      [nombreCompleto] => Carlos Mendez Cruz
      [fechaRealizado] => 22-8-2019
      [horaRealizado] => 7:26:29
      [totalPiezas] => 5
      [tipoMovimiento] => S
      [totalImporte] => 1104
      [piezas] => Array
      (
      [0] => Array
      (
      [Codigo] => 209
      [Cantidad] => 3
      )

      [1] => Array
      (
      [Codigo] => 349
      [Cantidad] => 2
      )

      )

      )

      [4] => Array
      (
      [usuario] => Mendez
      [nombreCompleto] => Carlos Mendez Cruz
      [fechaRealizado] => 22-8-2019
      [horaRealizado] => 7:34:44
      [totalPiezas] => 19
      [tipoMovimiento] => E
      [totalImporte] => 5344
      [piezas] => Array
      (
      [0] => Array
      (
      [Codigo] => 209
      [Cantidad] => 5
      )

      [1] => Array
      (
      [Codigo] => 359
      [Cantidad] => 5
      )

      [2] => Array
      (
      [Codigo] => 389
      [Cantidad] => 2
      )

      [3] => Array
      (
      [Codigo] => 399
      [Cantidad] => 7
      )

      )

      )

      )
     */


    
    
    
//yyy por ultimo retornamos el json array al movil que quedo asi:
//[{"usuario":"Mendez","nombreCompleto":"Carlos Mendez Cruz","fechaRealizado":"21-8-2019","horaRealizado":"7:45:38","totalPiezas":"7","tipoMovimiento":"S","totalImporte":"1888","piezas":[{"Codigo":"399","Cantidad":"3"},{"Codigo":"299","Cantidad":"1"},{"Codigo":"279","Cantidad":"2"},{"Codigo":"209","Cantidad":"1"}]},{"usuario":"Mendez","nombreCompleto":"Carlos Mendez Cruz","fechaRealizado":"20-8-2019","horaRealizado":"21:13:56","totalPiezas":"1","tipoMovimiento":"S","totalImporte":"174","piezas":[{"Codigo":"209","Cantidad":"1"}]},{"usuario":"Mendez","nombreCompleto":"Carlos Mendez Cruz","fechaRealizado":"21-8-2019","horaRealizado":"7:58:26","totalPiezas":"34","tipoMovimiento":"E","totalImporte":"9762","piezas":[{"Codigo":"279","Cantidad":"3"},{"Codigo":"299","Cantidad":"3"},{"Codigo":"339","Cantidad":"11"},{"Codigo":"349","Cantidad":"6"},{"Codigo":"359","Cantidad":"5"},{"Codigo":"389","Cantidad":"4"},{"Codigo":"399","Cantidad":"2"}]},{"usuario":"Mendez","nombreCompleto":"Carlos Mendez Cruz","fechaRealizado":"22-8-2019","horaRealizado":"7:26:29","totalPiezas":"5","tipoMovimiento":"S","totalImporte":"1104","piezas":[{"Codigo":"209","Cantidad":"3"},{"Codigo":"349","Cantidad":"2"}]},{"usuario":"Mendez","nombreCompleto":"Carlos Mendez Cruz","fechaRealizado":"22-8-2019","horaRealizado":"7:34:44","totalPiezas":"19","tipoMovimiento":"E","totalImporte":"5344","piezas":[{"Codigo":"209","Cantidad":"5"},{"Codigo":"359","Cantidad":"5"},{"Codigo":"389","Cantidad":"2"},{"Codigo":"399","Cantidad":"7"}]}]
    

echo json_encode($arrayMov);
    
    //ponemos la hora de envio a los movimientos del almacen
    $dataBase->movimientos_inventarios_sucursales_bitacora_ponerEnviadoAlMovil($propietario);
}


