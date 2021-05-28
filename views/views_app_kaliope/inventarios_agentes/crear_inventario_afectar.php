<?php

/* Este es el archivo que primero corroborara que el usuario no tenga ya otro inventario asignado
 * si tiene otro inventario avisamos al administrador
 * si no tiene otro inventario creamos el inventario con el usuario seleccionado en la casilla 
 * de la vista
 */

include_once '../../../app_kaliope/base_de_datos_Class.php';

$dataBase  = new base_de_datos_Class();


if($_SERVER['REQUEST_METHOD'] == 'POST'){   
    
    $datos = $_POST;
    //print_r($datos);

/*
        Array
     (
         [usuario] => Jovas
         [continuar] => Continuar
     )
 */    
    array_pop($datos);//le quitamos la ultima posicion del array que es lo del boton
    //print_r($datos);    
    
    /*
            * Array
        (
            [usuario] => Jovas
        )
     */
    
    $propietario = $datos['usuario'];
    
    
        
    //ahora buscamos entre los inventarios si con el nombre de usuario ya retorna productos
    
    if(!empty($dataBase->inventarios_agentes_consultarInventarioArray($propietario))){
        //si el array retona con datos entonces enviamos el aviso al usuario
        echo "<h2>No podemos crear el nuevo inventario para el usuarios:  $propietario </h2> <br><br>";
        echo "<h2> porque este usuario ya tiene un inventario asignado </h2><br><br>";
        
        //añadimos el boton para volver
        echo "<a href=crear_inventario_mostrar.php><-Volver al menu anterior</a>";  

    }else{
        //si no se retornan datos de inventario con el usuario entonces creamos el nuevo inventario
        //echo "<h3>Se ha creado un inventario nuevo para el usuario: $propietario exitosamente</h3>";
        $dataBase->inventarios_agentes_insertaNuevoInventario($propietario);
        
        header('Location: MAIN_mostrar_inventarios.php'); //redireccionamos al menu de inventarios donde ya debe de estar el nuevo inventario
    }
    
    
    

    
}
