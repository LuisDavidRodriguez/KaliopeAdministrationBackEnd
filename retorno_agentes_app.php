<?php

//$password = $_REQUEST["password"];
$password = 'klp2589';

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
            
            $usuarios = $conexion->prepare(
                "SELECT DISTINCT agente FROM nominas"
            );
            $usuarios->execute();
            $usuarios = $usuarios->fetchAll();

            echo json_encode($usuarios);

        }

    }

?>