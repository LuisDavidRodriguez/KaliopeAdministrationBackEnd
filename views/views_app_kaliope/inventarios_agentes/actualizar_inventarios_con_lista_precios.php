<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include_once '../../../app_kaliope/base_de_datos_Class.php';

$dataBase = new base_de_datos_Class();

try{
    $dataBase->inventarios_agentes_actualizaNuevaListaDePreciosInventario();    
} catch (Exception $ex) {
    echo $ex->getMessage();
}


