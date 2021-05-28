<?php

/* 
 * En este archivo recibimos el array del formulario cuando el usuario preciono el boton de continuar
 * lo que haremos aqui sera recibir ese array que viene asociativo con todos los nombres de campos y pasarlo a un array bidimencional partiendolo en 2
 * donde en cada indice vendra un renglon con su codigo y su producto, despues validaremos que los datos 
 * sean numericos y que los codigos existan en el inventario, y por ultimo consultaremos el inventario del propietario
 * codigo a codigo obteniendo las existencias, y si lo capturado en el array, concuerda, si no concuerda en alguna pieza
 * imprimiremos un mensaje con las piezas que deberia tener, y las fisicas, y cuantas le faltan o le sobran, junto con su importe calculado en empresaria ya sea negativo o positivo
 * imprimiremos las piezas totales reportadas, las faltantes o sobrantes 
 * 
 * y añadiremos un boton hasta abajo el cual al precionarlo, realizara el balance pertinente en el inventario del sistema
 * para que la mercancia fisica concuerde con el registro del inventario.
 * 
 * para esto pensar, hay dos formas la primera es reiniciar completamente el inventario a 0 e insertar lo fisico al inventario
 * o el calculo de las diferencias actualizar el inventario por ejemplo si en 139 falto 1 pz, entonces que esa pieza se saque del inventario
 * 
 * Una vez hecha la modificacion hay que actualizar la version del inventario
 */
