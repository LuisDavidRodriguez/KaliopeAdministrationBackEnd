<?php

/* 
 * Llenaremos la vista de crear el inventario, solo con un select con los nombres de usuarios que tenmos
 * registrados en la lista de usuarios
 */


include_once '../../../app_kaliope/base_de_datos_Class.php';

$dataBase  = new base_de_datos_Class();

$arrayUsuarios_existentes = $dataBase->usuarios_app_kaliope_consultaTodosLosUsuarios();


require 'crear_inventario_mostrar.view.php';

