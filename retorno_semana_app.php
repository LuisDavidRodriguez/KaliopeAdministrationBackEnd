<?php

//$password = $_REQUEST["password"];
//$empleado = $_REQUEST["empleado"];
$password = 'klp2589';
$empleado = 'HECTOR';

    if ($password != '') {
        //Creamos la conexion a la base de datos.
		try {
			$conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
		} catch(PDOException $e){
			echo "Error" . $e->getMessage();;
        }

        //Comprobamos el usuario y contraseña.
        $validar = $conexion->prepare(
            "SELECT contrasena FROM usuarios WHERE usuario = 'app'"
        );
        $validar->execute();
        $validar = $validar->fetchAll();
        $validar = $validar[0][0];
        //echo $validar;

        if ($validar == $password) {
            
            $semana = $conexion->prepare(
                "SELECT DISTINCT semana FROM nominas WHERE agente = '$empleado' ORDER BY semana DESC"
            );
            $semana->execute();
            $semana = $semana->fetchAll();

            echo json_encode($semana);

        }

    }

?>