include_once '../../../../app_kaliope/base_de_datos_Class.php';
include_once '../../../../app_kaliope/utilitarios_Class.php';
$database = new base_de_datos_Class();





    
    $datos = $_POST;
    //print_r($datos);
    /*
     * Array
(
    [propietario] => David
    [motivoMovimiento] => fkaihdflkasrlfkds
    [codigo1] => 139
    [cantidad1] => 1
    [codigo2] => 149
    [cantidad2] => 5
    [codigo3] => 159
    [cantidad3] => 6
    [codigo4] => 189
    [cantidad4] => 4
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
    [codigo12] => 
    [cantidad12] => 
    [codigo13] => 
    [cantidad13] => 
    [codigo14] => 
    [cantidad14] => 
    [codigo15] => 
    [cantidad15] => 
    [codigo16] => 
    [cantidad16] => 
    [codigo17] => 
    [cantidad17] => 
    [codigo18] => 
    [cantidad18] => 
    [codigo19] => 
    [cantidad19] => 
    [codigo20] => 
    [cantidad20] => 
    [codigo21] => 
    [cantidad21] => 
    [codigo22] => 
    [cantidad22] => 
    [codigo23] => 
    [cantidad23] => 
    [codigo24] => 
    [cantidad24] => 
    [codigo25] => 
    [cantidad25] => 
    [codigo26] => 
    [cantidad26] => 
    [codigo27] => 
    [cantidad27] => 
    [codigo28] => 
    [cantidad28] => 
    [codigo29] => 
    [cantidad29] => 
    [codigo30] => 
    [cantidad30] => 
    [codigo31] => 
    [cantidad31] => 
    [codigo32] => 
    [cantidad32] => 
    [codigo33] => 
    [cantidad33] => 
    [codigo34] => 
    [cantidad34] => 
    [codigo35] => 
    [cantidad35] => 
    [codigo36] => 
    [cantidad36] => 
    [codigo37] => 
    [cantidad37] => 
    [codigo38] => 
    [cantidad38] => 
    [codigo39] => 
    [cantidad39] => 
    [codigo40] => 
    [cantidad40] => 
    [codigo41] => 
    [cantidad41] => 
    [codigo42] => 
    [cantidad42] => 
    [codigo43] => 
    [cantidad43] => 
    [codigo44] => 
    [cantidad44] => 
    [codigo45] => 
    [cantidad45] => 
    [codigo46] => 
    [cantidad46] => 
    [codigo47] => 
    [cantidad47] => 
    [codigo48] => 
    [cantidad48] => 
    [codigo49] => 
    [cantidad49] => 
    [codigo50] => 
    [cantidad50] => 
    [enviar] => Enviar Datos
)
     */
 
    //quitamos el ultimo indice del boton y el primer indice del propietario
    array_pop($datos);//le quitamos la ultima posicion del array que es lo del boton
    $propietario = array_shift($datos);
    $notas = array_shift($datos);
    //print_r($datos);   
    /*
     * Array
(
    [codigo1] => 139
    [cantidad1] => 1
    [codigo2] => 149
    [cantidad2] => 5
    [codigo3] => 159
    [cantidad3] => 6
    [codigo4] => 189
    [cantidad4] => 4
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
    [codigo12] => 
    [cantidad12] => 
    [codigo13] => 
    [cantidad13] => 
    [codigo14] => 
    [cantidad14] => 
    [codigo15] => 
    [cantidad15] => 
    [codigo16] => 
    [cantidad16] => 
    [codigo17] => 
    [cantidad17] => 
    [codigo18] => 
    [cantidad18] => 
    [codigo19] => 
    [cantidad19] => 
    [codigo20] => 
    [cantidad20] => 
    [codigo21] => 
    [cantidad21] => 
    [codigo22] => 
    [cantidad22] => 
    [codigo23] => 
    [cantidad23] => 
    [codigo24] => 
    [cantidad24] => 
    [codigo25] => 
    [cantidad25] => 
    [codigo26] => 
    [cantidad26] => 
    [codigo27] => 
    [cantidad27] => 
    [codigo28] => 
    [cantidad28] => 
    [codigo29] => 
    [cantidad29] => 
    [codigo30] => 
    [cantidad30] => 
    [codigo31] => 
    [cantidad31] => 
    [codigo32] => 
    [cantidad32] => 
    [codigo33] => 
    [cantidad33] => 
    [codigo34] => 
    [cantidad34] => 
    [codigo35] => 
    [cantidad35] => 
    [codigo36] => 
    [cantidad36] => 
    [codigo37] => 
    [cantidad37] => 
    [codigo38] => 
    [cantidad38] => 
    [codigo39] => 
    [cantidad39] => 
    [codigo40] => 
    [cantidad40] => 
    [codigo41] => 
    [cantidad41] => 
    [codigo42] => 
    [cantidad42] => 
    [codigo43] => 
    [cantidad43] => 
    [codigo44] => 
    [cantidad44] => 
    [codigo45] => 
    [cantidad45] => 
    [codigo46] => 
    [cantidad46] => 
    [codigo47] => 
    [cantidad47] => 
    [codigo48] => 
    [cantidad48] => 
    [codigo49] => 
    [cantidad49] => 
    [codigo50] => 
    [cantidad50] => 
)
     */ 
    
    
    //convertimos el array asociativo en uno numerico
    /*
     *como vemos el array viene con claves, lo cual nos evita poder recorrerlo con bucles for
     *la funcion de array_chuick que es la misma que usamos para cortar el array por ejemplo en pares
     *notamos que nos lo devuelve en un array numerico, por lo tanto lo usarmos pero en el valor de cortar le pasamos la longitud total del array
     * 
     */
    $arrayNumerico= array_chunk($datos, sizeof($datos));
    //print_r($arrayNumerico);
    /*
     * Array
(
    [0] => Array
        (
            [0] => 139
            [1] => 1
            [2] => 149
            [3] => 5
            [4] => 159
            [5] => 6
            [6] => 189
            [7] => 4
            [8] => 
            [9] => 
            [10] => 
            [11] => 
            [12] => 
            [13] => 
            [14] => 
            [15] => 
            [16] => 
            [17] => 
            [18] => 
            [19] => 
            [20] => 
            [21] => 
            [22] => 
            [23] => 
            [24] => 
            [25] => 
            [26] => 
            [27] => 
            [28] => 
            [29] => 
            [30] => 
            [31] => 
            [32] => 
            [33] => 
            [34] => 
            [35] => 
            [36] => 
            [37] => 
            [38] => 
            [39] => 
            [40] => 
            [41] => 
            [42] => 
            [43] => 
            [44] => 
            [45] => 
            [46] => 
            [47] => 
            [48] => 
            [49] => 
            [50] => 
            [51] => 
            [52] => 
            [53] => 
            [54] => 
            [55] => 
            [56] => 
            [57] => 
            [58] => 
            [59] => 
            [60] => 
            [61] => 
            [62] => 
            [63] => 
            [64] => 
            [65] => 
            [66] => 
            [67] => 
            [68] => 
            [69] => 
            [70] => 
            [71] => 
            [72] => 
            [73] => 
            [74] => 
            [75] => 
            [76] => 
            [77] => 
            [78] => 
            [79] => 
            [80] => 
            [81] => 
            [82] => 
            [83] => 
            [84] => 
            [85] => 
            [86] => 
            [87] => 
            [88] => 
            [89] => 
            [90] => 
            [91] => 
            [92] => 
            [93] => 
            [94] => 
            [95] => 
            [96] => 
            [97] => 
            [98] => 
            [99] => 
        )

)
     */
    
    //sacamos el indice del array porque se creo uno bidimencional
    $arrayNumerico = $arrayNumerico[0];
    //print_r($arrayNumerico);
    
    /*
     * Array
(
    [0] => 139
    [1] => 1
    [2] => 149
    [3] => 5
    [4] => 159
    [5] => 6
    [6] => 189
    [7] => 4
    [8] => 
    [9] => 
    [10] => 
    [11] => 
    [12] => 
    [13] => 
    [14] => 
    [15] => 
    [16] => 
    [17] => 
    [18] => 
    [19] => 
    [20] => 
    [21] => 
    [22] => 
    [23] => 
    [24] => 
    [25] => 
    [26] => 
    [27] => 
    [28] => 
    [29] => 
    [30] => 
    [31] => 
    [32] => 
    [33] => 
    [34] => 
    [35] => 
    [36] => 
    [37] => 
    [38] => 
    [39] => 
    [40] => 
    [41] => 
    [42] => 
    [43] => 
    [44] => 
    [45] => 
    [46] => 
    [47] => 
    [48] => 
    [49] => 
    [50] => 
    [51] => 
    [52] => 
    [53] => 
    [54] => 
    [55] => 
    [56] => 
    [57] => 
    [58] => 
    [59] => 
    [60] => 
    [61] => 
    [62] => 
    [63] => 
    [64] => 
    [65] => 
    [66] => 
    [67] => 
    [68] => 
    [69] => 
    [70] => 
    [71] => 
    [72] => 
    [73] => 
    [74] => 
    [75] => 
    [76] => 
    [77] => 
    [78] => 
    [79] => 
    [80] => 
    [81] => 
    [82] => 
    [83] => 
    [84] => 
    [85] => 
    [86] => 
    [87] => 
    [88] => 
    [89] => 
    [90] => 
    [91] => 
    [92] => 
    [93] => 
    [94] => 
    [95] => 
    [96] => 
    [97] => 
    [98] => 
    [99] => 
)
     * 
     */
    
    //Ahora si recorremos el array validando datos vacios
   /*
    * para esto recorreremos todo el array, seria muy facil solo usar array_filter para
    * eliminar en automatico los valores vacios, pero que pasa si el usuario por error
    * deja en blanco la casilla de cantidad, entonces esa tambien la borraria la funcion
    * y no habria manera de acomodar el array por pares porque ya no serian pares
    * 
    * para esto vamos a rrecorrer el array mirando una posicion adelante que es donde
    * deberia de estar la cantidad entonces en la posicion 0 estara el codigo, y en la posicion 1 la cantidad
    * si la posicion 0 tiene dato, pero la posicion 1 esta vacia detonaremos un error y mataremos el proceso
    * si ambas posiciones tienen dato entonces analizamos el siguiente dato
    * si ni la posicion 0 y la posicion 1 no tienen dato entonces es un renglon en blanco y continuaremos
    * a analizar el siguiente renglon porque es probable que pudieran dejar renglones intermedios en blanco
    * 
    * y llenamos un array nuevo asociativo con los movimientos oficiales que se vana  realizar
    *  
    */
    $arrayMovimientos = array();
    
    for ($index = 0; $index < count($arrayNumerico); $index+=2) {
        $codigo = $arrayNumerico[$index];
        $cantidad = $arrayNumerico[$index + 1];
        //echo "$codigo-$cantidad <br>";
        
        //ahora validamos que ambos esten con datos
        if(!empty($codigo)){
            
            
            //si el codigo no esta vacio entonces corroboramos la cantidad
            if(empty($cantidad)){
                //si la cantidad esta vacia avisamos del problema
                echo "<h3>Error! Hay una cantidad en blanco en la seccion codigo: $codigo </h3>";
                die;
            }
            
            
        }else{
            //si el codigo esta vacio comprobamos que la cantidad tambien este vacia 
            if(empty($cantidad)){
                //si la cantidad esta vacia saltamos al siguiente for por si el usuario dejo renglones intermedios en blanco
                continue;
            }else{
                //si la cantidad no esta vacia avizamos del error que falta un codigo
                echo "<h3>Error! Hay un codigo en blanco donde las piezas son: $cantidad </h3>";
                die;
            }
        }
        
        
        
        
        //si en ninguna instruccion de arriba mato el codigo entonces tanto codigo como cantidad existen ahora validamos que los datos sean numericos
        if(!is_numeric($codigo)||!is_numeric($cantidad)){
            //si alguno de los dos no es valor numerico entonces matamos el codigo
            echo "<h3>Error! Hay un dato no numerico en: $codigo, cantidad: $cantidad </h3>";
                die;
        }else{
            //si el dato si es numerico entonces validamos que el codigo exista en el inventario del propietario
            //y que la cantidad sea mayor a 0
            if($database->inventarios_agentes_validarCodigoRetornaBoleano($propietario, $codigo)){
                //si el codigo existe validamos que la pieza sea mayor a 0
                if($cantidad<0){
                    echo "<h3>Error! Hay una cantidad en negativo en: $cantidad  <br> en el codigo: $codigo</h3>";
                    die;
                }
            }else{
                echo "<h3>Error! El siguiente codigo no existe en el inventario del propietario: $codigo </h3>";
                die;
            }
        }
        
        
        //si nada de arriba mato el codigo, significa que el el codigo es numerico y ademas existe en el inventario del usuairo
        //y que la cantidad es numerica y que ademas es mayor a 0
        
        $temporal = array (
                "codigo"=>$codigo,
                "cantidad"=>$cantidad
        );
        
        
        //colocamos los valores organizados en un array
        array_push($arrayMovimientos, $temporal);
        
        
        
    }
    
    
 



