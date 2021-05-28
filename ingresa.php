<?php session_start();
//Comprobamos que se inicio sesion si no enviamos a index a comprobar
if(isset($_SESSION['usuario'])){
    header('Location: index.php');
}

$errores = '';

//Recibimos los datos que envia el usuario
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $propietario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
    $contrasena = $_POST['contrasena'];
    
    //Creamos la conexion a la base de datos
    try {
        $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');

    } catch(PDOException $e){
        echo "Error" . $e->getMessage();;
    }
    
    //Ejecutamos la conexion y especificamos la tabla a elegir
    $statement = $conexion->prepare('
        SELECT * FROM usuarios WHERE usuario = :usuario AND contrasena = :contrasena
    ');
    $statement->execute(array(
        ':usuario' => $propietario,
        ':contrasena' => $contrasena
    ));
    
    //Ingresamos en array, comprobamos si no esta vacio entonces se crea la sesion
    $resultado = $statement->fetch();
    if($resultado !== false){
        $_SESSION['usuario'] = $propietario;
        header('Location: index.php');
    //Si esta vacio el array rellenamos la variable errores y mostramos
    } else{
        $errores .= '<li>Por favor ingresa un usuario y contraseña valida.</li>';
    }
}


require 'views/ingresa.view.php';

?>
