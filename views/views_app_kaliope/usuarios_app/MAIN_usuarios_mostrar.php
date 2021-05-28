<?php

include_once '../../../app_kaliope/base_de_datos_Class.php';

$dataBase = new base_de_datos_Class();
try{
    $datosUsuarios = $dataBase->usuarios_app_kaliope_consultaTodosLosUsuariosMenosSinPropietario();
} catch (Exception $ex) {
    echo $ex->getMessage();
}

//consultamos los usuarios pero no mostramos los que son utilitarios para mover los inventarios los de SinPropietario



require 'MA_usuarios.view.php';
