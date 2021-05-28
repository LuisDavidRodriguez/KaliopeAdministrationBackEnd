<?php session_start();

if(isset($_SESSION['usuario'])){
    //creamos la coneccion a la base de datos
    try{
        $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
    }catch(PDOException $e){
        echo "Error".$e->getMessage();;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
	{

        $datos_nomina = $_POST;

        //print_r($datos_nomina);

        //Asignamos un nombre a cada variable del array.
        $zona_lunes =  filter_var(strtoupper ($datos_nomina['zona_lunes']), FILTER_SANITIZE_STRING);
        $fecha_lunes =  filter_var(strtoupper ($datos_nomina['fecha_lunes']), FILTER_SANITIZE_STRING);
        $cobro_lunes =  filter_var(strtoupper ($datos_nomina['cobro_lunes']), FILTER_SANITIZE_STRING);
        $nuevas_lunes =  filter_var(strtoupper ($datos_nomina['nuevas_lunes']), FILTER_SANITIZE_STRING);
        $lios_lunes =  filter_var(strtoupper ($datos_nomina['lios_lunes']), FILTER_SANITIZE_STRING);
        $sobrante_lunes =  filter_var(strtoupper ($datos_nomina['sobrante_lunes']), FILTER_SANITIZE_STRING);
        $adelantos_lunes =  filter_var(strtoupper ($datos_nomina['adelantos_lunes']), FILTER_SANITIZE_STRING);
        $gasolina_lunes =  filter_var(strtoupper ($datos_nomina['gasolina_lunes']), FILTER_SANITIZE_STRING);
        $gastos_lunes_1 =  filter_var(strtoupper ($datos_nomina['gastos_lunes_1']), FILTER_SANITIZE_STRING);
        $concepto_lunes_1 =  filter_var(strtoupper ($datos_nomina['concepto_lunes_1']), FILTER_SANITIZE_STRING);
        $gastos_lunes_2 =  filter_var(strtoupper ($datos_nomina['gastos_lunes_2']), FILTER_SANITIZE_STRING);
        $concepto_lunes_2 =  filter_var(strtoupper ($datos_nomina['concepto_lunes_2']), FILTER_SANITIZE_STRING);
        $gastos_lunes_3 =  filter_var(strtoupper ($datos_nomina['gastos_lunes_3']), FILTER_SANITIZE_STRING);
        $concepto_lunes_3 =  filter_var(strtoupper ($datos_nomina['concepto_lunes_3']), FILTER_SANITIZE_STRING);
        $gastos_lunes_4 =  filter_var(strtoupper ($datos_nomina['gastos_lunes_4']), FILTER_SANITIZE_STRING);
        $concepto_lunes_4 =  filter_var(strtoupper ($datos_nomina['concepto_lunes_4']), FILTER_SANITIZE_STRING);
        $total_lunes =  filter_var(strtoupper ($datos_nomina['total_lunes']), FILTER_SANITIZE_STRING);
        
        
        $zona_martes =  filter_var(strtoupper ($datos_nomina['zona_martes']), FILTER_SANITIZE_STRING);
        $fecha_martes =  filter_var(strtoupper ($datos_nomina['fecha_martes']), FILTER_SANITIZE_STRING);
        $cobro_martes =  filter_var(strtoupper ($datos_nomina['cobro_martes']), FILTER_SANITIZE_STRING);
        $nuevas_martes =  filter_var(strtoupper ($datos_nomina['nuevas_martes']), FILTER_SANITIZE_STRING);
        $lios_martes =  filter_var(strtoupper ($datos_nomina['lios_martes']), FILTER_SANITIZE_STRING);
        $sobrante_martes =  filter_var(strtoupper ($datos_nomina['sobrante_martes']), FILTER_SANITIZE_STRING);
        $adelantos_martes =  filter_var(strtoupper ($datos_nomina['adelantos_martes']), FILTER_SANITIZE_STRING);
        $gasolina_martes =  filter_var(strtoupper ($datos_nomina['gasolina_martes']), FILTER_SANITIZE_STRING);
        $gastos_martes_1 =  filter_var(strtoupper ($datos_nomina['gastos_martes_1']), FILTER_SANITIZE_STRING);
        $concepto_martes_1 =  filter_var(strtoupper ($datos_nomina['concepto_martes_1']), FILTER_SANITIZE_STRING);
        $gastos_martes_2 =  filter_var(strtoupper ($datos_nomina['gastos_martes_2']), FILTER_SANITIZE_STRING);
        $concepto_martes_2 =  filter_var(strtoupper ($datos_nomina['concepto_martes_2']), FILTER_SANITIZE_STRING);
        $gastos_martes_3 =  filter_var(strtoupper ($datos_nomina['gastos_martes_3']), FILTER_SANITIZE_STRING);
        $concepto_martes_3 =  filter_var(strtoupper ($datos_nomina['concepto_martes_3']), FILTER_SANITIZE_STRING);
        $gastos_martes_4 =  filter_var(strtoupper ($datos_nomina['gastos_martes_4']), FILTER_SANITIZE_STRING);
        $concepto_martes_4 =  filter_var(strtoupper ($datos_nomina['concepto_martes_4']), FILTER_SANITIZE_STRING);
        $total_martes =  filter_var(strtoupper ($datos_nomina['total_martes']), FILTER_SANITIZE_STRING);
        
        
        $zona_miercoles =  filter_var(strtoupper ($datos_nomina['zona_miercoles']), FILTER_SANITIZE_STRING);
        $fecha_miercoles =  filter_var(strtoupper ($datos_nomina['fecha_miercoles']), FILTER_SANITIZE_STRING);
        $cobro_miercoles =  filter_var(strtoupper ($datos_nomina['cobro_miercoles']), FILTER_SANITIZE_STRING);
        $nuevas_miercoles =  filter_var(strtoupper ($datos_nomina['nuevas_miercoles']), FILTER_SANITIZE_STRING);
        $lios_miercoles =  filter_var(strtoupper ($datos_nomina['lios_miercoles']), FILTER_SANITIZE_STRING);
        $sobrante_miercoles =  filter_var(strtoupper ($datos_nomina['sobrante_miercoles']), FILTER_SANITIZE_STRING);
        $adelantos_miercoles =  filter_var(strtoupper ($datos_nomina['adelantos_miercoles']), FILTER_SANITIZE_STRING);
        $gasolina_miercoles =  filter_var(strtoupper ($datos_nomina['gasolina_miercoles']), FILTER_SANITIZE_STRING);
        $gastos_miercoles_1 =  filter_var(strtoupper ($datos_nomina['gastos_miercoles_1']), FILTER_SANITIZE_STRING);
        $concepto_miercoles_1 =  filter_var(strtoupper ($datos_nomina['concepto_miercoles_1']), FILTER_SANITIZE_STRING);
        $gastos_miercoles_2 =  filter_var(strtoupper ($datos_nomina['gastos_miercoles_2']), FILTER_SANITIZE_STRING);
        $concepto_miercoles_2 =  filter_var(strtoupper ($datos_nomina['concepto_miercoles_2']), FILTER_SANITIZE_STRING);
        $gastos_miercoles_3 =  filter_var(strtoupper ($datos_nomina['gastos_miercoles_3']), FILTER_SANITIZE_STRING);
        $concepto_miercoles_3 =  filter_var(strtoupper ($datos_nomina['concepto_miercoles_3']), FILTER_SANITIZE_STRING);
        $gastos_miercoles_4 =  filter_var(strtoupper ($datos_nomina['gastos_miercoles_4']), FILTER_SANITIZE_STRING);
        $concepto_miercoles_4 =  filter_var(strtoupper ($datos_nomina['concepto_miercoles_4']), FILTER_SANITIZE_STRING);
        $total_miercoles =  filter_var(strtoupper ($datos_nomina['total_miercoles']), FILTER_SANITIZE_STRING);
        
        
        $zona_jueves =  filter_var(strtoupper ($datos_nomina['zona_jueves']), FILTER_SANITIZE_STRING);
        $fecha_jueves =  filter_var(strtoupper ($datos_nomina['fecha_jueves']), FILTER_SANITIZE_STRING);
        $cobro_jueves =  filter_var(strtoupper ($datos_nomina['cobro_jueves']), FILTER_SANITIZE_STRING);
        $nuevas_jueves =  filter_var(strtoupper ($datos_nomina['nuevas_jueves']), FILTER_SANITIZE_STRING);
        $lios_jueves =  filter_var(strtoupper ($datos_nomina['lios_jueves']), FILTER_SANITIZE_STRING);
        $sobrante_jueves =  filter_var(strtoupper ($datos_nomina['sobrante_jueves']), FILTER_SANITIZE_STRING);
        $adelantos_jueves =  filter_var(strtoupper ($datos_nomina['adelantos_jueves']), FILTER_SANITIZE_STRING);
        $gasolina_jueves =  filter_var(strtoupper ($datos_nomina['gasolina_jueves']), FILTER_SANITIZE_STRING);
        $gastos_jueves_1 =  filter_var(strtoupper ($datos_nomina['gastos_jueves_1']), FILTER_SANITIZE_STRING);
        $concepto_jueves_1 =  filter_var(strtoupper ($datos_nomina['concepto_jueves_1']), FILTER_SANITIZE_STRING);
        $gastos_jueves_2 =  filter_var(strtoupper ($datos_nomina['gastos_jueves_2']), FILTER_SANITIZE_STRING);
        $concepto_jueves_2 =  filter_var(strtoupper ($datos_nomina['concepto_jueves_2']), FILTER_SANITIZE_STRING);
        $gastos_jueves_3 =  filter_var(strtoupper ($datos_nomina['gastos_jueves_3']), FILTER_SANITIZE_STRING);
        $concepto_jueves_3 =  filter_var(strtoupper ($datos_nomina['concepto_jueves_3']), FILTER_SANITIZE_STRING);
        $gastos_jueves_4 =  filter_var(strtoupper ($datos_nomina['gastos_jueves_4']), FILTER_SANITIZE_STRING);
        $concepto_jueves_4 =  filter_var(strtoupper ($datos_nomina['concepto_jueves_4']), FILTER_SANITIZE_STRING);
        $total_jueves =  filter_var(strtoupper ($datos_nomina['total_jueves']), FILTER_SANITIZE_STRING);
        
        
        $zona_viernes =  filter_var(strtoupper ($datos_nomina['zona_viernes']), FILTER_SANITIZE_STRING);
        $fecha_viernes =  filter_var(strtoupper ($datos_nomina['fecha_viernes']), FILTER_SANITIZE_STRING);
        $cobro_viernes =  filter_var(strtoupper ($datos_nomina['cobro_viernes']), FILTER_SANITIZE_STRING);
        $nuevas_viernes =  filter_var(strtoupper ($datos_nomina['nuevas_viernes']), FILTER_SANITIZE_STRING);
        $lios_viernes =  filter_var(strtoupper ($datos_nomina['lios_viernes']), FILTER_SANITIZE_STRING);
        $sobrante_viernes =  filter_var(strtoupper ($datos_nomina['sobrante_viernes']), FILTER_SANITIZE_STRING);
        $adelantos_viernes =  filter_var(strtoupper ($datos_nomina['adelantos_viernes']), FILTER_SANITIZE_STRING);
        $gasolina_viernes =  filter_var(strtoupper ($datos_nomina['gasolina_viernes']), FILTER_SANITIZE_STRING);
        $gastos_viernes_1 =  filter_var(strtoupper ($datos_nomina['gastos_viernes_1']), FILTER_SANITIZE_STRING);
        $concepto_viernes_1 =  filter_var(strtoupper ($datos_nomina['concepto_viernes_1']), FILTER_SANITIZE_STRING);
        $gastos_viernes_2 =  filter_var(strtoupper ($datos_nomina['gastos_viernes_2']), FILTER_SANITIZE_STRING);
        $concepto_viernes_2 =  filter_var(strtoupper ($datos_nomina['concepto_viernes_2']), FILTER_SANITIZE_STRING);
        $gastos_viernes_3 =  filter_var(strtoupper ($datos_nomina['gastos_viernes_3']), FILTER_SANITIZE_STRING);
        $concepto_viernes_3 =  filter_var(strtoupper ($datos_nomina['concepto_viernes_3']), FILTER_SANITIZE_STRING);
        $gastos_viernes_4 =  filter_var(strtoupper ($datos_nomina['gastos_viernes_4']), FILTER_SANITIZE_STRING);
        $concepto_viernes_4 =  filter_var(strtoupper ($datos_nomina['concepto_viernes_4']), FILTER_SANITIZE_STRING);
        $total_viernes =  filter_var(strtoupper ($datos_nomina['total_viernes']), FILTER_SANITIZE_STRING);
        
        
        $zona_sabado =  filter_var(strtoupper ($datos_nomina['zona_sabado']), FILTER_SANITIZE_STRING);
        $fecha_sabado =  filter_var(strtoupper ($datos_nomina['fecha_sabado']), FILTER_SANITIZE_STRING);
        $cobro_sabado =  filter_var(strtoupper ($datos_nomina['cobro_sabado']), FILTER_SANITIZE_STRING);
        $nuevas_sabado =  filter_var(strtoupper ($datos_nomina['nuevas_sabado']), FILTER_SANITIZE_STRING);
        $lios_sabado =  filter_var(strtoupper ($datos_nomina['lios_sabado']), FILTER_SANITIZE_STRING);
        $sobrante_sabado =  filter_var(strtoupper ($datos_nomina['sobrante_sabado']), FILTER_SANITIZE_STRING);
        $adelantos_sabado =  filter_var(strtoupper ($datos_nomina['adelantos_sabado']), FILTER_SANITIZE_STRING);
        $gasolina_sabado =  filter_var(strtoupper ($datos_nomina['gasolina_sabado']), FILTER_SANITIZE_STRING);
        $gastos_sabado_1 =  filter_var(strtoupper ($datos_nomina['gastos_sabado_1']), FILTER_SANITIZE_STRING);
        $concepto_sabado_1 =  filter_var(strtoupper ($datos_nomina['concepto_sabado_1']), FILTER_SANITIZE_STRING);
        $gastos_sabado_2 =  filter_var(strtoupper ($datos_nomina['gastos_sabado_2']), FILTER_SANITIZE_STRING);
        $concepto_sabado_2 =  filter_var(strtoupper ($datos_nomina['concepto_sabado_2']), FILTER_SANITIZE_STRING);
        $gastos_sabado_3 =  filter_var(strtoupper ($datos_nomina['gastos_sabado_3']), FILTER_SANITIZE_STRING);
        $concepto_sabado_3 =  filter_var(strtoupper ($datos_nomina['concepto_sabado_3']), FILTER_SANITIZE_STRING);
        $gastos_sabado_4 =  filter_var(strtoupper ($datos_nomina['gastos_sabado_4']), FILTER_SANITIZE_STRING);
        $concepto_sabado_4 =  filter_var(strtoupper ($datos_nomina['concepto_sabado_4']), FILTER_SANITIZE_STRING);
        $total_sabado =  filter_var(strtoupper ($datos_nomina['total_sabado']), FILTER_SANITIZE_STRING);
        
        
        $zona_domingo =  filter_var(strtoupper ($datos_nomina['zona_domingo']), FILTER_SANITIZE_STRING);
        $fecha_domingo =  filter_var(strtoupper ($datos_nomina['fecha_domingo']), FILTER_SANITIZE_STRING);
        $cobro_domingo =  filter_var(strtoupper ($datos_nomina['cobro_domingo']), FILTER_SANITIZE_STRING);
        $nuevas_domingo =  filter_var(strtoupper ($datos_nomina['nuevas_domingo']), FILTER_SANITIZE_STRING);
        $lios_domingo =  filter_var(strtoupper ($datos_nomina['lios_domingo']), FILTER_SANITIZE_STRING);
        $sobrante_domingo =  filter_var(strtoupper ($datos_nomina['sobrante_domingo']), FILTER_SANITIZE_STRING);
        $adelantos_domingo =  filter_var(strtoupper ($datos_nomina['adelantos_domingo']), FILTER_SANITIZE_STRING);
        $gasolina_domingo =  filter_var(strtoupper ($datos_nomina['gasolina_domingo']), FILTER_SANITIZE_STRING);
        $gastos_domingo_1 =  filter_var(strtoupper ($datos_nomina['gastos_domingo_1']), FILTER_SANITIZE_STRING);
        $concepto_domingo_1 =  filter_var(strtoupper ($datos_nomina['concepto_domingo_1']), FILTER_SANITIZE_STRING);
        $gastos_domingo_2 =  filter_var(strtoupper ($datos_nomina['gastos_domingo_2']), FILTER_SANITIZE_STRING);
        $concepto_domingo_2 =  filter_var(strtoupper ($datos_nomina['concepto_domingo_2']), FILTER_SANITIZE_STRING);
        $gastos_domingo_3 =  filter_var(strtoupper ($datos_nomina['gastos_domingo_3']), FILTER_SANITIZE_STRING);
        $concepto_domingo_3 =  filter_var(strtoupper ($datos_nomina['concepto_domingo_3']), FILTER_SANITIZE_STRING);
        $gastos_domingo_4 =  filter_var(strtoupper ($datos_nomina['gastos_domingo_4']), FILTER_SANITIZE_STRING);
        $concepto_domingo_4 =  filter_var(strtoupper ($datos_nomina['concepto_domingo_4']), FILTER_SANITIZE_STRING);
        $total_domingo =  filter_var(strtoupper ($datos_nomina['total_domingo']), FILTER_SANITIZE_STRING);

               
        $cobro_total =  filter_var(strtoupper ($datos_nomina['cobro_total']), FILTER_SANITIZE_STRING);
        $nuevas_totales =  filter_var(strtoupper ($datos_nomina['nuevas_totales']), FILTER_SANITIZE_STRING);
        $lios_totales =  filter_var(strtoupper ($datos_nomina['lios_totales']), FILTER_SANITIZE_STRING);
        

        $folio =  filter_var(strtoupper ($datos_nomina['folio']), FILTER_SANITIZE_STRING);
        $semana =  filter_var(strtoupper ($datos_nomina['semana']), FILTER_SANITIZE_STRING);
        $agente =  filter_var(strtoupper ($datos_nomina['agente']), FILTER_SANITIZE_STRING);
        $pulcera =  filter_var(strtoupper ($datos_nomina['pulcera']), FILTER_SANITIZE_STRING);
        $sueldo_base =  filter_var(strtoupper ($datos_nomina['sueldo_base']), FILTER_SANITIZE_STRING);
        $porcentaje_comicion =  filter_var(strtoupper ($datos_nomina['porcentaje_comicion']), FILTER_SANITIZE_STRING);
        $comiciones =  filter_var(strtoupper ($datos_nomina['comiciones']), FILTER_SANITIZE_STRING);
        $porcentaje_lios =  filter_var(strtoupper ($datos_nomina['porcentaje_lios']), FILTER_SANITIZE_STRING);
        $bono_lios =  filter_var(strtoupper ($datos_nomina['bono_lios']), FILTER_SANITIZE_STRING);
        $pago_nuevas =  filter_var(strtoupper ($datos_nomina['pago_nuevas']), FILTER_SANITIZE_STRING);
        $bono_nuevas =  filter_var(strtoupper ($datos_nomina['bono_nuevas']), FILTER_SANITIZE_STRING);
        
        $bono1 =  filter_var(strtoupper ($datos_nomina['bono1']), FILTER_SANITIZE_STRING);
        $descripcion_bono1 =  filter_var(strtoupper ($datos_nomina['descripcion_bono1']), FILTER_SANITIZE_STRING);
        $bono2 =  filter_var(strtoupper ($datos_nomina['bono2']), FILTER_SANITIZE_STRING);
        $descripcion_bono2 =  filter_var(strtoupper ($datos_nomina['descripcion_bono2']), FILTER_SANITIZE_STRING);
        $bono3 =  filter_var(strtoupper ($datos_nomina['bono3']), FILTER_SANITIZE_STRING);
        $descripcion_bono3 =  filter_var(strtoupper ($datos_nomina['descripcion_bono3']), FILTER_SANITIZE_STRING);
        $bono4 =  filter_var(strtoupper ($datos_nomina['bono4']), FILTER_SANITIZE_STRING);
        $descripcion_bono4 =  filter_var(strtoupper ($datos_nomina['descripcion_bono4']), FILTER_SANITIZE_STRING);
        $subtotal =  filter_var(strtoupper ($datos_nomina['subtotal']), FILTER_SANITIZE_STRING);
        $total_adelantos =  filter_var(strtoupper ($datos_nomina['total_adelantos']), FILTER_SANITIZE_STRING);

        
        $deuda1 = filter_var(strtoupper ($datos_nomina['deuda1']), FILTER_SANITIZE_STRING);
        $descuento1 =  filter_var(strtoupper ($datos_nomina['descuento1']), FILTER_SANITIZE_STRING);
        $concepto_descuento1 =  filter_var(strtoupper ($datos_nomina['concepto_descuento1']), FILTER_SANITIZE_STRING);
        $adeudo_restante1 =  filter_var(strtoupper ($datos_nomina['adeudo_restante1']), FILTER_SANITIZE_STRING);
        $deuda2 = filter_var(strtoupper ($datos_nomina['deuda2']), FILTER_SANITIZE_STRING);
        $descuento2 =  filter_var(strtoupper ($datos_nomina['descuento2']), FILTER_SANITIZE_STRING);
        $concepto_descuento2 =  filter_var(strtoupper ($datos_nomina['concepto_descuento2']), FILTER_SANITIZE_STRING);
        $adeudo_restante2 =  filter_var(strtoupper ($datos_nomina['adeudo_restante2']), FILTER_SANITIZE_STRING);
        $deuda3 = filter_var(strtoupper ($datos_nomina['deuda3']), FILTER_SANITIZE_STRING);
        $descuento3 =  filter_var(strtoupper ($datos_nomina['descuento3']), FILTER_SANITIZE_STRING);
        $concepto_descuento3 =  filter_var(strtoupper ($datos_nomina['concepto_descuento3']), FILTER_SANITIZE_STRING);
        $adeudo_restante3 =  filter_var(strtoupper ($datos_nomina['adeudo_restante3']), FILTER_SANITIZE_STRING);
        $deuda4 = filter_var(strtoupper ($datos_nomina['deuda4']), FILTER_SANITIZE_STRING);
        $descuento4 =  filter_var(strtoupper ($datos_nomina['descuento4']), FILTER_SANITIZE_STRING);
        $concepto_descuento4 =  filter_var(strtoupper ($datos_nomina['concepto_descuento4']), FILTER_SANITIZE_STRING);
        $adeudo_restante4 =  filter_var(strtoupper ($datos_nomina['adeudo_restante4']), FILTER_SANITIZE_STRING);
        $deuda5 = filter_var(strtoupper ($datos_nomina['deuda5']), FILTER_SANITIZE_STRING);
        $descuento5 =  filter_var(strtoupper ($datos_nomina['descuento5']), FILTER_SANITIZE_STRING);
        $concepto_descuento5 =  filter_var(strtoupper ($datos_nomina['concepto_descuento5']), FILTER_SANITIZE_STRING);
        $adeudo_restante5 =  filter_var(strtoupper ($datos_nomina['adeudo_restante5']), FILTER_SANITIZE_STRING);
        $deuda6 = filter_var(strtoupper ($datos_nomina['deuda6']), FILTER_SANITIZE_STRING);
        $descuento6 =  filter_var(strtoupper ($datos_nomina['descuento6']), FILTER_SANITIZE_STRING);
        $concepto_descuento6 =  filter_var(strtoupper ($datos_nomina['concepto_descuento6']), FILTER_SANITIZE_STRING);
        $adeudo_restante6 =  filter_var(strtoupper ($datos_nomina['adeudo_restante6']), FILTER_SANITIZE_STRING);
        
        $porcentaje_ahorro =  filter_var(strtoupper ($datos_nomina['porcentaje_ahorro']), FILTER_SANITIZE_STRING);
        $descuento_ahorro =  filter_var(strtoupper ($datos_nomina['descuento_ahorro']), FILTER_SANITIZE_STRING);
        
        $total_nomina =  filter_var(strtoupper ($datos_nomina['total_nomina']), FILTER_SANITIZE_STRING);

        $caja_ahorros_disponible =  filter_var(strtoupper ($datos_nomina['caja_ahorros_disponible']), FILTER_SANITIZE_STRING);
        $incremento_caja_ahorro =  filter_var(strtoupper ($datos_nomina['incremento_caja_ahorro']), FILTER_SANITIZE_STRING);
        $retiro_caja_ahorro =  filter_var(strtoupper ($datos_nomina['retiro_caja_ahorro']), FILTER_SANITIZE_STRING);
        $concepto_retiro_caja_ahorro =  filter_var(strtoupper ($datos_nomina['concepto_retiro_caja_ahorro']), FILTER_SANITIZE_STRING);
        $total_caja =  filter_var(strtoupper ($datos_nomina['total_caja']), FILTER_SANITIZE_STRING);

        $bloqueo =  filter_var(strtoupper ($datos_nomina['bloqueo']), FILTER_SANITIZE_STRING);
        $motivo =  filter_var(strtoupper ($datos_nomina['motivo']), FILTER_SANITIZE_STRING);

        $copiar_hoja =  filter_var(strtoupper ($datos_nomina['copiar_hoja']), FILTER_SANITIZE_STRING);
        
        //Mostramos las variables solo para corroborar.
        // echo $zona_lunes . '<br/>';
        // echo $fecha_lunes . '<br/>';
        // echo $cobro_lunes . '<br/>';
        // echo $nuevas_lunes . '<br/>';
        // echo $lios_lunes . '<br/>';
        // echo $adelantos_lunes . '<br/>';
        // echo $gastos_lunes_1 . '<br/>';
        // echo $gasolina_lunes . '<br/>';
        // echo $total_lunes . '<br/>';
        // echo $zona_martes . '<br/>';
        // echo $fecha_martes . '<br/>';
        // echo $cobro_martes . '<br/>';
        // echo $nuevas_martes . '<br/>';
        // echo $lios_martes . '<br/>';
        // echo $adelantos_martes . '<br/>';
        // echo $gastos_martes . '<br/>';
        // echo $gasolina_martes . '<br/>';
        // echo $total_martes . '<br/>';
        // echo $zona_miercoles . '<br/>';
        // echo $fecha_miercoles . '<br/>';
        // echo $cobro_miercoles . '<br/>';
        // echo $nuevas_miercoles . '<br/>';
        // echo $lios_miercoles . '<br/>';
        // echo $adelantos_miercoles . '<br/>';
        // echo $gastos_miercoles . '<br/>';
        // echo $gasolina_miercoles . '<br/>';
        // echo $total_miercoles . '<br/>';
        // echo $zona_jueves . '<br/>';
        // echo $fecha_jueves . '<br/>';
        // echo $cobro_jueves . '<br/>';
        // echo $nuevas_jueves . '<br/>';
        // echo $lios_jueves . '<br/>';
        // echo $adelantos_jueves . '<br/>';
        // echo $gastos_jueves . '<br/>';
        // echo $gasolina_jueves . '<br/>';
        // echo $total_jueves . '<br/>';
        // echo $zona_viernes . '<br/>';
        // echo $fecha_viernes . '<br/>';
        // echo $cobro_viernes . '<br/>';
        // echo $nuevas_viernes . '<br/>';
        // echo $lios_viernes . '<br/>';
        // echo $adelantos_viernes . '<br/>';
        // echo $gastos_viernes . '<br/>';
        // echo $gasolina_viernes . '<br/>';
        // echo $total_viernes . '<br/>';
        // echo $folio . '<br/>';
        // echo $semana . '<br/>';
        // echo $agente . '<br/>';
        // echo $pulcera . '<br/>';
        // echo $sueldo_base . '<br/>';
        // echo $bono1 . '<br/>';
        // echo $descripcion_bono1 . '<br/>';
        // echo $descuento1 . '<br/>';
        // echo $concepto_descuento1 . '<br/>';
        // echo $partes_restantes1 . '<br/>';
        // echo $descuento2 . '<br/>';
        // echo $concepto_descuento2 . '<br/>';
        // echo $partes_restantes2 . '<br/>';
        // echo $descuento3 . '<br/>';
        // echo $concepto_descuento3 . '<br/>';
        // echo $partes_restantes3 . '<br/>';
        // echo $caja_ahorros_disponible . '<br/>';
        // echo $incremento_caja_ahorro . '<br/>';
        // echo $retiro_caja_ahorro . '<br/>';
        // echo $concepto_retiro_caja_ahorro . '<br/>';

        //Creamos la logica de la aplicacion:

        $total_lunes = $cobro_lunes + $sobrante_lunes - $adelantos_lunes - $gastos_lunes_1 - $gastos_lunes_2 - $gastos_lunes_3 - $gastos_lunes_4 - $gasolina_lunes;
        $total_martes = $cobro_martes + $sobrante_martes - $adelantos_martes - $gastos_martes_1 - $gastos_martes_2 - $gastos_martes_3 - $gastos_martes_4 - $gasolina_martes;
        $total_miercoles = $cobro_miercoles + $sobrante_miercoles - $adelantos_miercoles - $gastos_miercoles_1 - $gastos_miercoles_2 - $gastos_miercoles_3 - $gastos_miercoles_4 - $gasolina_miercoles;
        $total_jueves = $cobro_jueves + $sobrante_jueves - $adelantos_jueves - $gastos_jueves_1 - $gastos_jueves_2 - $gastos_jueves_3 - $gastos_jueves_4 - $gasolina_jueves;
        $total_viernes = $cobro_viernes + $sobrante_viernes - $adelantos_viernes - $gastos_viernes_1 - $gastos_viernes_2 - $gastos_viernes_3 - $gastos_viernes_4 - $gasolina_viernes;
        $total_sabado = $cobro_sabado + $sobrante_sabado - $adelantos_sabado - $gastos_sabado_1 - $gastos_sabado_2 - $gastos_sabado_3 - $gastos_sabado_4 - $gasolina_sabado;
        $total_domingo = $cobro_domingo + $sobrante_domingo - $adelantos_domingo - $gastos_domingo_1 - $gastos_domingo_2 - $gastos_domingo_3 - $gastos_domingo_4 - $gasolina_domingo;

        $cobro_total = $cobro_lunes + $cobro_martes + $cobro_miercoles + $cobro_jueves + $cobro_viernes + $cobro_sabado + $cobro_domingo;

        $nuevas_totales = $nuevas_lunes + $nuevas_martes + $nuevas_miercoles + $nuevas_jueves + $nuevas_viernes + $nuevas_sabado + $nuevas_domingo;

        $lios_totales = $lios_lunes + $lios_martes + $lios_miercoles + $lios_jueves + $lios_viernes + $lios_sabado + $lios_domingo;



        $comiciones = $cobro_total * ($porcentaje_comicion / 100);

        $bono_lios = $lios_totales * ($porcentaje_lios / 100);

        $bono_nuevas = $nuevas_totales * $pago_nuevas;

        $subtotal = $sueldo_base + $comiciones + $bono_lios + $bono_nuevas + $bono1 + $bono2 + $bono3 + $bono4;

        $total_adelantos = $adelantos_lunes + $adelantos_martes + $adelantos_miercoles + $adelantos_jueves + $adelantos_viernes + $adelantos_sabado + $adelantos_domingo;

        $adeudo_restante1 = $deuda1 - $descuento1;
        $adeudo_restante2 = $deuda2 - $descuento2;
        $adeudo_restante3 = $deuda3 - $descuento3;
        $adeudo_restante4 = $deuda4 - $descuento4;
        $adeudo_restante5 = $deuda5 - $descuento5;
        $adeudo_restante6 = $deuda6 - $descuento6;

        $descuento_ahorro = $subtotal * ($porcentaje_ahorro / 100);
        
        $total_nomina = $subtotal - $total_adelantos - $descuento1 - $descuento2 - $descuento3 - $descuento4 - $descuento5 - $descuento6 - $descuento_ahorro;

        $incremento_caja_ahorro = $descuento_ahorro;

        if ($bloqueo == 'BLOQUEO') {
            $retiro_caja_ahorro = 0;
            $concepto_retiro_caja_ahorro = 0;
        }

        $total_caja = $caja_ahorros_disponible + $incremento_caja_ahorro - $retiro_caja_ahorro;


        //creamos la sentencia sql, y ejecutamos para guardar los datos.
        $guardar = $conexion->prepare(
            "UPDATE nominas SET 
            zona_lunes = '$zona_lunes', 
            fecha_lunes = '$fecha_lunes', 
            cobro_lunes = '$cobro_lunes', 
            nuevas_lunes = '$nuevas_lunes', 
            lios_lunes = '$lios_lunes', 
            sobrante_lunes = '$sobrante_lunes', 
            adelantos_lunes = '$adelantos_lunes', 
            gasolina_lunes = '$gasolina_lunes', 
            gastos_lunes_1 = '$gastos_lunes_1', 
            concepto_lunes_1 = '$concepto_lunes_1', 
            gastos_lunes_2 = '$gastos_lunes_2', 
            concepto_lunes_2 = '$concepto_lunes_2', 
            gastos_lunes_3 = '$gastos_lunes_3', 
            concepto_lunes_3 = '$concepto_lunes_3', 
            gastos_lunes_4 = '$gastos_lunes_4', 
            concepto_lunes_4 = '$concepto_lunes_4', 
            total_lunes = '$total_lunes', 
            zona_martes = '$zona_martes', 
            fecha_martes = '$fecha_martes', 
            cobro_martes = '$cobro_martes', 
            nuevas_martes = '$nuevas_martes', 
            lios_martes = '$lios_martes', 
            sobrante_martes = '$sobrante_martes', 
            adelantos_martes = '$adelantos_martes', 
            gasolina_martes = '$gasolina_martes', 
            gastos_martes_1 = '$gastos_martes_1', 
            concepto_martes_1 = '$concepto_martes_1', 
            gastos_martes_2 = '$gastos_martes_2', 
            concepto_martes_2 = '$concepto_martes_2', 
            gastos_martes_3 = '$gastos_martes_3', 
            concepto_martes_3 = '$concepto_martes_3', 
            gastos_martes_4 = '$gastos_martes_4', 
            concepto_martes_4 = '$concepto_martes_4', 
            total_martes = '$total_martes', 
            zona_miercoles = '$zona_miercoles', 
            fecha_miercoles = '$fecha_miercoles', 
            cobro_miercoles = '$cobro_miercoles', 
            nuevas_miercoles = '$nuevas_miercoles', 
            lios_miercoles = '$lios_miercoles', 
            sobrante_miercoles = '$sobrante_miercoles', 
            adelantos_miercoles = '$adelantos_miercoles', 
            gasolina_miercoles = '$gasolina_miercoles', 
            gastos_miercoles_1 = '$gastos_miercoles_1', 
            concepto_miercoles_1 = '$concepto_miercoles_1', 
            gastos_miercoles_2 = '$gastos_miercoles_2', 
            concepto_miercoles_2 = '$concepto_miercoles_2', 
            gastos_miercoles_3 = '$gastos_miercoles_3', 
            concepto_miercoles_3 = '$concepto_miercoles_3', 
            gastos_miercoles_4 = '$gastos_miercoles_4', 
            concepto_miercoles_4 = '$concepto_miercoles_4', 
            total_miercoles = '$total_miercoles', 
            zona_jueves = '$zona_jueves', 
            fecha_jueves = '$fecha_jueves', 
            cobro_jueves = '$cobro_jueves', 
            nuevas_jueves = '$nuevas_jueves', 
            lios_jueves = '$lios_jueves', 
            sobrante_jueves = '$sobrante_jueves', 
            adelantos_jueves = '$adelantos_jueves', 
            gasolina_jueves = '$gasolina_jueves', 
            gastos_jueves_1 = '$gastos_jueves_1', 
            concepto_jueves_1 = '$concepto_jueves_1', 
            gastos_jueves_2 = '$gastos_jueves_2', 
            concepto_jueves_2 = '$concepto_jueves_2', 
            gastos_jueves_3 = '$gastos_jueves_3', 
            concepto_jueves_3 = '$concepto_jueves_3', 
            gastos_jueves_4 = '$gastos_jueves_4', 
            concepto_jueves_4 = '$concepto_jueves_4', 
            total_jueves = '$total_jueves', 
            zona_viernes = '$zona_viernes', 
            fecha_viernes = '$fecha_viernes', 
            cobro_viernes = '$cobro_viernes', 
            nuevas_viernes = '$nuevas_viernes', 
            lios_viernes = '$lios_viernes', 
            sobrante_viernes = '$sobrante_viernes', 
            adelantos_viernes = '$adelantos_viernes', 
            gasolina_viernes = '$gasolina_viernes', 
            gastos_viernes_1 = '$gastos_viernes_1', 
            concepto_viernes_1 = '$concepto_viernes_1', 
            gastos_viernes_2 = '$gastos_viernes_2', 
            concepto_viernes_2 = '$concepto_viernes_2', 
            gastos_viernes_3 = '$gastos_viernes_3', 
            concepto_viernes_3 = '$concepto_viernes_3', 
            gastos_viernes_4 = '$gastos_viernes_4', 
            concepto_viernes_4 = '$concepto_viernes_4', 
            total_viernes = '$total_viernes', 
            zona_sabado = '$zona_sabado', 
            fecha_sabado = '$fecha_sabado', 
            cobro_sabado = '$cobro_sabado', 
            nuevas_sabado = '$nuevas_sabado', 
            lios_sabado = '$lios_sabado', 
            sobrante_sabado = '$sobrante_sabado', 
            adelantos_sabado = '$adelantos_sabado', 
            gasolina_sabado = '$gasolina_sabado', 
            gastos_sabado_1 = '$gastos_sabado_1', 
            concepto_sabado_1 = '$concepto_sabado_1', 
            gastos_sabado_2 = '$gastos_sabado_2', 
            concepto_sabado_2 = '$concepto_sabado_2', 
            gastos_sabado_3 = '$gastos_sabado_3', 
            concepto_sabado_3 = '$concepto_sabado_3', 
            gastos_sabado_4 = '$gastos_sabado_4', 
            concepto_sabado_4 = '$concepto_sabado_4', 
            total_sabado = '$total_sabado',     
            zona_domingo = '$zona_domingo', 
            fecha_domingo = '$fecha_domingo', 
            cobro_domingo = '$cobro_domingo', 
            nuevas_domingo = '$nuevas_domingo', 
            lios_domingo = '$lios_domingo', 
            sobrante_domingo = '$sobrante_domingo', 
            adelantos_domingo = '$adelantos_domingo', 
            gasolina_domingo = '$gasolina_domingo', 
            gastos_domingo_1 = '$gastos_domingo_1', 
            concepto_domingo_1 = '$concepto_domingo_1', 
            gastos_domingo_2 = '$gastos_domingo_2', 
            concepto_domingo_2 = '$concepto_domingo_2', 
            gastos_domingo_3 = '$gastos_domingo_3', 
            concepto_domingo_3 = '$concepto_domingo_3', 
            gastos_domingo_4 = '$gastos_domingo_4', 
            concepto_domingo_4 = '$concepto_domingo_4', 
            total_domingo = '$total_domingo', 
            cobro_total = '$cobro_total', 
            nuevas_totales = '$nuevas_totales', 
            lios_totales = '$lios_totales', 
            semana = '$semana', 
            agente = '$agente', 
            pulcera = '$pulcera', 
            sueldo_base = '$sueldo_base', 
            porcentaje_comicion = '$porcentaje_comicion', 
            comiciones = '$comiciones', 
            porcentaje_lios = '$porcentaje_lios', 
            bono_lios = '$bono_lios', 
            pago_nuevas = '$pago_nuevas', 
            bono_nuevas = '$bono_nuevas', 
            bono1 = '$bono1', 
            descripcion_bono1 = '$descripcion_bono1', 
            bono2 = '$bono2', 
            descripcion_bono2 = '$descripcion_bono2', 
            bono3 = '$bono3', 
            descripcion_bono3 = '$descripcion_bono3', 
            bono4 = '$bono4', 
            descripcion_bono4 = '$descripcion_bono4', 
            subtotal = '$subtotal', 
            total_adelantos = '$total_adelantos', 
            deuda1 = '$deuda1', 
            descuento1 = '$descuento1', 
            concepto_descuento1 = '$concepto_descuento1', 
            adeudo_restante1 = '$adeudo_restante1', 
            deuda2 = '$deuda2', 
            descuento2 = '$descuento2', 
            concepto_descuento2 = '$concepto_descuento2', 
            adeudo_restante2 = '$adeudo_restante2', 
            deuda3 = '$deuda3', 
            descuento3 = '$descuento3', 
            concepto_descuento3 = '$concepto_descuento3', 
            adeudo_restante3 = '$adeudo_restante3', 
            deuda4 = '$deuda4', 
            descuento4 = '$descuento4', 
            concepto_descuento4 = '$concepto_descuento4', 
            adeudo_restante4 = '$adeudo_restante4', 
            deuda5 = '$deuda5', 
            descuento5 = '$descuento5', 
            concepto_descuento5 = '$concepto_descuento5', 
            adeudo_restante5 = '$adeudo_restante5', 
            deuda6 = '$deuda6', 
            descuento6 = '$descuento6', 
            concepto_descuento6 = '$concepto_descuento6', 
            adeudo_restante6 = '$adeudo_restante6', 
            porcentaje_ahorro = '$porcentaje_ahorro', 
            descuento_ahorro = '$descuento_ahorro', 
            total_nomina = '$total_nomina', 
            caja_ahorros_disponible = '$caja_ahorros_disponible', 
            incremento_caja_ahorro = '$incremento_caja_ahorro', 
            retiro_caja_ahorro = '$retiro_caja_ahorro', 
            concepto_retiro_caja_ahorro = '$concepto_retiro_caja_ahorro', 
            total_caja = '$total_caja',  
            bloqueo = '$bloqueo', 
            motivo = '$motivo' 
            WHERE folio = '$folio'"
        );
        $guardar->execute();

        //Vamos a crear la fecha futura:

    if ($copiar_hoja == 'SI') {

        $semana_futura = $semana + 1;
        $deuda1 = $adeudo_restante1;
        $deuda2 = $adeudo_restante2;
        $deuda3 = $adeudo_restante3;
        $deuda4 = $adeudo_restante4;
        $deuda5 = $adeudo_restante5;
        $deuda6 = $adeudo_restante6;
        $caja_ahorros_disponible = $total_caja;

        //Reiniciamos los descuentos si ya no deve nada se borran los descuentos.
        if ($deuda1 == 0) {
            $descuento1 = 0;
            $concepto_descuento1 = 0;
            $adeudo_restante1 = 0;
        }
        if ($deuda2 == 0) {
            $descuento2 = 0;
            $concepto_descuento2 = 0;
            $adeudo_restante2 = 0;
        }
        if ($deuda3 == 0) {
            $descuento3 = 0;
            $concepto_descuento3 = 0;
            $adeudo_restante3 = 0;
        }
        if ($deuda4 == 0) {
            $descuento4 = 0;
            $concepto_descuento4 = 0;
            $adeudo_restante4 = 0;
        }
        if ($deuda5 == 0) {
            $descuento5 = 0;
            $concepto_descuento5 = 0;
            $adeudo_restante5 = 0;
        }
        if ($deuda6 == 0) {
            $descuento6 = 0;
            $concepto_descuento6 = 0;
            $adeudo_restante6 = 0;
        }
        
        //Rectificamos que la semana futura no este creada, si no esta creada
        $consulta_semana = $conexion->prepare(
            "SELECT folio FROM nominas WHERE agente = '$agente' AND semana = '$semana_futura'"
        );
        $consulta_semana->execute();
        $consulta_semana = $consulta_semana->fetchAll();
        //Si no esta ingresada la fecha futura devuelve array vacio y generamos la fecha futura.
        //Si si esta ingresada la fecha futura regresa datos y entonces no creamos fecha futura solo actualisamos cualquier cambio.

        if (empty($consulta_semana)) {
            $guardar_futura = $conexion->prepare(
                "INSERT INTO nominas (semana, agente, pulcera, sueldo_base, porcentaje_comicion, porcentaje_lios, pago_nuevas, bono1, descripcion_bono1, bono2, descripcion_bono2, bono3, descripcion_bono3, bono4, descripcion_bono4, deuda1, descuento1, concepto_descuento1, deuda2, descuento2, concepto_descuento2, deuda3, descuento3, concepto_descuento3, deuda4, descuento4, concepto_descuento4, deuda5, descuento5, concepto_descuento5,deuda6, descuento6, concepto_descuento6, caja_ahorros_disponible, porcentaje_ahorro, bloqueo, motivo)
                VALUES ('$semana_futura', '$agente', '$pulcera', '$sueldo_base', '$porcentaje_comicion', '$porcentaje_lios', '$pago_nuevas', '$bono1', '$descripcion_bono1', '$bono2', '$descripcion_bono2', '$bono3', '$descripcion_bono3', '$bono4', '$descripcion_bono4', '$deuda1', '$descuento1', '$concepto_descuento1', '$deuda2', '$descuento2', '$concepto_descuento2', '$deuda3', '$descuento3', '$concepto_descuento3', '$deuda4', '$descuento4', '$concepto_descuento4', '$deuda5', '$descuento5', '$concepto_descuento5', '$deuda6', '$descuento6', '$concepto_descuento6', '$caja_ahorros_disponible', '$porcentaje_ahorro', '$bloqueo', '$motivo')"
            );
            $guardar_futura->execute();
        }else {
            $actualizar = $conexion->prepare(
                "UPDATE nominas SET 
                semana = '$semana_futura', 
                agente = '$agente', 
                pulcera = '$pulcera', 
                sueldo_base = '$sueldo_base', 
                porcentaje_comicion = '$porcentaje_comicion', 
                porcentaje_lios = '$porcentaje_lios', 
                pago_nuevas = '$pago_nuevas', 
                bono1 = '$bono1', 
                descripcion_bono1 = '$descripcion_bono1', 
                bono2 = '$bono2', 
                descripcion_bono2 = '$descripcion_bono2', 
                bono3 = '$bono3', 
                descripcion_bono3 = '$descripcion_bono3', 
                bono4 = '$bono4', 
                descripcion_bono4 = '$descripcion_bono4', 
                deuda1 = '$deuda1', 
                descuento1 = '$descuento1', 
                concepto_descuento1 = '$concepto_descuento1', 
                deuda2 = '$deuda2', 
                descuento2 = '$descuento2', 
                concepto_descuento2 = '$concepto_descuento2', 
                deuda3 = '$deuda3', 
                descuento3 = '$descuento3', 
                concepto_descuento3 = '$concepto_descuento3', 
                deuda4 = '$deuda4', 
                descuento4 = '$descuento4', 
                concepto_descuento4 = '$concepto_descuento4', 
                deuda5 = '$deuda5', 
                descuento5 = '$descuento5', 
                concepto_descuento5 = '$concepto_descuento5', 
                deuda6 = '$deuda6', 
                descuento6 = '$descuento6', 
                concepto_descuento6 = '$concepto_descuento6', 
                porcentaje_ahorro = '$porcentaje_ahorro', 
                bloqueo = '$bloqueo', 
                motivo = '$motivo' 
                WHERE semana = '$semana_futura' AND agente = '$agente'"
            );
            $actualizar->execute();
        }

    }


    
header("Location: nominas.php?agente=$agente&semana=$semana");

	}

//si no ay session mandamos a ingresa para crear sesion  
} else {
    header('Location: ingresa.php');
}

?>