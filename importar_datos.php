<?php session_start();

//Comprobamos que se inicio sesion
if(isset($_SESSION['usuario'])){
    
    //Mandamos los datos a la misma pagina y los procesamos.
    if (isset($_POST['enviar'])) {

        //Comprobamos que se mandaron los datos por POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //Comprobamos que se ayan mandado datos.
            if (empty($_POST['datos'])) {
                
                header ('Location: importar_datos.php');

            //Si se mandaron datos se procesan.
            }else{

                //Guardamos los datos en una variable.
                $datos = ($_POST['datos']);

                //Separamos los datos por el salto de linea.
                $datos_separados = explode(PHP_EOL, $datos);
                
                //Asignamos una variable a los identificadores de cadena y los limpiamos de saltos de linea con trim.
                $identificador_inicial = trim($datos_separados[0]);
                $identificador_final = trim(end($datos_separados));

                //Comprobamos los identificadores si estan pasamos al ciclo.
                if ($identificador_inicial == '?' && $identificador_final == '?') {

                    //Quitamos los identificadores (?).
                    array_shift($datos_separados);
                    array_pop($datos_separados);

                    //Obtenemos la zona del array y la limpiamos y quitamos numeros y limpiamos de saltos de Linea.
                    $zona = filter_var(strtoupper (array_shift($datos_separados)), FILTER_SANITIZE_STRING);
                    $zona1 = preg_replace('/[0-9]+/', '', $zona);
                    $zona1 = trim($zona1);

                    //Creamos la conexion a la base de datos para utilizarla mas adelante.
                    try {
                        $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
                    } catch (PDOException $e) {
                        echo "Error".$e->getMessage('Error al conectar con base de datos');;
                    }

                    //Listo nos quedan solo los datos para que ocupamos para procesarlos.

                    //Asignamos el valor del iterador.
                    $i=0;

                    //Ejecutamos foreach para ir manejando los datos de los clientes.
                    foreach ($datos_separados as $cliente) {
                        //Separamos los datos por la coma, y iteramos para que valla cambiando de cliente.
                        $datos_cliente = explode(',', $datos_separados[$i]);
                        //Iterador.
                        $i++;
                        
                        //Condicionales si esta vacio la variable, asignamos valor 0.
                        if (empty($datos_cliente[0])) {
                            $cuenta = 0;
                            } else {
                            $cuenta = $datos_cliente[0];
                            }

                        if (empty($datos_cliente[1])) {
                            $nombre = 0;
                            } else {
                            $nombre = $datos_cliente[1];
                            }

                        if (empty($datos_cliente[2])) {
                            $pz_devueltas = 0;
                            } else {
                            $pz_devueltas = $datos_cliente[2];
                            }

                        if (empty($datos_cliente[3])) {
                            $importe_devolucion = 0;
                            } else {
                            $importe_devolucion = $datos_cliente[3];
                            }
                        
                        if (empty($datos_cliente[4])) {
                            $mercancia_devuelta = 0;
                            } else {
                            $mercancia_devuelta = $datos_cliente[4];
                            }

                        if (empty($datos_cliente[5])) {
                            $pago_cierre = 0;
                            } else {
                            $pago_cierre = $datos_cliente[5];
                            }

                        if (empty($datos_cliente[6])) {
                            $pago_adeudo = 0;
                            } else {
                            $pago_adeudo = $datos_cliente[6];
                            }

                        if (empty($datos_cliente[7])) {
                            $pago_otro = 0;
                            } else {
                            $pago_otro = $datos_cliente[7];
                            }

                        if (empty($datos_cliente[8])) {
                            $pago_dif_regalo = 0;
                            } else {
                            $pago_dif_regalo = $datos_cliente[8];
                            }
                        
                        //Como no tenemos el total de pagos, lo obtenemos sumando todos los pagos.
                        $total_pagos = $pago_cierre + $pago_adeudo + $pago_otro + $pago_dif_regalo;
                        
                        if (empty($datos_cliente[10])) {
                            $puntos_entregados = 0;
                            } else {
                            $puntos_entregados = $datos_cliente[10];
                            }

                        
                        //Limpiamos la fecha de entrega, solo si es cliente.
                        $historial = substr($datos_cliente[11], 10);

                        if (empty($datos_cliente[11])) {
                            $fecha_entrega = 0;
                            } else {
                                if ($cuenta <= 9) {
                                    $fecha_entrega = $datos_cliente[11];
                                        }else {
                                        $fecha_entrega = substr($datos_cliente[11], 0, 10);
                                        }                    
                                    }

                        if (empty($datos_cliente[12])) {
                            $piezas_entregadas = 0;
                            } else {
                            $piezas_entregadas = $datos_cliente[12];
                            }

                        if (empty($datos_cliente[13])) {
                            $importe_entregado = 0;
                            } else {
                            $importe_entregado = $datos_cliente[13];
                            }

                        if (empty($datos_cliente[14])) {
                            $mercancia_entregada = 0;
                            } else {
                            $mercancia_entregada = $datos_cliente[14];
                            }

                        if (empty($datos_cliente[15])) {
                            $fecha_vencimiento = 0;
                            } else {
                            $fecha_vencimiento = $datos_cliente[15];
                            }
                        
                        if (empty($datos_cliente[16])) {
                            $hora = 0;
                            } else {
                            $hora = substr($datos_cliente[16], 10);
                            }

                        if (empty($datos_cliente[17])) {
                            $puntos_cambiados = 0;
                            } else {
                            $puntos_cambiados = $datos_cliente[17];
                            }
                        
                        if (empty($datos_cliente[18])) {
                            $latitud = 0;
                            }else {
                            $latitud = $datos_cliente[18];
                            }

                        if (empty($datos_cliente[19])) {
                            $longitud = 0;
                            }else {
                            $longitud = $datos_cliente[19];
                            }

                        //Le quitamos a los puntos la diferencia de regalo.
                        $puntos_cambiados = $puntos_cambiados - $pago_dif_regalo;

                        //Redondeamos los puntos cambiados.
                        if ($puntos_cambiados > 51) {
                            for ($z=50; $z < 2000; $z+=50) { 
                                if ($puntos_cambiados > $z && $puntos_cambiados <= $z+50) {
                                    $puntos_cambiados = $z + 50;
                                    break;
                                }
                            }
                        }

                        
                        //Inicialisamos las variables cierre, adeudo, puntos disponibles y puntos restantes.
                        $cierre = 0;
                        $adeudo = 0;
                        $puntos_disponibles = 0;
                        $puntos_restantes = 0;

                        //Sacamos su cierre: consultamos bd.
                        if ($cuenta > 31) {
                            $Importe_cargo = $conexion->prepare(
                                "SELECT importe_cargo FROM movimientos WHERE cuenta = '$cuenta' AND fecha = '$fecha_entrega' AND zona = '$zona1'"
                            );
                            $Importe_cargo->execute();
                            $array_importe_cargo = $Importe_cargo->fetchAll();
                            $total_importe = $array_importe_cargo[0][0];

                            $adeudo_cargo = $conexion->prepare(
                                "SELECT adeudo_cargo FROM movimientos WHERE cuenta = '$cuenta' AND fecha = '$fecha_entrega' AND zona = '$zona1'"
                            );
                            $adeudo_cargo->execute();
                            $adeudo_cargo = $adeudo_cargo->fetchAll();
                            $adeudo_cargo = $adeudo_cargo[0][0];
                            
                            $cierre = $total_importe - $importe_devolucion;

                            $pagos = $pago_cierre + $pago_adeudo + $pago_otro;
                            $adeudo = ($cierre + $adeudo_cargo) - $pagos;

                            $puntos_disponibles = $conexion->prepare(
                                "SELECT puntos_disponibles FROM movimientos WHERE cuenta = '$cuenta' AND fecha = '$fecha_entrega' AND zona = '$zona1'"
                            );
                            $puntos_disponibles->execute();
                            $puntos_disponibles = $puntos_disponibles->fetchAll();
                            $puntos_disponibles = $puntos_disponibles[0][0];
                            

                            $puntos_restantes = ($puntos_disponibles + $puntos_entregados) - $puntos_cambiados;
                        }             
                            

                        //Ingresamos cuenta nueva de 10 a 30 es un cliente nuevo.
                        if ($cuenta >= 10 && $cuenta < 30 ) {

                            //Como es cliente nuevo asignamos valores de primera vez.
                            $grado = 'vendedora';
                            $credito = 1500;
                            $dias = 14;
                            $firma_voz = 'NO';
                            $revisada = 'NO';

                            //Vamos a abtener el numero de cuenta que nos va a dar la bd.
                            //Primero insertamos solo el nombre por que el no_cuenta es autoincrement.
                            $no_cuenta = $conexion->prepare(
                                "INSERT INTO cuentas (no_cuenta, nombre) VALUES ('', '$nombre')"
                            );
                            $no_cuenta->execute();

                            //Despues seleccionamos el numero de cuenta que nos devolvio la bd de acuerdo a su nombre.
                            $no_cuenta = $conexion->prepare(
                                "SELECT no_cuenta FROM cuentas WHERE nombre = '$nombre'"
                            );
                            $no_cuenta->execute();
                            $no_cuenta = $no_cuenta->fetchAll();
                            $no_cuenta = $no_cuenta[0][0];
                            
                            //Asignamos el nuevo numero de cuenta que nos devolvio la bd.
                            $cuenta = $no_cuenta;

                            //Primero comprobamos que no este el cliente en la base de datos por si se ingresa 2 veces la cadena.
                            $cliente_nuevo = $conexion->prepare(
                                "SELECT folio FROM movimientos WHERE cuenta = '$cuenta'"
                            );
                            $cliente_nuevo->execute();
                            $cliente_nuevo = $cliente_nuevo->fetchAll();

                            //Si no esta ingresada nos va a devolver una cosulta vacia la comprobamos y la insertamos a la bd.
                            if (empty($cliente_nuevo)) {
                                $guardar_cliente2 = $conexion->prepare(
                                    "INSERT INTO movimientos (folio, zona, fecha, cuenta, nombre, grado, credito, dias, firma_voz, revisada) 
                                    VALUES ('', '$zona1', '$fecha_entrega', '$cuenta', '$nombre', '$grado', '$credito', '$dias', '$firma_voz', '$revisada')"
                                );
                                $guardar_cliente2->execute();
                            }//Si regresa consulta con datos ya no hacemos nada, por que ya esta ingresada o en esta parte podemos actualisar.
                             
                        }

                        //Comprobamos las cargas del agente y ingresamos a base de datos.
                        if ($cuenta <= 9) {

                            //Si no esta ingresada nos va a devolver una cosulta vacia la comprobamos y la insertamos a la bd.
                                if ($pz_devueltas == 0) {

                                    $salidas = $conexion->prepare(
                                        "UPDATE inventarios SET
                                        salidas = '$piezas_entregadas', 
                                        importe_salidas = '$importe_entregado', 
                                        descripcion_salidas = '$mercancia_entregada' 
                                        WHERE zona = '$zona1' AND fecha = '$fecha_vencimiento'"
                                    );
                                    $salidas->execute();
    
                                }else {
    
                                    $entradas = $conexion->prepare(
                                        "UPDATE inventarios SET
                                        entradas = '$pz_devueltas', 
                                        importe_entradas = '$importe_devolucion', 
                                        descripcion_entradas = '$mercancia_devuelta' 
                                        WHERE zona = '$zona1' AND fecha = '$fecha_vencimiento'"
                                    );
                                    $entradas->execute();
                                }
                            //Si regresa consulta con datos ya no hacemos nada, por que ya esta ingresada o en esta parte podemos actualisar.

                            
                        } else {

                            //SQL Verificamos que la cuenta exista, si existe regresa el no folio.
                            $cliente = $conexion->prepare(
                                "SELECT folio FROM movimientos WHERE cuenta = '$cuenta' AND fecha = '$fecha_entrega' AND zona = '$zona1'"
                            );
                            $cliente->execute();
                            $cliente_existe = $cliente->fetchAll();

                            //Solo ocupamos el folio por lo que lo guardamos en una variable.
                            //Asignamos el valor de folio para que no nos de error.                    
                            if (empty($cliente_existe)) {
                                $folio = '';
                                }else {
                                $folio = $cliente_existe[0][0];
                                }
                            
                        
                            //Comprobamos si algun cliente no existe en BD y matamos el ciclo.
                            //Si todo esta bien procedemos a ingresar a base de datos.
                            if (empty($cliente_existe)) {
                                echo 'El cliente ' . $nombre . ' no existe en BD' . '<br/>' . '<br/>';


                            //SQL guardamos los datos en el Folio que nos mando la consulta cliente existe.
                            }else {
                                $guardar = $conexion->prepare(
                                "UPDATE movimientos SET 
                                latitud = '$latitud', 
                                longitud = '$longitud', 
                                pz_devueltas = '$pz_devueltas', 
                                importe_devolucion = '$importe_devolucion', 
                                mercancia_devuelta = '$mercancia_devuelta', 
                                cierre = '$cierre', 
                                pago_cierre = '$pago_cierre', 
                                pago_adeudo = '$pago_adeudo', 
                                pago_otro = '$pago_otro', 
                                pago_dif_regalo = '$pago_dif_regalo', 
                                total_pagos = '$total_pagos', 
                                puntos_entregados='$puntos_entregados', 
                                puntos_cambiados='$puntos_cambiados', 
                                puntos_restantes='$puntos_restantes', 
                                historial = '$historial', 
                                fecha_entrega = '$fecha_entrega', 
                                piezas_entregadas = '$piezas_entregadas', 
                                importe_entregado = '$importe_entregado', 
                                mercancia_entregada = '$mercancia_entregada', 
                                adeudo = '$adeudo', 
                                fecha_vencimiento = '$fecha_vencimiento', 
                                hora = '$hora' 
                                WHERE folio = '$folio' "
                                );
                                $guardar->execute();
                                echo 'Guardado Exitoso'.'<br/>';
                            }
                        }
                
                        //Mostramos los datos que se trabajaron
                        echo 'Cuenta: ' . $cuenta . '<br/>';
                        echo 'Nombre: ' . $nombre . '<br/>';
                        echo 'Pz Devueltas: ' . $pz_devueltas . '<br/>';
                        echo 'Importe devuelto: ' . $importe_devolucion . '<br/>';
                        echo 'Mercancia devuelta: ' . $mercancia_devuelta . '<br/>';
                        echo 'Cierre: ' . $cierre . '<br/>';
                        echo 'Pago cierre: ' . $pago_cierre . '<br/>';
                        echo 'Pago Adeudo: ' . $pago_adeudo . '<br/>';
                        echo 'Pago otro: ' . $pago_otro . '<br/>';
                        echo 'Pago regalo: ' . $pago_dif_regalo . '<br/>';
                        echo 'Total pagos: ' . $total_pagos . '<br/>';
                        echo 'Puntos entregados: ' . $puntos_entregados . '<br/>';
                        echo 'Fecha Entrega: ' . $fecha_entrega . '<br/>';
                        echo 'historial: ' . $historial . '<br/>';
                        echo 'Piezas entregadas: ' . $piezas_entregadas . '<br/>';
                        echo 'Importe entregado: ' . $importe_entregado . '<br/>';
                        echo 'Mercancia entregado: ' . $mercancia_entregada . '<br/>';
                        echo 'Adeudo: ' . $adeudo . '<br/>';
                        echo 'Fecha vencimiento: ' . $fecha_vencimiento . '<br/>';
                        echo 'Hora: ' . $hora . '<br/>';
                        echo 'Puntos Cambiados: ' . $puntos_cambiados . '<br/>';
                        echo 'Latitud: ' . $latitud . '<br/>';
                        echo 'Longitud: ' . $longitud . '<br/>' . '<br/>';
                
                    }  

                    //Si no concuerdan los identificadores mostramos un error.
                }else {
                echo 'ERROR POR FAVOR INGRESA UNA CADENA VALIDA';
                }
            }
        }

    }else {
        require 'views/importar_datos.view.php';
    }

//Si no se inicio sesion enviamos a pagina ingresa
}else{
    header('Location: ingresa.php');
}





?>