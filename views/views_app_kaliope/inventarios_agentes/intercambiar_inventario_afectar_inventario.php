<?php
include_once '../../../app_kaliope/base_de_datos_Class.php';

/*
 * Cuando den en acptar intercambiar inventario
 * vamos a evalual si los nombres de los usuarios son diferentes
 * despues 
 * el invetario del propietario 1 lo renombraremos con un nombre especifico intercambiopppp5945
 * para que sea dificil de ingresar por error como nombre de usuario en algun otro inventairo
 * entonces renombraremos el inventario del propietario 2 por el del propietario1
 * 
 * y al final cambiamos el inventario con el nombre de intercambiopppp5945
 * al nombre del propietario2
 * 
 * y no nos olvidemos de actualizar las versiones en ambos inventarios
 * 
 *  */

$dataBase = new base_de_datos_Class();



if($_SERVER['REQUEST_METHOD'] == 'POST'){   
    
    $datos = $_POST;
    //print_r($datos);

/*
    * Array
   (
       [propietario1] => David
       [propietario2] => David
       [continuar] => Continuar
   )
 */    
    array_pop($datos);//le quitamos la ultima posicion del array que es lo del boton
    //print_r($datos);    
    
    /*
    * Array
       (
           [propietario1] => David
           [propietario2] => David
       )
     */
    
    
    $propietario1 = $datos['propietario1'];
    $propietario2 = $datos['propietario2'];
    
    
    
    
    
    /*
         * Necesitamos Tambien aparte de intercambiar el nombre, intercambiar la version del inventario
         * Debido al siguiente problema,
         * Supongamos que realizamos un intercambio de inventarios, el inventario de ramiro tiene la version 11 y tambien su mobil.
         * El inventario de juan tiene la version 10 en servidor y tambien en el movil entonces:
         * Ramiro V.S:11 V.M:11  Juan V.S:10 V.M:10
         * 
         * Queremos intercambiar los inventarios. Cuando se llama a la funcion intercambiar Inventario primero se cambian los nombres,y al finalizar suma las versiones + 1
         * Es decir el inventario de juan ahora sera el de ramiro quedando asi Juan V.S:11+1=12 en este momento el mobil reconoce los cambios de version porque V.M:10 != V.M:12
         * Pero el problema viene con el de ramiro que ahora tiene el inventario de juan quedando asi:
         * Ramiro V.S:10+1=11 V.M:11
         * En este momento el inventario de ramiro no se cargara en el movil porque el movil tiene la version 11 y la nueva version apesar que cambio de 10 a 11 
         * 
         * entonces aunque ya se haya realizado el intercambio en el sistema
         * la app kaliope no lo cargara y mucho peor cuando envie su inventario el servidor sustituira el inventario que intercambiamos
         * con el del mobil que ya es antiuguo porque las versiones son iguales!!!!
         * 
         * xD espero que pudiera explicar el problema
     * intercambiando tambien la version nos aseguramos que esto no ocurra
     * 
         */
    
    
          
    if($propietario1!=$propietario2){
        
        
        /*
         * intercambiamos primero las versiones de los agentes, la version del propietario 2 se la ponemos al pripietario 1
         * y la del propietario 1 al propietario 2
         */
        $versionPropietario1 = $dataBase->inventarios_agentes_consultaVersionInventario($propietario1);
        $versionPropietario2 = $dataBase->inventarios_agentes_consultaVersionInventario($propietario2);        
        $dataBase->inventarios_agentes_cambiarVersionVersionInicial($propietario1, $versionPropietario2);
        $dataBase->inventarios_agentes_cambiarVersionVersionInicial($propietario2, $versionPropietario1);
        
        
        
        
        //intercambiamos el nombre del propietario 1
        $dataBase->inventarios_agentes_cambiarNombreInventario($propietario1, 'intercambiopppp5945');
        //intercambiamos el nombre del inventario del propietario 2 por el de propietario1
        $dataBase->inventarios_agentes_cambiarNombreInventario($propietario2, $propietario1);
        //por ultimo renombramos el inventario intercambiopppp5945 al propietario2
        $dataBase->inventarios_agentes_cambiarNombreInventario('intercambiopppp5945', $propietario2);
        
        
        //actualizamos las versiones de los inventarios para que la app de kaliope carge el nuevo inventario cuando se sincronize
        $dataBase->inventarios_agentes_actualizaVersion($propietario1);
        $dataBase->inventarios_agentes_actualizaVersion($propietario2);
        
        header('Location: MAIN_mostrar_inventarios.php');
        
        
    }else{
        echo "<h2>No podemos hacer el intercambio porque los propietarios son los mismos</h2>";
    }
        
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}