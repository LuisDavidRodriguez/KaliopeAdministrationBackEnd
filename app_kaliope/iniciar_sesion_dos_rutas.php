<?php
header('Content-type: application/json; charset=utf-8');



include_once 'utilitarios_Class.php';
include_once 'base_de_datos_Class.php';


$propietario = filter_var ($_REQUEST["alias"], FILTER_SANITIZE_STRING);
$password = filter_var ($_REQUEST["password"], FILTER_SANITIZE_STRING);
$uuid = filter_var ($_REQUEST["UUID"], FILTER_SANITIZE_STRING);
$modeloMovil = filter_var ($_REQUEST["modeloDispositivo"], FILTER_SANITIZE_STRING);
date_default_timezone_set('America/Mexico_City');
$fechaActual = utilitarios_Class::fechaActualToText();



//$propietario = 'Eduardo';
//$password = '050059';
//$uuid = '8acc9cc1-5e26-40bb-a832-71270de8547b';
//$modeloMovil = 'LM-X210CMR';

//creamos un nuevo objeto de la clase usuarios_app_kaliope para manejar todo lo referente a los usuarios

$dataBase = new base_de_datos_Class();



try{
    
    $dataBase->usuarios_app_kaliope_verificarUsuarioPassword($propietario, $password);    
    $dataBase->dispositivos_verificarDispositivo($uuid, $modeloMovil, $fechaActual);     
    
    
                   
            //creamos el json con los clientes, y el inventario
            echo '{
                "inventario":'    . $dataBase->inventarios_agentes_consultarInventarioJsonEncode($propietario). ','.
                '"informacion":'.   '{"id":"Bienvenido '.$propietario.'","nombre":"otro valor que quiera"},'.
                '"zona":'. $dataBase->zonificacion_getZonificacionDosRutas($propietario). ','.                 
                '"clientes":'. $dataBase->movimientos_consultarCuentasDosRutas($propietario).','.
                '"infoUsuario":'. $dataBase->usuarios_app_kaliope_consultaInfoUsuarioJsonEncode($propietario)
                 .'}';
            
            
            //ponemos que el inventario se envio al movil
            $dataBase->inventarios_agentes_ponerEnviadoAlMovil($propietario);
            
            
            
            /*
             * 	
inventario	
    0	
            0	"1933"
            1	"Eduardo"
            2	"29"
            3	"0"
            4	"29"
            5	"22"
            6	"21"
            7	"21"
            8	"25"
            9	"0"
            10	""
            11	""
            id	"1933"
            propietario	"Eduardo"
            codigo	"29"
            existencia	"0"
            precio	"29"
            vendedora	"22"
            socia	"21"
            empresaria	"21"
            version	"25"
            enviado_al_movil	"0"
            hora_de_envio_al_movil	""
            hora_sincronizado_desde_el_movil	""
    1	
            0	"1934"
            1	"Eduardo"
            2	"39"
            3	"0"
            4	"39"
            5	"30"
            6	"29"
            7	"28"
            8	"25"
            9	"0"
            10	""
            11	""
            id	"1934"
            propietario	"Eduardo"
            codigo	"39"
            existencia	"0"
            precio	"39"
            vendedora	"30"
            socia	"29"
            empresaria	"28"
            version	"25"
            enviado_al_movil	"0"
            hora_de_envio_al_movil	""
            hora_sincronizado_desde_el_movil	""
             
informacion	
    id  	"Bienvenido Eduardo"
    nombre	"otro valor que quiera"
             
zona	
    0	
        zona	"CANALEJAS"
        zonificacion	"-99.6323495443894,19.939…282677387721,20.0771827"
    1	
        zona	"SAN JUAN DEL RIO"
        zonificacion	"-99.89717659228742,20.37…742,20.37502814621686,0"

clientes	
    0	
            zona        "CANALEJAS"
            clientes	
                    0	
                            0	"1146"
                            1	"ANA LAURA JUAREZ ARELLANO"
                            2	"55 39 60 97 72"
                            3	"28"
                            4	"EMPRESARIA"
                            5	"4000"
                            6	"ACTIVO"
                            7	"20.021389875920317"
                            8	"-99.66920361254584"
                            9	"0"
                            10	"13"
                            11	"2687"
                            12	"12-09-2019"
                            13	"0"
                            14	"TODO BIEN"
                            15	"0"
                            16	"1-159-0 1-279-0 1-159-0 …71 2-369-295 1-459-376 "
                            17	"**29-08-2019* Pago: 0*Sa…eporte: CUENTA DE MES**"
                            cuenta	"1146"
                            nombre	"ANA LAURA JUAREZ ARELLANO"
                            telefono	"55 39 60 97 72"
                            dias	"28"
                            grado	"EMPRESARIA"
                            credito	"4000"
                            estado	"ACTIVO"
                            latitud_fija	"20.021389875920317"
                            longitud_fija	"-99.66920361254584"
                            adeudo_cargo	"0"
                            piezas_cargo	"13"
                            importe_cargo	"2687"
                            fecha_vence_cargo	"12-09-2019"
                            puntos_disponibles	"0"
                            reporte_agente	"TODO BIEN"
                            reporte_administracion	"0"
                            mercancia_cargo	"1-159-0 1-279-0 1-159-0 …71 2-369-295 1-459-376 "
                            total_pagos	"**29-08-2019* Pago: 0*Sa…eporte: CUENTA DE MES**"
                    1	{…}
                    2	{…}
                    3	{…}
                    4	{…}
                    5	{…}
                    6	{…}
                    7	{…}
                    8	{…}
                    9	{…}
                    10	{…}
                    11	{…}
                    12	{…}
                    13	{…}
            fechaClientesConsulta	"29-08-2019"
    1	
            zona        "SAN JUAN DEL RIO"
            clientes	
                    0	{…}
                    1	{…}
                    2	{…}
                    3	{…}
                    4	{…}
                    5	{…}
                    6	{…}
                    7	{…}
                    8	{…}
                    9	{…}
                    10	{…}
                    11	{…}
                    12	{…}
                    13	{…}
            fechaClientesConsulta	"27-08-2019"
             
infoUsuario	
        0	
        0	"Eduardo Baldomero Maximo"
        1	"Eduardo"
        2	"p5348"
        3	"A1"
        nombre_empleado	"Eduardo Baldomero Maximo"
        usuario	"Eduardo"
        codigo_empleado_pulsera	"p5348"
        ruta_asignada	"A1"
             * 
             */
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}


    

         
     




























    



