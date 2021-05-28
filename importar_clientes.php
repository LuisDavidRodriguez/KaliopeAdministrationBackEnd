<?php session_start();

//Comprobamos la sesion, si ay sesion requerimos de la vista de selecciona ruta
if(isset($_SESSION['usuario'])){
    
    if (isset ($_POST['enviar_informacion'])) {
    
        //Comprobamos que se mandaron los datos por POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
            //Comprobamos que se ayan mandado datos.
            if (empty($_POST['datos'])) {
                
                header ('Location: importar_clientes.php');
    
            //Si se mandaron datos se procesan.
            }else{
    
                //Guardamos los datos en una variable.
                $datos = ($_POST['datos']);
                
    
                //Separamos los datos por el salto de linea.
                $datos_separados = explode(PHP_EOL, $datos);
                

                    //Obtenemos la zona del array y la limpiamos de cualquier caracter html.
                    $zona = filter_var(strtoupper (array_shift($datos_separados)), FILTER_SANITIZE_STRING);

                    //Limpiamos la zona de los numeros
                    $zona1 = preg_replace('/[0-9]+/', '', $zona);

                    //Limpiamos la zona de saltos de linea y espacios
                    $zona1 = trim($zona1);
    
                    //Creamos la conexion a la base de datos para utilizarla mas adelante.
                    try {
                        $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
                    } catch (PDOException $e) {
                        echo "Error".$e->getMessage('Error al conectar con base de datos');;
                    }
    
                    //Creamos la fecha actual.
                    $fecha = '26-04-2019'; //date("d-m-Y");
                    //echo $fecha;
    
                    //Listo nos quedan solo los datos para que ocupamos para procesarlos.
    
                    //Asignamos el valor del iterador.
                    $i=0;
    
                    //Ejecutamos foreach para ir manejando los datos de los clientes.
                    foreach ($datos_separados as $cliente) {
                        //Separamos los datos por la coma, y iteramos para que valla cambiando de cliente.
                        $datos_cliente = explode('#', $datos_separados[$i]);
                        //print_r($datos_cliente);
                        //Iterador.
                        $i=$i+1;
                        
                        //Condicionales si esta vacio la variable, asignamos valor 0.
                        if (empty($datos_cliente[0])) {
                            $cuenta = 0;
                            } else {
                            $cuenta = filter_var(strtoupper ($datos_cliente[0]), FILTER_SANITIZE_STRING);
                            
                            }
    
                        if (empty($datos_cliente[1])) {
                            $nombre = 0;
                            } else {
                            $nombre = filter_var(strtoupper ($datos_cliente[1]), FILTER_SANITIZE_STRING);
                            }
    
                        if (empty($datos_cliente[2])) {
                            $telefono = 0;
                            } else {
                            $telefono = filter_var(strtoupper ($datos_cliente[2]), FILTER_SANITIZE_STRING);
                            }
    
                        if (empty($datos_cliente[3])) {
                            $dias = 0;
                            } else {
                            $dias = filter_var(strtoupper ($datos_cliente[3]), FILTER_SANITIZE_STRING);
                            }
                        
                        if (empty($datos_cliente[4])) {
                            $grado = 0;
                            } else {
                            $grado = filter_var(strtoupper ($datos_cliente[4]), FILTER_SANITIZE_STRING);
                            }
    
                        if (empty($datos_cliente[5])) {
                            $credito = 0;
                            } else {
                            $credito = filter_var(strtoupper ($datos_cliente[5]), FILTER_SANITIZE_STRING);;
                            }
    
                        if (empty($datos_cliente[6])) {
                            $estado = 0;
                            } else {
                            $estado = filter_var(strtoupper ($datos_cliente[6]), FILTER_SANITIZE_STRING);;
                            }
    
                        if (empty($datos_cliente[7])) {
                            $latitud = 0;
                            } else {
                            $latitud = filter_var(strtoupper ($datos_cliente[7]), FILTER_SANITIZE_STRING);;
                            }
    
                        if (empty($datos_cliente[8])) {
                            $longitud = 0;
                            } else {
                            $longitud = filter_var(strtoupper ($datos_cliente[8]), FILTER_SANITIZE_STRING);;
                            }
    
                        if (empty($datos_cliente[9])) {
                            $adeudo_cargo = 0;
                            } else {
                            $adeudo_cargo = filter_var(strtoupper ($datos_cliente[9]), FILTER_SANITIZE_STRING);;
                            }
    
                        if (empty($datos_cliente[10])) {
                            $piezas_cargo = 0;
                            } else {
                            $piezas_cargo = filter_var(strtoupper ($datos_cliente[10]), FILTER_SANITIZE_STRING);;
                            }
    
                        if (empty($datos_cliente[11])) {
                            $importe_cargo = 0;
                            } else {
                            $importe_cargo = filter_var(strtoupper ($datos_cliente[11]), FILTER_SANITIZE_STRING);;
                            }
    
                        if (empty($datos_cliente[12])) {
                            $fecha_vence_cargo = 0;
                            } else {
                            $fecha_vence_cargo = filter_var(strtoupper ($datos_cliente[12]), FILTER_SANITIZE_STRING);;
                            }
                        
                        $historial = $datos_cliente[13];
    
                        if (empty($datos_cliente[14])) {
                            $puntos_disponibles = 0;
                            } else {
                            $puntos_disponibles = filter_var(strtoupper ($datos_cliente[14]), FILTER_SANITIZE_STRING);;
                            }
    
                        if (empty($datos_cliente[15])) {
                            $reporte_agente = 0;
                            } else {
                            $reporte_agente = filter_var(strtoupper ($datos_cliente[15]), FILTER_SANITIZE_STRING);
                            }
                        
                        if (empty($datos_cliente[16])) {
                            $reporte_administracion = 0;
                            } else {
                            $reporte_administracion = filter_var(strtoupper ($datos_cliente[16]), FILTER_SANITIZE_STRING);;
                            }
                            
                        if (empty($datos_cliente[18])) {
                            $mercancia_cargo = 0;
                            } else {
                            $mercancia_cargo = filter_var(strtoupper ($datos_cliente[18]), FILTER_SANITIZE_STRING);;
                            }

                        
                        if (empty($datos_cliente[19])) {
                            $fecha_entrega = 0;
                            $hora = 0;
                            } else {
                                $fecha_hora = trim($datos_cliente[19]);
                                $medida_string = strlen($fecha_hora);
                                //Checamos la medida de fecha_hora por que las fechas iniciales varean de: 3-01-2019 a 15-03-2019 ay mas caracteres.
                                if ($medida_string == 19) {
                                    $fecha_entrega = substr($fecha_hora, 0, -9);
            
                                    $hora = substr($fecha_hora, 11);
                                } else {
                                    $fecha_entrega = substr($fecha_hora, 0, -9);
            
                                    $hora = substr($fecha_hora, 9);
                                }                            
                                   
                            }

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
    
                        $guardar_clientes = $conexion->prepare(
                            "INSERT INTO movimientos (folio, zona, fecha, cuenta, nombre, telefono, dias, grado, credito, 
                            estado, latitud, longitud, adeudo_cargo, piezas_cargo, importe_cargo, fecha_vence_cargo, 
                            puntos_disponibles, reporte_agente, reporte_administracion, mercancia_cargo, fecha_cargo, hora_cargo, firma_voz, revisada) 
                            VALUES ('', '$zona1', '$fecha', '$cuenta', '$nombre', '$telefono', '$dias', '$grado', '$credito', 
                            '$estado', '$latitud', '$longitud', '$adeudo_cargo', '$piezas_cargo', '$importe_cargo', '$fecha_vence_cargo', 
                            '$puntos_disponibles', '$reporte_agente', '$reporte_administracion', '$mercancia_cargo', '$fecha_entrega', '$hora', '$firma_voz', '$revisada')"
                        );
                        $guardar_clientes->execute();

                        //Mostramos los datos que se trabajaron
                        echo $cuenta . '<br/>';
                        echo $nombre . '<br/>';
                        echo $telefono . '<br/>';
                        echo $dias . '<br/>';
                        echo $grado . '<br/>';
                        echo $credito . '<br/>';
                        echo $estado . '<br/>';
                        echo $latitud . '<br/>';
                        echo $longitud . '<br/>';
                        echo $adeudo_cargo . '<br/>';
                        echo $piezas_cargo . '<br/>';
                        echo $importe_cargo . '<br/>';
                        echo $fecha_vence_cargo . '<br/>';
                        echo $historial . '<br/>';
                        echo $puntos_disponibles . '<br/>';
                        echo $reporte_agente . '<br/>';
                        echo $reporte_administracion . '<br/>';
                        echo $mercancia_cargo . '<br/>';
                        echo $fecha_entrega . '<br/>';
                        echo $hora. '<br/>';
    
                        echo 'Guardado Exitoso'.'<br/>'.'<br/>';                       
                  
                    } 
                    
                    $guardar = $conexion->prepare(
                        "INSERT INTO inventarios (folio, zona, fecha)
                        VALUES ('', '$zona1', '$fecha')"
                    );
                    $guardar->execute();

                    $guardar = $conexion->prepare(
                        "INSERT INTO vehiculos (folio, zona, fecha)
                        VALUES ('', '$zona1', '$fecha')"
                    );
                    $guardar->execute();
    
            }
        }
    }else {
        require 'views/importar_clientes.view.php';
    }

    //Si no ay sesion mandamos a ingresa para crear la sesion
}else{
    header('Location: ingresa.php');
}





?>