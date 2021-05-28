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



//$alias = 'David';
//$password = '9411';
//$uuid = '50608741-d54a-4095-86ef-b101872a939';
//$modeloMovil = 'M20';

//creamos un nuevo objeto de la clase usuarios_app_kaliope para manejar todo lo referente a los usuarios

$dataBase = new base_de_datos_Class();



try{
    
    $dataBase->usuarios_app_kaliope_verificarUsuarioPassword($propietario, $password);    
    $dataBase->dispositivos_verificarDispositivo($uuid, $modeloMovil, $fechaActual);     
    
    
                   
            //creamos el json con los clientes, y el inventario
            echo '{
                "inventario":'    . $dataBase->inventarios_agentes_consultarInventarioJsonEncode($propietario). ','.
                '"informacion":'.   '{"id":"Bienvenido '.$propietario.'","nombre":"otro valor que quiera"},'.
                '"zona":'. $dataBase->zonificacion_getZonificacion($propietario). ','.                 
                '"clientes":'. $dataBase->movimientos_consultarCuentas($propietario).','.
                '"infoUsuario":'. $dataBase->usuarios_app_kaliope_consultaInfoUsuarioJsonEncode($propietario)
                 .'}';
            
            
            //ponemos que el inventario se envio al movil
            $dataBase->inventarios_agentes_ponerEnviadoAlMovil($propietario);
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}


    

         
     




























    



