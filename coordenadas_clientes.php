<?php

//Recibimos las variables enviadas que son Zona, Fecha, y Vehiculo.
$zona = $_GET['zona'];
$fecha = $_GET['fecha'];
$vehiculo = $_GET['vehiculo'];

//Remplazamos caracteres y los covertimos en xml
function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

//Creamos la conexion a la base de datos para utilizarla mas adelante.
try {
    $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
} catch(PDOException $e){
    echo "Error" . $e->getMessage();;
}

//Hacemos la consulta de las coordenadas de los clientes.
$result = $conexion->prepare(
    "SELECT folio, nombre, estado, latitud_fija, longitud_fija, grado FROM movimientos WHERE zona = '$zona' AND fecha = '$fecha'"
);
$result->execute();
$result = $result->fetchAll();

//Creamos las cabeceras xml para pasarlas al archivo javascrip.
header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';

foreach ($result as $row) {
    // Add to XML document node
  echo '<marker ';
  echo 'id="' . $row['folio'] . '" ';
  echo 'name="' . parseToXML($row['nombre']) . '" ';
  echo 'address="' . parseToXML($row['estado']) . '" ';
  echo 'lat="' . $row['latitud_fija'] . '" ';
  echo 'lng="' . $row['longitud_fija'] . '" ';
  echo 'type="' . $row['grado'] . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';


//header('Location: representar_mapa.php');
?>