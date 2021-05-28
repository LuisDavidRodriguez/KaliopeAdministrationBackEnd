<?php session_start();

//Comprobamos si ay sesion y ejecutamos instrucciones
if(isset($_SESSION['usuario'])){

    $zona = $_GET['zona'];
    $fecha = $_GET['fecha'];


    //Comprobamos que se mandaron los datos por POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Extraemos la informacion de POST asignamos el nombre del array.
        $cliente = $_POST;

		//Quitamos el ultimo dato del array es: guardar que manda el boton de enviar.
        $ultimo_array_boton_enviar = array_pop($cliente);

        $cliente = array_chunk($cliente, 44);

        $cliente = $cliente[0];



		//Creamos la conexion a la base de datos para utilizarla mas adelante.
		try {
			$conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
		} catch(PDOException $e){
			echo "Error" . $e->getMessage();;
        }

        //Asignamos un nombre a cada variable del array.
			$folio =  filter_var(strtoupper ($cliente[0]), FILTER_SANITIZE_STRING); 
			$zona = filter_var(strtoupper ($cliente[1]), FILTER_SANITIZE_STRING); 
			$cuenta = filter_var(strtoupper ($cliente[2]), FILTER_SANITIZE_STRING); 
			$nombre = filter_var(strtoupper ($cliente[3]), FILTER_SANITIZE_STRING); 
			$telefono = filter_var(strtoupper ($cliente[4]), FILTER_SANITIZE_STRING);
			$grado = filter_var(strtoupper ($cliente[5]), FILTER_SANITIZE_STRING);
			$credito = filter_var(strtoupper ($cliente[6]), FILTER_SANITIZE_STRING);
			$dias = filter_var(strtoupper ($cliente[7]), FILTER_SANITIZE_STRING);
			$estado = filter_var(strtoupper ($cliente[8]), FILTER_SANITIZE_STRING);
			$observaciones = filter_var(strtoupper ($cliente[9]), FILTER_SANITIZE_STRING);
			$latitud = filter_var(strtoupper ($cliente[10]), FILTER_SANITIZE_STRING);
			$longitud = filter_var(strtoupper ($cliente[11]), FILTER_SANITIZE_STRING);
			$puntos_disponibles = filter_var(strtoupper ($cliente[12]), FILTER_SANITIZE_STRING);
			$puntos_entregados = filter_var(strtoupper ($cliente[13]), FILTER_SANITIZE_STRING);
			$puntos_cambiados = filter_var(strtoupper ($cliente[14]), FILTER_SANITIZE_STRING);
			$puntos_restantes = filter_var(strtoupper ($cliente[15]), FILTER_SANITIZE_STRING);
			$piezas_cargo = filter_var(strtoupper ($cliente[16]), FILTER_SANITIZE_STRING);
			$importe_cargo = filter_var(strtoupper ($cliente[17]), FILTER_SANITIZE_STRING);
			$adeudo_cargo = filter_var(strtoupper ($cliente[18]), FILTER_SANITIZE_STRING);
			$hora_cargo = filter_var(strtoupper ($cliente[19]), FILTER_SANITIZE_STRING);
			$fecha_cargo = filter_var(strtoupper ($cliente[20]), FILTER_SANITIZE_STRING);
			$fecha_vence_cargo = filter_var(strtoupper ($cliente[21]), FILTER_SANITIZE_STRING);
			$mercancia_cargo = filter_var(strtoupper ($cliente[22]), FILTER_SANITIZE_STRING);
			$pz_devueltas = filter_var(strtoupper ($cliente[23]), FILTER_SANITIZE_STRING);
			$importe_devolucion = filter_var(strtoupper ($cliente[24]), FILTER_SANITIZE_STRING);
			$cierre = filter_var(strtoupper ($cliente[25]), FILTER_SANITIZE_STRING);
			$pago_cierre = filter_var(strtoupper ($cliente[26]), FILTER_SANITIZE_STRING);
			$pago_adeudo = filter_var(strtoupper ($cliente[27]), FILTER_SANITIZE_STRING);
			$pago_otro = filter_var(strtoupper ($cliente[28]), FILTER_SANITIZE_STRING);
			$pago_dif_regalo = filter_var(strtoupper ($cliente[29]), FILTER_SANITIZE_STRING);
			$total_pagos = filter_var(strtoupper ($cliente[30]), FILTER_SANITIZE_STRING);
			$mercancia_devuelta = filter_var(strtoupper ($cliente[31]), FILTER_SANITIZE_STRING);
			$piezas_entregadas = filter_var(strtoupper ($cliente[32]), FILTER_SANITIZE_STRING);
			$importe_entregado = filter_var(strtoupper ($cliente[33]), FILTER_SANITIZE_STRING);
			$adeudo = filter_var(strtoupper ($cliente[34]), FILTER_SANITIZE_STRING);
			$fecha_vencimiento = filter_var(strtoupper ($cliente[35]), FILTER_SANITIZE_STRING);
			$hora = filter_var(strtoupper ($cliente[36]), FILTER_SANITIZE_STRING);
			$fecha_entrega = filter_var(strtoupper ($cliente[37]), FILTER_SANITIZE_STRING);
			$reporte_agente = filter_var(strtoupper ($cliente[38]), FILTER_SANITIZE_STRING);
			$historial = filter_var(strtoupper ($cliente[39]), FILTER_SANITIZE_STRING);
			$mercancia_entregada = filter_var(strtoupper ($cliente[40]), FILTER_SANITIZE_STRING);
			$reporte_administracion = filter_var(strtoupper ($cliente[41]), FILTER_SANITIZE_STRING);
			$firma_voz = filter_var(strtoupper ($cliente[42]), FILTER_SANITIZE_STRING);
			$revisada = filter_var(strtoupper ($cliente[43]), FILTER_SANITIZE_STRING);
			
			$reporte_agente = preg_replace('/[#]+/', 'No.', $reporte_agente);
            
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
            
            //Como la fecha la mandamos por el Folio, asignamos la variable.
            $fecha = $folio;

		    //Ejecutamos la conexion y especificamos las tablas a modificar
		    $guardar_clientes = $conexion->prepare(
                "INSERT INTO movimientos (folio, zona, fecha, cuenta, nombre, telefono, grado, credito, dias, estado, observaciones, 
                latitud, longitud, puntos_disponibles, puntos_entregados, puntos_cambiados, puntos_restantes, piezas_cargo, 
                importe_cargo, mercancia_cargo, adeudo_cargo, hora_cargo, fecha_cargo, fecha_vence_cargo, reporte_agente, reporte_administracion, 
                firma_voz, revisada)
                VALUES ('', '$zona', '$fecha', '$cuenta', '$nombre', '$telefono', '$grado', '$credito', '$dias', '$estado', 
                '$observaciones', '$latitud', '$longitud', '$puntos_disponibles', '$puntos_entregados', '$puntos_cambiados', 
                '$puntos_restantes', '$piezas_cargo', '$importe_cargo', '$mercancia_cargo', '$adeudo_cargo', '$hora_cargo', 
                '$fecha_cargo', '$fecha_vence_cargo', '$reporte_agente', '$reporte_administracion', '$firma_voz', '$revisada')"
                );
                $guardar_clientes->execute();

                header("Location: contenido.php?zona=$zona&fecha=$fecha");
    }

    require 'views/ingresa_cliente.view.php';

} else {
    header('Location: ingresa.php');
}


?>