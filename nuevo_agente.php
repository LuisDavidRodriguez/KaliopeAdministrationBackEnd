<?php session_start();

//Comprobamos la sesion, si ay sesion requerimos de la vista de selecciona ruta
if(isset($_SESSION['usuario'])){

    //Mandamos los datos a la misma pagina y los procesamos.
    if (isset($_POST['enviar'])) {

        $nombre_agente = $_POST['nombre_agente'];
        $numero_semana = $_POST['numero_semana'];
        
        $nombre_agente =  filter_var(strtoupper ($nombre_agente), FILTER_SANITIZE_STRING);
        $numero_semana =  filter_var(strtoupper ($numero_semana), FILTER_SANITIZE_STRING);
        $porcentaje_comicion = 4;
        $porcentaje_lios = 21;
        $pago_nuevas = 20;
        $bloqueo = 'LIBRE';

        //Creamos la conexion a la base de datos para utilizarla mas adelante.
		try {
			$conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
		} catch(PDOException $e){
			echo "Error" . $e->getMessage();;
        }

        $agente = $conexion->prepare(
            "INSERT INTO nominas(semana, agente, porcentaje_comicion, porcentaje_lios, pago_nuevas, bloqueo) VALUES('$numero_semana', '$nombre_agente', '$porcentaje_comicion', '$porcentaje_lios', '$pago_nuevas', '$bloqueo')"
        );
        $agente->execute();

        header('Location: selecciona_agente.php');

    }else {
            require 'views/nuevo_agente.view.php';
          }

    


//Si no ay sesion mandamos a ingresa para crear la sesion
}else{
   header('Location: ingresa.php');
}

?>