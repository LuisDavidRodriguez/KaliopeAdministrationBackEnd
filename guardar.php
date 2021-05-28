<?php 

session_start();

//Comprobamos la sesion, si ay session ejecutamos y guardamos los datos.
if(isset($_SESSION['usuario']))
{

	//Comprombamos que los datos aigan sido enviados por POST, si si ejecutamos.
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		//Extraemos la informacion de POST asignamos el nombre del array.
		$datos_clientes = $_POST;
		
		//Extraemos los datos adicionales para guardarlos por separado
		$datos_adicionales = array_slice($datos_clientes, 0, 22);

		//Quitamos los datos adicionales, del array, para que queden los puros datos de clientes.
		$conteo = count($datos_clientes);
		$conteo = $conteo - 22;
		$datos_clientes = array_splice($datos_clientes, 22, $conteo);
		//Creamos una matriz separando los clientes de 47 para ingresar a foreach.
		//print_r($datos_clientes);
		$datos_clientes_separados = array_chunk($datos_clientes, 46);

		//Quitamos el ultimo dato del array es: guardar que manda el boton de enviar.
		$ultimo_array_boton_enviar = array_pop($datos_clientes_separados);

		//Creamos la conexion a la base de datos para utilizarla mas adelante.
		try {
			$conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
		} catch(PDOException $e){
			echo "Error" . $e->getMessage();;
		}

		//Guardamos los datos del vehiculo.
		//Asignamos un nombre a cada variable:
		$folio_vehiculo = filter_var(($datos_adicionales['folio_vehiculo']), FILTER_SANITIZE_STRING);
		$vehiculo = filter_var(($datos_adicionales['vehiculo']), FILTER_SANITIZE_STRING);
		$gasolina = filter_var(($datos_adicionales['gasolina']), FILTER_SANITIZE_STRING);
		$gas_lp = 0;
		$total = 0;
		$kilometraje_inicial = filter_var(($datos_adicionales['kilometraje_inicial']), FILTER_SANITIZE_STRING);
		$kilometraje_final = filter_var(($datos_adicionales['kilometraje_final']), FILTER_SANITIZE_STRING);
		$kilometraje_recorrido = filter_var(($datos_adicionales['kilometraje_recorrido']), FILTER_SANITIZE_STRING);
		$litros_gasolina_usados = 0;
		$precio_gasolina = 20;
		$gasolina_manana = filter_var(($datos_adicionales['gasolina_manana']), FILTER_SANITIZE_STRING);
		$litros_gas_usados = 0;
		$precio_gas = 9;
		$gas_lp_manana = filter_var(($datos_adicionales['gas_lp_manana']), FILTER_SANITIZE_STRING);
		
		$total = $gasolina + $gas_lp;
		$kilometraje_recorrido = $kilometraje_final - $kilometraje_inicial;
		$litros_gasolina_usados = $kilometraje_recorrido / 13;
		$litros_gas_usados = $kilometraje_recorrido / 11;
		$gasolina_manana = $litros_gasolina_usados * $precio_gasolina;
		$gas_lp_manana = $litros_gas_usados * $precio_gas;
		//Ejecutamos la conexecion a bd.
		$guardar = $conexion->prepare(
			"UPDATE vehiculos SET 
			vehiculo='$vehiculo',
			gasolina='$gasolina',
			gas_lp='$gas_lp',
			total='$total',
			kilometraje_inicial='$kilometraje_inicial',
			kilometraje_final='$kilometraje_final',
			kilometraje_recorrido='$kilometraje_recorrido',
			litros_gasolina_usados='$litros_gasolina_usados',
			precio_gasolina='$precio_gasolina',
			gasolina_manana='$gasolina_manana',
			litros_gas_usados='$litros_gas_usados',
			precio_gas='$precio_gas',
			gas_lp_manana='$gas_lp_manana'
			WHERE folio='$folio_vehiculo'"
		);
		$guardar->execute();

		//Guardamos los datos del inventario.
		//Asignamos un nombre a cada variable:
		$folio_inventario = filter_var(($datos_adicionales['folio_inventario']), FILTER_SANITIZE_STRING);
		$piezas_iniciales = filter_var(($datos_adicionales['piezas_iniciales']), FILTER_SANITIZE_STRING);
		$salidas = filter_var(($datos_adicionales['salidas']), FILTER_SANITIZE_STRING);
		$importe_salidas = filter_var(($datos_adicionales['importe_salidas']), FILTER_SANITIZE_STRING);
		$descripcion_salidas = filter_var(($datos_adicionales['descripcion_salidas']), FILTER_SANITIZE_STRING);
		$entradas = filter_var(($datos_adicionales['entradas']), FILTER_SANITIZE_STRING);
		$importe_entradas = filter_var(($datos_adicionales['importe_entradas']), FILTER_SANITIZE_STRING);
		$descripcion_entradas = filter_var(($datos_adicionales['descripcion_entradas']), FILTER_SANITIZE_STRING);
		$total_piezas = filter_var(($datos_adicionales['total_piezas']), FILTER_SANITIZE_STRING);
		$piezas_entregadas = filter_var(($datos_adicionales['piezas_entregadas']), FILTER_SANITIZE_STRING);
		$piezas_devueltas = filter_var(($datos_adicionales['piezas_devueltas']), FILTER_SANITIZE_STRING);
		$piezas_finales = filter_var(($datos_adicionales['piezas_finales']), FILTER_SANITIZE_STRING);

		$total_piezas = ($piezas_iniciales - $salidas)+$entradas;

		//Ejecutamos la conexion a bd.
		$guardar=$conexion->prepare(
			"UPDATE inventarios SET
			piezas_iniciales ='$piezas_iniciales',
			salidas ='$salidas',
			importe_salidas ='$importe_salidas',
			descripcion_salidas ='$descripcion_salidas',
			entradas ='$entradas',
			importe_entradas ='$importe_entradas',
			descripcion_entradas ='$descripcion_entradas',
			total_piezas ='$total_piezas',
			piezas_entregadas ='$piezas_entregadas',
			piezas_devueltas ='$piezas_devueltas',
			piezas_finales='$piezas_finales'
			WHERE folio='$folio_inventario'"
		);
		$guardar->execute();
		
		
		//Ejecutamos foreach para guardar los datos de los clientes.
		foreach ($datos_clientes_separados as $cliente) 
		{
			//print_r($datos_clientes_separados);
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
			$latitud_fija = filter_var(strtoupper ($cliente[10]), FILTER_SANITIZE_STRING);
			$longitud_fija = filter_var(strtoupper ($cliente[11]), FILTER_SANITIZE_STRING);
			$latitud = filter_var(strtoupper ($cliente[12]), FILTER_SANITIZE_STRING);
			$longitud = filter_var(strtoupper ($cliente[13]), FILTER_SANITIZE_STRING);
			$puntos_disponibles = filter_var(strtoupper ($cliente[14]), FILTER_SANITIZE_STRING);
			$puntos_entregados = filter_var(strtoupper ($cliente[15]), FILTER_SANITIZE_STRING);
			$puntos_cambiados = filter_var(strtoupper ($cliente[16]), FILTER_SANITIZE_STRING);
			$puntos_restantes = filter_var(strtoupper ($cliente[17]), FILTER_SANITIZE_STRING);
			$piezas_cargo = filter_var(strtoupper ($cliente[18]), FILTER_SANITIZE_STRING);
			$importe_cargo = filter_var(strtoupper ($cliente[19]), FILTER_SANITIZE_STRING);
			$adeudo_cargo = filter_var(strtoupper ($cliente[20]), FILTER_SANITIZE_STRING);
			$hora_cargo = filter_var(strtoupper ($cliente[21]), FILTER_SANITIZE_STRING);
			$fecha_cargo = filter_var(strtoupper ($cliente[22]), FILTER_SANITIZE_STRING);
			$fecha_vence_cargo = filter_var(strtoupper ($cliente[23]), FILTER_SANITIZE_STRING);
			$mercancia_cargo = filter_var(strtoupper ($cliente[24]), FILTER_SANITIZE_STRING);
			$pz_devueltas = filter_var(strtoupper ($cliente[25]), FILTER_SANITIZE_STRING);
			$importe_devolucion = filter_var(strtoupper ($cliente[26]), FILTER_SANITIZE_STRING);
			$cierre = filter_var(strtoupper ($cliente[27]), FILTER_SANITIZE_STRING);
			$pago_cierre = filter_var(strtoupper ($cliente[28]), FILTER_SANITIZE_STRING);
			$pago_adeudo = filter_var(strtoupper ($cliente[29]), FILTER_SANITIZE_STRING);
			$pago_otro = filter_var(strtoupper ($cliente[30]), FILTER_SANITIZE_STRING);
			$pago_dif_regalo = filter_var(strtoupper ($cliente[31]), FILTER_SANITIZE_STRING);
			$total_pagos = filter_var(strtoupper ($cliente[32]), FILTER_SANITIZE_STRING);
			$mercancia_devuelta = filter_var(strtoupper ($cliente[33]), FILTER_SANITIZE_STRING);
			$piezas_entregadas = filter_var(strtoupper ($cliente[34]), FILTER_SANITIZE_STRING);
			$importe_entregado = filter_var(strtoupper ($cliente[35]), FILTER_SANITIZE_STRING);
			$adeudo = filter_var(strtoupper ($cliente[36]), FILTER_SANITIZE_STRING);
			$fecha_vencimiento = filter_var(strtoupper ($cliente[37]), FILTER_SANITIZE_STRING);
			$hora = filter_var(strtoupper ($cliente[38]), FILTER_SANITIZE_STRING);
			$fecha_entrega = filter_var(strtoupper ($cliente[39]), FILTER_SANITIZE_STRING);
			$reporte_agente = filter_var(strtoupper ($cliente[40]), FILTER_SANITIZE_STRING);
			$historial = filter_var(strtoupper ($cliente[41]), FILTER_SANITIZE_STRING);
			$mercancia_entregada = filter_var(strtoupper ($cliente[42]), FILTER_SANITIZE_STRING);
			$reporte_administracion = filter_var(strtoupper ($cliente[43]), FILTER_SANITIZE_STRING);
			$firma_voz = filter_var(strtoupper ($cliente[44]), FILTER_SANITIZE_STRING);
			$revisada = filter_var(strtoupper ($cliente[45]), FILTER_SANITIZE_STRING);

			//Obtenemos los puntos restantes.
			$puntos_restantes = $puntos_disponibles + $puntos_entregados - $puntos_cambiados;

			//Guardamos las cordenadas fijas es decir latitud fija y longitud fija.
			if ($latitud_fija == 0 && $longitud_fija == 0) {
				$latitud_fija = $latitud;
				$longitud_fija = $longitud;
			}
		    
		    //Ejecutamos la conexion y especificamos las tablas a modificar
		    $guardar = $conexion->prepare(
		    	"UPDATE movimientos SET 
		    	zona='$zona', 
		    	cuenta='$cuenta', 
		    	nombre='$nombre', 
		    	telefono='$telefono', 
		    	grado='$grado', 
		    	credito='$credito', 
		    	dias='$dias', 
		    	estado='$estado', 
		    	observaciones='$observaciones', 
				latitud_fija='$latitud_fija', 
		    	longitud_fija='$longitud_fija', 
		    	latitud='$latitud', 
		    	longitud='$longitud', 
		    	puntos_disponibles='$puntos_disponibles', 
		    	puntos_entregados='$puntos_entregados', 
		    	puntos_cambiados='$puntos_cambiados', 
		    	puntos_restantes='$puntos_restantes', 
		    	piezas_cargo = '$piezas_cargo', 
		    	importe_cargo = '$importe_cargo', 
		    	mercancia_cargo = '$mercancia_cargo', 
		    	adeudo_cargo = '$adeudo_cargo', 
				hora_cargo = '$hora_cargo', 
				fecha_cargo = '$fecha_cargo', 
				fecha_vence_cargo = '$fecha_vence_cargo', 
				pz_devueltas = '$pz_devueltas', 
				importe_devolucion = '$importe_devolucion', 
				mercancia_devuelta = '$mercancia_devuelta', 
				cierre = '$cierre', 
				pago_cierre = '$pago_cierre', 
				pago_adeudo = '$pago_adeudo', 
				pago_otro = '$pago_otro', 
				pago_dif_regalo = '$pago_dif_regalo', 
				total_pagos = '$total_pagos', 
				piezas_entregadas = '$piezas_entregadas', 
				importe_entregado = '$importe_entregado', 
				mercancia_entregada = '$mercancia_entregada', 
				adeudo = '$adeudo', 
				fecha_vencimiento = '$fecha_vencimiento', 
				hora = '$hora', 
				fecha_entrega = '$fecha_entrega', 
				reporte_agente = '$reporte_agente', 
				historial = '$historial', 
				reporte_administracion = '$reporte_administracion', 
				firma_voz = '$firma_voz', 
				revisada = '$revisada' 
			    WHERE folio='$folio' "
		    );
			$guardar->execute();
			
			//Comprobamos si la cuenta es de mes.
			//Consultamos bd para obtener las fechas de vencimiento.
			$consulta_fecha_vencimiento = $conexion->prepare(
				"SELECT fecha_vence_cargo FROM movimientos WHERE folio = '$folio'"
			);
			$consulta_fecha_vencimiento->execute();
			$array_consulta_fecha_vencimiento = $consulta_fecha_vencimiento->fetchAll();
			$vencimiento = $array_consulta_fecha_vencimiento[0][0];

			//Asignamos la zona horaria.
			date_default_timezone_set('America/Mexico_City');

			//Checamos la fecha del sistema.
			$fecha_actual = date("d-m-Y");		
			
			//Como en la consulta nos puede regresar unas fechas en 0 le asignamos la fecha actual menos 14 dias.
			if ($vencimiento == 0) {
				$vencimiento = date("d-m-Y", strtotime($fecha_actual."- 14 days"));
			}

			//Convertimos las fechas a numeros para poderlos comparar.
			$fecha_actual = strtotime($fecha_actual);
			$vencimiento = strtotime($vencimiento);

			//Comparamos las fechas, si es mayor la fecha actual, significa que vencio y actualizamos grado y credito.
			if ($fecha_actual >= $vencimiento && $estado == 'ACTIVO') {

				//Calculamos el grado de las clientas en base a las 3 ultimas ventas.
				$pagos = $conexion->prepare(
					"SELECT total_pagos FROM movimientos WHERE cuenta = '$cuenta' ORDER BY folio DESC LIMIT 4"
				);
				$pagos->execute();
				$array_pagos = $pagos->fetchAll();

				//Contamos los valores que devuelve la consulta, puede devolver solo 1 o 2 ventas y entonces nos marca error.
				//La venta futura es un desecho cuando consultamos bd ya nos arroja el total de pagos con el de la fecha futura
				//entonces siempre la ultima venta era igual a cero por eso la venta futura no la tomamos en cuenta
				$numero_ventas = count($array_pagos);
				if ($numero_ventas == 1) {
					$venta_futura = $array_pagos[0][0];
					$ultima_venta = 0;
					$penultima_venta = 0;
					$antepenultima_venta = 0;
				}
				if ($numero_ventas == 2) {
					$venta_futura = $array_pagos[0][0];
					$ultima_venta = $array_pagos[1][0];;
					$penultima_venta = 0;
					$antepenultima_venta = 0;
				}
				if ($numero_ventas == 3) {
					$venta_futura = $array_pagos[0][0];
					$ultima_venta = $array_pagos[1][0];
					$penultima_venta = $array_pagos[2][0];
					$antepenultima_venta = 0;
				}

				if ($numero_ventas == 4) {
					$venta_futura = $array_pagos[0][0];
					$ultima_venta = $array_pagos[1][0];
					$penultima_venta = $array_pagos[2][0];
					$antepenultima_venta = $array_pagos[3][0];
				}

				if ($grado == 'VENDEDORA' && $estado == 'ACTIVO') {
					if ($ultima_venta >= 500 && $penultima_venta >= 500) {
						$grado = 'SOCIA';
						if ($reporte_administracion == 0) {
							$reporte_administracion = '*SE CAMBIA A SOCIA*';
						}else {
							$reporte_administracion = '*SE CAMBIA A SOCIA* ' . $reporte_administracion;
						}
					}
				}

				if ($grado == 'SOCIA' && $estado == 'ACTIVO') {
					if ($ultima_venta >= 1000 && $penultima_venta >= 1000 && $antepenultima_venta >= 1000) {
						$grado = 'EMPRESARIA';
						if ($reporte_administracion == 0) {
							$reporte_administracion = '*SE CAMBIA A EMPRESARIA*';
						}else {
							$reporte_administracion = '*SE CAMBIA A EMPRESARIA* ' . $reporte_administracion;
						}
					}
				}
			
				
				//Verificamos cual de las 2 ventas es la mas alta.
				if ($ultima_venta > $penultima_venta) {
					$venta = $ultima_venta;
				}else {
					$venta = $penultima_venta;
				}

				//Verificamos si es cuenta de mes, se toma en cuenta 1 venta atras, seria la penultima y antepenultima ventas las que se toman en cuenta.
				if ($dias == 28 && $total_pagos == 0) {
					if ($penultima_venta > $antepenultima_venta) {
						$venta = $penultima_venta;
					}else {
						$venta = $antepenultima_venta;
					}
				}
				
				//Calculamos creditos de VENDEDORAS.
				if ($grado == 'VENDEDORA') {
					if ($venta < 500) {
						$credito = 1500;
					}
					if ($venta >= 500) {
						$credito = 1800;
					}
					if ($venta >=800) {
						$credito = 2000;
					}
					if ($venta >1000) {
						$credito = 2200;
					}
				}

				//Calculamos creditos de SOCIAS.
				if ($grado == 'SOCIA') {
					if ($venta < 350) {
						$credito = 1800;
					}
					if ($venta >= 350) {
						$credito = 2000;
					}
					if ($venta >= 500) {
						$credito = 2200;
					}
					if ($venta >=800) {
						$credito = 2500;
					}
					if ($venta >=1000) {
						$credito = 2800;
					}
					if ($venta >1500) {
						$credito = 3000;
					}
				}

				//Calculamos creditos de EMPRESARIAS.
				if ($grado == 'EMPRESARIA') {
					if ($venta < 350) {
						$credito = 2000;
					}
					if ($venta >= 350) {
						$credito = 2300;
					}
					if ($venta >= 500) {
						$credito = 2500;
					}
					if ($venta >= 1000) {
						$credito = 2800;
					}
					if ($venta >= 1500) {
						$credito = 3000;
					}
					if ($venta >=2000) {
						$credito = 3500;
					}
					if ($venta >=2500) {
						$credito = 4000;
					}
					if ($venta >3000) {
						$credito = 4500;
					}
				}

			}

			// Cambiamos el estado de Activo a LIO.
			//Es posible que la fecha de vencimiento sea igual a o no aiga datos si es asi la fecha de vencimiento la asignamos a la fecha actual.
			if ($fecha_vence_cargo == '0' || $fecha_vence_cargo == '') {
				$fecha_vence_cargo = date("d-m-Y");
			}
			//Revisamos su fecha de vencimiento y le sumamos 56 dias o 4 visitas.
			$fecha_conteo = date("d-m-Y", strtotime($fecha_vence_cargo."+ 56 days"));
			$fecha_conteo = strtotime($fecha_conteo);
			//Comprobamos que la fecha actual no sea mayor a la fecha del conteo, si es mayor el estado es igual a LIO.
			if ($fecha_actual >= $fecha_conteo && $estado == 'ACTIVO' && $total_pagos == 0) {
				$estado = 'LIO';
			}	

			//Cambiamos el estado del cliente de Activo a REACTIVAR.
			//Primero es el caso de que alla devuelto toda la mercancia y ya no se entrego nada.
			if ($estado == 'ACTIVO' && $pz_devueltas != '0' && $piezas_entregadas == '0' && $adeudo == '0' ) {
				$estado = 'REACTIVAR';
			}
			//Segundo caso que realiso el pago de toda la mercancia y ya no se deja mercancia ni adeudo.
			if ($estado == 'ACTIVO' && $total_pagos != '0' && $piezas_entregadas == '0' && $adeudo == '0') {
				$estado = 'REACTIVAR';
			}

			//Cambiamos el estado de Reactivar a ACTIVO.
			if ($estado == 'REACTIVAR' && $piezas_entregadas != '0' && $importe_entregado != '0') {
				$estado = 'ACTIVO';
			}

			//Cambiamos el estado de Prospecto a ACTIVO.
			if ($estado == 'PROSPECTO' && $piezas_entregadas != '0' && $importe_entregado != '0') {
				$estado = 'ACTIVO';
			}

			
			//Asignamos credito a prospectos.
			if ($estado == 'PROSPECTO') {
				$credito = 1500;
			}

			//Cancelamos credito a LIOS.
			if ($estado == 'LIO') {
				$credito = 0;
			}
			
			//Verificamos las fechas si no ay mercancia entregada las fechas de vencimiento se quedan igual y no se anotan las nuevas fechas al dar solo un pago.
			if ($piezas_entregadas == 0 && $importe_entregado == 0) {
				$fecha_vencimiento = $fecha_vence_cargo;
				$fecha_entrega = $fecha_cargo;
			}
				
			//Vamos a crear la fecha futura.

			//Consultamos la fecha del movimiento de base de datos en base al folio del cliente.
			$fecha_movimiento = $conexion->prepare(
				"SELECT fecha FROM movimientos WHERE folio = '$folio'"
			);
			$fecha_movimiento->execute();
			$array_fecha_movimiento = $fecha_movimiento->fetchAll();
			$fecha_consulta = $array_fecha_movimiento[0][0];
			
			//Tomamos la ultima fecha de la consulta y le sumamos 14 dias.
			$fecha_futura = date("d-m-Y", strtotime($fecha_consulta."+ 14 days"));

			//Creamos consulta a bd para ver si ya se ingreso la fecha futura.
			$consulta_fecha = $conexion->prepare(
				"SELECT folio FROM movimientos WHERE zona = '$zona' AND fecha = '$fecha_futura' AND cuenta = '$cuenta'"
			);
			$consulta_fecha->execute();
			$consulta_fecha_futura = $consulta_fecha->fetchAll();
			//Si no esta ingresada nos devuelve un array vacio.
			//Si ya se ingreso nos devuelve un array con los folios.

			//Para corregir error de que se copean los puntos a la fecha futura reiniciamos los puntos a 0
			//Pero esto ay que corregirlo quitando las consultas.

					$puntos_cambiados = 0;
					$puntos_entregados = 0;
					$puntos_disponibles = $puntos_restantes;
					$puntos_restantes = $puntos_disponibles;
					$latitud = 0;
					$longitud = 0;

			//creamos un candado para que no se creen fechas futuras en cada ocacion por que si no se generan muchas fechas futuras.
		

			//Vamos a introducir los datos de la fecha futura
			if (empty($consulta_fecha_futura)) {

				//Rescribimos firma de voz y revisada.
				$firma_voz = 'NO';
				$revisada = 'NO';

				//Coprobamos que la cuenta no este de BAJA si esta de baja no hace nada ni copea ni nada
				if ($estado == 'ACTIVO' || $estado == 'REACTIVAR' || $estado == 'LIO' || $estado == 'PROSPECTO') {
					
					//Significa que no estubo, o que es cuenta de mes, y se copean los mismos datos de a cargo.
					if ($pz_devueltas == '0' && $piezas_entregadas == '0' && $total_pagos == '0') {
						$guardar_clientes = $conexion->prepare(
							"INSERT INTO movimientos (folio, zona, fecha, cuenta, nombre, telefono, grado, credito, dias, estado, observaciones, 
							latitud_fija, longitud_fija, latitud, longitud, puntos_disponibles, puntos_entregados, puntos_cambiados, puntos_restantes, piezas_cargo, 
							importe_cargo, mercancia_cargo, adeudo_cargo, hora_cargo, fecha_cargo, fecha_vence_cargo, reporte_agente, reporte_administracion, 
							firma_voz, revisada)
							VALUES ('', '$zona', '$fecha_futura', '$cuenta', '$nombre', '$telefono', '$grado', '$credito', '$dias', '$estado', 
							'$observaciones', '$latitud_fija', '$longitud_fija', '$latitud', '$longitud', '$puntos_disponibles', '$puntos_entregados', '$puntos_cambiados', 
							'$puntos_restantes', '$piezas_cargo', '$importe_cargo', '$mercancia_cargo', '$adeudo_cargo', '$hora_cargo', 
							'$fecha_cargo', '$fecha_vence_cargo', '$reporte_agente', '$reporte_administracion', '$firma_voz', '$revisada')"
							);
							$guardar_clientes->execute();

					//Significa que realiso pago y le entregaron mercancia o hubo devolucion y se copean los datos de entrega.
					}else {
						$guardar_clientes = $conexion->prepare(
							"INSERT INTO movimientos (folio, zona, fecha, cuenta, nombre, telefono, grado, credito, dias, estado, observaciones, 
							latitud_fija, longitud_fija, latitud, longitud, puntos_disponibles, puntos_entregados, puntos_cambiados, puntos_restantes, piezas_cargo, 
							importe_cargo, mercancia_cargo, adeudo_cargo, hora_cargo, fecha_cargo, fecha_vence_cargo, reporte_agente, reporte_administracion,
							firma_voz, revisada) 
							VALUES ('', '$zona', '$fecha_futura', '$cuenta', '$nombre', '$telefono', '$grado', '$credito', '$dias', '$estado', 
							'$observaciones', '$latitud_fija', '$longitud_fija', '$latitud', '$longitud', '$puntos_disponibles', '$puntos_entregados', '$puntos_cambiados', 
							'$puntos_restantes', '$piezas_entregadas', '$importe_entregado', '$mercancia_entregada', '$adeudo', '$hora', 
							'$fecha_entrega', '$fecha_vencimiento', '$reporte_agente', '$reporte_administracion', '$firma_voz', '$revisada')"
							);		
						$guardar_clientes->execute();
					}
					
				}

				
			//Si ya esta ingresada la fecha futura solo actualizamos algun cambio generado en la fecha actual.
			}else {
						//Coprobamos que la cuenta no este de BAJA si esta de baja no hace nada ni copea ni nada
						if ($estado == 'ACTIVO' || $estado == 'REACTIVAR' || $estado == 'LIO' || $estado == 'PROSPECTO') {

							if ($pz_devueltas == '0' && $piezas_entregadas == '0' && $total_pagos == '0') {
								$actualizar = $conexion->prepare(
									"UPDATE movimientos SET 
									zona='$zona', 
									cuenta='$cuenta', 
									nombre='$nombre', 
									telefono='$telefono', 
									grado='$grado', 
									credito='$credito', 
									dias='$dias', 
									estado='$estado', 
									observaciones='$observaciones', 
									latitud_fija='$latitud_fija', 
									longitud_fija='$longitud_fija', 
									latitud='$latitud', 
									longitud='$longitud', 
									puntos_disponibles='$puntos_disponibles', 
									puntos_entregados='$puntos_entregados', 
									puntos_cambiados='$puntos_cambiados', 
									puntos_restantes='$puntos_restantes', 
									piezas_cargo='$piezas_cargo', 
									importe_cargo='$importe_cargo', 
									mercancia_cargo='$mercancia_cargo', 
									adeudo_cargo='$adeudo_cargo', 
									hora_cargo='$hora_cargo', 
									fecha_cargo='$fecha_cargo', 
									fecha_vence_cargo='$fecha_vence_cargo', 
									reporte_agente='$reporte_agente', 
									reporte_administracion='$reporte_administracion' 
									WHERE zona = '$zona' AND fecha = '$fecha_futura' AND cuenta = '$cuenta'"
								);
								$actualizar->execute();
							} else {
								$actualizar = $conexion->prepare(
									"UPDATE movimientos SET 
									zona='$zona', 
									cuenta='$cuenta', 
									nombre='$nombre', 
									telefono='$telefono', 
									grado='$grado', 
									credito='$credito', 
									dias='$dias', 
									estado='$estado', 
									observaciones='$observaciones', 
									latitud_fija='$latitud_fija', 
									longitud_fija='$longitud_fija', 
									latitud='$latitud', 
									longitud='$longitud', 
									puntos_disponibles='$puntos_disponibles', 
									puntos_entregados='$puntos_entregados', 
									puntos_cambiados='$puntos_cambiados', 
									puntos_restantes='$puntos_restantes',  
									piezas_cargo='$piezas_entregadas', 
									importe_cargo='$importe_entregado', 
									mercancia_cargo='$mercancia_entregada', 
									adeudo_cargo='$adeudo', 
									hora_cargo='$hora', 
									fecha_cargo='$fecha_entrega', 
									fecha_vence_cargo='$fecha_vencimiento', 
									reporte_agente='$reporte_agente', 
									reporte_administracion='$reporte_administracion' 
									WHERE zona = '$zona' AND fecha = '$fecha_futura' AND cuenta = '$cuenta'"
								);
								$actualizar->execute();
							}
					
						}
			}

				//Si ya se ingreso la fecha futura: Como se dio de baja el cliente en la fecha actual, se tiene que eliminar el registro
				//de la fecha futura.
				if ($estado == 'BAJA') {
					$borrar = $conexion->prepare(
							"DELETE FROM movimientos WHERE zona = '$zona' AND fecha = '$fecha_futura' AND cuenta = '$cuenta' LIMIT 2"
					);
					$borrar->execute();
				
				
				}
			

		}

		//Vamos a ingresar los datos del vehiculo y el inventario.
		//Primero vemos si ya existe la fecha futura.
		$consulta_vehiculo = $conexion->prepare(
			"SELECT folio FROM vehiculos WHERE zona = '$zona' AND fecha = '$fecha_futura'"
		);
		$consulta_vehiculo->execute();
		$consulta_vehiculo = $consulta_vehiculo->fetchAll();

		//Si no existe nos regresa un array vacio e ingresamos a bd.
		if (empty($consulta_vehiculo)) {

			//Se guardan los datos del vehiculo para en 15 dias.
			$guardar = $conexion->prepare(
				"INSERT INTO vehiculos (folio, zona, fecha, gasolina, gas_lp, total)
				VALUES ('', '$zona', '$fecha_futura', '$gasolina_manana', '$gas_lp_manana', $total)"
			);
			$guardar->execute();

			//Se guardan los datos del inventario para en 15 dias.
			$guardar = $conexion->prepare(
				"INSERT INTO inventarios (folio, zona, fecha)
				VALUES ('', '$zona', '$fecha_futura')"
			);
			$guardar->execute();

		}
	
		header("Location: contenido.php?zona=$zona&fecha=$fecha_consulta");

	}

	
}


//Si no ay sesion mandamos a ingresa para crear la sesion.
else
{
    header('Location: ingresa.php');
}





 ?>