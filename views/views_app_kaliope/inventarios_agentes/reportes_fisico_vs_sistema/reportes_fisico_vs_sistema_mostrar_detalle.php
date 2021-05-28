<?php

/* 
 *recibimos la cadena que contiene la informacion del reporte con formato html que estaba guardada en la base de datos
 * y simplemente la mostramos con un echo, crei que podiamos recibir la cadena por el get, pero para ello hay que usar el url decode ya que como es un string con caracteres que se
 * usan en HTML la informacion se daña, con el urlEncode funciona bien, pero con cadenas cortas, cuando la cadena es muy larga marca error de que el link no puede enviar una 
 * cadena tan grande.
 * para ello mejor recibimos el propietario creamos la consulta a la tabla y mostramos directamente la cadena mejor
 */

include_once '../../../../app_kaliope/base_de_datos_Class.php';
$database = new base_de_datos_Class();

$propietario = $_GET['propietario'];
$fecha = $_GET['fecha'];
$hora = $_GET['hora'];

$cadena = $database->fisico_vs_sistema_inventario_consultarCadenaReportes($propietario,$fecha,$hora);


echo "<h2> Visualisador de Reportes Fisico vs Sistema </h2> ";

//boton de menu anterior
echo "<a href=reportes_fisico_vs_sistema_mostrar.php?>Regresar</a> ";

echo "<br><br><br><br>";


echo "$cadena";






//echo "Propietario del Inventario: David                             <br>Nombre Completo:  Luis David Rodriguez Valades                             <br>Fecha Realizado: 9-8-2019                             <br>Hora: 14:29:54                             <br><br><br><br> VENDEDORA &nbsp EXISTENCIAS &nbsp CODIGO &nbsp FISICAMENTE &nbsp diferenciaPz &nbsp importe <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp333&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp10&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp399&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-10&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $-3330<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp423&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp499&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $2115<br><br><br><h3>Existencias segun Sistema: 10                             </h3><h3>Total piezas Fisicas Capturadas:  5                            </h3><h3>faltan: -5                             piezas</h3><h3>Importe Faltante: $-5                            </h3><br><br><br><br><br><br>";

