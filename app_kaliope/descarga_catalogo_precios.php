<?php

    //recibimos la version del catalogo que tiene el dispositivo, si el dispositivo no tiene version
    //cargada en su base de datos envia -1.

    $versionDelCatalogoRecibida = $_REQUEST["version"];
    //$versionDelCatalogoRecibida = -1;// 110858;

    




    //Creamos la conexion a la base de datos
    try {
        $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
    } catch(PDOException $e){
        echo "Error" . $e->getMessage();
    }


    
    /*Para llenar la base de datos por primera vez creamos un array con los precios
        $precios  =array(
            29,29,22,21,21,39,39,30,29,28,49,49,38,36,35,59,59,45,44,42,69,69,53,51,49,79,79,61,59,56,89,89,68,66,64,99,99,76,73,71,109,109,84,81,78,119,119,92,88,85,129,129,99,96,92,139,139,107,103,99,149,149,115,110,106,159,159,122,118,114,169,169,130,125,121,179,179,138,133,128,189,189,145,140,135,199,199,159,153,147,209,209,174,171,167,219,219,182,180,175,229,229,191,188,183,239,239,199,196,191,249,249,207,204,199,259,259,216,212,207,269,269,224,220,215,279,279,233,229,223,289,289,241,237,231,299,299,249,245,239,309,309,257,253,247,319,319,266,261,255,329,329,274,270,263,339,339,283,278,271,349,349,291,286,279,359,359,299,294,287,369,369,308,302,295,379,379,316,311,303,389,389,324,319,311,399,399,333,327,319,409,409,347,341,335,419,419,355,349,343,429,429,364,358,352,439,439,372,366,360,449,449,381,374,368,459,459,389,383,376,469,469,397,391,384,479,479,406,399,393,489,489,414,408,401,499,499,423,416,409,509,509,431,424,417,519,519,440,433,425,529,529,448,441,434,539,539,457,449,442,549,549,465,458,450,559,559,474,466,458,569,569,482,474,466,579,579,491,483,475,589,589,499,491,483,599,599,508,499,491,609,609,516,508,499,619,619,525,516,507,629,629,533,524,516,639,639,542,533,524,649,649,550,541,532,659,659,558,549,540,669,669,567,558,548,679,679,575,566,557,689,689,584,574,565,699,699,592,583,573,60,60,60,60,60        
        );
        


        
        //para insertar los precios desde el array que esta arriba
        for ($iterador = 0; $iterador <= count($precios) ; $iterador++){

            $codigo = $precios[$iterador];
            $precio = $precios[$iterador +=1];
            $vendedora = $precios [$iterador += 1];
            $socia = $precios [$iterador += 1];
            $empresaria = $precios [$iterador += 1];             
            $nombre = '';

            
                $statement = $conexion->prepare(
                    "INSERT INTO catalogo_precios (codigo, precio, vendedora, socia, empresaria, nombre) VALUES ('$codigo', '$precio','$vendedora', '$socia', '$empresaria','$nombre')"        
                );
                $statement->execute();


                echo 'se agrego exitosamente 1';
            
            
        }
    
    */


    

    
    
    /*creamos una consulta donde sumaremos los campos de codigo, precio, vendedora, socia y empresaria de cada uno de los precios
        devueltos en la base de datos, de esta manera cuando haya algun cambio de algun precio
        en la base de datos, la suma de todos los precios sera diferente, esta suma
        la guardara el dispositivo en el campo versionDelCatalogoRecibida, y si por ejemplo el dispositivo envia una version 28973
        pero en la base de datos alguien cambio el precio de algun producto en cualquier campo, ya sea codigo, precio, vendedora, empresarioa o socia
        la suma de esta base de datos sera diferente por ejemplo 28300 y al ser diferentes el sistema sabra que tiene que actualizar la base de datos de precios en 
        los telefonos.   
    */ 
 
    $versiones = $conexion->prepare(
        "SELECT * FROM catalogo_precios"        
    );
    
    


    //calculamos la version de la tabla sumando todos los campos
    $versiones->execute();
    $sumaDeVersiones = $versiones->fetchAll();
    $sumaDeCodigos = 0;
    foreach ($sumaDeVersiones as $elemento){        
        $sumaDeCodigos += $elemento[1] + $elemento[2] + $elemento[3] + $elemento [4] + $elemento [5];
    }
    //echo $sumaDeCodigos;



    if($versionDelCatalogoRecibida == -1 || $versionDelCatalogoRecibida != $sumaDeCodigos){
        //ahora devolvemos todos los productos en un array de JSON si no hay catalogo en el movil,
        //o si la version del catalogo en el movil es diferente a la del sistema
        $versiones->execute();
        $productos = $versiones->fetchAll();
        //print_r($productos);
        echo json_encode($productos);
        /*
            esto devuelve algo como esto:
            [{"id":"421","0":"421","codigo":"29","1":"29","precio":"29","2":"29","vendedora":"22","3":"22","socia":"21","4":"21","empresaria":"21","5":"21","version":"122","6":"122","nombre":"","7":""},{"id":"422","0":"422","codigo":"39","1":"39","precio":"39","2":"39","vendedora":"30","3":"30","socia":"29","4":"29","empresaria":"28","5":"28","version":"165","6":"165","nombre":"","7":""}]
            a lo que se le llama un JSON array, porque es un array de JSON, en cada indice de ese array hay un objeto JSON, un objeto JSON solito seria algo como esto
            {"id":"0" ,"codigo":"0", "precio":"0", "vendedora" : "0", "socia": "0", "empresaria" :"0", "version":"0", "nombre":"JsonObjet"};
        */        

    }else{
        /*
            si no son diferentes devolvemos un Json de una sola dimension con los parametros de exito, la diferencia es que ya se envia al movil un JSONObjet
            y en la parte de arriba se envia un JSONArray, entonces al manejar en la app de kaliope en onSucces se deben sobre escribir dos metodos
            el primero que es el que recibe un JSONArray que es el que manejara la respuesta con el catalogo de precios
            y el segundo que recibe el JSONObject. Entiendo que un JSONObject es exactamente lo de abajo
        
        
            //echo '{"id":"0" ,"codigo":"0", "precio":"0", "vendedora" : "0", "socia": "0", "empresaria" :"0", "version":"0", "nombre":"la base de datos es igual no hay nada que actualizar"}';
        

        
            debido a que ahora se manejara la respuesta en diferentes onSucces, no es necesario que al JSON objet que hacemos manualemte
            tenga exactamente los mismos campos que el que se genera con el json_enconde, porque antes como crei que se manejaban en el mismo onSucces
            para que la app recibiera correctamente los cambpos los identificadores del array debian de ser iguales.
            dejo el echo de arriba como ejemplo de como creia que se hacia y hago un nuevo echo abajo con solo la respuesta que me interesa

            En donde se manejan estas respuestas es en la app de kaliope concretamente en la actividad CatalogoPreciosActivity.java
            en el metodo downloadPricesCatalog();
        */
        echo '{"respuestaPersonalizadaDelServidor":"La tabla precios es igual no hay nada que actualizar"}';

        /*
            y por un JSONArray un array de JSON que es lo de abajo!!        
            '[{"id":"0" ,"codigo":"0", "precio":"0", "vendedora" : "0", "socia": "0", "empresaria" :"0", "version":"0", "nombre":"indice bidimencional 1"},
            {"id":"0" ,"codigo":"0", "precio":"0", "vendedora" : "0", "socia": "0", "empresaria" :"0", "version":"0", "indice bidimencional 2"}]'
            
                entonces en la app cuando se invoca al metodo getJSONObjet te solicita un indice, entonces te devuelve el JSON que esta guardado en ese indice
        */
    }



    /* por ejemplo en el archivo ingresar_datos_dispositivos.php
    hice una funcion para crear un array personalizado y despues pasarle este array al json_encode y que quedara igual que el que se genera en automatico
    con lo que aprendi hoy eso no era necesario entonces, detodas maneras dejo lo de ingresar_datos_dispositivos exactamente igual
    como ejemplo :3
    */
        





    


   
    
    
  


?>