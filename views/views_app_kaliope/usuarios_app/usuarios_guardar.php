<?php

include_once '../../app_kaliope/base_de_datos_Class.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$database = new base_de_datos_Class();



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    
    $datos = $_POST;

    print_r($datos);
    
    array_pop($datos);//le quitamos la ultima posicion del array que es lo del boton
    print_r($datos);
    
    $valores = array_chunk($datos, 6);
    
    foreach ($valores as $value) {
        
        
    }
    
    
    
    print_r($valores);
        
    
    
}

