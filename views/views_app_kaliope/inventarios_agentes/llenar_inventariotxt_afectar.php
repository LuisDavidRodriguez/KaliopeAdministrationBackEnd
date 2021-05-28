<?php

/* 
 * en este archivo recibimos el formulario que enviamos de la vista llenar_inventariotxt.view.php
 * que contendra el propietario del inventario en el que se haran los cambios 
 * y la cadena de texto con todos los codigos y las existencias que se van a sumar al inventario
 */

include_once '../../../app_kaliope/base_de_datos_Class.php';

$dataBase  = new base_de_datos_Class();


if($_SERVER['REQUEST_METHOD'] == 'POST'){   
    
    $datos = $_POST;
    //print_r($datos);

/*
    Array
        (
        [propietario] => David
        [cadena] => 29,3
                    399,4
                    459,5
                    399,5
        [enviar] => Enviar Datos
        )
 */    
    array_pop($datos);//le quitamos la ultima posicion del array que es lo del boton
    //print_r($datos);    
    
    /*
            Array
        (
        [propietario] => David
        [cadena] => 29,3
                    399,4
                    459,5
                    399,5
        
        )
     */
    
    $propietario = $datos['propietario'];
    $cadena = $datos['cadena'];
    
    
    //comprobamos que la cadena contenga datos
    if(empty($cadena)){
        echo 'La cadena esta vacia por favor ingrese un dato';
        die;
    }else{
        
        //si contiene datos analizamos cada uno de de los indices para
        //que la longitud sea de 2 caracteres y reportar el error antes
        //que se afecte el inventario
        $renglon= explode(PHP_EOL, $cadena);//metemos en el array renglones en cada indice un producto
        //print_r($renglon);
        /*
         * Array
            (
                [0] => 29,3
                [1] => 399,4
                [2] => 459,5
                [3] => 399,5
            )
         */
        
        $movimientoCompleto = array();//este array contendra los datos una ves revizados, y un array asociativo en cada indice
        
        //ahora por cada indice del array renglones lo partimos en la coma        
        foreach ($renglon as $value) {
            $movimiento = explode(',', $value);
            //print_r($movimiento);
            /*el array movimientos ahora contiene esto
             * Array
                (
                    [0] => 29
                    [1] => 3
                )                
             */         
            
            
            //hacemos la revicion que solo tenga la longitud de 2
            //por cada bucle for, si algun renglon tiene error rompemos el bucle for
            if(sizeof($movimiento)!=2){
                echo "Error son diferente de 2 las columnas en el renglon $value revice datos para poder continuar";
                //throw new Exception("Error son diferente de 2 las columnas en el renglon $value revice datos para poder continuar");
                die;//Matamos el proceso
                
            }else{
                
                //si las columnas estan bien ahora verificamos que los datos sean numericos
                
                
                //ahora revizamos si los datos son numericos
                if(!is_numeric(trim($movimiento[0])) || !is_numeric(trim($movimiento[0]))){
                    //si hay algun dato no numerico 
                    echo "hay un dato no numerico en: $movimiento[0] o $movimiento[1] revice datos para poder continuar";
                    die;                    
                }else{
                    //si los datos son numericos ahora revizamos que el codigo exista en el inventario que se va a modificar
                   if(!$dataBase->inventarios_agentes_validarCodigoRetornaBoleano($propietario, $movimiento[0])){
                       echo "No existe el codigo: $movimiento[0] en el inventario del propietario: $propietario revice datos para poder continuar";
                       die;
                   }else{
                       //si existe el codigo en el inventario entonces creamos un nuevo array asociativo y insetamos este array en el array general con el que se modificara el inventario
                       $temporal = array("codigo"=>$movimiento[0],
                                    "cantidad"=>$movimiento[1]
                                );
                
                        //print_r($temporal);
                         /* temporal ahora contiene esto
                         * Array
                            (
                                [codigo] => 29
                                [cantidad] => 3
                            )
                         */
                        
                        array_push($movimientoCompleto, $temporal);
                        
                   }
                    
                }
                
            }
            
            
            
        }
        
        
             
        
        
        
    }
    
    
    //si en todas las validaciones de arriba no encontramos ningun error y matamos el proceso
        //entonces llegamos hasta este punto
        //print_r($movimientoCompleto);
        /*
                    * Array
           (
               [0] => Array
                   (
                       [codigo] => 29
                       [cantidad] => 3
                   )

               [1] => Array
                   (
                       [codigo] => 399
                       [cantidad] => 4
                   )

               [2] => Array
                   (
                       [codigo] => 459
                       [cantidad] => 5
                   )

               [3] => Array
                   (
                       [codigo] => 399
                       [cantidad] => 5
                   )

           )
         */
        
        //creamos el bucle for para recorrer el array movimientos completos y afectar el inventario
        foreach ($movimientoCompleto as $value) {
            /*
             * en cada value tenemos esto
             * [codigo] => 29
               [cantidad] => 3
             */
            
            $dataBase->inventarios_agentes_incrementaInventario($propietario, $value['codigo'], $value['cantidad']);
            
            
            
        }
        //cambiamos la version del inventario
            $dataBase->inventarios_agentes_actualizaVersion($propietario);
        
        

    
    
    
    
    

    
}

        //llamamos a la vista menu principal inventairo
        header('Location: MAIN_mostrar_inventarios.php');

