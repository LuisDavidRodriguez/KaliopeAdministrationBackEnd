<?php

/* 
 *recibimos la cadena que contiene la informacion del reporte con formato html que estaba guardada en la base de datos
 * y simplemente la mostramos con un echo,  recibimos el propietario fecha y hora creamos la consulta a la tabla y mostramos directamente la cadena mejor
 */

include_once '../../../../app_kaliope/base_de_datos_Class.php';
$database = new base_de_datos_Class();

$propietario = $_GET['propietario'];
$fecha = $_GET['fecha'];
$hora = $_GET['hora'];

$cadena = $database->modificar_inventarios_bitacora_consultarCadenaBitacora($propietario, $fecha, $hora);


echo "<h2> Visualisador de Bitacoras de Modificacion de Inventario </h2> ";

//boton de menu anterior
echo "<a href=bitacora_movimientos_mostrar.php?>Regresar</a> ";

echo "<br><br><br><br>";


echo "$cadena";