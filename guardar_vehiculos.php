<?php session_start();

//Comprobamos la sesion, si ay session ejecutamos y guardamos los datos.
if(isset($_SESSION['usuario']))
{

	//Comprombamos que los datos aigan sido enviados por POST, si si ejecutamos.
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{

        //Creamos la conexion a la base de datos para utilizarla mas adelante.
		try {
			$conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
		} catch(PDOException $e){
			echo "Error" . $e->getMessage();;
        }
        
		//Extraemos la informacion de POST asignamos el nombre del array.
        $reparaciones_unidad = $_POST;

        //Extraemos los datos adicionales para guardarlos por separado
        $datos_unidad = array_slice($reparaciones_unidad, 0, 14);

        //Quitamos los datos adicionales, del array, para que queden los puros datos de clientes.
		$conteo = count($reparaciones_unidad);
		$conteo = $conteo - 14;
		$reparaciones_unidad = array_splice($reparaciones_unidad, 14, $conteo);
        //Creamos una matriz separando los clientes de 41 para ingresar a foreach.
        $reparaciones_unidad = array_chunk($reparaciones_unidad, 14);

        //Quitamos el ultimo dato del array es: guardar que manda el boton de enviar.

        $nueva_reparacion = array_pop($reparaciones_unidad);
        $boton_guardar = array_pop($nueva_reparacion);

        //Especificamos un nombre a variable de datos del vehiculo para guardar.


        $folio = filter_var(strtoupper($datos_unidad['folio']), FILTER_SANITIZE_STRING);
        $unidad = filter_var(strtoupper($datos_unidad['unidad']), FILTER_SANITIZE_STRING);
        $marca_unidad = filter_var(strtoupper($datos_unidad['marca_unidad']), FILTER_SANITIZE_STRING);
        $modelo = filter_var(strtoupper($datos_unidad['modelo']), FILTER_SANITIZE_STRING);
        $ano = filter_var(strtoupper($datos_unidad['ano']), FILTER_SANITIZE_STRING);
        $color = filter_var(strtoupper($datos_unidad['color']), FILTER_SANITIZE_STRING);
        $placas = filter_var(strtoupper($datos_unidad['placas']), FILTER_SANITIZE_STRING);
        $numero_serie = filter_var(strtoupper($datos_unidad['numero_serie']), FILTER_SANITIZE_STRING);
        $seguro = filter_var(strtoupper($datos_unidad['seguro']), FILTER_SANITIZE_STRING);
        $poliza = filter_var(strtoupper($datos_unidad['poliza']), FILTER_SANITIZE_STRING);
        $lugar = filter_var(strtoupper($datos_unidad['lugar']), FILTER_SANITIZE_STRING);
        $descripcion = filter_var(strtoupper($datos_unidad['descripcion']), FILTER_SANITIZE_STRING);
        $costo = filter_var(strtoupper($datos_unidad['costo']), FILTER_SANITIZE_STRING);
        $km_actual = filter_var(strtoupper($datos_unidad['km_actual']), FILTER_SANITIZE_STRING);


        //Sacamos el registro de vehiculos de la utima entrada que genero alguna unidad.

        $kilometraje_final = $conexion->prepare(
            "SELECT kilometraje_final FROM vehiculos WHERE vehiculo = '$unidad' ORDER BY folio DESC LIMIT 1"
        );
        $kilometraje_final->execute();
        $kilometraje_final = $kilometraje_final->fetchAll();
        $kilometraje_final = $kilometraje_final[0][0];
        
        $km_actual = $kilometraje_final;


        $guardar_unidad = $conexion->prepare(
            "UPDATE unidades SET 
            unidad = '$unidad', 
            marca_unidad = '$marca_unidad', 
            modelo = '$modelo', 
            ano = '$ano', 
            color = '$color', 
            placas = '$placas', 
            numero_serie = '$numero_serie', 
            seguro = '$seguro', 
            poliza = '$poliza', 
            lugar = '$lugar', 
            descripcion = '$descripcion', 
            costo = '$costo', 
            km_actual = '$km_actual' 
            WHERE folio = '$folio'"
        );
        $guardar_unidad->execute();



        foreach ($reparaciones_unidad as $reparacion) {
            $folio_reparacion =  filter_var(strtoupper ($reparacion[0]), FILTER_SANITIZE_STRING);
            $unidad_reparacion =  filter_var(strtoupper ($reparacion[1]), FILTER_SANITIZE_STRING);
            $kilometraje =  filter_var(strtoupper ($reparacion[2]), FILTER_SANITIZE_STRING);
            $fecha_mantenimiento =  filter_var(strtoupper ($reparacion[3]), FILTER_SANITIZE_STRING);
            $piezas_cambiadas =  filter_var(strtoupper ($reparacion[4]), FILTER_SANITIZE_STRING);
            $marca =  filter_var(strtoupper ($reparacion[5]), FILTER_SANITIZE_STRING);
            $compra =  filter_var(strtoupper ($reparacion[6]), FILTER_SANITIZE_STRING);
            $lugar_servicio =  filter_var(strtoupper ($reparacion[7]), FILTER_SANITIZE_STRING);
            $km_vida =  filter_var(strtoupper ($reparacion[8]), FILTER_SANITIZE_STRING);
            $kilometraje_cambio =  filter_var(strtoupper ($reparacion[9]), FILTER_SANITIZE_STRING);
            $fecha_cambio =  filter_var(strtoupper ($reparacion[10]), FILTER_SANITIZE_STRING);
            $dias_restantes =  filter_var(strtoupper ($reparacion[11]), FILTER_SANITIZE_STRING);
            $kilometraje_restante =  filter_var(strtoupper ($reparacion[12]), FILTER_SANITIZE_STRING);
            $reporte =  filter_var(strtoupper ($reparacion[13]), FILTER_SANITIZE_STRING);

            $kilometraje_cambio = $kilometraje + $km_vida;
            $kilometraje_restante = $kilometraje_cambio - $km_actual;

            //Asignamos la zona horaria.
			date_default_timezone_set('America/Mexico_City');

			//Checamos la fecha del sistema.
            $fecha_actual = date("d-m-Y");	
            
            $no_dias = ($km_vida / 1000) * 7;

            $fecha_cambio = date("d-m-Y", strtotime($fecha_mantenimiento."+ $no_dias days"));

            $datetime1 = new DateTime($fecha_actual);
            $datetime2 = new DateTime($fecha_cambio);
            $interval = $datetime1->diff($datetime2);
            $dias_restantes = $interval->format('%r%a ');
            

            $guardar_reparacion = $conexion->prepare(
                "UPDATE reparaciones SET
                unidad_reparacion = '$unidad_reparacion', 
                kilometraje = '$kilometraje', 
                fecha_mantenimiento = '$fecha_mantenimiento', 
                piezas_cambiadas = '$piezas_cambiadas', 
                marca = '$marca', 
                compra = '$compra', 
                lugar_servicio = '$lugar_servicio', 
                km_vida = '$km_vida', 
                kilometraje_cambio = '$kilometraje_cambio', 
                fecha_cambio = '$fecha_cambio', 
                dias_restantes = '$dias_restantes', 
                kilometraje_restante = '$kilometraje_restante', 
                reporte = '$reporte' 
                WHERE folio_reparacion = '$folio_reparacion'"
            );
            $guardar_reparacion->execute();
        }

        if (empty($nueva_reparacion)) {
            //Si esta vacia no hacemos nada pero si si tiene datos los utilisamos en else
        }else{

            $nueva_reparacion = $nueva_reparacion[0];

            if ($nueva_reparacion == 'cambio_aceite') {
                $piezas_cambiadas = 'CAMBIO DE ACEITE';
                $km_vida = '9000';
                $reporte = 'NO';
                $insertar_reparacion = $conexion->prepare(
                    "INSERT INTO reparaciones (folio_reparacion, unidad_reparacion, kilometraje, fecha_mantenimiento, piezas_cambiadas, km_vida, reporte) 
                    VALUES ('', '$unidad', '$km_actual', '$fecha_actual', '$piezas_cambiadas', '$km_vida', '$reporte')"
                );
                $insertar_reparacion->execute();
            }

            if ($nueva_reparacion == 'afinacion_gas') {
                $piezas_cambiadas = 'FILTRO DE GAS Y LIMPIEZA VAPORISADOR';
                $km_vida = '25000';
                $reporte = 'NO';
                $insertar_reparacion = $conexion->prepare(
                    "INSERT INTO reparaciones (folio_reparacion, unidad_reparacion, kilometraje, fecha_mantenimiento, piezas_cambiadas, km_vida, reporte) 
                    VALUES ('', '$unidad', '$km_actual', '$fecha_actual', '$piezas_cambiadas', '$km_vida', '$reporte')"
                );
                $insertar_reparacion->execute();
            }

            if ($nueva_reparacion == 'afinacion_gasolina') {
                $piezas_cambiadas = 'LAVADO INYECTORES Y CUERPO ACELERACION, FILTRO AIRE, FILTRO GASOLINA, BUJIAS';
                $km_vida = '15000';
                $reporte = 'NO';
                $insertar_reparacion = $conexion->prepare(
                    "INSERT INTO reparaciones (folio_reparacion, unidad_reparacion, kilometraje, fecha_mantenimiento, piezas_cambiadas, km_vida, reporte) 
                    VALUES ('', '$unidad', '$km_actual', '$fecha_actual', '$piezas_cambiadas', '$km_vida', '$reporte')"
                );
                $insertar_reparacion->execute();
            }

            if ($nueva_reparacion == 'media_afinacion') {
                $piezas_cambiadas = 'LAVADO CUERPO ACELERACION, FILTRO AIRE, BUJIAS';
                $km_vida = '20000';
                $reporte = 'NO';
                $insertar_reparacion = $conexion->prepare(
                    "INSERT INTO reparaciones (folio_reparacion, unidad_reparacion, kilometraje, fecha_mantenimiento, piezas_cambiadas, km_vida, reporte) 
                    VALUES ('', '$unidad', '$km_actual', '$fecha_actual', '$piezas_cambiadas', '$km_vida', '$reporte')"
                );
                $insertar_reparacion->execute();
            }

            if ($nueva_reparacion == 'kit_distribucion') {
                $piezas_cambiadas = 'BANDA DE TIEMPO Y POLEA TENSORA';
                $km_vida = '30000';
                $reporte = 'NO';
                $insertar_reparacion = $conexion->prepare(
                    "INSERT INTO reparaciones (folio_reparacion, unidad_reparacion, kilometraje, fecha_mantenimiento, piezas_cambiadas, km_vida, reporte) 
                    VALUES ('', '$unidad', '$km_actual', '$fecha_actual', '$piezas_cambiadas', '$km_vida', '$reporte')"
                );
                $insertar_reparacion->execute();
            }

            if ($nueva_reparacion == 'banda_alternador') {
                $piezas_cambiadas = 'BANDA ALTERNADOR';
                $km_vida = '30000';
                $reporte = 'NO';
                $insertar_reparacion = $conexion->prepare(
                    "INSERT INTO reparaciones (folio_reparacion, unidad_reparacion, kilometraje, fecha_mantenimiento, piezas_cambiadas, km_vida, reporte) 
                    VALUES ('', '$unidad', '$km_actual', '$fecha_actual', '$piezas_cambiadas', '$km_vida', '$reporte')"
                );
                $insertar_reparacion->execute();
            }

            if ($nueva_reparacion == 'balatas_delanteras') {
                $piezas_cambiadas = 'BALATAS DELANTERAS';
                $km_vida = '30000';
                $reporte = 'NO';
                $insertar_reparacion = $conexion->prepare(
                    "INSERT INTO reparaciones (folio_reparacion, unidad_reparacion, kilometraje, fecha_mantenimiento, piezas_cambiadas, km_vida, reporte) 
                    VALUES ('', '$unidad', '$km_actual', '$fecha_actual', '$piezas_cambiadas', '$km_vida', '$reporte')"
                );
                $insertar_reparacion->execute();
            }

            if ($nueva_reparacion == 'balatas_traseras') {
                $piezas_cambiadas = 'BALATAS TRASERAS';
                $km_vida = '30000';
                $reporte = 'NO';
                $insertar_reparacion = $conexion->prepare(
                    "INSERT INTO reparaciones (folio_reparacion, unidad_reparacion, kilometraje, fecha_mantenimiento, piezas_cambiadas, km_vida, reporte) 
                    VALUES ('', '$unidad', '$km_actual', '$fecha_actual', '$piezas_cambiadas', '$km_vida', '$reporte')"
                );
                $insertar_reparacion->execute();
            }

            if ($nueva_reparacion == 'llantas') {
                $piezas_cambiadas = 'LLANTAS DELANTERAS';
                $km_vida = '20000';
                $reporte = 'NO';
                $insertar_reparacion = $conexion->prepare(
                    "INSERT INTO reparaciones (folio_reparacion, unidad_reparacion, kilometraje, fecha_mantenimiento, piezas_cambiadas, km_vida, reporte) 
                    VALUES ('', '$unidad', '$km_actual', '$fecha_actual', '$piezas_cambiadas', '$km_vida', '$reporte')"
                );
                $insertar_reparacion->execute();
            }

            if ($nueva_reparacion == 'nueva_reparacion') {
                $piezas_cambiadas = 'ESPECIFICAR PIEZAS CAMBIADAS';
                $km_vida = '0';
                $reporte = 'NO';
                $insertar_reparacion = $conexion->prepare(
                    "INSERT INTO reparaciones (folio_reparacion, unidad_reparacion, kilometraje, fecha_mantenimiento, piezas_cambiadas, km_vida, reporte) 
                    VALUES ('', '$unidad', '$km_actual', '$fecha_actual', '$piezas_cambiadas', '$km_vida', '$reporte')"
                );
                $insertar_reparacion->execute();
            }
        }


        header("Location: vehiculos.php?unidad=$unidad");

        

//Si no ay sesion mandamos a ingresa para crear la sesion.
}
}else
{
    header('Location: ingresa.php');
}