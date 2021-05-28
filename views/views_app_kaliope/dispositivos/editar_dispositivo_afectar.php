<?php

/* 
 * En este archivo recibimos los parametros enviados por el formulario
 * pero solo los dos que estan habilitados para la edicion
 */



include_once '../../../app_kaliope/base_de_datos_Class.php';

$dataBase = new base_de_datos_Class();


if($_SERVER['REQUEST_METHOD'] == 'POST'){   
    
    $datos = $_POST;
    print_r($datos); 
    /*
     * Array
        (
    [id] => 98
    [autorizado] => 1
    [comentarios] => 0
    [Guardar_Cambios] => Guardar Cambios
        )
     */
    array_pop($datos);//le quitamos la ultima posicion del array que es lo del boton
    print_r($datos);  
    
    /*
     * Array
    (
    [id] => 98
    [autorizado] => 1
    [comentarios] => 0
    )
     */
    
          
    $dataBase->dispositivos_actualizarDispositivoId($datos['id'], $datos['autorizado'], $datos['comentarios']);
       require './MAIN_mostrar_dispositivos.php';
    

    
}