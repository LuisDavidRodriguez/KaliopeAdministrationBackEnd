<?php
include_once '../../../app_kaliope/base_de_datos_Class.php';

/*
 * En llamamos a este archivo cuando en la vista de nuevo_usuario.view.html 
 * quieramos cargar un nuevo usuario
 * el metodo agregar nuevo usuario ya tiene una serie de 
 * excepciones, y validadores, por ejemplo validamos que los nombres tengan una logitud minima
 * que la ruta asignada como la A1 exista y que no este ya asignada a ningun otro usuario
 * 
 * Al momento de que se crea el nuevo usuario en automatico se tiene que insertar un nuevo inventario con su nombre de usuario en 0
 */

$dataBase = new base_de_datos_Class();


if($_SERVER['REQUEST_METHOD'] == 'POST'){   
    
    $datos = $_POST;
    //print_r($datos);    
    array_pop($datos);//le quitamos la ultima posicion del array que es lo del boton
    //print_r($datos);    

    try{
        $dataBase->usuarios_app_kalipe_agergarNuevoUsuario($datos['nombre'],$datos['usuario'], $datos['password'], $datos['pulsera'], $datos['rutaAsignada'], $datos['autorizado']);
        $dataBase->inventarios_agentes_insertaNuevoInventario($datos['usuario']); //insertamos un nuevo inventario en 0
        require 'MAIN_usuarios_mostrar.php';
        
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
