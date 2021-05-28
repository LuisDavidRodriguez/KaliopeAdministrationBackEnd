<?php

/* 
 * Reiniciamos el sistema del usuario a 0 y cargamos las piezas fisicas recibimos el array de los movimientos fisicos con el decode
 * Crearemos un String este string sera un texto HTML el cual guardaremos en una base de datos
 * para que cuando consultemos ese string tengamos el reporte de inventario facilmente
 * 
 * &renglones=<?php echo urlencode(serialize($arrayRenglonesParaVista)) ;?>
                            $existenciasTotalesSistema = <?php echo $existenciasTotalesSistemaVista ;?>
                            $totalPiezasFisicasCapturadas = <?php echo $totalPiezasFisicasCapturadasVista ;?>
                            $totalPiezasDiferencias = <?php echo $totalPiezasDiferenciasVista ;?>
                            $importeTotalDiferencias = <?php echo $importeTotalDiferenciasVista ;?>
 */

include_once '../../../../app_kaliope/base_de_datos_Class.php';
include_once '../../../../app_kaliope/utilitarios_Class.php';
$database = new base_de_datos_Class();



$propietario = $_GET['propietario'];
$nombreCompleto = $_GET['nombreCompleto'];
$fechaRealizado = $_GET['fecha'];
$horaRealizado = $_GET['hora'];
$existenciasSistema = $_GET['existenciasTotalesSistema'];
$totalFisicasCapturadas = $_GET['totalPiezasFisicasCapturadas'];
$totalDiferenciaPiezas = $_GET['totalPiezasDiferencias'];
$importeTotalDiferencias = $_GET['importeTotalDiferencias'];
$notas = $_GET['notas'];

$arrayFormulario = $_POST;


/*
 * Array
(
    [costoEmpr0] => 99
    [existenciaSistema0] => 0
    [existenciafisica0] => 1
    [codigo0] => 139
    [diferenciaPiezas0] => 1
    [importeDiferencia0] => $99
    [costoEmpr1] => 106
    [existenciaSistema1] => 0
    [existenciafisica1] => 1
    [codigo1] => 149
    [diferenciaPiezas1] => 1
    [importeDiferencia1] => $106
    [costoEmpr2] => 114
    [existenciaSistema2] => 0
    [existenciafisica2] => 1
    [codigo2] => 159
    [diferenciaPiezas2] => 1
    [importeDiferencia2] => $114
    [costoEmpr3] => 121
    [existenciaSistema3] => 0
    [existenciafisica3] => 8
    [codigo3] => 169
    [diferenciaPiezas3] => 8
    [importeDiferencia3] => $968
    [datos] => Finalizar Captura de inventario
)
 */

array_pop($arrayFormulario);
/*
 * Array
(
    [costoEmpr0] => 99
    [existenciaSistema0] => 0
    [existenciafisica0] => 1
    [codigo0] => 139
    [diferenciaPiezas0] => 1
    [importeDiferencia0] => $99
    [costoEmpr1] => 106
    [existenciaSistema1] => 0
    [existenciafisica1] => 1
    [codigo1] => 149
    [diferenciaPiezas1] => 1
    [importeDiferencia1] => $106
    [costoEmpr2] => 114
    [existenciaSistema2] => 0
    [existenciafisica2] => 1
    [codigo2] => 159
    [diferenciaPiezas2] => 1
    [importeDiferencia2] => $114
    [costoEmpr3] => 121
    [existenciaSistema3] => 0
    [existenciafisica3] => 8
    [codigo3] => 169
    [diferenciaPiezas3] => 8
    [importeDiferencia3] => $968
)
 */

$arrayFormulario = array_chunk($arrayFormulario, 6);
/*
 * Array
(
    [0] => Array
        (
            [0] => 99
            [1] => 0
            [2] => 1
            [3] => 139
            [4] => 1
            [5] => $99
        )

    [1] => Array
        (
            [0] => 106
            [1] => 0
            [2] => 1
            [3] => 149
            [4] => 1
            [5] => $106
        )

    [2] => Array
        (
            [0] => 114
            [1] => 0
            [2] => 1
            [3] => 159
            [4] => 1
            [5] => $114
        )

    [3] => Array
        (
            [0] => 121   CostoEmpresaria
            [1] => 0    Existencia sistema
            [2] => 8    existencia fisica
            [3] => 169          Codigo
            [4] => 8    diferencia en peizas
            [5] => $968 importe diferencia
        )

)
 */


$database->inventarios_agentes_reiniciarInventarioA0($propietario);


//afectamos el inventario, las existencias fisicas que vengan en 0 no afectaran el inventario
foreach ($arrayFormulario as $value) {    
    
    $database->inventarios_agentes_incrementaInventario($propietario, $value[3], $value[2]);
}

$database->inventarios_agentes_actualizaVersion($propietario);










echo "<h1> Se ha realizado exitosamente el inventario, ha sido reiniciado con las piezas capturadas fisicamente</h1> ";



$stringPorImprimir= "Notas: $notas <br><br><br>";
$stringPorImprimir.= "Propietario del Inventario: $propietario <br>";
$stringPorImprimir.= "Nombre Completo: $nombreCompleto <br>";
$stringPorImprimir.= "Fecha Realizado: $fechaRealizado <br>";
$stringPorImprimir.= "Hora: $horaRealizado <br><br><br>";



//creamos el estring con el formato de impresion que se guardara en la base de datos para mostrarla en html, le insertamois el encabezado
$stringPorImprimir.= "<br> EMPRESARIA &nbsp EXISTENCIAS &nbsp CODIGO &nbsp FISICAMENTE &nbsp diferenciaPz &nbsp importe <br>";
    

        foreach ($arrayFormulario as $value) {
            $stringPorImprimir.= 
                       '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'. $value[0].
                       '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$value[1].
                       '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$value[3].
                       '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'. $value[2].
                       '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$value[4].
                       '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$value[5] .
                               '<br>';
                       

        }
               
         
        
         $stringPorImprimir.= '<br><br>';
         
         $stringPorImprimir.= "<h3>Existencias segun Sistema: $existenciasSistema </h3>";
         $stringPorImprimir.= "<h3>Total piezas Fisicas Capturadas:  $totalFisicasCapturadas</h3>";         
         $stringPorImprimir.= ($totalDiferenciaPiezas>0)?"<h3>Sobran: $totalDiferenciaPiezas piezas</h3>" : "<h3>Faltan: $totalDiferenciaPiezas piezas</h3>";
         $stringPorImprimir.= ($importeTotalDiferencias>0)?"<h3>Importe Sobrante: $$importeTotalDiferencias</h3>" : "<h3>Importe Faltante: $$importeTotalDiferencias</h3>";
         $stringPorImprimir.= '<br><br><br><br><br><br>';
         
         
           
         
         
         //Mostramos en la pantalla el stringPorImprimir         
         echo $stringPorImprimir;
         
         
         //guardamos la cadena del reporte en la base de datos de los fisico_vs_sistema
         $database->fisico_vs_sistema_inventario_insertarReporte($propietario, $nombreCompleto, $fechaRealizado, $horaRealizado, $importeTotalDiferencias, $totalDiferenciaPiezas, $stringPorImprimir);
         
         
         
          echo "<a href=../MAIN_mostrar_inventarios.php?>Ir a Los Inventarios</a> ";
         
        
         
        
    
    
    
    
    
    






