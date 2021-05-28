<?php

/* este archivo se llamara
 * cuando se precione el botond e envair el formulario
 * aqui validaremos la logitud del nombre, del usuario, de la contraseña
 * al igual como lo hicimos cuando añadimos un nuevo usuario
 */


include_once '../../../app_kaliope/base_de_datos_Class.php';

$dataBase = new base_de_datos_Class();


if($_SERVER['REQUEST_METHOD'] == 'POST'){   
    
    $datos = $_POST;
    //print_r($datos); 
    /*
     * Array
        (
            [nombre] => Jovahni estrada Eligio
            [usuario] => Jovas
            [password] => 1234
            [pulsera] => P5652
            [rutaAsignada] => M4
            [autorizado] => 1
            [Guardar_Cambios] => Guardar Cambios
        )
     */
    array_pop($datos);//le quitamos la ultima posicion del array que es lo del boton
    //print_r($datos);  
    
    /*
     * Array
(
    [nombre] => Jovahni estrada Eligio
    [usuario] => Jovas
    [password] => 1234
    [pulsera] => P5652
    [rutaAsignada] => M4
    [autorizado] => 1
)
     */
    
    try{
        $dataBase->usuarios_app_kaliope_actualizarUsuario($datos['nombre'], $datos['usuario'], $datos['password'], $datos['pulsera'], $datos['rutaAsignada'], $datos['autorizado']);
        require 'MAIN_usuarios_mostrar.php';
    } catch (Exception $ex) {
        
        echo $ex->getMessage();
        
    }
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

