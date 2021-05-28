<?php

/* Cuando el usuario firme el movimiento que realizo en el inventario, lo hara unicamente ingresando su contraseña 
 * de usuario, en ese momento la handheld se conectara a este archivo, donde buscaremos a que usuario 
 * pertenese esa contraseña ingresada, y le responderemos a la handheld con el nombre de usuario, su nombre completo
 * 
 */

include_once './base_de_datos_Class.php';

$dataBase = new base_de_datos_Class();

$password = filter_var ($_REQUEST["password"], FILTER_SANITIZE_STRING);


try{
    $arrayUsuarioPorPassword = $dataBase->usuarios_app_kaliope_consultaUsuarioPorPasswordArray($password);
    $nombreCompleto  =$arrayUsuarioPorPassword['nombre_empleado'];
    $usuario  =$arrayUsuarioPorPassword['usuario'];
    
    echo '{"nombreCompleto":"'  .$nombreCompleto.  '",'.
            '"usuario":"'.  $usuario    .'"'                  
            .'}';
} catch (Exception $ex) {
    echo $ex->getMessage();
}



