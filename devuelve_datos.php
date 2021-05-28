<?php

try {
    $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
} catch(PDOException $e){
    echo "Error" . $e->getMessage();;
}

$datos = $conexion->prepare(
    "SELECT * FROM personas"
);
$datos->execute();
$datos = $datos->fetchAll();

echo json_encode($datos);

?>