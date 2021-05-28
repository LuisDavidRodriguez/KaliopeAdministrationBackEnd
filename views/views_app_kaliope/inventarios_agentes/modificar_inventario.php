<?php

/*Aqui recibimos el parametro del usuario enviado por get
 * y mostramos la vista con el inventario del usuario
 */

$propietario = $_GET['propietario'];

//llamamos a la vista y en ella proyectamos el nombre del propietario


require 'modificar_inventario.view.php';