//al finalizar las validaciones tendremos en el array arrayMovimientos lo siguiete
    //print_r($arrayMovimientos);    
    /*en el array final tendremos esto
     * (
    [0] => Array
        (
            [codigo] => 139
            [cantidad] => 11
        )

    [1] => Array
        (
            [codigo] => 149
            [cantidad] => 5
        )

    [2] => Array
        (
            [codigo] => 159
            [cantidad] => 6
        )

    [3] => Array
        (
            [codigo] => 189
            [cantidad] => 4
        )

)
     */
    
    
    
             
        
    
    
    
    
    
        /*
         * Ahora realizaremos la comparacion, para eso consultaremos todo el inventario del propietario tenga o no tenga existencias
         * vamos a recorrer producto a producto y lo iremos imprimiendo, al tiempo que recorremos por ejemplo el codigo 139 del inventario
         *entramos a otro bucle que recorre el array que tiene los valores que capturamos fisicamente, si encontramos el codigo 139 tambien en los movimientos capturados
         * entonces colocamos la cantidad en un array, por si hay otra de 139 en el siguiente bucle de lo capturado igual se sume al array y asi obtener el total de piezas aunque 
         * 2 codigos o mas vengan en diferente renglon.
         * echo " <font color=\"#555555\">Hola mundo</font>";  
         */
    
         $importeTotalDiferenciasVista=0;
         $totalPiezasDiferenciasVista=0;
         $totalPiezasFisicasCapturadasVista = 0;
         $arrayRenglonesParaVista = array();
         
    
        
        
        //ahora realizamos la comparacion vamos a consultar todos los codigos totales del inventario tenga o no existencias obtendremos un array bidimencional        
        $inventarioTotal = $database->inventarios_agentes_consultarInventarioArray($propietario);
        
        //recorremos uno a uno los productos que tiene el inventario del propietario
        foreach ($inventarioTotal as $productoEnInventario) {
            /*en cada productoEnInventario tenemos esto
             * (
            [id] => 73
            [0] => 73
            [propietario] => David
            [1] => David
            [codigo] => 59
            [2] => 59
            [existencia] => 0
            [3] => 0
            [precio] => 59
            [4] => 59
            [vendedora] => 45
            [5] => 45
            [socia] => 44
            [6] => 44
            [empresaria] => 42
            [7] => 42
            [version] => 10
            [8] => 10
        )
             */
            
            
           
            
            
            //cada que vallamos imprimiendo una linea de producto recuperado del inventario recorremos el arrayMovimientos lo que capturo fisiamente buscando que el codigo que estamos imprimiento aparesca ahi
            /*
             * si aparese ahi entonces al array existenciasMismoCodigo le metenos las piezas
             * debido a que esta la posibilidad de que haya en diferentes renglones el mismo codigo
             * entonces cuando vuelva a encontrar otro codigo igual en lo que se capturo
             * lo vuelve a meter, y al final solo tenemos que calcular la suma del array
             */
            $existenciasMismoCodigo = array();
            foreach ($arrayMovimientos as $value) {
                if($productoEnInventario['codigo']==$value['codigo']){
                    array_push($existenciasMismoCodigo,$value['cantidad']);                  
                    
                }
                
            }
            
            
            
            
            
            
            //ahora calculamos las diferencias restandole a lo fisico, lo que el sistema deberia tener y el importe de la diferencia 
            $comparacionDePiezas = array_sum($existenciasMismoCodigo) - $productoEnInventario['existencia'];          
            $importeDiferencia = $comparacionDePiezas*$productoEnInventario['empresaria'];            
            $totalPiezasDiferenciasVista+=$comparacionDePiezas;
            $importeTotalDiferenciasVista+=$importeDiferencia;
            $totalPiezasFisicasCapturadasVista += array_sum($existenciasMismoCodigo);
            
            
            
            //Creamos el renglon, decidiremos si guardar o no el renglon si las existencias del inventario o lo capturado fisicamente son diferentes de 0
            //esto para evitar imprimir todos los demas codigos que no tienne ni existencia y tampoco tienen piezas capturadas en fisico
            if($productoEnInventario['existencia']!=0 || array_sum($existenciasMismoCodigo)!=0){
               
                
                $temp = array(
                    "codigo"=> $productoEnInventario['codigo'],
                    "empresaria"=> $productoEnInventario['empresaria'],
                    "existencia"=> $productoEnInventario['existencia'],
                    "existenciaFisica"=> array_sum($existenciasMismoCodigo),
                    "diferenciaPiezas"=> $comparacionDePiezas,
                    "importeDiferencia"=> $importeDiferencia                   
                    
                );
                
                array_push($arrayRenglonesParaVista, $temp);                
            }
            

            
            
        }
        
        //print_r($arrayRenglonesParaVista);
        /*
         * Array
(
    [0] => Array
        (
            [codigo] => 139
            [empresaria] => 99
            [existencia] => 0
            [existenciaFisica] => 1
            [diferenciaPiezas] => 1
            [importeDiferencia] => 99
        )

    [1] => Array
        (
            [codigo] => 149
            [empresaria] => 106
            [existencia] => 1
            [existenciaFisica] => 5
            [diferenciaPiezas] => 4
            [importeDiferencia] => 424
        )

    [2] => Array
        (
            [codigo] => 159
            [empresaria] => 114
            [existencia] => 7
            [existenciaFisica] => 0
            [diferenciaPiezas] => -7
            [importeDiferencia] => -798
        )

    [3] => Array
        (
            [codigo] => 169
            [empresaria] => 121
            [existencia] => 0
            [existenciaFisica] => 20
            [diferenciaPiezas] => 20
            [importeDiferencia] => 2420
        )

    [4] => Array
        (
            [codigo] => 179
            [empresaria] => 128
            [existencia] => 1
            [existenciaFisica] => 0
            [diferenciaPiezas] => -1
            [importeDiferencia] => -128
        )

    [5] => Array
        (
            [codigo] => 189
            [empresaria] => 135
            [existencia] => 3
            [existenciaFisica] => 0
            [diferenciaPiezas] => -3
            [importeDiferencia] => -405
        )

    [6] => Array
        (
            [codigo] => 199
            [empresaria] => 147
            [existencia] => 2
            [existenciaFisica] => 5
            [diferenciaPiezas] => 3
            [importeDiferencia] => 441
        )

    [7] => Array
        (
            [codigo] => 209
            [empresaria] => 167
            [existencia] => 7
            [existenciaFisica] => 4
            [diferenciaPiezas] => -3
            [importeDiferencia] => -501
        )

    [8] => Array
        (
            [codigo] => 229
            [empresaria] => 183
            [existencia] => 2
            [existenciaFisica] => 3
            [diferenciaPiezas] => 1
            [importeDiferencia] => 183
        )

    [9] => Array
        (
            [codigo] => 239
            [empresaria] => 191
            [existencia] => 2
            [existenciaFisica] => 4
            [diferenciaPiezas] => 2
            [importeDiferencia] => 382
        )

    [10] => Array
        (
            [codigo] => 249
            [empresaria] => 199
            [existencia] => 0
            [existenciaFisica] => 5
            [diferenciaPiezas] => 5
            [importeDiferencia] => 995
        )

    [11] => Array
        (
            [codigo] => 259
            [empresaria] => 207
            [existencia] => 4
            [existenciaFisica] => 1
            [diferenciaPiezas] => -3
            [importeDiferencia] => -621
        )

    [12] => Array
        (
            [codigo] => 269
            [empresaria] => 215
            [existencia] => 0
            [existenciaFisica] => 20
            [diferenciaPiezas] => 20
            [importeDiferencia] => 4300
        )

    [13] => Array
        (
            [codigo] => 279
            [empresaria] => 223
            [existencia] => 34
            [existenciaFisica] => 5
            [diferenciaPiezas] => -29
            [importeDiferencia] => -6467
        )

    [14] => Array
        (
            [codigo] => 289
            [empresaria] => 231
            [existencia] => 0
            [existenciaFisica] => 4
            [diferenciaPiezas] => 4
            [importeDiferencia] => 924
        )

    [15] => Array
        (
            [codigo] => 299
            [empresaria] => 239
            [existencia] => 35
            [existenciaFisica] => 30
            [diferenciaPiezas] => -5
            [importeDiferencia] => -1195
        )

    [16] => Array
        (
            [codigo] => 309
            [empresaria] => 247
            [existencia] => 10
            [existenciaFisica] => 1
            [diferenciaPiezas] => -9
            [importeDiferencia] => -2223
        )

    [17] => Array
        (
            [codigo] => 319
            [empresaria] => 255
            [existencia] => 4
            [existenciaFisica] => 0
            [diferenciaPiezas] => -4
            [importeDiferencia] => -1020
        )

    [18] => Array
        (
            [codigo] => 329
            [empresaria] => 263
            [existencia] => 2
            [existenciaFisica] => 1
            [diferenciaPiezas] => -1
            [importeDiferencia] => -263
        )

    [19] => Array
        (
            [codigo] => 339
            [empresaria] => 271
            [existencia] => 18
            [existenciaFisica] => 0
            [diferenciaPiezas] => -18
            [importeDiferencia] => -4878
        )

    [20] => Array
        (
            [codigo] => 349
            [empresaria] => 279
            [existencia] => 4
            [existenciaFisica] => 0
            [diferenciaPiezas] => -4
            [importeDiferencia] => -1116
        )

    [21] => Array
        (
            [codigo] => 359
            [empresaria] => 287
            [existencia] => 20
            [existenciaFisica] => 0
            [diferenciaPiezas] => -20
            [importeDiferencia] => -5740
        )

    [22] => Array
        (
            [codigo] => 369
            [empresaria] => 295
            [existencia] => 2
            [existenciaFisica] => 2
            [diferenciaPiezas] => 0
            [importeDiferencia] => 0
        )

    [23] => Array
        (
            [codigo] => 379
            [empresaria] => 303
            [existencia] => 0
            [existenciaFisica] => 5
            [diferenciaPiezas] => 5
            [importeDiferencia] => 1515
        )

    [24] => Array
        (
            [codigo] => 389
            [empresaria] => 311
            [existencia] => 3
            [existenciaFisica] => 4
            [diferenciaPiezas] => 1
            [importeDiferencia] => 311
        )

    [25] => Array
        (
            [codigo] => 399
            [empresaria] => 319
            [existencia] => 35
            [existenciaFisica] => 20
            [diferenciaPiezas] => -15
            [importeDiferencia] => -4785
        )

    [26] => Array
        (
            [codigo] => 459
            [empresaria] => 376
            [existencia] => 4
            [existenciaFisica] => 0
            [diferenciaPiezas] => -4
            [importeDiferencia] => -1504
        )

)
         * 
         */
        
        
        
         $existenciasTotalesSistemaVista= $database->inventarios_agentes_consultarPiezasTotalesPropietario($propietario);
         $database->usuarios_app_kaliope_consultaUsuarioArray($propietario); 
         
         $nombreCompletoPropietarioVista = $database->usuarios_app_kaliope_consultaNombreCompleto($propietario);
         $fechaCortaVista = utilitarios_Class::dameFecha_dd_mm_aaaa_ToText();
         $horaVista = utilitarios_Class::horaActual_hh_mm_ss_ToText();
         
         
         
         
         require 'fisico_vs_sistema_reporte.view.php';
         
        
    
    
    
    
    
    
    

    









