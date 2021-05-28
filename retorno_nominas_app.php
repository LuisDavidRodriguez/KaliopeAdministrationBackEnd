<?php

//$password = $_REQUEST["password"];
//$empleado = $_REQUEST["empleado"];
//$semana = $_REQUEST["numeroSemana"];

$password = 'klp2589';
$empleado = 'HECTOR';
$semana = '22';



    if ($password != "") {
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

                $datos = $conexion->prepare(
                    "SELECT * FROM nominas WHERE agente = '$empleado' AND semana = '$semana'"
                );
                $datos->execute();
                $datos = $datos->fetchAll();

                echo json_encode($datos);

        }

    }

?>