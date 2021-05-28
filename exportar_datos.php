<?php session_start();
    
    //Comprobamos si ay sesion y ejecutamos instrucciones
    if(isset($_SESSION['usuario'])){

        //creamos la coneccion a la base de datos
    try{
        $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
    }catch(PDOException $e){
        echo "Error".$e->getMessage();;
    }

        //Recibimos la zona.
        $zona = $_GET['zona'];

        //Consultamos las fechas en la base de datos para obtener la ultima fecha del movimiento
        $fechas=$conexion->prepare(
            "SELECT DISTINCT fecha FROM movimientos WHERE zona = '$zona'"
        );
        $fechas->execute();
        $datos_fecha = $fechas->fetchAll();
        //print_r($datos_fecha);

        //Extraemos la ultima fecha de la consulta
        $ultima_fecha = array_pop($datos_fecha);
        $ultima_fecha2 = $ultima_fecha[0];


        //Como se extrae la ultima fecha con este comando volvemos a ingresar la ultima fecha en el array para dejar como al inicio con todos sus datos
        array_push($datos_fecha, $ultima_fecha);


        //Recibimos la fecha de contenido.view por el metodo get.
        //si no ay fecha escogemos la ultima fecha que extraimos de la base de datos.
        if (empty($_GET['fecha'])) {
            $fecha_consulta = $ultima_fecha2;
        }else{
            $fecha_consulta = $_GET['fecha'];
        }

        //Solisitamos los datos que necesitamos a la bd.
        $datos_clientes = $conexion->prepare(
            "SELECT cuenta, nombre, telefono, dias, grado, credito, estado, latitud_fija, longitud_fija, adeudo_cargo, piezas_cargo, importe_cargo, 
            fecha_vence_cargo, puntos_disponibles, reporte_agente, reporte_administracion, mercancia_cargo 
            FROM movimientos WHERE zona='$zona' AND fecha='$fecha_consulta'"
        );
        $datos_clientes->execute();
        $datos_clientes = $datos_clientes->fetchAll();


        //Creamos 25 variables de clientes, para utilisarlas en ciclo foreach.
        $cliente0 = '';
        $cliente1 = '';
        $cliente2 = '';
        $cliente3 = '';
        $cliente4 = '';
        $cliente5 = '';
        $cliente6 = '';
        $cliente7 = '';
        $cliente8 = '';
        $cliente9 = '';
        $cliente10 = '';
        $cliente11 = '';
        $cliente12 = '';
        $cliente13 = '';
        $cliente14 = '';
        $cliente15 = '';
        $cliente16 = '';
        $cliente17 = '';
        $cliente18 = '';
        $cliente19 = '';
        $cliente20 = '';
        $cliente21 = '';
        $cliente22 = '';
        $cliente23 = '';
        $cliente24 = '';
        $cliente25 = '';

        //Inicialisamos el iterador para ingresarlo al foreach.
        $a = 0;
        foreach ($datos_clientes as $dato) {

            $a = $a + 1;
            
            //Asignamos una variable a cada dato del cliente.
            $cuenta = $dato[0];
            $nombre = $dato[1];
            $telefono = $dato[2];
            $dias = $dato[3];
            $grado = $dato[4];
            $credito = $dato[5];
            $estado = $dato[6];
            $latitud = $dato[7];
            $longitud = $dato[8];
            $adeudo_cargo = $dato[9];
            $piezas_cargo = $dato[10];
            $importe_cargo = $dato[11];
            $fecha_vence_cargo = $dato[12];
            $puntos_disponibles = $dato[13];
            $reporte_agente = $dato[14];
            $reporte_administracion = $dato[15];
            $estado_visita = 'VISITAR';
            $mercancia_cargo = $dato[16];

            //Para hacer el historial del cliente, solicitamos a bd informacion de los ultimos 5 movimientos.
            $datos_ventas = $conexion->prepare(
                "SELECT fecha, total_pagos, adeudo, reporte_agente FROM movimientos WHERE cuenta = '$cuenta' ORDER BY folio DESC LIMIT 5"
            );
            $datos_ventas->execute();
            $datos_ventas = $datos_ventas->fetchAll();

            //Inicialisamos las variables para los 5 ultimos movimientos.
            $historial1 = '';
            $historial2 = '';
            $historial3 = '';
            $historial4 = '';
            $historial5 = '';

            //Inicialisamos el iterador para ingresar al ciclo foreach.
            $i=0;
            foreach ($datos_ventas as $datos) {
                $i = $i + 1;
                
                //Asignamos una variable para cada dato del historial.
                $fecha = $datos[0];
                $total_pagos = $datos[1];
                $adeudo = $datos[2];
                $reporte_agente2 = $datos[3];


                //Cuando vaya iterando va a entrar y modificar cada uno de los historiales, y vamos concatenando los
                //datos del historial para que queden como queremos.
                if ($i == 1) {
                    $historial1 ='*' . $fecha . ', P: ' . $total_pagos . ', S: ' . $adeudo . ', R: ' . $reporte_agente2 . '*';
                }
                if ($i == 2) {
                    $historial2 ='*' . $fecha . ', P: ' . $total_pagos . ', S: ' . $adeudo . ', R: ' . $reporte_agente2 . '*';
                }
                if ($i == 3) {
                    $historial3 ='*' . $fecha . ', P: ' . $total_pagos . ', S: ' . $adeudo . ', R: ' . $reporte_agente2 . '*';
                }
                if ($i == 4) {
                    $historial4 ='*' . $fecha . ', P: ' . $total_pagos . ', S: ' . $adeudo . ', R: ' . $reporte_agente2 . '*';
                }
                if ($i == 5) {
                    $historial5 ='*' . $fecha . ', P: ' . $total_pagos . ', S: ' . $adeudo . ', R: ' . $reporte_agente2 . '*';
                }

            }

            //Concatenamos los 5 historiales para que nos quede todo dentro de uno mismo.
            $historial = $historial1 . $historial2 . $historial3 . $historial4 . $historial5;


            // echo $cuenta . '<br/>' ;
            // echo $nombre . '<br/>';
            // echo $telefono . '<br/>';
            // echo $dias . '<br/>';
            // echo $grado . '<br/>';
            // echo $credito . '<br/>';
            // echo $estado . '<br/>';
            // echo $latitud . '<br/>';
            // echo $longitud . '<br/>';
            // echo $adeudo_cargo . '<br/>';
            // echo $piezas_cargo . '<br/>';
            // echo $importe_cargo . '<br/>';
            // echo $fecha_vence_cargo . '<br/>';
            // echo $historial . '<br/>' ;
            // echo $puntos_disponibles . '<br/>';
            // echo $reporte_agente . '<br/>';
            // echo $reporte_administracion . '<br/>';
            // echo $estado_visita . '<br/>';
            // echo $mercancia_cargo . '<br/>'  . '<br/>';

            //Cuando vaya iterando va a entrar y modificar cada uno de los clientes, y vamos concatenando los
            //datos de los clientes separando por '#' para que queden separados.
            if ($a == 1) {
                $cliente1 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 2) {
                $cliente2 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 3) {
                $cliente3 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 4) {
                $cliente4 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 5) {
                $cliente5 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 6) {
                $cliente6 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 7) {
                $cliente7 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo .  '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 8) {
                $cliente8 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 9) {
                $cliente9 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 10) {
                $cliente10 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 11) {
                $cliente11 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 12) {
                $cliente12 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 13) {
                $cliente13 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 14) {
                $cliente14 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 15) {
                $cliente15 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 16) {
                $cliente16 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 17) {
                $cliente17 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 18) {
                $cliente18 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 19) {
                $cliente19 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 20) {
                $cliente20 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 21) {
                $cliente21 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 22) {
                $cliente22 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 23) {
                $cliente23 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 24) {
                $cliente24 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }
            if ($a == 25) {
                $cliente25 = $cuenta . '#' . $nombre . '#' . $telefono . '#' . $dias . '#' . $grado . '#' . $credito . '#' . $estado . '#' . $latitud . '#' . $longitud . '#' . 
                $adeudo_cargo . '#' . $importe_cargo . '#' . $fecha_vence_cargo . '#' . $historial . '#' . $puntos_disponibles . '#' . $reporte_agente . '#' . $reporte_administracion . '#' . 
                $estado_visita . '#' . $mercancia_cargo;
            }

        }
        
        //Concatenamos los 25 clientes para que nos quede todo dentro de uno mismo.
        //Y separamos por el salto de linea.

        $encabezado = $zona . '#id';

        $clientes = $encabezado . PHP_EOL . $cliente1 . PHP_EOL . $cliente2 . PHP_EOL . $cliente3 . PHP_EOL . $cliente4 . PHP_EOL . $cliente5 . PHP_EOL . $cliente6 . PHP_EOL . $cliente7 . PHP_EOL . $cliente8
        . PHP_EOL . $cliente9 . PHP_EOL . $cliente10 . PHP_EOL . $cliente11 . PHP_EOL . $cliente12 . PHP_EOL . $cliente13 . PHP_EOL . $cliente14 . PHP_EOL . $cliente15 . PHP_EOL . $cliente16
        . PHP_EOL . $cliente17 . PHP_EOL . $cliente18 . PHP_EOL . $cliente19 . PHP_EOL . $cliente20 . PHP_EOL . $cliente21 . PHP_EOL . $cliente22 . PHP_EOL . $cliente23 . PHP_EOL . $cliente24
        . PHP_EOL . $cliente25;

        //definimos nombre del archivo.
        //quitamos los espacios en blanco a la zona:
        $zona = str_replace(' ', '', $zona);
        $nombre_archivo = $zona . $fecha_consulta . '.txt';

        //agregamos la informacion de los clientes al archivo.
        file_put_contents($nombre_archivo, $clientes);


        //Solicitamos la descarga del archivo al servidor.
        header("Content-disposition: attachment; filename=$nombre_archivo");
        header("Content-type: text/plain");
        readfile("$nombre_archivo");


    }else {
        header('Location: ingresa.php');
    }
    

?>