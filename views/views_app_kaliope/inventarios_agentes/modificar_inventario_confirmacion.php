<?php

include_once '../../../app_kaliope/base_de_datos_Class.php';

/* 
 * Este archivo se llama cuando un administrador necesita hacer cambios en el inventario
 * de algun agente, para esto nos va a llegar un array del formulario modificar_inventario
 * con los valores que el usuario ingreso
 * deberemos validar que los datos ingresados sean numericos
 * despues que sean mayores que 0
 * y que exista el codigo en el inventario en el cual se va a modificar
 * 
 * despues que se valide todo esto le mostrara al usuario un resumen de los movimientos que se haran
 * 
 * y debera presionar un boton para que se realice la modificacion del inventario eso se tratara en otro archivo
 * 
 */

$database = new base_de_datos_Class();



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    
    $datos = $_POST;

    //print_r($datos);
    
     /*Array este es el array que recibimos
(
    [nombre] => Jovas
    [administrador] =>
    [motivoMovimiento] =>      
    [codigo1] => 
    [cantidad1] => 
    [codigo2] => 
    [cantidad2] => 
    [codigo3] => 
    [cantidad3] => 
    [codigo4] => 
    [cantidad4] => 
    [codigo5] => 
    [cantidad5] => 
    [codigo6] => 
    [cantidad6] => 
    [codigo7] => 
    [cantidad7] => 
    [codigo8] => 
    [cantidad8] => 
    [codigo9] => 
    [cantidad9] => 
    [codigo10] => 
    [cantidad10] => 
    [codigo11] => 
    [cantidad11] => 
    [codigo1s] => 
    [cantidad1s] => 
    [codigo2s] => 
    [cantidad2s] => 
    [codigo3s] => 
    [cantidad3s] => 
    [codigo4s] => 
    [cantidad4s] => 
    [codigo5s] => 
    [cantidad5s] => 
    [codigo6s] => 
    [cantidad6s] => 
    [codigo7s] => 
    [cantidad7s] => 
    [codigo8s] => 
    [cantidad8s] => 
    [codigo9s] => 
    [cantidad9s] => 
    [codigo10s] => 
    [cantidad10s] => 
    [codigo11s] => 
    [cantidad11s] => 
    [continuar] => Continuar
)
     * 
     * 
     * 
     */
    
    
    $propietario = array_shift($datos);//sacamos el primer elemento del array, y lo eliminamos del array original, desplazando todos los indices a la izq  
    $administrador = array_shift($datos);
    $motivoMovimiento = array_shift($datos);
    
    array_pop($datos);//quitamos el ultimo elento de array que es la info del boton
    //print_r($datos);
    
    /*este es el array despues
     * Array
(
    [codigo1] => 139
    [cantidad1] => 5
    [codigo] => 
    [cantidad] => 
    [codigo3] => 
    [cantidad3] => 
    [codigo4] => 
    [cantidad4] => 
    [codigo5] => 
    [cantidad5] => 
    [codigo6] => 
    [cantidad6] => 
    [codigo7] => 
    [cantidad7] => 
    [codigo8] => 
    [cantidad8] => 
    [codigo9] => 
    [cantidad9] => 
    [codigo10] => 
    [cantidad10] => 
    [codigo11] => 
    [cantidad11] => 
    [codigo1s] => 
    [cantidad1s] => 
    [codigo2s] => 
    [cantidad2s] => 
    [codigo3s] => 
    [cantidad3s] => 
    [codigo4s] => 
    [cantidad4s] => 
    [codigo5s] => 
    [cantidad5s] => 
    [codigo6s] => 
    [cantidad6s] => 
    [codigo7s] => 
    [cantidad7s] => 
    [codigo8s] => 
    [cantidad8s] => 
    [codigo9s] => 
    [cantidad9s] => 
    [codigo10s] => 
    [cantidad10s] => 
    [codigo11s] => 
    [cantidad11s] => 
)

     */
    
    //ahora vamos a agrupar el array de 2 en 2 es decir codigo y cantidad
    
    $agrupados = array_chunk($datos, 2);
    
    //print_r($agrupados);
    
    /*obtenemos esto del indice 0 al 10 son las 11 entradas y del indice 11 al 21 son las 11 salidas
     * Array
(
    [0] => Array
        (
            [0] => 139
            [1] => 5
        )

    [1] => Array
        (
            [0] => 
            [1] => 
        )

    [2] => Array
        (
            [0] => 
            [1] => 
        )

    [3] => Array
        (
            [0] => 
            [1] => 
        )

    [4] => Array
        (
            [0] => 
            [1] => 
        )

    [5] => Array
        (
            [0] => 
            [1] => 
        )

    [6] => Array
        (
            [0] => 
            [1] => 
        )

    [7] => Array
        (
            [0] => 
            [1] => 
        )

    [8] => Array
        (
            [0] => 
            [1] => 
        )

    [9] => Array
        (
            [0] => 
            [1] => 
        )

    [10] => Array
        (
            [0] => 
            [1] => 
        )

    [11] => Array
        (
            [0] => 
            [1] => 
        )

    [12] => Array
        (
            [0] => 
            [1] => 
        )

    [13] => Array
        (
            [0] => 
            [1] => 
        )

    [14] => Array
        (
            [0] => 
            [1] => 
        )

    [15] => Array
        (
            [0] => 
            [1] => 
        )

    [16] => Array
        (
            [0] => 
            [1] => 
        )

    [17] => Array
        (
            [0] => 
            [1] => 
        )

    [18] => Array
        (
            [0] => 
            [1] => 
        )

    [19] => Array
        (
            [0] => 
            [1] => 
        )

    [20] => Array
        (
            [0] => 
            [1] => 
        )

    [21] => Array
        (
            [0] => 
            [1] => 
        )

)

     */
    
    
    
    
    
    $piezasTotalesEntradas = 0;  
    $piezasTotalesSalidas = 0;  
   
    
    try {
        
        
        //validamos que el motivo del movimiento y el administrador tengan datos
        if(empty($motivoMovimiento)||empty($administrador)){
            throw new Exception("<h3>Debe de agregar datos del administrador que realizo la modificacion y el motivo del movimiento</h3>");
        }
        


        //validar que cada uno de los codigos sea numerico y diferente de 0 y lo guardamos en un nuevo array
        $arrayEntradas = array();
        $arraySalidas = array();

        $contador = 0; //para saber cuando llegamos al 10 y apartir de ahi son salidas
        foreach ($agrupados as $valores) {

            //ahora recorremos el codigo y la cantidad, si los campos estan vacios no hacemos nada vamos al siguiente bucle
            if (!empty($valores[0]) && !empty($valores[1])) {
                //si los campos de codigo y cantidad no estan vacios entonces evaluamos que sean datos numericos
                if (is_numeric($valores[0]) && is_numeric($valores[1])) {
                    //si son numericos verificamos que sean mayores a 0
                    
                    
                    
                    if($valores[0] > 0 && $valores[1] > 0){
                        
                        
                        
                        //una ves validados los datos ingresados llamamos a la funcion de 
                        //validar los codigos, los codigos ingresados deben de existir en el inventario
                        //del agente, si no este metodo retorna una excepcion
                        $database->inventarios_agentes_validarCodigoRetornaExcepcion($propietario, $valores[0]);
                        
                        
                        //si el metodo de arriba no retorna una excepcion es decir que si encontro el codigo llenamos nuestros arrays
                        // en que array lo vamos a guardar
                        //si el contador es menor a 24 entran en el array de entradas
                        //siu es mayor a 24 entra en el array de salidas
                        $temporal = array(
                            "codigo" => $valores[0],
                            "cantidad" => $valores[1]
                        );
                        

                        if ($contador <= 24) {
                            array_push($arrayEntradas, $temporal);
                            $piezasTotalesEntradas += $valores[1];
                        } else {
                            array_push($arraySalidas, $temporal);
                            $piezasTotalesSalidas += $valores[1];
                        }                      
                        
                        
                        
                        
                    }else{
                         throw new Exception("<h3> Los datos deben ser mayores a 0 error en:  $valores[0] y $valores[1] </h3>");
                    }
                    
                    
                    
                    
                } else {
                    //si los datos no son numericos lanzamos una excepcion
                    throw new Exception("<h3> Hay datos invalidos en:  $valores[0] y $valores[1] </h3>");
                }
            }

            $contador++;
        }
        
        
        //print_r($arrayEntradas);
        //print_r($arraySalidas);
        
        
        //llamamos a la vista de confirmacion        
        
        require 'modificar_inventario_confirmacion.view.php';
        
        
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}









