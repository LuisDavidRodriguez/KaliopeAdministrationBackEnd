<?php
include_once '../../../app_kaliope/base_de_datos_Class.php';
include_once '../../../app_kaliope/utilitarios_Class.php';


$propietario = $_GET['propietario'];
$administrador = $_GET['administrador'];
$motivoMovimiento = $_GET['motivo'];
//recibimos los arrays, sin el urldecode tambien funciono solo con el unserialize
$arrayEntradas = unserialize(urldecode($_GET['entradas']));
$arraySalidas = unserialize(urldecode($_GET['salidas']));

$dataBase = new base_de_datos_Class();


//echo   "en afectar inventario";
//echo "<br>";

//echo $propietario;
//echo "<br>";



//print_r($arrayEntradas);
/*
 * (
    [0] => Array
        (
            [codigo] => 159
            [cantidad] => 5
        )

    [1] => Array
        (
            [codigo] => 169
            [cantidad] => 2
        )

    [2] => Array
        (
            [codigo] => 189
            [cantidad] => 3
        )

)
 */
//echo "<br>";
//print_r($arraySalidas);
//echo "<br>";

$piezasAntesDeModificacion = $dataBase->inventarios_agentes_consultarPiezasTotalesPropietario($propietario);
$importeAntesDeModificacion = $dataBase->inventarios_agentes_consultarImporteTotalPropietario($propietario);
$versionAntesDeModificacion = $dataBase->inventarios_agentes_consultaVersionInventario($propietario);

//afectamos el inventario con los movimientos

foreach ($arrayEntradas as $value) {
    $codigo = $value['codigo'];
    $cantidad = $value['cantidad'];
    $dataBase->inventarios_agentes_incrementaInventario($propietario, $codigo, $cantidad);
    //echo "Ingresando: $cantidad de $codigo al inventario de $propietario <br>";
    
    
}

foreach ($arraySalidas as $value) {
   $codigo = $value['codigo'];
    $cantidad = $value['cantidad'];
    $dataBase->inventarios_agentes_decrementaInventario($propietario, $codigo, $cantidad);
    //echo "Sacando: $cantidad de $codigo del inventario de $propietario <br>";
    
    
}

//ahora llamamos al metodo que actualiza la version del inventario porque este ha sufrido cambios
$dataBase->inventarios_agentes_actualizaVersion($propietario);

$piezasDespuesDeModificacion = $dataBase->inventarios_agentes_consultarPiezasTotalesPropietario($propietario);
$importeDespuesDeModificacion = $dataBase->inventarios_agentes_consultarImporteTotalPropietario($propietario);
$versionDespuesDeModificacion = $dataBase->inventarios_agentes_consultaVersionInventario($propietario);



crearImpresionGuardarBitacora($propietario, $administrador, $motivoMovimiento, $arrayEntradas, $arraySalidas, $dataBase, $piezasAntesDeModificacion, $importeAntesDeModificacion, $versionAntesDeModificacion, $piezasDespuesDeModificacion, $importeDespuesDeModificacion, $versionDespuesDeModificacion);

header('Location: MAIN_mostrar_inventarios.php');








function crearImpresionGuardarBitacora($propietario,$administrador,$motivoMovimiento,$entradas,$salidas,$dataBase,$piezasAntes,$importeAntes,$versionAntes,$piezasDespues,$importeDespues,$versionDespues){
    
    $fecha = utilitarios_Class::dameFecha_dd_mm_aaaa_ToText();
    $hora = utilitarios_Class::horaActual_hh_mm_ss_ToText();
    
    
$stringPorImprimir= "Propietario del Inventario: $propietario <br>";
$stringPorImprimir.= "Administrador $administrador <br>";
$stringPorImprimir.= "Motivo: $motivoMovimiento <br>";
$stringPorImprimir.= "Fecha Realizado: $fecha <br>";
$stringPorImprimir.= "Hora: $hora <br><br><br>";



//creamos el estring con el formato de impresion que se guardara en la base de datos para mostrarla en html, le insertamois el encabezado
$stringPorImprimir.= "<br> Entradas";
$stringPorImprimir.= "<br> CODIGO &nbsp CANTIDAD <br>";
$totalEntradas = 0;
    

        foreach ($entradas as $value) {
            $stringPorImprimir.= 
                       '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'. $value['codigo'].
                       '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$value['cantidad'].
                               '<br>';                     
            $totalEntradas+=$value['cantidad'];
        }
$stringPorImprimir.= "Total Entradas: $totalEntradas <br>";
        
$stringPorImprimir.= "<br> Salidas";
$stringPorImprimir.= "<br> CODIGO &nbsp CANTIDAD <br>";
$totalSalidas = 0;
        
        foreach ($salidas as $value) {
            $stringPorImprimir.= 
                       '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'. $value['codigo'].
                       '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$value['cantidad'].
                               '<br>';  
            $totalSalidas+=$value['cantidad'];

        }
$stringPorImprimir.= "Total Salidas: $totalSalidas <br>";        
               
         
        
         $stringPorImprimir.= '<br><br>';
         
         $stringPorImprimir.= "<h3>Existencias Antes: $piezasAntes </h3>";
         $stringPorImprimir.= "<h3>Existencias Despues:  $piezasDespues</h3>"; 
         $stringPorImprimir.= "<h3>Importe Antes:  $importeAntes</h3>";
         $stringPorImprimir.= "<h3>Importe Despues:  $importeDespues</h3>";
         $stringPorImprimir.= "<h3>Version Antes:  $versionAntes</h3>";
         $stringPorImprimir.= "<h3>Version Despues:  $versionDespues</h3>";         
         $stringPorImprimir.= '<br><br><br><br><br><br>';
         
         
           
         
         
         //Mostramos en la pantalla el stringPorImprimir
         //echo $stringPorImprimir;
         
         
         
         
         //guardamos la cadena del reporte en la base de datos de los fisico_vs_sistema
         $dataBase->modificar_inventarios_bitacora_insertarBitacora ($propietario,$administrador,$motivoMovimiento,$fecha,$hora,$totalEntradas,$totalSalidas,$piezasAntes,$piezasDespues,$versionAntes,$versionDespues,$stringPorImprimir);
}