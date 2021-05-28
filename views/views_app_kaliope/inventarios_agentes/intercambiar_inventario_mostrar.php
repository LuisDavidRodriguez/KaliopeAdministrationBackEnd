<?php

/*
 * En este archivo vamos a consultar todos los propietarios existentes
 * para rellenar nuestras casillas de seleccion en la vista
 */
include_once '../../../app_kaliope/base_de_datos_Class.php';

$dataBase  = new base_de_datos_Class();

$arrayPropietarios_existentes = $dataBase->inventarios_agentes_consultarUsuariosConInventario();


require 'intercambiar_inventario.view.php';