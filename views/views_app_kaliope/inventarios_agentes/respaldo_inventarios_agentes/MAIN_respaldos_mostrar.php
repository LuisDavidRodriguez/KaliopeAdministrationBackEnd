<?php

/* 
 *Recuperamos de la base de datos los respaldos existentes con un limite de 200 respaldos
 */

include_once '../../../../app_kaliope/base_de_datos_Class.php';

$dataBase = new base_de_datos_Class();

//recojemos los posibles filtros que vengan en el formultario
$filtros = $_POST;
//print_r($filtros);



$arrayRegistrosPorMostrar = $dataBase->respaldo_inventarios_agentes_consultarTodosLosRespaldos();
$arrayPropietariosConRespaldo = $dataBase->respaldo_inventarios_agentes_consultarPropietarioConRespaldo();
$filtroDePropietario = "sinFiltro";
$filtroDeId = "sinFiltro";

//si se entro por primera vez a la pagina los filtros estaran vacios porque no se le ha dado clic al boton filtrar del formulario de filtros
//por lo tanto nada de aqui abajo se mostrara y solo se ejecutara lo de arriba. 
if(!empty($filtros)){
    
    /*Los datos de los filtros llegan asi
     * Array
    (
    [filtroPropietario] => Luisda
    [filtroId] => sinFiltro
    [enviar] => filtrar
    )
     */    
    
    $filtroDePropietario = $filtros['filtroPropietario'];
    $filtroDeId = $filtros["filtroId"];
    
    
    
    if($filtroDePropietario!="sinFiltro"){
        $arrayRegistrosPorMostrar = $dataBase->respaldo_inventarios_agentes_consultarRespaldosPorPropietario($filtroDePropietario);        
        $arrayTodosLosId = array_column($arrayRegistrosPorMostrar,'id');//llenamos los id del usuario para llenar el select
        
        if($filtroDeId!="sinFiltro"){
            $arrayRegistrosPorMostrar = $dataBase->respaldo_inventarios_agentes_consultarRespaldosPorId($filtroDeId);
        }
    }
    
    
}





require './MA_respaldos_mostrar.view.php';













function impar($var)
{
    // Retorna siempre que el número entero sea impar
    return($var & 1);
}