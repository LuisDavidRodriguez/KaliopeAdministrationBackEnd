<?php

/*
 * clase que incluye todos los metods para conectarse a las tablas y manejar la informacion
 * 
 */

/**
 * Description of base_de_datos_Class
 *
 * @author david
 */

include_once 'utilitarios_Class.php';




class base_de_datos_Class {

    //put your code here
    
    



    private $conexion;

    public function __construct() {

        try {
            //realizamos la conexion a la base de datos
            //$this->conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'root', '');
            $this->conexion = new PDO('mysql:host=127.0.0.1;dbname=kaliopec_kaliope', 'kaliopec_kaliope', 'ja2408922007');

        } catch (PDOException $e) {
            echo "Error" . $e->getMessage();
        }
    }
    
    
    
    
    
    
    
/**
 * return el valor de la consstante
 * @param string $usuario
 * the constant name.
 * </p>
 * @return el valor del usuario
 */
    public function inventarios_agentes_consultarInventarioJsonEncode($usuario) {
        /* este metodo se usa para consultar el inventario
         * y retornar un json encode, es para la app de kaliope agentes
         * 
         */
        

        $inventario = $this->conexion->prepare(
                "SELECT * FROM inventarios_agentes WHERE propietario = '$usuario'"
        );
        $inventario->execute();
        $inventario = $inventario->fetchAll();
        //print_r($inventario);

        if (!empty($inventario)) {
            return json_encode($inventario);
        } else {
            throw new Exception("Error al iniciar sesion no existe inventario para el usuario $usuario");
        }
    }
    
    public function inventarios_agentes_consultarInventarioArray($usuario) {
        /* este metodo retorna un array
         * lo usamos para usarlo en cualquier archivo php a diferencia del que 
         * retorna un JsonEnconde que se usa para enviar los datos a la app de kaliope
         */
        

        $inventario = $this->conexion->prepare(
                "SELECT * FROM inventarios_agentes WHERE propietario = '$usuario'"
        );
        $inventario->execute();
        $inventario = $inventario->fetchAll();
        //print_r($inventario);
        
        /*
         * Array
        (
    [0] => Array
        (
            [id] => 70
            [0] => 70
            [propietario] => David
            [1] => David
            [codigo] => 29
            [2] => 29
            [existencia] => 0
            [3] => 0
            [precio] => 29
            [4] => 29
            [vendedora] => 22
            [5] => 22
            [socia] => 21
            [6] => 21
            [empresaria] => 21
            [7] => 21
            [version] => 10
            [8] => 10
        )

    [1] => Array
        (
            [id] => 71
            [0] => 71
            [propietario] => David
            [1] => David
            [codigo] => 39
            [2] => 39
            [existencia] => 0
            [3] => 0
            [precio] => 39
            [4] => 39
            [vendedora] => 30
            [5] => 30
            [socia] => 29
            [6] => 29
            [empresaria] => 28
            [7] => 28
            [version] => 10
            [8] => 10
        )

    [2] => Array
        (
            [id] => 72
            [0] => 72
            [propietario] => David
            [1] => David
            [codigo] => 49
            [2] => 49
            [existencia] => 0
            [3] => 0
            [precio] => 49
            [4] => 49
            [vendedora] => 38
            [5] => 38
            [socia] => 36
            [6] => 36
            [empresaria] => 35
            [7] => 35
            [version] => 10
            [8] => 10
        )

    [3] => Array
        (
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

    [4] => Array
        (
            [id] => 74
            [0] => 74
            [propietario] => David
            [1] => David
            [codigo] => 69
            [2] => 69
            [existencia] => 0
            [3] => 0
            [precio] => 69
            [4] => 69
            [vendedora] => 53
            [5] => 53
            [socia] => 51
            [6] => 51
            [empresaria] => 49
            [7] => 49
            [version] => 10
            [8] => 10
        )
)
         */

        
            return $inventario;
        
    }
    
    public function inventarios_agentes_consultarInventarioExistenciasArray($usuario) {
        /* este metodo retorna un array
         * lo usamos para usarlo en cualquier archivo php a diferencia del que 
         * retorna un JsonEnconde que se usa para enviar los datos a la app de kaliope
         */
        

        $inventario = $this->conexion->prepare(
                "SELECT * FROM inventarios_agentes WHERE propietario = '$usuario' AND existencia != 0"
        );
        $inventario->execute();
        $inventario = $inventario->fetchAll();
        //print_r($inventario);

        
            return $inventario;
        
    }
    
    public function inventarios_agentes_consultarInventarioSoloCodigoExistenciasArray($usuario) {
        /* este metodo retorna un array
         * lo usamos para usarlo en cualquier archivo php este archivo solo retornara el codigo de producto y las
         * existencias del mismo
         */
        

        $inventario = $this->conexion->prepare(
                "SELECT codigo, existencia  FROM inventarios_agentes WHERE propietario = '$usuario' AND existencia != 0"
        );
        $inventario->execute();
        $inventario = $inventario->fetchAll();
        //print_r($inventario);

        
            return $inventario;
        
    }
    
    public function inventarios_agentes_consultaVersionInventario($propietario){
        
        //consultamos la tabla inventario si ya existen productos a nombre del usuario
        $version = $this->conexion->prepare(
                "SELECT DISTINCT version FROM inventarios_agentes WHERE propietario = '$propietario'"
        );
        $version->execute();
        $versionRecuperada = $version->fetchAll();
        //print_r($versionRecuperada);
        
        
       return $versionRecuperada[0][0];
        
    }
    
    public function inventarios_agentes_consultarUsuariosConInventario(){
        //consultamos la tabla inventario si ya existen productos a nombre del usuario
        $propietarios = $this->conexion->prepare(
                "SELECT DISTINCT propietario FROM inventarios_agentes ORDER BY propietario ASC"
        );
        $propietarios->execute();
        $respuesta = $propietarios->fetchAll();
        //print_r($respuesta);
        
        /*
         * Array
                (
                    [0] => Array
                        (
                            [propietario] => David
                            [0] => David
                        )

                    [1] => Array
                        (
                            [propietario] => Jovas
                            [0] => Jovas
                        )

                )
         */
        
        
       return $respuesta;
    }
    
    public function inventarios_agentes_consultarPiezasTotalesPropietario ($propietario){
        
        //consultamos la tabla inventario si ya existen productos a nombre del usuario
        $existenciasConsulta = $this->conexion->prepare(
                "SELECT existencia FROM inventarios_agentes WHERE propietario = '$propietario' AND existencia != 0"
        );
        $existenciasConsulta->execute();
        $existencias = $existenciasConsulta->fetchAll();
        //print_r($existencias);
        
        $totalDeExistencias = 0;
        foreach ($existencias as $value) {
            $totalDeExistencias += $value['existencia'];
        }       
        
        
        
       return $totalDeExistencias;
        
    }
    
    public function inventarios_agentes_consultarImporteTotalPropietario ($propietario){
        /*calcularemos el importe total del inventario
         * con las existencias y el precio de vendedora
         */
        
        //consultamos la tabla inventario si ya existen productos a nombre del usuario
        $importeConsulta = $this->conexion->prepare(
                "SELECT existencia, vendedora FROM inventarios_agentes WHERE propietario = '$propietario' AND existencia != 0"
        );
        $importeConsulta->execute();
        $importe = $importeConsulta->fetchAll();
        //print_r($importe);
        
        
        
        $calculoImporteTotal = 0;        
        foreach ($importe as $value) {
            $calculoImporteTotal += $value['existencia'] * $value['vendedora'];            
        }
        
        return $calculoImporteTotal;
        
        
    }  
       
    public function inventarios_agentes_actualizaInventario($alias, $arrayInventario) {
        /*Metodo para actualizar el inventario dependiendo donde el usuario
         * sea el adecuado. se necesita enviar un array de una sola dimension
         */


        if (!empty($arrayInventario)) {


            //print_r($arrayInventario); esto se ve en el cuadro de dialogo de la app cuando se abre el onFaiure

            foreach ($arrayInventario as $value) {
                //print_r($value); esto se ve en el cuadro de dialogo de la app cuando se abre el onFaiure
                /* en cada forEach tenemos esto
                 * array
                 * (
                 *       [codigo]=>249
                 *       [existencias]=>52     
                 * )
                 */

                //echo ' valorDe codigo:'. $value['codigo'];//esto se ve en el cuadro de dialogo de la app cuando se abre el onFaiure
                //echo ' Existencias:'. $value['existencias'];
                $existencias = $value['existencias'];
                $codigo = $value['codigo'];


                $insertarInventario = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET "
                        . "existencia= '$existencias'"
                        . "WHERE codigo='$codigo'"
                        . "AND propietario='$alias'");
                $insertarInventario->execute();
            }
        }
    }
    
    public function inventarios_agentes_actualizaVersion($propietario){        
        
        $actualizaVersion = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET version = version + 1 WHERE propietario='$propietario'"
                );
                $actualizaVersion->execute();
                
                
                
                
        $this->inventarios_agentes_reiniciarEnviadoAlMovil($propietario);

        
    }
    
    public function inventarios_agentes_reiniciaVersion($propietario){
        
        $actualizaVersion = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET version = 0 WHERE propietario='$propietario'"
                );
                $actualizaVersion->execute();
                
                
                
                
                $this->inventarios_agentes_reiniciarEnviadoAlMovil($propietario);
        
    }    
    
    public function inventarios_agentes_reiniciarInventarioA0($propietario) {
        /*Reiniciamos el inventairo de cualquier usuario a 0
         */

                $insertarInventario = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET "
                        . "existencia= '0'"
                        . "WHERE propietario='$propietario'");
                $insertarInventario->execute();
            
        
    }
    
    public function inventarios_agentes_eliminaInventario($propietario){
        
        $delete = $this->conexion->prepare(
                "DELETE FROM inventarios_agentes WHERE propietario = '$propietario'"
        );
        $delete->execute();
       
        
    }
    
    public function inventarios_agentes_insertaNuevoInventario($propietario) {
        /* este metodo ingresa un nuevo inventario
         * para un nuevo usuario tomando los precios desde el catalogo de precios
         * e insertando en 0 las existencias.
         */

        $precios = $this->conexion->prepare(
                "SELECT * FROM catalogo_precios"
        );
        $precios->execute();
        $precios = $precios->fetchAll();
        //print_r($precios);
        //consultamos la tabla inventario si ya existen productos a nombre del usuario
        $existeInv = $this->conexion->prepare(
                "SELECT * FROM inventarios_agentes WHERE propietario = '$propietario'"
        );
        $existeInv->execute();
        $existeInv = $existeInv->fetchAll();
        //print_r($existeInv);


        if (empty($existeInv)) {

            if (!empty($precios)) {

                foreach ($precios as $precio) {
                    $propietario = $propietario;
                    $code = $precio['codigo'];
                    $stock = 0;
                    $price = $precio['precio'];
                    $ven = $precio['vendedora'];
                    $soc = $precio['socia'];
                    $emp = $precio['empresaria'];
                    $ver = 0;
                    //para cada usuario 
                    $statement = $this->conexion->prepare(
                            "INSERT INTO inventarios_agentes (propietario, codigo, existencia, precio, vendedora, socia, empresaria, version) VALUES ('$propietario', '$code', '$stock', '$price', '$ven', '$soc', '$emp', '$ver')"
                    );
                    $statement->execute();
                }
            }
        } else {
            throw new Exception("Existen productos a nombre de este nuevo usuario");
        }
    }   
    
    public function inventarios_agentes_validarCodigoRetornaExcepcion($propietario, $codigo){
       $consulta = $this->conexion->prepare(
                "SELECT codigo FROM inventarios_agentes WHERE propietario = '$propietario' AND codigo = '$codigo'"
                )
               ;
       $consulta->execute();
       
       $resultados = $consulta->fetchAll();
       
       if(empty($resultados)){
           throw new Exception("<h3> No existe el codigo: $codigo, en el inventario de: $propietario </h3>");
       }
       
       
        
    }
    
    public function inventarios_agentes_validarCodigoRetornaBoleano($propietario, $codigo){
       $consulta = $this->conexion->prepare(
                "SELECT codigo FROM inventarios_agentes WHERE propietario = '$propietario' AND codigo = '$codigo'"
                )
               ;
       $consulta->execute();
       
       $resultados = $consulta->fetchAll();
       
       if(empty($resultados)){
           return false;
       }else{
           return true;
       }
       
       
        
    }
    
    public function inventarios_agentes_incrementaInventario($propietario,$codigo,$cantidad){        
        
        $incrementaInventario = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET existencia = existencia + '$cantidad' WHERE propietario='$propietario' AND codigo='$codigo'"
                );
                $incrementaInventario->execute();
        
    }
    
    public function inventarios_agentes_decrementaInventario($propietario,$codigo,$cantidad){        
        
        $incrementaInventario = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET existencia = existencia - '$cantidad' WHERE propietario='$propietario' AND codigo='$codigo'"
                );
                $incrementaInventario->execute();
        
    }    
    
    public function inventarios_agentes_cambiarNombreInventario($propietario,$nombreNuevo){       
        
        /*
         * Este metodo cambia el nombre del propietario por otro nuevo ingresado
         */
        
        $cambiaNombre = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET propietario = '$nombreNuevo' WHERE propietario='$propietario'"
                );
                $cambiaNombre->execute();
    
        
    }
    
    public function inventarios_agentes_cambiarVersionVersionInicial($propietario,$versionNueva){
        
        $actualizaVersion = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET version = '$versionNueva' WHERE propietario='$propietario'"
                );
                $actualizaVersion->execute();
                
                $this->inventarios_agentes_reiniciarEnviadoAlMovil($propietario);
                
         
    }
    
    private function inventarios_agentes_reiniciarEnviadoAlMovil($propietario){
        /*
         * Creamos este metodo que reiniciara los campos del inventario donde se almacena si el inventario
         * ya fue enviado al movil, es decir si el movil ya lo sincronizo. Debemos llamar a este metodo cada que 
         * se cambie la version de un inventario
         * 
         * Para que sea mas funcional vamos a manejar este metodo solo en los metodos de la base de datos donde se realice un cambio de
         * version, y lo hacemos privado
         */
        
        $actualizaVersion = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET enviado_al_movil = '0', hora_de_envio_al_movil = '' WHERE propietario='$propietario'"
                );
                $actualizaVersion->execute();
                
                
                
                
                
                /*
         * Creamos este metodo que reiniciara el campo del inventario donde se almacena si el movil ya envio su inventario al servidor
         * para saber si el inventario que tenemos en el servidor es reciente con el que el movil tiene.
               
         *Debemos llamar a este metodo cada que 
         * se cambie la version de un inventario         * 

         */
        
        $actualizaVersion = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET hora_sincronizado_desde_el_movil = '' WHERE propietario='$propietario'"
                );
                $actualizaVersion->execute();
    }
    
    public function inventarios_agentes_ponerEnviadoAlMovil($propietario){
        /*
         * Creamos este metodo que actualizara el envio del inventario, esto lo vamos a llamar cuando el servidor
         * envio una nueva version del inventario al telefono, para poner a que hora lo envio
         * Y tambien en el inicio de sesion cuando el telefono lo envia
         */
        
        $horaDeEnvioAlMovil = utilitarios_Class::dameFecha_dd_mm_aaaa_ToText()."  ". utilitarios_Class::horaActual_hh_mm_ss_ToText();
        
        $actualizaVersion = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET enviado_al_movil = 1, hora_de_envio_al_movil = '$horaDeEnvioAlMovil' WHERE propietario='$propietario'"
                );
                $actualizaVersion->execute();
    }
    
    public function inventarios_agentes_consultaEnviadoAlMovil($propietario){
        /*
         * Retornamos los campos de si el inventario se envio al movil y la hora en que se envio
         * tambien recogemos la ultima hora en la que se sincronizo el inventario dfel movil hacia el servidor
         */
        
        //consultamos la tabla inventario si ya existen productos a nombre del usuario
        $consulta = $this->conexion->prepare(
                "SELECT DISTINCT enviado_al_movil, hora_de_envio_al_movil , hora_sincronizado_desde_el_movil FROM inventarios_agentes WHERE propietario = '$propietario'"
        );
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        //print_r($resultado);
        
        /*
         * Array
        (
            [0] => Array
        (
            
            [enviado_al_movil] => 1
            [0] => 1
            [hora_de_envio_al_movil] => 23:4:29 21-8-2019
            [1] => 23:4:29 21-8-2019
         * [hora_sincronizado_desde_el_movil] => 23:4:29 21-8-2019
            [2] => 23:4:29 21-8-2019

        )

        )
         */
        
        //retornamos ya con un indice menos el array
       return $resultado[0];
        
    }
    
    public function inventarios_agentes_ponerSincronizadoDesdeElMovil($propietario){
        /*
         *Este metodo colocara en el campo de la tabla de los inventarios la hora en la que el inventario que tiene el movil
         * se sincronizo con el del inventario. Es decir cuando el telefono envie su inventario al servidor se registrara la hora
         * Esto para saber que tan reciente es el inventario que tenemos en el servidor con el movil, asi sabremos a que hora se actualizo
         * la informacion del servidor.
         * 
         * A diferencia del ponerEnviadoAlMovil, esa hora es cuando el inventario del servidor sufre un cambio al momento de que
         * se envia el inventario del servidor al movil se registra la hora.
         * 
         * 
         * Se debera llamar en cualquier documento donde el servidor reciba un inventario. en este caso es en cerrar_sesion.php
         */
        
        $horaSincronizadoDesdeElMovil = utilitarios_Class::dameFecha_dd_mm_aaaa_ToText()."  ". utilitarios_Class::horaActual_hh_mm_ss_ToText();
        
        $ejecutar = $this->conexion->prepare(
                        "UPDATE inventarios_agentes SET hora_sincronizado_desde_el_movil = '$horaSincronizadoDesdeElMovil' WHERE propietario='$propietario'"
                );
                $ejecutar->execute();
    }
    
    public function inventarios_agentes_actualizaNuevaListaDePreciosInventario() {
        /*
         * Nos encargaremos en este metodo de actualizar, con forme a la lista de precios los inventarios de los agentes
         * por ejemplo si añadimos un nuevo precio al catalgo de precios, o modificamos algun precio de cierto codigo
         * ejecutaremos este metodo.
         * 
         * 1
         * Consultaremos todos los precios del catalogo,
         * Consultaremos que agentes tienen inventarios existentes
         * Recorreremos en un foreach, primero los agentes entonces empesaremos con el agente
         * pj.  Erik
         * y consultaremos si 1 precio del catalogo de precios existe en ese inventario, si ese codigo ya existe
         * entonces se actualizara el precio en el inventario del agente, pero las existencias se quedaran igual,
         * el propietario
         * 
         * si el precio no existe en ese inventario, entonces se añadira un nuevo renglon con ese precio al inventario
         * del agente, con las existencias en 0 y la version de ese nuevo renglon sera la misma que tiene el agente
         * 
         * al terminar ese precio se consulta el siguiente, y asi hasta terminar todos los precios de ese inventario, en ese
         * momento se hara el cambio al siguiente inventario de otro agente y comienza denuevo a recorrer todos los precios.
         * 
         * Lo hice asi siguiendo el orden de agente por agente aunque quizas trabaje mas y tarde mas tiempo, porque tiene que hacer lo mismo
         * para cada inventario, cuando se podria haber cambiado consultando solo precios, pero preferi evitar el problema si en algun momento
         * algun inventario estaba corrompido y no tenia un precio que otros si tenian, ese precio en ningun momento podria agregarse.
         *
         * Al final terminamos y para que la app kaliope de los agentes entienda que debe cargar una nueva version de inventario cuando se conecte entonces
         * actualizamos la version a una diferente a la que tenia.
         * 
         * 
         * Al añadir un precio nuevo o actualizarlo en el inventario del agente, en automatico ese nuevo precio estara disponible en la app de los agentes kaliope
         * porque la app usa el inventario como "catalogo de precios" del inventario obtiene la informacion de precio venta vendedora socia y empresaria
         * 
         * IMPORTANTE ESTE CODIGO DEBERA EJECUTARSE, SOLO CUANDO TODOS LOS INVENTARIOS QUE TIENEN LOS AGENTES EN SUS MOVILES YA ESTEN SINCRONIZADOS CON LOS DEL SERVIDOR
         * PORQUE SI NO CUANDO SE EJECUTE ESTE CODIGO Y SE CAMBIEN LAS VERSIONES DE LOS INVENTARIOS EN EL SERVIDOR, 
         * EL SERVIDOR DESECHARA EL INVENTARIO QUE LE ENVIE EL MOVIL Y EL MOVIL DESCARGARA EL NUEVO INVENTARIO, GENERANDO PERDIDAS DE INFORMACION RESPECTO A LAS EXISTENCIAS
         * QUE EL USUARIO TIENE EN SU MOVIL.
         * 
         * DE PREFERENCIA HACER ESTE PROCESO UN DIA SABADO O DOMINGO CUANDO SE ESTA TOTALMENTE SEGURO QUE TODOS LOS INVENTARIOS HAN SIDO SINCRONIZADOS
         * 
         * Y COLOCAR EL BOTON PARA EJECUTAR ESTE CODIGO PROTEGIDO DE ALGUNA MANERA A PRESIONES ACCIDENTALES O CON ACCESO SOLO A UN ADMINISTRADOR
         *
         */

        $precios = $this->conexion->prepare(
                "SELECT * FROM catalogo_precios"
        );
        $precios->execute();
        $precios = $precios->fetchAll();
        //print_r($precios);
        
        /*
         * Array
                (
                    [0] => Array
                        (
                            [id] => 421
                            [0] => 421
                            [codigo] => 29
                            [1] => 29
                            [precio] => 29
                            [2] => 29
                            [vendedora] => 22
                            [3] => 22
                            [socia] => 21
                            [4] => 21
                            [empresaria] => 21
                            [5] => 21
                            [nombre] => 
                            [6] => 
                        )

                    [1] => Array
                        (
                            [id] => 422
                            [0] => 422
                            [codigo] => 39
                            [1] => 39
                            [precio] => 39
                            [2] => 39
                            [vendedora] => 30
                            [3] => 30
                            [socia] => 29
                            [4] => 29
                            [empresaria] => 28
                            [5] => 28
                            [nombre] => 
                            [6] => 
                        )



                    [68] => Array
                        (
                            [id] => 489
                            [0] => 489
                            [codigo] => 60
                            [1] => 60
                            [precio] => 60
                            [2] => 60
                            [vendedora] => 60
                            [3] => 60
                            [socia] => 60
                            [4] => 60
                            [empresaria] => 60
                            [5] => 60
                            [nombre] => 
                            [6] => 
                        )
                            
                        [69] => Array
                         (
                          [id] => 490
                          [0] => 490
                          [codigo] => 456
                          [1] => 456
                          [precio] => 456
                          [2] => 456
                          [vendedora] 454
                          [3] => 454
                          [socia] => 453
                          [4] => 453
                          [empresaria] => 452
                          [5] => 452
                          [nombre] => 
                          [6] => 
                        )
         
      

                )
         */
        
        
        if (!empty($precios)) {
            //Si la tabla precios no esta vacia consultamos el nombre de todos los usuarios que tengan inventarios registrados
            $agentesConInventariosRegistrados = $this->inventarios_agentes_consultarUsuariosConInventario();
            //print_r($agentesConInventariosRegistrados);
            /*
             * 
             * Array
              (
              [0] => Array
              (
              [propietario] => almacenPrueba
              [0] => almacenPrueba
              )

              [1] => Array
              (
              [propietario] => Atlacomulco
              [0] => Atlacomulco
              )

              [2] => Array
              (
              [propietario] => Cruz
              [0] => Cruz
              )

              [3] => Array
              (
              [propietario] => David
              [0] => David
              )

              [4] => Array
              (
              [propietario] => Eduardo
              [0] => Eduardo
              )

              [5] => Array
              (
              [propietario] => Elihu
              [0] => Elihu
              )

              [6] => Array
              (
              [propietario] => Erick
              [0] => Erick
              )

              [7] => Array
              (
              [propietario] => Ernesto
              [0] => Ernesto
              )

              [8] => Array
              (
              [propietario] => Esteban
              [0] => Esteban
              )

              [9] => Array
              (
              [propietario] => Gustavo
              [0] => Gustavo
              )

              [10] => Array
              (
              [propietario] => Hector
              [0] => Hector
              )

              [11] => Array
              (
              [propietario] => Juan
              [0] => Juan
              )

              [12] => Array
              (
              [propietario] => Luisda
              [0] => Luisda
              )

              [13] => Array
              (
              [propietario] => Mendez
              [0] => Mendez
              )

              [14] => Array
              (
              [propietario] => Morelia
              [0] => Morelia
              )

              [15] => Array
              (
              [propietario] => Queretaro
              [0] => Queretaro
              )

              [16] => Array
              (
              [propietario] => Roberto
              [0] => Roberto
              )

              [17] => Array
              (
              [propietario] => Uriel
              [0] => Uriel
              )

              )
             * 
             */

            //cotejamos que haya almenos un usuario que tenga inventario si no no tendria caso llebar este proceso debido a que
            //el usuario tendria que darle en crear inventario nuevo y en ese momento se tomaria la nueva lista de precios
            if (!empty($agentesConInventariosRegistrados)) {
                echo "<H1>SE HAN REALIZADO LAS ACCIONES, SE MUESTRA EL REPORTE: </H1> ";    //MOSTRAMOS AL USUARIO EL BOTON MENU PRINCIPAL
                echo "<a href=MAIN_mostrar_inventarios.php>Volver al Menu Principal</a>";   //DE TODOS LOS ECHO QUE GENERARA ESTE METODO SERA UN TIPO "REPORTE"
                echo "<br><br>";

                foreach ($agentesConInventariosRegistrados as $usuarios) {
                    //por cada agente con inventario encontrado consultaremos si dicho inventario contiene dicho precio, de ser asi lo actualiza con los datos del catalogo de precios
                    //si no lo contiene entonces añadimos un nuevo renglon a su inventario
                    $propietario = $usuarios['propietario'];


                    foreach ($precios as $precio) {
                        $code = $precio['codigo'];
                        $price = $precio['precio'];
                        $ven = $precio['vendedora'];
                        $soc = $precio['socia'];
                        $emp = $precio['empresaria'];

                        $consultaExisteCodigo = $this->conexion->prepare(
                                "SELECT * FROM inventarios_agentes where codigo = '$code' AND propietario = '$propietario'"
                        );
                        $consultaExisteCodigo->execute();
                        $preciosDevueltos = $consultaExisteCodigo->fetchAll();
                        //print_r($preciosDevueltos);
                        /*
                         * Array
                          (
                          [0] => Array
                          (
                          [id] => 4072
                          [0] => 4072
                          [propietario] => almacenPrueba
                          [1] => almacenPrueba
                          [codigo] => 29
                          [2] => 29
                          [existencia] => 0
                          [3] => 0
                          [precio] => 29
                          [4] => 29
                          [vendedora] => 22
                          [5] => 22
                          [socia] => 21
                          [6] => 21
                          [empresaria] => 21
                          [7] => 21
                          [version] => 5
                          [8] => 5
                          [enviado_al_movil] => 1
                          [9] => 1
                          [hora_de_envio_al_movil] => 29-8-2019  16:45:37
                          [10] => 29-8-2019  16:45:37
                          [hora_sincronizado_desde_el_movil] =>
                          [11] =>
                          )

                          )
                         * 
                         */

                        $versionDelInventarioActual = $this->inventarios_agentes_consultaVersionInventario($propietario);

                        //si no esta vacio significa que el precio existe en el usuario en turno por lo tanto actualizamos
                        //solo actualizamos precios de venta, existencias propietario y codigo no se actualizaran, las existencias quedaran las que estan actualmente
                        if (!empty($preciosDevueltos)) {

                            $this->conexion->prepare(
                                    "UPDATE inventarios_agentes SET"
                                    . " precio= '$price',"
                                    . " vendedora= '$ven',"
                                    . " socia= '$soc',"
                                    . " empresaria= '$emp'"
                                    . " WHERE propietario='$propietario' AND codigo = '$code'"
                            )->execute();
                            
                            echo "El Codigo $code existe en el inventario de: $propietario,             se han actualizando los datos del precio <br>";
                            
                        } else {
                            //si esta vacio entonces lo agregamos                      
                            $stock = 0;
                            $statement = $this->conexion->prepare(
                                    "INSERT INTO inventarios_agentes (propietario, codigo, existencia, precio, vendedora, socia, empresaria, version) VALUES ('$propietario', '$code', '$stock', '$price', '$ven', '$soc', '$emp', '$versionDelInventarioActual')"
                            );
                            $statement->execute();

                            echo "EL CODIGO $code NO EXISTE EN EL INVENTARIO DE: $propietario,     <h6>SE HA INSTERTADO EL PRECIO DEACUERDO AL CATALOGO DE PRECIOS</h6> <br>";
                        }

                        /*
                         * Sabremos en este punto si el precio en turno del bucle existe en el inventario del agente en turno del bucle,
                         * Array
                          (
                          [0] => Array
                          (
                          [id] => 4072
                          [0] => 4072
                          [propietario] => almacenPrueba
                          [1] => almacenPrueba
                          [codigo] => 29
                          [2] => 29
                          [existencia] => 0
                          [3] => 0
                          [precio] => 29
                          [4] => 29
                          [vendedora] => 22
                          [5] => 22
                          [socia] => 21
                          [6] => 21
                          [empresaria] => 21
                          [7] => 21
                          [version] => 5
                          [8] => 5
                          [enviado_al_movil] => 1
                          [9] => 1
                          [hora_de_envio_al_movil] => 29-8-2019  16:45:37
                          [10] => 29-8-2019  16:45:37
                          [hora_sincronizado_desde_el_movil] =>
                          [11] =>
                          )

                          )
                          El Codigo 29 existe en el inventario de: almacenPrueba,             actualizando datos del precioArray
                          (
                          [0] => Array
                          (
                          [id] => 4073
                          [0] => 4073
                          [propietario] => almacenPrueba
                          [1] => almacenPrueba
                          [codigo] => 39
                          [2] => 39
                          [existencia] => 0
                          [3] => 0
                          [precio] => 39
                          [4] => 39
                          [vendedora] => 30
                          [5] => 30
                          [socia] => 29
                          [6] => 29
                          [empresaria] => 28
                          [7] => 28
                          [version] => 5
                          [8] => 5
                          [enviado_al_movil] => 1
                          [9] => 1
                          [hora_de_envio_al_movil] => 29-8-2019  16:45:37
                          [10] => 29-8-2019  16:45:37
                          [hora_sincronizado_desde_el_movil] =>
                          [11] =>
                          )


                          )
                          El Codigo 39 existe en el inventario de: almacenPrueba,             actualizando datos del precioArray

                          (
                          )
                          EL CODIGO 456 NO EXISTE EN EL INVENTARIO DE: almacenPrueba,      INSERTANDO EL PRECIOArray


                          (
                          [0] => Array
                          (
                          [id] => 2278
                          [0] => 2278
                          [propietario] => Cruz
                          [1] => Cruz
                          [codigo] => 29
                          [2] => 29
                          [existencia] => 0
                          [3] => 0
                          [precio] => 29
                          [4] => 29
                          [vendedora] => 22
                          [5] => 22
                          [socia] => 21
                          [6] => 21
                          [empresaria] => 21
                          [7] => 21
                          [version] => 14
                          [8] => 14
                          [enviado_al_movil] => 1
                          [9] => 1
                          [hora_de_envio_al_movil] => 3-9-2019  7:57:2
                          [10] => 3-9-2019  7:57:2
                          [hora_sincronizado_desde_el_movil] => 3-9-2019  13:7:54
                          [11] => 3-9-2019  13:7:54
                          )

                          )
                          El Codigo 29 existe en el inventario de: Cruz,             actualizando datos del precioArray
                          (
                          [0] => Array
                          (
                          [id] => 2279
                          [0] => 2279
                          [propietario] => Cruz
                          [1] => Cruz
                          [codigo] => 39
                          [2] => 39
                          [existencia] => 0
                          [3] => 0
                          [precio] => 39
                          [4] => 39
                          [vendedora] => 30
                          [5] => 30
                          [socia] => 29
                          [6] => 29
                          [empresaria] => 28
                          [7] => 28
                          [version] => 14
                          [8] => 14
                          [enviado_al_movil] => 1
                          [9] => 1
                          [hora_de_envio_al_movil] => 3-9-2019  7:57:2
                          [10] => 3-9-2019  7:57:2
                          [hora_sincronizado_desde_el_movil] => 3-9-2019  13:7:54
                          [11] => 3-9-2019  13:7:54
                          )

                          )
                          El Codigo 39 existe en el inventario de: Cruz,             actualizando datos del precioArray

                          (
                          )
                          EL CODIGO 456 NO EXISTE EN EL INVENTARIO DE: Cruz,      INSERTANDO EL PRECIOArray

                         * 
                         */
                    }

                    $this->inventarios_agentes_actualizaVersion($propietario);
                    $temporal = $this->inventarios_agentes_consultaVersionInventario($propietario);
                    echo "<H4> Se ha Actualizado la version del inventario $propietario a la numero: $temporal</H4> <br>";
                }
            } else {
                throw new Exception("No existen ningun inventario a procesar, no tiene caso llebar este proceso agrege el inventario al usuario");
            }
        } else {
            throw new Exception("No existen resultados devueltos de la tabla catalogo_precios");
        }
        
        
        echo "<H1>SE HAN REALIZADO LAS ACCIONES, FIN DEL REPORTE </H1> ";
                echo "<a href=MAIN_mostrar_inventarios.php>Volver al Menu Principal</a>";
                echo "<br><br>";
        
    }   
    
    
    
    
    public function respaldo_inventarios_agentes_insertarRespaldo($propietario){
        /*En esta funcion, vamos a consultar el inventario del propietario
         * lo convertiremos en un json array y lo insertaremos a la base de datos
         * crearemos un respaldo del inventario cada que el servidor borre su inventario
         * y lo escriba del proveniente del telefono. Esto porque algunas veces han ocurrido errores
         * y como no tengo copia del inventario inicial pierdo toda la informacion
         * 
         * Crearemos otro archivo php en el inventario que se llamara, Recuperar Inventario y ahi
         * podremos pegar el json array, para que el sistema escriba sus datos con el respaldo.
         * 
         * PARA QUE ESTA FUNCION TRABAJE CORRECTAMENTE HAY QUE LLAMARLA ANTES DE QUE EL INVENTARIO SE SUSTITUYA
         * para que asi tome los datos del inventario actual y los respalde, y despues ya se sobreescriba el nuevo inventario
         * 
         * Vamos a crear un respaldo del inventario cada que un administrador haga una modificacion en el inventario como puede ser:
         * Cuando se hace una modificacion al inventario.
         * Cuando se elimina un inventario
         * 
         * 
         */
        
        $jsonInventario = json_encode($this->inventarios_agentes_consultarInventarioExistenciasArray($propietario));
        $versionInventario = $this->inventarios_agentes_consultaVersionInventario($propietario);
        $piezasTotales = $this->inventarios_agentes_consultarPiezasTotalesPropietario($propietario);
        $importeTotal = $this->inventarios_agentes_consultarImporteTotalPropietario($propietario);
        $horaDeEnvio = $this->inventarios_agentes_consultaEnviadoAlMovil($propietario);
        $horaDeEnvio = $horaDeEnvio[1];
        $horaRespaldo = utilitarios_Class::dameFecha_dd_mm_aaaa_ToText()."  ". utilitarios_Class::horaActual_hh_mm_ss_ToText();
        
        
        $this->conexion->prepare(
                "INSERT INTO respaldo_inventarios_agentes (propietario, version, piezas_totales, importe_total, hora_de_envio, hora_de_respaldo, json_inventario) "
                . "VALUES ('$propietario', '$versionInventario', '$piezasTotales', '$importeTotal', '$horaDeEnvio', '$horaRespaldo', '$jsonInventario')"
                )->execute();
        
         
        
        
        
    }
    
    public function respaldo_inventarios_agentes_consultarTodosLosRespaldos(){
        
        $consulta = $this->conexion->prepare(
                "SELECT * FROM respaldo_inventarios_agentes ORDER BY id DESC LIMIT 100"
                );
        $consulta->execute();
        
        $resultados = $consulta->fetchAll();
        //print_r($resultados);
        
        
        
        
        /*
         * Array
    (
    [0] => Array
        (
            [id] => 1
            [0] => 1
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 10
            [3] => 10
            [importe_total] => 3022
            [4] => 3022
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019----11:44
            [6] => 3-9-2019----11:44
            [json_inventario] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"}]
            [7] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"}]
        )

    [1] => Array
        (
            [id] => 2
            [0] => 2
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 10
            [3] => 10
            [importe_total] => 3022
            [4] => 3022
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019----11:53
            [6] => 3-9-2019----11:53
            [json_inventario] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"}]
            [7] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"}]
        )

    [2] => Array
        (
            [id] => 3
            [0] => 3
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 15
            [3] => 15
            [importe_total] => 3300
            [4] => 3300
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019----11:53
            [6] => 3-9-2019----11:53
            [json_inventario] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
            [7] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
        )

    [3] => Array
        (
            [id] => 4
            [0] => 4
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 15
            [3] => 15
            [importe_total] => 3300
            [4] => 3300
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019  11:57:14
            [6] => 3-9-2019  11:57:14
            [json_inventario] => [{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
            [7] => [{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
        )

        )
         * 
         * 
         * 
         */
        
        return $resultados;
        
        
        
        
        
        
        
    }
    
    public function respaldo_inventarios_agentes_consultarPropietarioConRespaldo(){
        
        $consulta = $this->conexion->prepare(
                "SELECT DISTINCT propietario FROM respaldo_inventarios_agentes ORDER BY id DESC LIMIT 100"
                );
        $consulta->execute();
        
        $resultados = $consulta->fetchAll();
        //print_r($resultados);
        
        
        
        
        /*
         * Array
    (
    [0] => Array
        (
            [id] => 1
            [0] => 1
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 10
            [3] => 10
            [importe_total] => 3022
            [4] => 3022
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019----11:44
            [6] => 3-9-2019----11:44
            [json_inventario] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"}]
            [7] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"}]
        )

    [1] => Array
        (
            [id] => 2
            [0] => 2
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 10
            [3] => 10
            [importe_total] => 3022
            [4] => 3022
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019----11:53
            [6] => 3-9-2019----11:53
            [json_inventario] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"}]
            [7] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"}]
        )

    [2] => Array
        (
            [id] => 3
            [0] => 3
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 15
            [3] => 15
            [importe_total] => 3300
            [4] => 3300
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019----11:53
            [6] => 3-9-2019----11:53
            [json_inventario] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
            [7] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
        )

    [3] => Array
        (
            [id] => 4
            [0] => 4
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 15
            [3] => 15
            [importe_total] => 3300
            [4] => 3300
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019  11:57:14
            [6] => 3-9-2019  11:57:14
            [json_inventario] => [{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
            [7] => [{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
        )

        )
         * 
         * 
         * 
         */
        
        return $resultados;
        
        
        
        
        
        
        
    }
    
    public function respaldo_inventarios_agentes_consultarRespaldosPorPropietario($propietario){
        
        $consulta = $this->conexion->prepare(
                "SELECT * FROM respaldo_inventarios_agentes WHERE propietario='$propietario' ORDER BY id DESC LIMIT 50"
                );
        $consulta->execute();
        
        $resultados = $consulta->fetchAll();
        //print_r($resultados);
        
        
        
        
        /*
         * Array
    (
    [0] => Array
        (
            [id] => 1
            [0] => 1
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 10
            [3] => 10
            [importe_total] => 3022
            [4] => 3022
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019----11:44
            [6] => 3-9-2019----11:44
            [json_inventario] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"}]
            [7] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"}]
        )

    [1] => Array
        (
            [id] => 2
            [0] => 2
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 10
            [3] => 10
            [importe_total] => 3022
            [4] => 3022
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019----11:53
            [6] => 3-9-2019----11:53
            [json_inventario] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"}]
            [7] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:44:55","11":"3-9-2019  11:44:55"}]
        )

    [2] => Array
        (
            [id] => 3
            [0] => 3
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 15
            [3] => 15
            [importe_total] => 3300
            [4] => 3300
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019----11:53
            [6] => 3-9-2019----11:53
            [json_inventario] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
            [7] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
        )

    [3] => Array
        (
            [id] => 4
            [0] => 4
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 15
            [3] => 15
            [importe_total] => 3300
            [4] => 3300
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019  11:57:14
            [6] => 3-9-2019  11:57:14
            [json_inventario] => [{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
            [7] => [{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"6","3":"6","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"1","3":"1","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"3-9-2019  11:53:18","11":"3-9-2019  11:53:18"}]
        )

        )
         * 
         * 
         * 
         */
        
        return $resultados;
        
        
        
        
        
        
        
    }
    
    public function respaldo_inventarios_agentes_consultarRespaldosPorId($id){
        
        $consulta = $this->conexion->prepare(
                "SELECT * FROM respaldo_inventarios_agentes WHERE id='$id'"
                );
        $consulta->execute();
        
        $resultados = $consulta->fetchAll();
        //print_r($resultados);
        
        
        
        
        /*
         * Array
    (
    [0] => Array
        (
            [id] => 1
            [0] => 1
            [propietario] => Luisda
            [1] => Luisda
            [version] => 5
            [2] => 5
            [piezas_totales] => 10
            [3] => 10
            [importe_total] => 3022
            [4] => 3022
            [hora_de_envio] => 3-9-2019  11:44:53
            [5] => 3-9-2019  11:44:53
            [hora_de_respaldo] => 3-9-2019----11:44
            [6] => 3-9-2019----11:44
            [json_inventario] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"}]
            [7] => [{"id":"4003","0":"4003","propietario":"Luisda","1":"Luisda","codigo":"29","2":"29","existencia":"0","3":"0","precio":"29","4":"29","vendedora":"22","5":"22","socia":"21","6":"21","empresaria":"21","7":"21","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4004","0":"4004","propietario":"Luisda","1":"Luisda","codigo":"39","2":"39","existencia":"0","3":"0","precio":"39","4":"39","vendedora":"30","5":"30","socia":"29","6":"29","empresaria":"28","7":"28","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4005","0":"4005","propietario":"Luisda","1":"Luisda","codigo":"49","2":"49","existencia":"0","3":"0","precio":"49","4":"49","vendedora":"38","5":"38","socia":"36","6":"36","empresaria":"35","7":"35","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4006","0":"4006","propietario":"Luisda","1":"Luisda","codigo":"59","2":"59","existencia":"0","3":"0","precio":"59","4":"59","vendedora":"45","5":"45","socia":"44","6":"44","empresaria":"42","7":"42","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4007","0":"4007","propietario":"Luisda","1":"Luisda","codigo":"69","2":"69","existencia":"0","3":"0","precio":"69","4":"69","vendedora":"53","5":"53","socia":"51","6":"51","empresaria":"49","7":"49","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4008","0":"4008","propietario":"Luisda","1":"Luisda","codigo":"79","2":"79","existencia":"0","3":"0","precio":"79","4":"79","vendedora":"61","5":"61","socia":"59","6":"59","empresaria":"56","7":"56","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4009","0":"4009","propietario":"Luisda","1":"Luisda","codigo":"89","2":"89","existencia":"0","3":"0","precio":"89","4":"89","vendedora":"68","5":"68","socia":"66","6":"66","empresaria":"64","7":"64","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4010","0":"4010","propietario":"Luisda","1":"Luisda","codigo":"99","2":"99","existencia":"0","3":"0","precio":"99","4":"99","vendedora":"76","5":"76","socia":"73","6":"73","empresaria":"71","7":"71","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4011","0":"4011","propietario":"Luisda","1":"Luisda","codigo":"109","2":"109","existencia":"0","3":"0","precio":"109","4":"109","vendedora":"84","5":"84","socia":"81","6":"81","empresaria":"78","7":"78","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4012","0":"4012","propietario":"Luisda","1":"Luisda","codigo":"119","2":"119","existencia":"0","3":"0","precio":"119","4":"119","vendedora":"92","5":"92","socia":"88","6":"88","empresaria":"85","7":"85","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4013","0":"4013","propietario":"Luisda","1":"Luisda","codigo":"129","2":"129","existencia":"0","3":"0","precio":"129","4":"129","vendedora":"99","5":"99","socia":"96","6":"96","empresaria":"92","7":"92","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4014","0":"4014","propietario":"Luisda","1":"Luisda","codigo":"139","2":"139","existencia":"2","3":"2","precio":"139","4":"139","vendedora":"107","5":"107","socia":"103","6":"103","empresaria":"99","7":"99","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4015","0":"4015","propietario":"Luisda","1":"Luisda","codigo":"149","2":"149","existencia":"2","3":"2","precio":"149","4":"149","vendedora":"115","5":"115","socia":"110","6":"110","empresaria":"106","7":"106","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4016","0":"4016","propietario":"Luisda","1":"Luisda","codigo":"159","2":"159","existencia":"0","3":"0","precio":"159","4":"159","vendedora":"122","5":"122","socia":"118","6":"118","empresaria":"114","7":"114","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4017","0":"4017","propietario":"Luisda","1":"Luisda","codigo":"169","2":"169","existencia":"0","3":"0","precio":"169","4":"169","vendedora":"130","5":"130","socia":"125","6":"125","empresaria":"121","7":"121","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4018","0":"4018","propietario":"Luisda","1":"Luisda","codigo":"179","2":"179","existencia":"0","3":"0","precio":"179","4":"179","vendedora":"138","5":"138","socia":"133","6":"133","empresaria":"128","7":"128","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4019","0":"4019","propietario":"Luisda","1":"Luisda","codigo":"189","2":"189","existencia":"0","3":"0","precio":"189","4":"189","vendedora":"145","5":"145","socia":"140","6":"140","empresaria":"135","7":"135","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4020","0":"4020","propietario":"Luisda","1":"Luisda","codigo":"199","2":"199","existencia":"0","3":"0","precio":"199","4":"199","vendedora":"159","5":"159","socia":"153","6":"153","empresaria":"147","7":"147","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4021","0":"4021","propietario":"Luisda","1":"Luisda","codigo":"209","2":"209","existencia":"0","3":"0","precio":"209","4":"209","vendedora":"174","5":"174","socia":"171","6":"171","empresaria":"167","7":"167","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4022","0":"4022","propietario":"Luisda","1":"Luisda","codigo":"219","2":"219","existencia":"0","3":"0","precio":"219","4":"219","vendedora":"182","5":"182","socia":"180","6":"180","empresaria":"175","7":"175","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4023","0":"4023","propietario":"Luisda","1":"Luisda","codigo":"229","2":"229","existencia":"0","3":"0","precio":"229","4":"229","vendedora":"191","5":"191","socia":"188","6":"188","empresaria":"183","7":"183","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4024","0":"4024","propietario":"Luisda","1":"Luisda","codigo":"239","2":"239","existencia":"0","3":"0","precio":"239","4":"239","vendedora":"199","5":"199","socia":"196","6":"196","empresaria":"191","7":"191","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4025","0":"4025","propietario":"Luisda","1":"Luisda","codigo":"249","2":"249","existencia":"0","3":"0","precio":"249","4":"249","vendedora":"207","5":"207","socia":"204","6":"204","empresaria":"199","7":"199","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4026","0":"4026","propietario":"Luisda","1":"Luisda","codigo":"259","2":"259","existencia":"0","3":"0","precio":"259","4":"259","vendedora":"216","5":"216","socia":"212","6":"212","empresaria":"207","7":"207","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4027","0":"4027","propietario":"Luisda","1":"Luisda","codigo":"269","2":"269","existencia":"0","3":"0","precio":"269","4":"269","vendedora":"224","5":"224","socia":"220","6":"220","empresaria":"215","7":"215","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4028","0":"4028","propietario":"Luisda","1":"Luisda","codigo":"279","2":"279","existencia":"0","3":"0","precio":"279","4":"279","vendedora":"233","5":"233","socia":"229","6":"229","empresaria":"223","7":"223","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4029","0":"4029","propietario":"Luisda","1":"Luisda","codigo":"289","2":"289","existencia":"0","3":"0","precio":"289","4":"289","vendedora":"241","5":"241","socia":"237","6":"237","empresaria":"231","7":"231","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4030","0":"4030","propietario":"Luisda","1":"Luisda","codigo":"299","2":"299","existencia":"0","3":"0","precio":"299","4":"299","vendedora":"249","5":"249","socia":"245","6":"245","empresaria":"239","7":"239","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4031","0":"4031","propietario":"Luisda","1":"Luisda","codigo":"309","2":"309","existencia":"0","3":"0","precio":"309","4":"309","vendedora":"257","5":"257","socia":"253","6":"253","empresaria":"247","7":"247","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4032","0":"4032","propietario":"Luisda","1":"Luisda","codigo":"319","2":"319","existencia":"0","3":"0","precio":"319","4":"319","vendedora":"266","5":"266","socia":"261","6":"261","empresaria":"255","7":"255","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4033","0":"4033","propietario":"Luisda","1":"Luisda","codigo":"329","2":"329","existencia":"2","3":"2","precio":"329","4":"329","vendedora":"274","5":"274","socia":"270","6":"270","empresaria":"263","7":"263","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4034","0":"4034","propietario":"Luisda","1":"Luisda","codigo":"339","2":"339","existencia":"0","3":"0","precio":"339","4":"339","vendedora":"283","5":"283","socia":"278","6":"278","empresaria":"271","7":"271","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4035","0":"4035","propietario":"Luisda","1":"Luisda","codigo":"349","2":"349","existencia":"0","3":"0","precio":"349","4":"349","vendedora":"291","5":"291","socia":"286","6":"286","empresaria":"279","7":"279","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4036","0":"4036","propietario":"Luisda","1":"Luisda","codigo":"359","2":"359","existencia":"0","3":"0","precio":"359","4":"359","vendedora":"299","5":"299","socia":"294","6":"294","empresaria":"287","7":"287","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4037","0":"4037","propietario":"Luisda","1":"Luisda","codigo":"369","2":"369","existencia":"0","3":"0","precio":"369","4":"369","vendedora":"308","5":"308","socia":"302","6":"302","empresaria":"295","7":"295","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4038","0":"4038","propietario":"Luisda","1":"Luisda","codigo":"379","2":"379","existencia":"0","3":"0","precio":"379","4":"379","vendedora":"316","5":"316","socia":"311","6":"311","empresaria":"303","7":"303","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4039","0":"4039","propietario":"Luisda","1":"Luisda","codigo":"389","2":"389","existencia":"0","3":"0","precio":"389","4":"389","vendedora":"324","5":"324","socia":"319","6":"319","empresaria":"311","7":"311","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4040","0":"4040","propietario":"Luisda","1":"Luisda","codigo":"399","2":"399","existencia":"0","3":"0","precio":"399","4":"399","vendedora":"333","5":"333","socia":"327","6":"327","empresaria":"319","7":"319","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4041","0":"4041","propietario":"Luisda","1":"Luisda","codigo":"409","2":"409","existencia":"0","3":"0","precio":"409","4":"409","vendedora":"347","5":"347","socia":"341","6":"341","empresaria":"335","7":"335","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4042","0":"4042","propietario":"Luisda","1":"Luisda","codigo":"419","2":"419","existencia":"0","3":"0","precio":"419","4":"419","vendedora":"355","5":"355","socia":"349","6":"349","empresaria":"343","7":"343","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4043","0":"4043","propietario":"Luisda","1":"Luisda","codigo":"429","2":"429","existencia":"0","3":"0","precio":"429","4":"429","vendedora":"364","5":"364","socia":"358","6":"358","empresaria":"352","7":"352","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4044","0":"4044","propietario":"Luisda","1":"Luisda","codigo":"439","2":"439","existencia":"0","3":"0","precio":"439","4":"439","vendedora":"372","5":"372","socia":"366","6":"366","empresaria":"360","7":"360","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4045","0":"4045","propietario":"Luisda","1":"Luisda","codigo":"449","2":"449","existencia":"0","3":"0","precio":"449","4":"449","vendedora":"381","5":"381","socia":"374","6":"374","empresaria":"368","7":"368","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4046","0":"4046","propietario":"Luisda","1":"Luisda","codigo":"459","2":"459","existencia":"0","3":"0","precio":"459","4":"459","vendedora":"389","5":"389","socia":"383","6":"383","empresaria":"376","7":"376","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4047","0":"4047","propietario":"Luisda","1":"Luisda","codigo":"469","2":"469","existencia":"0","3":"0","precio":"469","4":"469","vendedora":"397","5":"397","socia":"391","6":"391","empresaria":"384","7":"384","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4048","0":"4048","propietario":"Luisda","1":"Luisda","codigo":"479","2":"479","existencia":"0","3":"0","precio":"479","4":"479","vendedora":"406","5":"406","socia":"399","6":"399","empresaria":"393","7":"393","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4049","0":"4049","propietario":"Luisda","1":"Luisda","codigo":"489","2":"489","existencia":"0","3":"0","precio":"489","4":"489","vendedora":"414","5":"414","socia":"408","6":"408","empresaria":"401","7":"401","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4050","0":"4050","propietario":"Luisda","1":"Luisda","codigo":"499","2":"499","existencia":"2","3":"2","precio":"499","4":"499","vendedora":"423","5":"423","socia":"416","6":"416","empresaria":"409","7":"409","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4051","0":"4051","propietario":"Luisda","1":"Luisda","codigo":"509","2":"509","existencia":"0","3":"0","precio":"509","4":"509","vendedora":"431","5":"431","socia":"424","6":"424","empresaria":"417","7":"417","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4052","0":"4052","propietario":"Luisda","1":"Luisda","codigo":"519","2":"519","existencia":"0","3":"0","precio":"519","4":"519","vendedora":"440","5":"440","socia":"433","6":"433","empresaria":"425","7":"425","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4053","0":"4053","propietario":"Luisda","1":"Luisda","codigo":"529","2":"529","existencia":"0","3":"0","precio":"529","4":"529","vendedora":"448","5":"448","socia":"441","6":"441","empresaria":"434","7":"434","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4054","0":"4054","propietario":"Luisda","1":"Luisda","codigo":"539","2":"539","existencia":"0","3":"0","precio":"539","4":"539","vendedora":"457","5":"457","socia":"449","6":"449","empresaria":"442","7":"442","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4055","0":"4055","propietario":"Luisda","1":"Luisda","codigo":"549","2":"549","existencia":"0","3":"0","precio":"549","4":"549","vendedora":"465","5":"465","socia":"458","6":"458","empresaria":"450","7":"450","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4056","0":"4056","propietario":"Luisda","1":"Luisda","codigo":"559","2":"559","existencia":"0","3":"0","precio":"559","4":"559","vendedora":"474","5":"474","socia":"466","6":"466","empresaria":"458","7":"458","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4057","0":"4057","propietario":"Luisda","1":"Luisda","codigo":"569","2":"569","existencia":"0","3":"0","precio":"569","4":"569","vendedora":"482","5":"482","socia":"474","6":"474","empresaria":"466","7":"466","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4058","0":"4058","propietario":"Luisda","1":"Luisda","codigo":"579","2":"579","existencia":"0","3":"0","precio":"579","4":"579","vendedora":"491","5":"491","socia":"483","6":"483","empresaria":"475","7":"475","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4059","0":"4059","propietario":"Luisda","1":"Luisda","codigo":"589","2":"589","existencia":"0","3":"0","precio":"589","4":"589","vendedora":"499","5":"499","socia":"491","6":"491","empresaria":"483","7":"483","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4060","0":"4060","propietario":"Luisda","1":"Luisda","codigo":"599","2":"599","existencia":"0","3":"0","precio":"599","4":"599","vendedora":"508","5":"508","socia":"499","6":"499","empresaria":"491","7":"491","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4061","0":"4061","propietario":"Luisda","1":"Luisda","codigo":"609","2":"609","existencia":"0","3":"0","precio":"609","4":"609","vendedora":"516","5":"516","socia":"508","6":"508","empresaria":"499","7":"499","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4062","0":"4062","propietario":"Luisda","1":"Luisda","codigo":"619","2":"619","existencia":"0","3":"0","precio":"619","4":"619","vendedora":"525","5":"525","socia":"516","6":"516","empresaria":"507","7":"507","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4063","0":"4063","propietario":"Luisda","1":"Luisda","codigo":"629","2":"629","existencia":"0","3":"0","precio":"629","4":"629","vendedora":"533","5":"533","socia":"524","6":"524","empresaria":"516","7":"516","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4064","0":"4064","propietario":"Luisda","1":"Luisda","codigo":"639","2":"639","existencia":"0","3":"0","precio":"639","4":"639","vendedora":"542","5":"542","socia":"533","6":"533","empresaria":"524","7":"524","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4065","0":"4065","propietario":"Luisda","1":"Luisda","codigo":"649","2":"649","existencia":"0","3":"0","precio":"649","4":"649","vendedora":"550","5":"550","socia":"541","6":"541","empresaria":"532","7":"532","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4066","0":"4066","propietario":"Luisda","1":"Luisda","codigo":"659","2":"659","existencia":"0","3":"0","precio":"659","4":"659","vendedora":"558","5":"558","socia":"549","6":"549","empresaria":"540","7":"540","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4067","0":"4067","propietario":"Luisda","1":"Luisda","codigo":"669","2":"669","existencia":"0","3":"0","precio":"669","4":"669","vendedora":"567","5":"567","socia":"558","6":"558","empresaria":"548","7":"548","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4068","0":"4068","propietario":"Luisda","1":"Luisda","codigo":"679","2":"679","existencia":"0","3":"0","precio":"679","4":"679","vendedora":"575","5":"575","socia":"566","6":"566","empresaria":"557","7":"557","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4069","0":"4069","propietario":"Luisda","1":"Luisda","codigo":"689","2":"689","existencia":"0","3":"0","precio":"689","4":"689","vendedora":"584","5":"584","socia":"574","6":"574","empresaria":"565","7":"565","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4070","0":"4070","propietario":"Luisda","1":"Luisda","codigo":"699","2":"699","existencia":"2","3":"2","precio":"699","4":"699","vendedora":"592","5":"592","socia":"583","6":"583","empresaria":"573","7":"573","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"},{"id":"4071","0":"4071","propietario":"Luisda","1":"Luisda","codigo":"60","2":"60","existencia":"0","3":"0","precio":"60","4":"60","vendedora":"60","5":"60","socia":"60","6":"60","empresaria":"60","7":"60","version":"5","8":"5","enviado_al_movil":"1","9":"1","hora_de_envio_al_movil":"3-9-2019  11:44:53","10":"3-9-2019  11:44:53","hora_sincronizado_desde_el_movil":"30-8-2019  7:41:1","11":"30-8-2019  7:41:1"}]
        )

        )
         * 
         * 
         * 
         */
        
        return $resultados;
        
        
        
        
        
        
        
    }
    
   
    
    
    
    
    
    
    
    
    
    public function fisico_vs_sistema_inventario_insertarReporte ($propietario,$nombreCompleto,$fechaRealizado,$horaRealizado,$importeDif,$piezasDif,$cadena){
        $this->conexion->prepare(
                "INSERT INTO fisico_vs_sistema_inventario (propietario,nombre_completo,fecha_realizado,hora_realizado,importe_dif,piezas_dif,cadena)"
                . " VALUES ('$propietario','$nombreCompleto','$fechaRealizado','$horaRealizado','$importeDif','$piezasDif','$cadena')"
                )->execute();
        
    }
    
    public function fisico_vs_sistema_inventario_consultarReportes (){
        $consulta=$this->conexion->prepare(
                "SELECT * FROM fisico_vs_sistema_inventario ORDER BY id DESC"
                );
        $consulta->execute();
        $reportes=$consulta->fetchAll();
        //rint_r($reportes);
        
        
        /*
         * Array
                (
               [0] => Array
                   (
                       [id] => 1
                       [0] => 1
                       [propietario] => David               
                       [1] => David               
                       [nombre_completo] =>  Luis David Rodriguez Valades                     
                       [2] =>  Luis David Rodriguez Valades                     
                       [fecha_realizado] => 9-8-2019                      
                       [3] => 9-8-2019                      
                       [hora_realizado] => 13:58:26            
                       [4] => 13:58:26            
                       [importe_dif] => 1665
                       [5] => 1665
                       [piezas_dif] => 5
                       [6] => 5
                       [cadena] => Propietario del Inventario: David                             <br>Nombre Completo:  Luis David Rodriguez Valades                    
                       [7] => Propietario del Inventario: David                             <br>Nombre Completo:  Luis David Rodriguez Valades                             
                   )

                    )

         */
        
        return $reportes;
        
    }
    
    public function fisico_vs_sistema_inventario_consultarCadenaReportes ($propietario,$fecha,$hora){
        $consulta=$this->conexion->prepare(
                "SELECT cadena FROM fisico_vs_sistema_inventario WHERE propietario='$propietario' AND fecha_realizado='$fecha' AND hora_realizado='$hora'"
                );
        $consulta->execute();
        $cadena=$consulta->fetchAll();
        //print_r($cadena);
        
        $cadena=$cadena[0][0];
        
        return $cadena;
        
    }
    
    public function fisico_vs_sistema_inventario_consultarPropietariosConReportes (){
        $consulta=$this->conexion->prepare(
                "SELECT DISTINCT propietario FROM fisico_vs_sistema_inventario ORDER BY propietario ASC"
                );
        $consulta->execute();
        $cadena=$consulta->fetchAll();
        //print_r($cadena);
        
        /*
         * Array
(
    [0] => Array
        (
            [propietario] => Carlitos
            [0] => Carlitos
        )

    [1] => Array
        (
            [propietario] => Cruz
            [0] => Cruz
        )

    [2] => Array
        (
            [propietario] => David
            [0] => David
        )

    [3] => Array
        (
            [propietario] => Eduardo             
            [0] => Eduardo             
        )

    [4] => Array
        (
            [propietario] => Elihu
            [0] => Elihu
        )

    [5] => Array
        (
            [propietario] => Erick               
            [0] => Erick               
        )

    [6] => Array
        (
            [propietario] => Hector              
            [0] => Hector              
        )

    [7] => Array
        (
            [propietario] => Juan                
            [0] => Juan                
        )

    [8] => Array
        (
            [propietario] => Mendez
            [0] => Mendez
        )

    [9] => Array
        (
            [propietario] => Oswaldo             
            [0] => Oswaldo             
        )

    [10] => Array
        (
            [propietario] => Ramiro
            [0] => Ramiro
        )

    [11] => Array
        (
            [propietario] => Uriel
            [0] => Uriel
        )

)
         */
        
        
        return $cadena;
        
    }
    
    public function fisico_vs_sistema_inventario_consultarReportesPorPropietario ($propietario){
        $consulta=$this->conexion->prepare(
                "SELECT * FROM fisico_vs_sistema_inventario WHERE propietario='$propietario' ORDER BY id DESC LIMIT 50"
                );
        $consulta->execute();
        $reportes=$consulta->fetchAll();
        //print_r($reportes);
        
        /*
         * Array
(
    [0] => Array
        (
            [id] => 32
            [0] => 32
            [propietario] => Eduardo
            [1] => Eduardo
            [nombre_completo] =>  Eduardo Baldomero Maximo
            [2] =>  Eduardo Baldomero Maximo
            [fecha_realizado] => 23-8-2019
            [3] => 23-8-2019
            [hora_realizado] => 21:58:38 
            [4] => 21:58:38 
            [importe_dif] => 25
            [5] => 25
            [piezas_dif] => 0
            [6] => 0
            [cadena] => Propietario del Inventario: Eduardo <br>Nombre Completo:  Eduardo Baldomero Maximo <br>Fecha Realizado: 23-8-2019 <br>Hora: 21:58:38  <br><br><br><br> EMPRESARIA &nbsp EXISTENCIAS &nbsp CODIGO &nbsp FISICAMENTE &nbsp diferenciaPz &nbsp importe <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp114&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp135&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp189&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp147&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp199&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp167&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp7&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp209&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp7&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp183&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp229&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp191&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp239&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp207&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp6&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp259&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp6&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp223&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp24&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp279&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp24&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp239&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp30&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp299&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp30&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp247&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp15&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp309&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp15&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp263&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp329&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp271&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp22&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp339&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp22&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp279&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp349&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp287&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp7&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp359&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp8&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $287<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp295&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp369&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp311&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp389&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp319&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp32&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp399&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp30&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $-638<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp376&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp459&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $376<br><br><br><h3>Existencias segun Sistema: 183 </h3><h3>Total piezas Fisicas Capturadas:  183</h3><h3>Faltan: 0 piezas</h3><h3>Importe Sobrante: $25</h3><br><br><br><br><br><br>
            [7] => Propietario del Inventario: Eduardo <br>Nombre Completo:  Eduardo Baldomero Maximo <br>Fecha Realizado: 23-8-2019 <br>Hora: 21:58:38  <br><br><br><br> EMPRESARIA &nbsp EXISTENCIAS &nbsp CODIGO &nbsp FISICAMENTE &nbsp diferenciaPz &nbsp importe <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp114&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp135&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp189&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp147&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp199&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp167&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp7&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp209&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp7&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp183&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp229&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp191&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp239&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp207&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp6&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp259&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp6&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp223&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp24&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp279&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp24&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp239&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp30&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp299&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp30&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp247&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp15&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp309&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp15&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp263&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp329&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp271&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp22&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp339&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp22&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp279&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp349&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp287&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp7&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp359&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp8&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $287<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp295&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp369&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp311&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp389&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp319&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp32&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp399&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp30&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $-638<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp376&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp459&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $376<br><br><br><h3>Existencias segun Sistema: 183 </h3><h3>Total piezas Fisicas Capturadas:  183</h3><h3>Faltan: 0 piezas</h3><h3>Importe Sobrante: $25</h3><br><br><br><br><br><br>
        )

    [1] => Array
        (
            [id] => 16
            [0] => 16
            [propietario] => Eduardo             
            [1] => Eduardo             
            [nombre_completo] =>  Eduardo Baldomero Maximo                         
            [2] =>  Eduardo Baldomero Maximo                         
            [fecha_realizado] => 16-8-2019                     
            [3] => 16-8-2019                     
            [hora_realizado] => 21:2:19             
            [4] => 21:2:19             
            [importe_dif] => -49
            [5] => -49
            [piezas_dif] => 0
            [6] => 0
            [cadena] => Propietario del Inventario: Eduardo                             <br>Nombre Completo:  Eduardo Baldomero Maximo                             <br>Fecha Realizado: 16-8-2019                             <br>Hora: 21:2:19                             <br><br><br><br> EMPRESARIA &nbsp EXISTENCIAS &nbsp CODIGO &nbsp FISICAMENTE &nbsp diferenciaPz &nbsp importe <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp106&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp149&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp114&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp23&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp24&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $114<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp121&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp169&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp128&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp179&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp135&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp189&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp147&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp15&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp199&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp14&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $-147<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp167&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp209&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp191&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp239&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp207&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp259&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp223&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp28&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp279&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp28&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp239&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp40&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp299&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp39&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $-239<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp247&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp309&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp19&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $494<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp255&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp8&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp319&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp8&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp263&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp329&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp271&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp18&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp339&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $-271<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp319&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp399&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp376&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp459&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br><br><br><h3>Existencias segun Sistema: 189                             </h3><h3>Total piezas Fisicas Capturadas:  189                            </h3><h3>Faltan: 0                             piezas</h3><h3>Importe Faltante: $-49</h3><br><br><br><br><br><br>
            [7] => Propietario del Inventario: Eduardo                             <br>Nombre Completo:  Eduardo Baldomero Maximo                             <br>Fecha Realizado: 16-8-2019                             <br>Hora: 21:2:19                             <br><br><br><br> EMPRESARIA &nbsp EXISTENCIAS &nbsp CODIGO &nbsp FISICAMENTE &nbsp diferenciaPz &nbsp importe <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp106&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp149&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp114&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp23&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp24&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $114<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp121&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp169&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp128&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp179&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp135&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp189&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp147&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp15&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp199&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp14&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $-147<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp167&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp209&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp191&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp239&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp207&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp259&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp223&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp28&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp279&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp28&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp239&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp40&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp299&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp39&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $-239<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp247&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp309&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp19&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $494<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp255&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp8&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp319&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp8&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp263&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp329&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp3&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp271&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp18&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp339&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $-271<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp319&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp399&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp17&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp376&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp459&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $0<br><br><br><h3>Existencias segun Sistema: 189                             </h3><h3>Total piezas Fisicas Capturadas:  189                            </h3><h3>Faltan: 0                             piezas</h3><h3>Importe Faltante: $-49</h3><br><br><br><br><br><br>
        )

)

         */
        
        
        return $reportes;
        
    }
    
    
    
    
    
    
    
    
    
    public function modificar_inventarios_bitacora_insertarBitacora ($propietario,$administrador,$motivo,$fechaRealizado,$horaRealizado,$entradas,$salidas,$existenciasAntes,$existenciasDespues,$versionAntes,$versionDespues,$cadena){
        $this->conexion->prepare(
                "INSERT INTO modificar_inventarios_bitacora (propietario,administrador,motivo,fecha_realizado,hora_realizado,entradas,salidas,existencias_antes,existencias_despues,version_antes,version_despues,cadena)"
                . " VALUES ('$propietario','$administrador','$motivo','$fechaRealizado','$horaRealizado','$entradas','$salidas','$existenciasAntes','$existenciasDespues','$versionAntes','$versionDespues','$cadena')"
                )->execute();
    }

    public function modificar_inventarios_bitacora_consultarBitacoras (){
        $consulta=$this->conexion->prepare(
                "SELECT * FROM modificar_inventarios_bitacora ORDER BY id DESC"
                );
        $consulta->execute();
        $reportes=$consulta->fetchAll();
        //print_r($reportes);
        
        
        /*
         * Array
(
    [0] => Array
        (
            [id] => 1
            [0] => 1
            [propietario] => David                   
            [1] => David                   
            [administrador] => sdfsd                   
            [2] => sdfsd                   
            [motivo] => adsds                   
            [3] => adsds                   
            [fecha_realizado] => 9-8-2019
            [4] => 9-8-2019
            [hora_realizado] => 23:59:56
            [5] => 23:59:56
            [entradas] => 0
            [6] => 0
            [salidas] => 0
            [7] => 0
            [existencias_antes] => -178
            [8] => -178
            [existencias_despues] => -173
            [9] => -173
            [version_antes] => 64
            [10] => 64
            [version_despues] => 65
            [11] => 65
            [cadena] => Propietario del Inventario: David                    <br>Administrador sdfsd                    <br>Motivo: adsds                    <br>Fecha Realizado: 9-8-2019 <br>Hora: 23:59:56 <br><br><br><br> ENTRADAS<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp149&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5<br>TotalEntradas: 5 <br><br> SALIDAS<br> CODIGO &nbsp CANTIDAD <br>TotalSalidas: 0 <br><br><br><h3>Existencias Antes: -178 </h3><h3>Existencias Despues:  -173</h3><h3>Importe Antes:  -62531</h3><h3>Importe Despues:  -61956</h3><h3>Version Antes:  64</h3><h3>Version Despues:  65</h3><br><br><br><br><br><br>
            [12] => Propietario del Inventario: David                    <br>Administrador sdfsd                    <br>Motivo: adsds                    <br>Fecha Realizado: 9-8-2019 <br>Hora: 23:59:56 <br><br><br><br> ENTRADAS<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp149&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5<br>TotalEntradas: 5 <br><br> SALIDAS<br> CODIGO &nbsp CANTIDAD <br>TotalSalidas: 0 <br><br><br><h3>Existencias Antes: -178 </h3><h3>Existencias Despues:  -173</h3><h3>Importe Antes:  -62531</h3><h3>Importe Despues:  -61956</h3><h3>Version Antes:  64</h3><h3>Version Despues:  65</h3><br><br><br><br><br><br>
        )

    [1] => Array
        (
            [id] => 2
            [0] => 2
            [propietario] => David                   
            [1] => David                   
            [administrador] => Luisda                   
            [2] => Luisda                   
            [motivo] => Hola todo bien                   
            [3] => Hola todo bien                   
            [fecha_realizado] => 10-8-2019
            [4] => 10-8-2019
            [hora_realizado] => 0:27:37
            [5] => 0:27:37
            [entradas] => 0
            [6] => 0
            [salidas] => 0
            [7] => 0
            [existencias_antes] => -173
            [8] => -173
            [existencias_despues] => -193
            [9] => -193
            [version_antes] => 65
            [10] => 65
            [version_despues] => 66
            [11] => 66
            [cadena] => Propietario del Inventario: David                    <br>Administrador Luisda                    <br>Motivo: Hola todo bien                    <br>Fecha Realizado: 10-8-2019 <br>Hora: 0:27:37 <br><br><br><br> Entradas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp10<br>Total Entradas: 10 <br><br> Salidas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp699&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp20<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp339&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp10<br>Total Salidas: 30 <br><br><br><h3>Existencias Antes: -173 </h3><h3>Existencias Despues:  -193</h3><h3>Importe Antes:  -61956</h3><h3>Importe Despues:  -75406</h3><h3>Version Antes:  65</h3><h3>Version Despues:  66</h3><br><br><br><br><br><br>
            [12] => Propietario del Inventario: David                    <br>Administrador Luisda                    <br>Motivo: Hola todo bien                    <br>Fecha Realizado: 10-8-2019 <br>Hora: 0:27:37 <br><br><br><br> Entradas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp10<br>Total Entradas: 10 <br><br> Salidas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp699&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp20<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp339&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp10<br>Total Salidas: 30 <br><br><br><h3>Existencias Antes: -173 </h3><h3>Existencias Despues:  -193</h3><h3>Importe Antes:  -61956</h3><h3>Importe Despues:  -75406</h3><h3>Version Antes:  65</h3><h3>Version Despues:  66</h3><br><br><br><br><br><br>
        )

)


         */
        
        return $reportes;
        
    }

    public function modificar_inventarios_bitacora_consultarCadenaBitacora ($propietario,$fecha,$hora){
        $consulta=$this->conexion->prepare(
                "SELECT cadena FROM modificar_inventarios_bitacora WHERE propietario='$propietario' AND fecha_realizado='$fecha' AND hora_realizado='$hora'"
                );
        $consulta->execute();
        $cadena=$consulta->fetchAll();
        //print_r($cadena);
        
        /*
         * Array
        (
    [0] => Array
        (
            [cadena] => Propietario del Inventario: David                    <br>Administrador sdfsd                    <br>Motivo: adsds                    <br>Fecha Realizado: 9-8-2019 <br>Hora: 23:59:56 <br><br><br><br> ENTRADAS<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp149&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5<br>TotalEntradas: 5 <br><br> SALIDAS<br> CODIGO &nbsp CANTIDAD <br>TotalSalidas: 0 <br><br><br><h3>Existencias Antes: -178 </h3><h3>Existencias Despues:  -173</h3><h3>Importe Antes:  -62531</h3><h3>Importe Despues:  -61956</h3><h3>Version Antes:  64</h3><h3>Version Despues:  65</h3><br><br><br><br><br><br>
            [0] => Propietario del Inventario: David                    <br>Administrador sdfsd                    <br>Motivo: adsds                    <br>Fecha Realizado: 9-8-2019 <br>Hora: 23:59:56 <br><br><br><br> ENTRADAS<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp149&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5<br>TotalEntradas: 5 <br><br> SALIDAS<br> CODIGO &nbsp CANTIDAD <br>TotalSalidas: 0 <br><br><br><h3>Existencias Antes: -178 </h3><h3>Existencias Despues:  -173</h3><h3>Importe Antes:  -62531</h3><h3>Importe Despues:  -61956</h3><h3>Version Antes:  64</h3><h3>Version Despues:  65</h3><br><br><br><br><br><br>
        )

        )
         */
        
        $cadena=$cadena[0][0];
        
        return $cadena;
        
    }
    
    public function modificar_inventarios_bitacora_consultarPropietariosBitacoras (){
        $consulta=$this->conexion->prepare(
                "SELECT DISTINCT propietario FROM modificar_inventarios_bitacora ORDER BY propietario ASC"
                );
        $consulta->execute();
        $reportes=$consulta->fetchAll();
        //print_r($reportes);
        
        /*
         * Array
(
    [0] => Array
        (
            [propietario] => Angel
            [0] => Angel
        )

    [1] => Array
        (
            [propietario] => Atlacomulco
            [0] => Atlacomulco
        )

    [2] => Array
        (
            [propietario] => Carlitos
            [0] => Carlitos
        )

    [3] => Array
        (
            [propietario] => David                   
            [0] => David                   
        )

    [4] => Array
        (
            [propietario] => Eduardo                   
            [0] => Eduardo                   
        )

    [5] => Array
        (
            [propietario] => Elihu
            [0] => Elihu
        )

    [6] => Array
        (
            [propietario] => Erick
            [0] => Erick
        )

    [7] => Array
        (
            [propietario] => Gustavo
            [0] => Gustavo
        )

    [8] => Array
        (
            [propietario] => Hector
            [0] => Hector
        )

    [9] => Array
        (
            [propietario] => Juan                   
            [0] => Juan                   
        )

    [10] => Array
        (
            [propietario] => Mendez                   
            [0] => Mendez                   
        )

    [11] => Array
        (
            [propietario] => Morelia
            [0] => Morelia
        )

    [12] => Array
        (
            [propietario] => Oswaldo                   
            [0] => Oswaldo                   
        )

    [13] => Array
        (
            [propietario] => Queretaro
            [0] => Queretaro
        )

    [14] => Array
        (
            [propietario] => Ramiro
            [0] => Ramiro
        )

    [15] => Array
        (
            [propietario] => Uriel
            [0] => Uriel
        )

)
         */
        
        
        return $reportes;
        
    }
    
    public function modificar_inventarios_bitacora_consultarBitacorasPorPropietario ($propietario){
        $consulta=$this->conexion->prepare(
                "SELECT * FROM modificar_inventarios_bitacora WHERE propietario='$propietario' ORDER BY id DESC"
                );
        $consulta->execute();
        $reportes=$consulta->fetchAll();
        //print_r($reportes);
        
        /*
         * Array
(
    [0] => Array
        (
            [id] => 59
            [0] => 59
            [propietario] => Atlacomulco
            [1] => Atlacomulco
            [administrador] => Luisda
            [2] => Luisda
            [motivo] => solo hago una prueba a ver si entran los datos a la nueva base de datos
            [3] => solo hago una prueba a ver si entran los datos a la nueva base de datos
            [fecha_realizado] => 25-8-2019
            [4] => 25-8-2019
            [hora_realizado] => 19:2:10
            [5] => 19:2:10
            [entradas] => 1
            [6] => 1
            [salidas] => 1
            [7] => 1
            [existencias_antes] => 582
            [8] => 582
            [existencias_despues] => 582
            [9] => 582
            [version_antes] => 2
            [10] => 2
            [version_despues] => 3
            [11] => 3
            [cadena] => Propietario del Inventario: Atlacomulco <br>Administrador Luisda <br>Motivo: solo hago una prueba a ver si entran los datos a la nueva base de datos <br>Fecha Realizado: 25-8-2019 <br>Hora: 19:2:10 <br><br><br><br> Entradas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp139&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>Total Entradas: 1 <br><br> Salidas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp139&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>Total Salidas: 1 <br><br><br><h3>Existencias Antes: 582 </h3><h3>Existencias Despues:  582</h3><h3>Importe Antes:  163655</h3><h3>Importe Despues:  163655</h3><h3>Version Antes:  2</h3><h3>Version Despues:  3</h3><br><br><br><br><br><br>
            [12] => Propietario del Inventario: Atlacomulco <br>Administrador Luisda <br>Motivo: solo hago una prueba a ver si entran los datos a la nueva base de datos <br>Fecha Realizado: 25-8-2019 <br>Hora: 19:2:10 <br><br><br><br> Entradas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp139&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>Total Entradas: 1 <br><br> Salidas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp139&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>Total Salidas: 1 <br><br><br><h3>Existencias Antes: 582 </h3><h3>Existencias Despues:  582</h3><h3>Importe Antes:  163655</h3><h3>Importe Despues:  163655</h3><h3>Version Antes:  2</h3><h3>Version Despues:  3</h3><br><br><br><br><br><br>
        )

    [1] => Array
        (
            [id] => 58
            [0] => 58
            [propietario] => Atlacomulco
            [1] => Atlacomulco
            [administrador] => LUISDA
            [2] => LUISDA
            [motivo] => CARGA DE MERCANCIA
            [3] => CARGA DE MERCANCIA
            [fecha_realizado] => 24-8-2019
            [4] => 24-8-2019
            [hora_realizado] => 16:5:58
            [5] => 16:5:58
            [entradas] => 351
            [6] => 351
            [salidas] => 0
            [7] => 0
            [existencias_antes] => 231
            [8] => 231
            [existencias_despues] => 582
            [9] => 582
            [version_antes] => 1
            [10] => 1
            [version_despues] => 2
            [11] => 2
            [cadena] => Propietario del Inventario: Atlacomulco <br>Administrador LUISDA <br>Motivo: CARGA DE MERCANCIA <br>Fecha Realizado: 24-8-2019 <br>Hora: 16:5:58 <br><br><br><br> Entradas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp359&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp145<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp389&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp15<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp339&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp48<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp40<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp299&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp41<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp279&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp37<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp399&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp25<br>Total Entradas: 351 <br><br> Salidas<br> CODIGO &nbsp CANTIDAD <br>Total Salidas: 0 <br><br><br><h3>Existencias Antes: 231 </h3><h3>Existencias Despues:  582</h3><h3>Importe Antes:  69821</h3><h3>Importe Despues:  163655</h3><h3>Version Antes:  1</h3><h3>Version Despues:  2</h3><br><br><br><br><br><br>
            [12] => Propietario del Inventario: Atlacomulco <br>Administrador LUISDA <br>Motivo: CARGA DE MERCANCIA <br>Fecha Realizado: 24-8-2019 <br>Hora: 16:5:58 <br><br><br><br> Entradas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp359&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp145<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp389&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp15<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp339&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp48<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp40<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp299&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp41<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp279&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp37<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp399&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp25<br>Total Entradas: 351 <br><br> Salidas<br> CODIGO &nbsp CANTIDAD <br>Total Salidas: 0 <br><br><br><h3>Existencias Antes: 231 </h3><h3>Existencias Despues:  582</h3><h3>Importe Antes:  69821</h3><h3>Importe Despues:  163655</h3><h3>Version Antes:  1</h3><h3>Version Despues:  2</h3><br><br><br><br><br><br>
        )

    [2] => Array
        (
            [id] => 55
            [0] => 55
            [propietario] => Atlacomulco
            [1] => Atlacomulco
            [administrador] => Luisda
            [2] => Luisda
            [motivo] => Carga de inventario desde 0 sucursal de atlacomulco
            [3] => Carga de inventario desde 0 sucursal de atlacomulco
            [fecha_realizado] => 24-8-2019
            [4] => 24-8-2019
            [hora_realizado] => 9:0:48
            [5] => 9:0:48
            [entradas] => 231
            [6] => 231
            [salidas] => 0
            [7] => 0
            [existencias_antes] => 0
            [8] => 0
            [existencias_despues] => 231
            [9] => 231
            [version_antes] => 0
            [10] => 0
            [version_despues] => 1
            [11] => 1
            [cadena] => Propietario del Inventario: Atlacomulco <br>Administrador Luisda <br>Motivo: Carga de inventario desde 0 sucursal de atlacomulco <br>Fecha Realizado: 24-8-2019 <br>Hora: 9:0:48 <br><br><br><br> Entradas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp16<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp169&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp6<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp189&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp199&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp20<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp209&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp11<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp229&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp239&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp11<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp279&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp24<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp299&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp21<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp309&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp8<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp319&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp22<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp329&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp339&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp15<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp349&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp359&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp599&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp68<br>Total Entradas: 231 <br><br> Salidas<br> CODIGO &nbsp CANTIDAD <br>Total Salidas: 0 <br><br><br><h3>Existencias Antes: 0 </h3><h3>Existencias Despues:  231</h3><h3>Importe Antes:  0</h3><h3>Importe Despues:  69821</h3><h3>Version Antes:  0</h3><h3>Version Despues:  1</h3><br><br><br><br><br><br>
            [12] => Propietario del Inventario: Atlacomulco <br>Administrador Luisda <br>Motivo: Carga de inventario desde 0 sucursal de atlacomulco <br>Fecha Realizado: 24-8-2019 <br>Hora: 9:0:48 <br><br><br><br> Entradas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp16<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp169&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp6<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp189&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp199&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp20<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp209&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp11<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp229&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp239&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp11<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp279&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp24<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp299&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp21<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp309&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp8<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp319&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp22<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp329&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp339&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp15<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp349&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp359&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp599&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp68<br>Total Entradas: 231 <br><br> Salidas<br> CODIGO &nbsp CANTIDAD <br>Total Salidas: 0 <br><br><br><h3>Existencias Antes: 0 </h3><h3>Existencias Despues:  231</h3><h3>Importe Antes:  0</h3><h3>Importe Despues:  69821</h3><h3>Version Antes:  0</h3><h3>Version Despues:  1</h3><br><br><br><br><br><br>
        )

    [3] => Array
        (
            [id] => 49
            [0] => 49
            [propietario] => Atlacomulco
            [1] => Atlacomulco
            [administrador] => Luisda
            [2] => Luisda
            [motivo] => asdssd
            [3] => asdssd
            [fecha_realizado] => 23-8-2019
            [4] => 23-8-2019
            [hora_realizado] => 14:20:44
            [5] => 14:20:44
            [entradas] => 2
            [6] => 2
            [salidas] => 9
            [7] => 9
            [existencias_antes] => -156
            [8] => -156
            [existencias_despues] => -163
            [9] => -163
            [version_antes] => 17
            [10] => 17
            [version_despues] => 18
            [11] => 18
            [cadena] => Propietario del Inventario: Atlacomulco <br>Administrador Luisda <br>Motivo: asdssd <br>Fecha Realizado: 23-8-2019 <br>Hora: 14:20:44 <br><br><br><br> Entradas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp149&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>Total Entradas: 2 <br><br> Salidas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp99&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp699&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4<br>Total Salidas: 9 <br><br><br><h3>Existencias Antes: -156 </h3><h3>Existencias Despues:  -163</h3><h3>Importe Antes:  -45975</h3><h3>Importe Despues:  -48486</h3><h3>Version Antes:  17</h3><h3>Version Despues:  18</h3><br><br><br><br><br><br>
            [12] => Propietario del Inventario: Atlacomulco <br>Administrador Luisda <br>Motivo: asdssd <br>Fecha Realizado: 23-8-2019 <br>Hora: 14:20:44 <br><br><br><br> Entradas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp159&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp149&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp1<br>Total Entradas: 2 <br><br> Salidas<br> CODIGO &nbsp CANTIDAD <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp99&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp5<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp699&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4<br>Total Salidas: 9 <br><br><br><h3>Existencias Antes: -156 </h3><h3>Existencias Despues:  -163</h3><h3>Importe Antes:  -45975</h3><h3>Importe Despues:  -48486</h3><h3>Version Antes:  17</h3><h3>Version Despues:  18</h3><br><br><br><br><br><br>
        )

)
         */
        
        return $reportes;
        
    }


















    public function dispositivos_verificarDispositivo($uui, $modelo, $fecha) {
        $dispositivo = $this->conexion->prepare(
                "SELECT * FROM dispositivos WHERE uuid = '$uui'"
                //consultamos si en la tabla ya hay un numero uuid que concuerde
        );
        $dispositivo->execute();
        $dispositivo = $dispositivo->fetchAll();
        //print_r($dispositivo);

        if (empty($dispositivo)) {
            //si esta vacio añadimos el dispositivo a la tabla por primera vez
            //Ejecutamos la conexion y especificamos la tabla a elegir
            $statement = $this->conexion->prepare(
                    "INSERT INTO dispositivos (modelo_movil, uuid, fecha_hora_solicitud) VALUES ('$modelo', '$uui','$fecha')"
            );
            $statement->execute();
            
            throw new Exception("El dispositivo por el que intenta acceder no esta autorizado llame a sistemas kaliope, hora solicitud: ' . $fecha");
        } else {

            //evaluamos si el dispositivo esta autorizado
            if ($dispositivo[0]['autorizado']) {
                return true;
            } else {
               
                throw new Exception('El dispositivo por el que intenta acceder no esta autorizado.  Llama a sistemas Kaliope, hora de solicitud: ' . $dispositivo[0]['fecha_hora_solicitud']);
                //si el sistema encuentra que ya hay un uuid registrado en la tabla entonces devuelve la fecha de la solicitud
            }
        }
    }
    
    public function dispositivos_consultaroTodosLosDispositivos_returnArray(){
        $consulta = $this->conexion->prepare(
                "SELECT * FROM dispositivos"
                );
        
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        
        
        return $resultado;
       
        
    }
    
    public function dispositivos_consultaDispositivoPorId($id){
        $consulta = $this->conexion->prepare(
                "SELECT * FROM dispositivos WHERE id='$id'"
                );
        
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        //print_r($resultado);
        
        /*
         * Array
(
    [0] => Array
        (
            [id] => 82
            [0] => 82
            [modelo_movil] => SM-J250M
            [1] => SM-J250M
            [uuid] => 8749e640-0f73-47ec-9162-f3b1201a737d
            [2] => 8749e640-0f73-47ec-9162-f3b1201a737d
            [autorizado] => 1
            [3] => 1
            [fecha_hora_solicitud] => 8:10:35 20-7-2019
            [4] => 8:10:35 20-7-2019
            [comentarios] => Cambio de pantalla
            [5] => Cambio de pantalla
        )

)
         */
        
        /*retornamos solo esto: la posicion sero del array solo deberia de haber una coincidencia por id
         * 
         * 
                [id] => 82
                [0] => 82
                [modelo_movil] => SM-J250M
                [1] => SM-J250M
                [uuid] => 8749e640-0f73-47ec-9162-f3b1201a737d
                [2] => 8749e640-0f73-47ec-9162-f3b1201a737d
                [autorizado] => 1
                [3] => 1
                [fecha_hora_solicitud] => 8:10:35 20-7-2019
                [4] => 8:10:35 20-7-2019
                [comentarios] => Cambio de pantalla
                [5] => Cambio de pantalla
            
         */
        
        return $resultado[0];
        
        
    }
    
    public function dispositivos_eliminarDispositivoId($id){
        $this->conexion->prepare(
                "DELETE FROM dispositivos WHERE id='$id'"                    
                )->execute();
        
    }
    
    public function dispositivos_actualizarDispositivoId($id,$autorizado,$comentarios){
        $this->conexion->prepare(
                "UPDATE dispositivos SET"
                . " autorizado='$autorizado',"
                . " comentarios='$comentarios'"
                . " WHERE id='$id'"                    
                )->execute();
        
    }
    
    
    
    

    public function usuarios_app_kaliope_verificarUsuarioPassword($usuario, $password) {

        $consultaUsuarios = $this->conexion->prepare(
                "SELECT * FROM usuarios_app_kaliope WHERE usuario = '$usuario'"
                //consultamos si en la tabla ya hay un numero uuid que concuerde
        );
        $consultaUsuarios->execute();
        $usuarios = $consultaUsuarios->fetchAll();
        //print_r($usuarios);
        //verificamos que exista un usuario registrado en la tabla
        if (empty($usuarios)) {

            throw new Exception("No existe usuario registrado: $usuario");
        } else {
            //si existe el usuario, obtenemos su contraseña y la evaluamos
            if ($usuarios[0]['password'] == $password) {
                //echo 'contraseñaCorrecta'; //este mensaje se recibira en el onFailure que recibe un responseString
                //ahora verificamos que el usuario este autorizado

                if ($usuarios[0]['autorizado'] == 1) {
                    return true;
                } else {
                    echo "  El usuario $usuario ya no esta autorizado para conectarse al servidor. ";
                }
            } else {
                
                throw new Exception("Contraseña Incorrecta para el usuario: $usuario");
            }
        }
    }
    
    public function usuarios_app_kaliope_consultaInfoUsuarioJsonEncode($name) {
        $usuarios = $this->conexion->prepare(
                "SELECT nombre_empleado, usuario, codigo_empleado_pulsera, ruta_asignada FROM usuarios_app_kaliope WHERE usuario = '$name'"
                //consultamos si en la tabla ya hay un numero uuid que concuerde
        );
        $usuarios->execute();
        $usuarios = $usuarios->fetchAll();
        //print_r($usuarios);
        
        if(!empty($usuarios)){
            return json_encode($usuarios);
        }else{
            throw new Exception("No se encuentra informacion del usuario");
        }

        
    }
    
    public function usuarios_app_kaliope_consultaUsuarioArray($name) {
        $usuarios = $this->conexion->prepare(
                "SELECT * FROM usuarios_app_kaliope WHERE usuario = '$name'"
                //consultamos si en la tabla ya hay un numero uuid que concuerde
        );
        $usuarios->execute();
        $usuarios = $usuarios->fetchAll();
        //print_r($usuarios);
        
        if(!empty($usuarios)){
            return $usuarios[0];
        }else{
            throw new Exception("No se encuentra informacion del usuario");
        }

        
    }
    
    public function usuarios_app_kaliope_consultaNombreCompleto($name) {
        $usuarios = $this->conexion->prepare(
                "SELECT nombre_empleado FROM usuarios_app_kaliope WHERE usuario = '$name'"
                //consultamos si en la tabla ya hay un numero uuid que concuerde
        );
        $usuarios->execute();
        $usuarios = $usuarios->fetchAll();
        //print_r($usuarios);        
        
        return $usuarios[0][0];
        

        
    }
    
    public function usuarios_app_kaliope_consultaTodosLosUsuarios() {
       
        /*
         * COnsultamos todos los usuarios menos los de sin propietario que se asignaron
         * solo para poder mover los inventarios de lugar, en realidad no son usuarios sino que ayudan en el area administrativa de los inventarios
         * usuario!= SinPropietario1 AND usuario!=SinPropietario2 AND usuario!=SinPropietario3 AND usuario!=SinPropietario4
         */
        $usuarios = $this->conexion->prepare(
                "SELECT * FROM usuarios_app_kaliope ORDER BY usuario ASC"
                //consultamos si en la tabla ya hay un numero uuid que concuerde
        );
        $usuarios->execute();
        $usuarios = $usuarios->fetchAll();
        //print_r($usuarios);
        
        if(!empty($usuarios)){
            return $usuarios;
        }else{
            throw new Exception("No se encuentra informacion del usuario");
        }

        
    }    
    
    public function usuarios_app_kaliope_consultaTodosLosUsuariosMenosSinPropietario() {
       
        /*
         * COnsultamos todos los usuarios menos los de sin propietario que se asignaron
         * solo para poder mover los inventarios de lugar, en realidad no son usuarios sino que ayudan en el area administrativa de los inventarios
         * usuario!= SinPropietario1 AND usuario!=SinPropietario2 AND usuario!=SinPropietario3 AND usuario!=SinPropietario4
         */
        $usuarios = $this->conexion->prepare(
                "SELECT * FROM usuarios_app_kaliope WHERE usuario!= 'SinPropietario1' AND usuario!='SinPropietario2' AND usuario!='SinPropietario3' AND usuario!='SinPropietario4' ORDER BY ruta_asignada ASC"
                //consultamos si en la tabla ya hay un numero uuid que concuerde
        );
        $usuarios->execute();
        $usuarios = $usuarios->fetchAll();
        //print_r($usuarios);
        
        if(!empty($usuarios)){
            return $usuarios;
        }else{
            throw new Exception("No se encuentra informacion del usuario");
        }

        
    }
    
    public function usuarios_app_kaliope_obtenerRutaAsignadaUsuario($name) {
        $rutaAsignada = $this->conexion->prepare(
                "SELECT ruta_asignada FROM usuarios_app_kaliope WHERE usuario = '$name'"
                //consultamos si en la tabla ya hay un numero uuid que concuerde
        );
        $rutaAsignada->execute();
        $rutaAsignada = $rutaAsignada->fetchAll();
        //echo $rutaAsignada[0][0];
        return $rutaAsignada[0][0];
    }
    
    public function usuarios_app_kalipe_agergarNuevoUsuario($nombreCompleto,$username, $password, $codigoPulsera, $ruta_asignada, $autorizado){
        
        /*este metodo insertara un nuevo usuario de la app kaliope
         * pero primero verificando que el nombre de usuario no este ya en uso,
         * y tambien que la ruta asignada por ejemplo A2 no este en uso por otro usuario
         * 
         */
        
        
        
        //primero verificamos si el usuario no esta en uso
        
        $consulta = $this->conexion->prepare(
                "SELECT usuario FROM usuarios_app_kaliope WHERE usuario = '$username'"
                );
        $consulta->execute();
        $existeUsuario = $consulta->fetchAll();
        
        //Consultamos que la ruta asignada no este actualmente asignada a alguien mas
        $consulta2 = $this->conexion->prepare(
                "SELECT usuario, ruta_asignada FROM usuarios_app_kaliope WHERE ruta_asignada = '$ruta_asignada'"
                );
        $consulta2->execute();
        $existeRuta = $consulta2->fetchAll();
        
        
        //validamos que el nombre del empleado tenga una logitud minima
        if(strlen($nombreCompleto)<15){
            throw new Exception("No se puede guardar <h4> El nombre completo del empleado tiene menos de 15 caracteres o esta vacio ingrese nombre con apellidos</h4>");
        }
        
         if(strlen($username)<3){
            throw new Exception("No se puede guardar <h4>el nombre de usuario tiene menos de 3 caracteres o esta vacio</h4>");
        }
        
        if(strlen($password)<3){
            throw new Exception("No se puede guardar <h4>Password tiene menos de 3 caracteres o esta vacio</h4>");
        }
        
        if(strlen($codigoPulsera)<3){
            throw new Exception("No se puede guardar <h4>el codigo de pulcera tiene menos de 3 caracteres o esta vacio</h4>");
        }
        
        
        
        //validamos que el autorizado este entre 1 y 0 y sea numerico
        if(is_numeric($autorizado)){
            if ($autorizado != 0 && $autorizado != 1) {
                throw new Exception("No se puede guardar, autorizado es diferente de 1 o 0");
            }
        }else{
            throw new Exception("No se puede guardar, autorizado es diferente de 1 o 0");
        }
        
              
        
        
        
        
        if(empty($existeUsuario)){
            //si no existe usuario con el mismo nombre
            if(empty($existeRuta)){   
                
                $insertar = $this->conexion->prepare(
                "INSERT INTO usuarios_app_kaliope (nombre_empleado, usuario,password , codigo_empleado_pulsera, ruta_asignada, autorizado) "
                . "VALUES ('$nombreCompleto', '$username','$password', '$codigoPulsera', '$ruta_asignada','$autorizado')"
                );
                $insertar->execute();  
                
                echo '<h1> Guardado Exitoso </h1>';
                
            }else{
                $us = $existeRuta[0][0];
                
                throw new Exception("La ruta $ruta_asignada esta actualmente en uso por el usuario: $us");
            }
        }else{
            
            throw new Exception("El nombre de usuario <h3> $username </h3> ya esta en uso");
        }
        
        
       
        
        
                
                
        
    }
    
    public function usuarios_app_kaliope_actualizarUsuario($nombreCompleto,$username, $password, $codigoPulsera, $ruta_asignada, $autorizado){
        
        
        
        
        
        /*este metodo Editara un usuario de la app kaliope
         * pero primero verificando que el nombre de usuario no este ya en uso,
         * y tambien que la ruta asignada por ejemplo A2 no este en uso por otro usuario
         * 
         */
        
        
        
        //Consultamos que la ruta asignada no este actualmente asignada a alguien mas pero siempre y cuando no sea la del mismo agente que estamos editando
        //porque supongamos que no modificamos el campo de la ruta, saltara la excepcion de que la ruta ya esta usada, porque claro el mismo agente la tiene asignada
        $consulta2 = $this->conexion->prepare(
                "SELECT usuario, ruta_asignada FROM usuarios_app_kaliope WHERE ruta_asignada = '$ruta_asignada' AND usuario != '$username'"
                );
        $consulta2->execute();
        $existeRuta = $consulta2->fetchAll();
        
        
        //validamos que el nombre del empleado tenga una logitud minima
        if(strlen($nombreCompleto)<15){
            throw new Exception("No se puede guardar <h4> El nombre completo del empleado tiene menos de 15 caracteres o esta vacio ingrese nombre con apellidos</h4>");
        }
        
         if(strlen($username)<3){
            throw new Exception("No se puede guardar <h4>el nombre de usuario tiene menos de 3 caracteres o esta vacio</h4>");
        }
        
        if(strlen($password)<3){
            throw new Exception("No se puede guardar <h4>Password tiene menos de 3 caracteres o esta vacio</h4>");
        }
        
        if(strlen($codigoPulsera)<3){
            throw new Exception("No se puede guardar <h4>el codigo de pulcera tiene menos de 3 caracteres o esta vacio</h4>");
        }
        
        
        
        //validamos que el autorizado este entre 1 y 0 y sea numerico
        if(is_numeric($autorizado)){
            if ($autorizado != 0 && $autorizado != 1) {
                throw new Exception("No se puede guardar, autorizado es diferente de 1 o 0");
            }
        }else{
            throw new Exception("No se puede guardar, autorizado es diferente de 1 o 0");
        }
        
              
        
        
        
        
        
            if(empty($existeRuta)){   
                
                $actualizar = $this->conexion->prepare(                
                        "UPDATE usuarios_app_kaliope SET "
                        . "nombre_empleado= '$nombreCompleto',"
                        . "password = '$password',"
                        . "codigo_empleado_pulsera= '$codigoPulsera',"
                        . "ruta_asignada= '$ruta_asignada',"
                        . "autorizado= '$autorizado'"
                        . "WHERE usuario='$username'");
                $actualizar->execute();  
                
                //echo '<h3> Guardado Exitoso </h3>';
                
            }else{
                $us = $existeRuta[0][0];
                
                throw new Exception("La ruta $ruta_asignada esta actualmente en uso por el usuario: $us");
            }
        
        
        
        
        
        
    }
    
    public function usuarios_app_kaliope_eliminarUsuario($name) {
        $rutaAsignada = $this->conexion->prepare(
                "DELETE FROM usuarios_app_kaliope WHERE usuario = '$name'"
                //consultamos si en la tabla ya hay un numero uuid que concuerde
        )->execute();
        
    }
    
    public function usuarios_app_kaliope_consultaUsuarioPorPasswordArray($password) {
        $usuarios = $this->conexion->prepare(
                "SELECT * FROM usuarios_app_kaliope WHERE password = '$password'"
        );
        $usuarios->execute();
        $usuarios = $usuarios->fetchAll();
        //print_r($usuarios);
        

        
        if(!empty($usuarios)){
            return $usuarios[0];
                    
        /*
         * (
        [id] => 24
        [0] => 24
        [nombre_empleado] => Elihu Garcia Duran
        [1] => Elihu Garcia Duran
        [usuario] => Elihu
        [2] => Elihu
        [password] => 0596
        [3] => 0596
        [codigo_empleado_pulsera] => p8346
        [4] => p8346
        [ruta_asignada] => Q4
        [5] => Q4
        [autorizado] => 1
        [6] => 1
    )
         */
        }else{
            throw new Exception("No se encuentra informacion del usuario con el password ingresado");
        }

        
    }
   
    
    
    
    
    
    
    public function movimientos_consultarCuentas($name) {
        


        $rutaAsignada = $this->usuarios_app_kaliope_obtenerRutaAsignadaUsuario($name);


        $zona = $this->nombres_zonas_getIdZonaActual($rutaAsignada);      //obtenemos la zona del dia enviando el dia en ingles
        //APARTIR DE AQUI ES COPY PASTE DEL ARCHIVO EXPORTAR DATOS DE JORGE
        //Consultamos las fechas en la base de datos para obtener la ultima fecha del movimiento
        $fechas = $this->conexion->prepare(
                "SELECT DISTINCT fecha FROM movimientos WHERE zona = '$zona'"
        );
        $fechas->execute();
        $datos_fecha = $fechas->fetchAll();
        //print_r($datos_fecha);
        //Extraemos la ultima fecha de la consulta
        $ultima_fecha = array_pop($datos_fecha);
        $ultima_fecha2 = $ultima_fecha[0];
        //echo $ultima_fecha2;
        //Solicitamos los datos que necesitamos a la bd.
        $datos_clientes = $this->conexion->prepare(
                "SELECT cuenta, nombre, telefono, dias, grado, credito, estado, latitud_fija, longitud_fija, adeudo_cargo, piezas_cargo, importe_cargo, 
        fecha_vence_cargo, puntos_disponibles, reporte_agente, reporte_administracion, mercancia_cargo ,total_pagos
        FROM movimientos WHERE zona='$zona' AND fecha='$ultima_fecha2'"
        );
        $datos_clientes->execute();
        $datos_clientes = $datos_clientes->fetchAll();
        //echo 'Longitud del array datos_clientes: '. sizeof($datos_clientes). '         ';
        //print_r( $datos_clientes);
        //esto nos retorna los movimientos de los clientes, ahora necesitamos crear el historial de pagos, lo consultamos primero
        for ($i = 0; $i < sizeof($datos_clientes); $i++) {
            //por cada cliente devuelto obtenemos su numero de cuenta para hacer la consulta del historial
            $cuentaTemporal = $datos_clientes[$i]['cuenta'];
            //echo $cuentaTemporal. '<br/>';
            //una ves obtenida la cuenta consultamos sus pagos
            $datos_ventas = $this->conexion->prepare(
                    "SELECT fecha, total_pagos, adeudo, reporte_agente FROM movimientos WHERE cuenta = '$cuentaTemporal' ORDER BY folio DESC LIMIT 5"
            );
            $datos_ventas->execute();
            $datos_ventas = $datos_ventas->fetchAll();
            //print_r($datos_ventas);
            //creamos el historial con los datos de las 5 fechas de pagos
            $historial = '';
            foreach ($datos_ventas as $datos) {
                //por cada pago de 5 fechas concatenamos el valor que tenia el historial los '*' la app kaliope los remplazara con un salto de linea para que la visualizacion a los agentes sea mas clara
                $historial .= '**' . $datos['fecha'] . '* Pago: ' . $datos['total_pagos'] . '*Saldo: ' . $datos['adeudo'] . '*Reporte: ' . $datos['reporte_agente'] . '**';
            }
            //echo $historial.'<br/>';
            //ahora ese historial lo vamos a instertar en el array devuelto de los clientes en el indice total_pagos para que ya se envie dentro del mismo array
            $datos_clientes[$i]['total_pagos'] = $historial;
            $datos_clientes[$i][17] = $historial;
        }


        //imprimimos nuevamente el array de clientes ya con el historial incluido en el ultimo index
        //echo 'Longitud del array datos_clientes: '. sizeof($datos_clientes). '         ';
        //print_r( $datos_clientes);
        //echo json_encode($datos_clientes);
        return json_encode($datos_clientes) . ',"fechaClientesConsulta":{"fecha":"' . $ultima_fecha2 . '"}';
    }           //quedara opsoleto porque solo permite trabajar con 1 rutas 21-11-2019
    public function movimientos_consultarCuentasDosRutas($name) {
        


        $rutaAsignada = $this->usuarios_app_kaliope_obtenerRutaAsignadaUsuario($name);

        $multiplesZonas = $this->nombres_zonas_getIdZonaActualDosRutas($rutaAsignada);      //obtenemos la zona del dia
        /*zona tiene esto
         * Array
            (
                [nombre] => PIEDRAS BLANCAS
                [nombre2] => SAN JUAN DEL RIO
            )
         * 
         */
        

        $arrayClientesCompletos = array();
        
        

        foreach ($multiplesZonas as $zona) {
            
            if(empty($zona)){continue; }//si la zona esta vacia saltamos al siguiente for
                

            //APARTIR DE AQUI ES COPY PASTE DEL ARCHIVO EXPORTAR DATOS DE JORGE
            //Consultamos las fechas en la base de datos para obtener la ultima fecha del movimiento
            $fechas = $this->conexion->prepare(
                    "SELECT DISTINCT fecha FROM movimientos WHERE zona = '$zona'"
            );
            $fechas->execute();
            $datos_fecha = $fechas->fetchAll();
            //print_r($datos_fecha);
            //Extraemos la ultima fecha de la consulta
            $ultima_fecha = array_pop($datos_fecha);
            $ultima_fecha2 = $ultima_fecha[0];
            //echo $ultima_fecha2;
            //Solicitamos los datos que necesitamos a la bd.
            $datos_clientes = $this->conexion->prepare(
                    "SELECT cuenta, nombre, telefono, dias, grado, credito, estado, latitud_fija, longitud_fija, adeudo_cargo, piezas_cargo, importe_cargo, 
                    fecha_vence_cargo, puntos_disponibles, reporte_agente, reporte_administracion, mercancia_cargo ,total_pagos
                    FROM movimientos WHERE zona='$zona' AND fecha='$ultima_fecha2'"
            );
            $datos_clientes->execute();
            $datos_clientes = $datos_clientes->fetchAll();
            //echo 'Longitud del array datos_clientes: '. sizeof($datos_clientes). '         ';
            //print_r( $datos_clientes);
            /*
         * Array
            (
                [0] => Array
                    (
                        [cuenta] => 1146
                        [0] => 1146
                        [nombre] => ANA LAURA JUAREZ ARELLANO
                        [1] => ANA LAURA JUAREZ ARELLANO
                        [telefono] => 55 39 60 97 72
                        [2] => 55 39 60 97 72
                        [dias] => 28
                        [3] => 28
                        [grado] => EMPRESARIA
                        [4] => EMPRESARIA
                        [credito] => 4000
                        [5] => 4000
                        [estado] => ACTIVO
                        [6] => ACTIVO
                        [latitud_fija] => 20.021389875920317
                        [7] => 20.021389875920317
                        [longitud_fija] => -99.66920361254584
                        [8] => -99.66920361254584
                        [adeudo_cargo] => 0
                        [9] => 0
                        [piezas_cargo] => 13
                        [10] => 13
                        [importe_cargo] => 2687
                        [11] => 2687
                        [fecha_vence_cargo] => 12-09-2019
                        [12] => 12-09-2019
                        [puntos_disponibles] => 0
                        [13] => 0
                        [reporte_agente] => TODO BIEN
                        [14] => TODO BIEN
                        [reporte_administracion] => 0
                        [15] => 0
                        [mercancia_cargo] => 1-159-0 1-279-0 1-159-0 4-299-239 2-309-247 1-339-271 2-369-295 1-459-376 
                        [16] => 1-159-0 1-279-0 1-159-0 4-299-239 2-309-247 1-339-271 2-369-295 1-459-376 
                        [total_pagos] => 0
                        [17] => 0
                    )

                [1] => Array
                    (
                        [cuenta] => 1148
                        [0] => 1148
                        [nombre] => MANALI FLORES
                        [1] => MANALI FLORES
                        [telefono] => 0
                        [2] => 0
                        [dias] => 28
                        [3] => 28
                        [grado] => SOCIA
                        [4] => SOCIA
                        [credito] => 1500
                        [5] => 1500
                        [estado] => ACTIVO
                        [6] => ACTIVO
                        [latitud_fija] => 19.96900203
                        [7] => 19.96900203
                        [longitud_fija] => -99.55851103
                        [8] => -99.55851103
                        [adeudo_cargo] => 241
                        [9] => 241
                        [piezas_cargo] => 0
                        [10] => 0
                        [importe_cargo] => 0
                        [11] => 0
                        [fecha_vence_cargo] => 15-08-2019
                        [12] => 15-08-2019
                        [puntos_disponibles] => 0
                        [13] => 0
                        [reporte_agente] => LIQUIDA EN 15 DIAS
                        [14] => LIQUIDA EN 15 DIAS
                        [reporte_administracion] => 0
                        [15] => 0
                        [mercancia_cargo] => 0
                        [16] => 0
                        [total_pagos] => 0
                        [17] => 0
                    )

                [2] => Array
                    (
                        [cuenta] => 1149
                        [0] => 1149
                        [nombre] => YOLANDA SANTIAGO AGUILAR
                        [1] => YOLANDA SANTIAGO AGUILAR
                        [telefono] => 0
                        [2] => 0
                        [dias] => 28
                        [3] => 28
                        [grado] => VENDEDORA
                        [4] => VENDEDORA
                        [credito] => 1400
                        [5] => 1400
                        [estado] => ACTIVO
                        [6] => ACTIVO
                        [latitud_fija] =>  20.044472
                        [7] =>  20.044472
                        [longitud_fija] => -99.655413
                        [8] => -99.655413
                        [adeudo_cargo] => 0
                        [9] => 0
                        [piezas_cargo] => 5
                        [10] => 5
                        [importe_cargo] => 1345
                        [11] => 1345
                        [fecha_vence_cargo] => 29-08-2019
                        [12] => 29-08-2019
                        [puntos_disponibles] => 100
                        [13] => 100
                        [reporte_agente] => CUENTA DE MES
                        [14] => CUENTA DE MES
                        [reporte_administracion] => 0
                        [15] => 0
                        [mercancia_cargo] => 1-329-274 1-299-249 1-309-257 1-359-299 1-319-266 
                        [16] => 1-329-274 1-299-249 1-309-257 1-359-299 1-319-266 
                        [total_pagos] => 0
                        [17] => 0
                    )

            )
         */
        
        
        
        
        
            //esto nos retorna los movimientos de los clientes, ahora necesitamos crear el historial de pagos, lo consultamos primero
            for ($i = 0; $i < sizeof($datos_clientes); $i++) {
                //por cada cliente devuelto obtenemos su numero de cuenta para hacer la consulta del historial
                $cuentaTemporal = $datos_clientes[$i]['cuenta'];
                //echo $cuentaTemporal. '<br/>';
                //una ves obtenida la cuenta consultamos sus pagos
                $datos_ventas = $this->conexion->prepare(
                        "SELECT fecha, total_pagos, adeudo, reporte_agente FROM movimientos WHERE cuenta = '$cuentaTemporal' ORDER BY folio DESC LIMIT 5"
                );
                $datos_ventas->execute();
                $datos_ventas = $datos_ventas->fetchAll();
                //print_r($datos_ventas);
                /*
             * Array
            (
                [0] => Array
                    (
                        [fecha] => 29-08-2019
                        [0] => 29-08-2019
                        [total_pagos] => 0
                        [1] => 0
                        [adeudo] => 0
                        [2] => 0
                        [reporte_agente] => TODO BIEN
                        [3] => TODO BIEN
                    )

                [1] => Array
                    (
                        [fecha] => 15-08-2019
                        [0] => 15-08-2019
                        [total_pagos] => 3099
                        [1] => 3099
                        [adeudo] => 0
                        [2] => 0
                        [reporte_agente] => TODO BIEN
                        [3] => TODO BIEN
                    )

                [2] => Array
                    (
                        [fecha] => 01-08-2019
                        [0] => 01-08-2019
                        [total_pagos] => 0
                        [1] => 0
                        [adeudo] => 0
                        [2] => 0
                        [reporte_agente] => CUENTA DE MES
                        [3] => CUENTA DE MES
                    )
                
            )
             */
                //creamos el historial con los datos de las 5 fechas de pagos
                $historial = '';
                
                foreach ($datos_ventas as $datos) {
                    //por cada pago de 5 fechas concatenamos el valor que tenia el historial los '*' la app kaliope los remplazara con un salto de linea para que la visualizacion a los agentes sea mas clara
                    $historial .= '**' . $datos['fecha'] . '* Pago: ' . $datos['total_pagos'] . '*Saldo: ' . $datos['adeudo'] . '*Reporte: ' . $datos['reporte_agente'] . '**';
                }
                //echo $historial.'<br/>';
                //**29-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****15-08-2019* Pago: 3099*Saldo: 0*Reporte: TODO BIEN****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 2700*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES**<br/>Array
                //ahora ese historial lo vamos a instertar en el array devuelto de los clientes en el indice total_pagos para que ya se envie dentro del mismo array
                $datos_clientes[$i]['total_pagos'] = $historial;
                $datos_clientes[$i][17] = $historial;
                //print_r($datos_clientes);
                /*
             * Array
                    (
                        [0] => Array
                            (
                                [cuenta] => 1146
                                [0] => 1146
                                [nombre] => ANA LAURA JUAREZ ARELLANO
                                [1] => ANA LAURA JUAREZ ARELLANO
                                [telefono] => 55 39 60 97 72
                                [2] => 55 39 60 97 72
                                [dias] => 28
                                [3] => 28
                                [grado] => EMPRESARIA
                                [4] => EMPRESARIA
                                [credito] => 4000
                                [5] => 4000
                                [estado] => ACTIVO
                                [6] => ACTIVO
                                [latitud_fija] => 20.021389875920317
                                [7] => 20.021389875920317
                                [longitud_fija] => -99.66920361254584
                                [8] => -99.66920361254584
                                [adeudo_cargo] => 0
                                [9] => 0
                                [piezas_cargo] => 13
                                [10] => 13
                                [importe_cargo] => 2687
                                [11] => 2687
                                [fecha_vence_cargo] => 12-09-2019
                                [12] => 12-09-2019
                                [puntos_disponibles] => 0
                                [13] => 0
                                [reporte_agente] => TODO BIEN
                                [14] => TODO BIEN
                                [reporte_administracion] => 0
                                [15] => 0
                                [mercancia_cargo] => 1-159-0 1-279-0 1-159-0 4-299-239 2-309-247 1-339-271 2-369-295 1-459-376 
                                [16] => 1-159-0 1-279-0 1-159-0 4-299-239 2-309-247 1-339-271 2-369-295 1-459-376 
                                [total_pagos] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****15-08-2019* Pago: 3099*Saldo: 0*Reporte: TODO BIEN****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 2700*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES**
                                [17] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****15-08-2019* Pago: 3099*Saldo: 0*Reporte: TODO BIEN****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 2700*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES**
                            )

                        [1] => Array
                            (
                                [cuenta] => 1148
                                [0] => 1148
                                [nombre] => MANALI FLORES
                                [1] => MANALI FLORES
                                [telefono] => 0
                                [2] => 0
                                [dias] => 28
                                [3] => 28
                                [grado] => SOCIA
                                [4] => SOCIA
                                [credito] => 1500
                                [5] => 1500
                                [estado] => ACTIVO
                                [6] => ACTIVO
                                [latitud_fija] => 19.96900203
                                [7] => 19.96900203
                                [longitud_fija] => -99.55851103
                                [8] => -99.55851103
                                [adeudo_cargo] => 241
                                [9] => 241
                                [piezas_cargo] => 0
                                [10] => 0
                                [importe_cargo] => 0
                                [11] => 0
                                [fecha_vence_cargo] => 15-08-2019
                                [12] => 15-08-2019
                                [puntos_disponibles] => 0
                                [13] => 0
                                [reporte_agente] => LIQUIDA EN 15 DIAS
                                [14] => LIQUIDA EN 15 DIAS
                                [reporte_administracion] => 0
                                [15] => 0
                                [mercancia_cargo] => 0
                                [16] => 0
                                [total_pagos] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: LIQUIDA EN 15 DIAS****15-08-2019* Pago: 200*Saldo: 241*Reporte: LIQUIDA EN 15 DIAS****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 77*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 250*Saldo: 77*Reporte: LIQUIDA EN 15 DIAS**
                                [17] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: LIQUIDA EN 15 DIAS****15-08-2019* Pago: 200*Saldo: 241*Reporte: LIQUIDA EN 15 DIAS****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 77*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 250*Saldo: 77*Reporte: LIQUIDA EN 15 DIAS**
                            )

                        [2] => Array
                            (
                                [cuenta] => 1149
                                [0] => 1149
                                [nombre] => YOLANDA SANTIAGO AGUILAR
                                [1] => YOLANDA SANTIAGO AGUILAR
                                [telefono] => 0
                                [2] => 0
                                [dias] => 28
                                [3] => 28
                                [grado] => VENDEDORA
                                [4] => VENDEDORA
                                [credito] => 1400
                                [5] => 1400
                                [estado] => ACTIVO
                                [6] => ACTIVO
                                [latitud_fija] =>  20.044472
                                [7] =>  20.044472
                                [longitud_fija] => -99.655413
                                [8] => -99.655413
                                [adeudo_cargo] => 0
                                [9] => 0
                                [piezas_cargo] => 5
                                [10] => 5
                                [importe_cargo] => 1345
                                [11] => 1345
                                [fecha_vence_cargo] => 29-08-2019
                                [12] => 29-08-2019
                                [puntos_disponibles] => 100
                                [13] => 100
                                [reporte_agente] => CUENTA DE MES
                                [14] => CUENTA DE MES
                                [reporte_administracion] => 0
                                [15] => 0
                                [mercancia_cargo] => 1-329-274 1-299-249 1-309-257 1-359-299 1-319-266 
                                [16] => 1-329-274 1-299-249 1-309-257 1-359-299 1-319-266 
                                [total_pagos] => 0
                                [17] => 0
                            )

                    )
             */
            }


            //imprimimos nuevamente el array de clientes ya con el historial incluido en el ultimo index
            //echo 'Longitud del array datos_clientes: '. sizeof($datos_clientes). '         ';
            //print_r( $datos_clientes);
            /*
         * Array
            (
                [0] => Array
                    (
                        [cuenta] => 1146
                        [0] => 1146
                        [nombre] => ANA LAURA JUAREZ ARELLANO
                        [1] => ANA LAURA JUAREZ ARELLANO
                        [telefono] => 55 39 60 97 72
                        [2] => 55 39 60 97 72
                        [dias] => 28
                        [3] => 28
                        [grado] => EMPRESARIA
                        [4] => EMPRESARIA
                        [credito] => 4000
                        [5] => 4000
                        [estado] => ACTIVO
                        [6] => ACTIVO
                        [latitud_fija] => 20.021389875920317
                        [7] => 20.021389875920317
                        [longitud_fija] => -99.66920361254584
                        [8] => -99.66920361254584
                        [adeudo_cargo] => 0
                        [9] => 0
                        [piezas_cargo] => 13
                        [10] => 13
                        [importe_cargo] => 2687
                        [11] => 2687
                        [fecha_vence_cargo] => 12-09-2019
                        [12] => 12-09-2019
                        [puntos_disponibles] => 0
                        [13] => 0
                        [reporte_agente] => TODO BIEN
                        [14] => TODO BIEN
                        [reporte_administracion] => 0
                        [15] => 0
                        [mercancia_cargo] => 1-159-0 1-279-0 1-159-0 4-299-239 2-309-247 1-339-271 2-369-295 1-459-376 
                        [16] => 1-159-0 1-279-0 1-159-0 4-299-239 2-309-247 1-339-271 2-369-295 1-459-376 
                        [total_pagos] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****15-08-2019* Pago: 3099*Saldo: 0*Reporte: TODO BIEN****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 2700*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES**
                        [17] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****15-08-2019* Pago: 3099*Saldo: 0*Reporte: TODO BIEN****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 2700*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES**
                    )

                [1] => Array
                    (
                        [cuenta] => 1148
                        [0] => 1148
                        [nombre] => MANALI FLORES
                        [1] => MANALI FLORES
                        [telefono] => 0
                        [2] => 0
                        [dias] => 28
                        [3] => 28
                        [grado] => SOCIA
                        [4] => SOCIA
                        [credito] => 1500
                        [5] => 1500
                        [estado] => ACTIVO
                        [6] => ACTIVO
                        [latitud_fija] => 19.96900203
                        [7] => 19.96900203
                        [longitud_fija] => -99.55851103
                        [8] => -99.55851103
                        [adeudo_cargo] => 241
                        [9] => 241
                        [piezas_cargo] => 0
                        [10] => 0
                        [importe_cargo] => 0
                        [11] => 0
                        [fecha_vence_cargo] => 15-08-2019
                        [12] => 15-08-2019
                        [puntos_disponibles] => 0
                        [13] => 0
                        [reporte_agente] => LIQUIDA EN 15 DIAS
                        [14] => LIQUIDA EN 15 DIAS
                        [reporte_administracion] => 0
                        [15] => 0
                        [mercancia_cargo] => 0
                        [16] => 0
                        [total_pagos] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: LIQUIDA EN 15 DIAS****15-08-2019* Pago: 200*Saldo: 241*Reporte: LIQUIDA EN 15 DIAS****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 77*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 250*Saldo: 77*Reporte: LIQUIDA EN 15 DIAS**
                        [17] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: LIQUIDA EN 15 DIAS****15-08-2019* Pago: 200*Saldo: 241*Reporte: LIQUIDA EN 15 DIAS****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 77*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 250*Saldo: 77*Reporte: LIQUIDA EN 15 DIAS**
                    )

                [2] => Array
                    (
                        [cuenta] => 1149
                        [0] => 1149
                        [nombre] => YOLANDA SANTIAGO AGUILAR
                        [1] => YOLANDA SANTIAGO AGUILAR
                        [telefono] => 0
                        [2] => 0
                        [dias] => 28
                        [3] => 28
                        [grado] => VENDEDORA
                        [4] => VENDEDORA
                        [credito] => 1400
                        [5] => 1400
                        [estado] => ACTIVO
                        [6] => ACTIVO
                        [latitud_fija] =>  20.044472
                        [7] =>  20.044472
                        [longitud_fija] => -99.655413
                        [8] => -99.655413
                        [adeudo_cargo] => 0
                        [9] => 0
                        [piezas_cargo] => 5
                        [10] => 5
                        [importe_cargo] => 1345
                        [11] => 1345
                        [fecha_vence_cargo] => 29-08-2019
                        [12] => 29-08-2019
                        [puntos_disponibles] => 100
                        [13] => 100
                        [reporte_agente] => CUENTA DE MES
                        [14] => CUENTA DE MES
                        [reporte_administracion] => 0
                        [15] => 0
                        [mercancia_cargo] => 1-329-274 1-299-249 1-309-257 1-359-299 1-319-266 
                        [16] => 1-329-274 1-299-249 1-309-257 1-359-299 1-319-266 
                        [total_pagos] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****15-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****01-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****18-07-2019* Pago: 0*Saldo: 0*Reporte: NO ESTUBO PASA 2 VECES, PERO DICE HIJO QUE NO ESTABA****04-07-2019* Pago: 0*Saldo: 0*Reporte: NO ESTUBO PASA 2 VECES DICEN VECINOS QUE NO ABRIO**
                        [17] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****15-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****01-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****18-07-2019* Pago: 0*Saldo: 0*Reporte: NO ESTUBO PASA 2 VECES, PERO DICE HIJO QUE NO ESTABA****04-07-2019* Pago: 0*Saldo: 0*Reporte: NO ESTUBO PASA 2 VECES DICEN VECINOS QUE NO ABRIO**
                    )
          )
         */
        
        
        
        
            //guardamos en el array los clientes de la zona 1, y despues al siguiente bloque se guardaran los de la zona 2
            $arrayTemporal = array (
                "zona" => $zona,
                "clientes"=> $datos_clientes,
                "fechaClientesConsulta"=>$ultima_fecha2
            );
        
            array_push($arrayClientesCompletos, $arrayTemporal);
        }
        
        
        
        
        
        //print_r($arrayClientesCompletos);
        /*
         * Array
            (
                [0] => Array
                    (
                        [zona] => CANALEJAS
                        [clientes] => Array
                            (
                                [0] => Array
                                    (
                                        [cuenta] => 1146
                                        [0] => 1146
                                        [nombre] => ANA LAURA JUAREZ ARELLANO
                                        [1] => ANA LAURA JUAREZ ARELLANO
                                        [telefono] => 55 39 60 97 72
                                        [2] => 55 39 60 97 72
                                        [dias] => 28
                                        [3] => 28
                                        [grado] => EMPRESARIA
                                        [4] => EMPRESARIA
                                        [credito] => 4000
                                        [5] => 4000
                                        [estado] => ACTIVO
                                        [6] => ACTIVO
                                        [latitud_fija] => 20.021389875920317
                                        [7] => 20.021389875920317
                                        [longitud_fija] => -99.66920361254584
                                        [8] => -99.66920361254584
                                        [adeudo_cargo] => 0
                                        [9] => 0
                                        [piezas_cargo] => 13
                                        [10] => 13
                                        [importe_cargo] => 2687
                                        [11] => 2687
                                        [fecha_vence_cargo] => 12-09-2019
                                        [12] => 12-09-2019
                                        [puntos_disponibles] => 0
                                        [13] => 0
                                        [reporte_agente] => TODO BIEN
                                        [14] => TODO BIEN
                                        [reporte_administracion] => 0
                                        [15] => 0
                                        [mercancia_cargo] => 1-159-0 1-279-0 1-159-0 4-299-239 2-309-247 1-339-271 2-369-295 1-459-376 
                                        [16] => 1-159-0 1-279-0 1-159-0 4-299-239 2-309-247 1-339-271 2-369-295 1-459-376 
                                        [total_pagos] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****15-08-2019* Pago: 3099*Saldo: 0*Reporte: TODO BIEN****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 2700*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES**
                                        [17] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****15-08-2019* Pago: 3099*Saldo: 0*Reporte: TODO BIEN****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 2700*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES**
                                    )

                                [1] => Array
                                    (
                                        [cuenta] => 1148
                                        [0] => 1148
                                        [nombre] => MANALI FLORES
                                        [1] => MANALI FLORES
                                        [telefono] => 0
                                        [2] => 0
                                        [dias] => 28
                                        [3] => 28
                                        [grado] => SOCIA
                                        [4] => SOCIA
                                        [credito] => 1500
                                        [5] => 1500
                                        [estado] => ACTIVO
                                        [6] => ACTIVO
                                        [latitud_fija] => 19.96900203
                                        [7] => 19.96900203
                                        [longitud_fija] => -99.55851103
                                        [8] => -99.55851103
                                        [adeudo_cargo] => 241
                                        [9] => 241
                                        [piezas_cargo] => 0
                                        [10] => 0
                                        [importe_cargo] => 0
                                        [11] => 0
                                        [fecha_vence_cargo] => 15-08-2019
                                        [12] => 15-08-2019
                                        [puntos_disponibles] => 0
                                        [13] => 0
                                        [reporte_agente] => LIQUIDA EN 15 DIAS
                                        [14] => LIQUIDA EN 15 DIAS
                                        [reporte_administracion] => 0
                                        [15] => 0
                                        [mercancia_cargo] => 0
                                        [16] => 0
                                        [total_pagos] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: LIQUIDA EN 15 DIAS****15-08-2019* Pago: 200*Saldo: 241*Reporte: LIQUIDA EN 15 DIAS****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 77*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 250*Saldo: 77*Reporte: LIQUIDA EN 15 DIAS**
                                        [17] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: LIQUIDA EN 15 DIAS****15-08-2019* Pago: 200*Saldo: 241*Reporte: LIQUIDA EN 15 DIAS****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 77*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 250*Saldo: 77*Reporte: LIQUIDA EN 15 DIAS**
                                    )

                                [2] => Array
                                    (
                                        [cuenta] => 1149
                                        [0] => 1149
                                        [nombre] => YOLANDA SANTIAGO AGUILAR
                                        [1] => YOLANDA SANTIAGO AGUILAR
                                        [telefono] => 0
                                        [2] => 0
                                        [dias] => 28
                                        [3] => 28
                                        [grado] => VENDEDORA
                                        [4] => VENDEDORA
                                        [credito] => 1400
                                        [5] => 1400
                                        [estado] => ACTIVO
                                        [6] => ACTIVO
                                        [latitud_fija] =>  20.044472
                                        [7] =>  20.044472
                                        [longitud_fija] => -99.655413
                                        [8] => -99.655413
                                        [adeudo_cargo] => 0
                                        [9] => 0
                                        [piezas_cargo] => 5
                                        [10] => 5
                                        [importe_cargo] => 1345
                                        [11] => 1345
                                        [fecha_vence_cargo] => 29-08-2019
                                        [12] => 29-08-2019
                                        [puntos_disponibles] => 100
                                        [13] => 100
                                        [reporte_agente] => CUENTA DE MES
                                        [14] => CUENTA DE MES
                                        [reporte_administracion] => 0
                                        [15] => 0
                                        [mercancia_cargo] => 1-329-274 1-299-249 1-309-257 1-359-299 1-319-266 
                                        [16] => 1-329-274 1-299-249 1-309-257 1-359-299 1-319-266 
                                        [total_pagos] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****15-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****01-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****18-07-2019* Pago: 0*Saldo: 0*Reporte: NO ESTUBO PASA 2 VECES, PERO DICE HIJO QUE NO ESTABA****04-07-2019* Pago: 0*Saldo: 0*Reporte: NO ESTUBO PASA 2 VECES DICEN VECINOS QUE NO ABRIO**
                                        [17] => **29-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****15-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****01-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****18-07-2019* Pago: 0*Saldo: 0*Reporte: NO ESTUBO PASA 2 VECES, PERO DICE HIJO QUE NO ESTABA****04-07-2019* Pago: 0*Saldo: 0*Reporte: NO ESTUBO PASA 2 VECES DICEN VECINOS QUE NO ABRIO**
                                    )

                            )

                        [fechaClientesConsulta] => 29-08-2019
                    )

                [1] => Array
                    (
                        [zona] => SAN JUAN DEL RIO
                        [clientes] => Array
                            (
                                [0] => Array
                                    (
                                        [cuenta] => 2170
                                        [0] => 2170
                                        [nombre] => MARIA ISABEL PICHARDO CAMACHO
                                        [1] => MARIA ISABEL PICHARDO CAMACHO
                                        [telefono] => 427 103 42 23
                                        [2] => 427 103 42 23
                                        [dias] => 14
                                        [3] => 14
                                        [grado] => EMPRESARIA
                                        [4] => EMPRESARIA
                                        [credito] => 2500
                                        [5] => 2500
                                        [estado] => ACTIVO
                                        [6] => ACTIVO
                                        [latitud_fija] => 20.33718862282818
                                        [7] => 20.33718862282818
                                        [longitud_fija] => -99.94939814772276
                                        [8] => -99.94939814772276
                                        [adeudo_cargo] => 0
                                        [9] => 0
                                        [piezas_cargo] => 10
                                        [10] => 10
                                        [importe_cargo] => 2343
                                        [11] => 2343
                                        [fecha_vence_cargo] => 27-08-2019
                                        [12] => 27-08-2019
                                        [puntos_disponibles] => 50
                                        [13] => 50
                                        [reporte_agente] => TODO BIEN
                                        [14] => TODO BIEN
                                        [reporte_administracion] => 0
                                        [15] => 0
                                        [mercancia_cargo] => 1-259-207 2-299-239 1-329-263 1-339-271 3-399-319 1-279-0 1-209-167 
                                        [16] => 1-259-207 2-299-239 1-329-263 1-339-271 3-399-319 1-279-0 1-209-167 
                                        [total_pagos] => **27-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****13-08-2019* Pago: 529*Saldo: 0*Reporte: TODO BIEN****30-07-2019* Pago: 1123*Saldo: 0*Reporte: TODO BIEN****16-07-2019* Pago: 1050*Saldo: 2*Reporte: TODO BIEN****02-07-2019* Pago: 813*Saldo: 0*Reporte: TODO BIEN**
                                        [17] => **27-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****13-08-2019* Pago: 529*Saldo: 0*Reporte: TODO BIEN****30-07-2019* Pago: 1123*Saldo: 0*Reporte: TODO BIEN****16-07-2019* Pago: 1050*Saldo: 2*Reporte: TODO BIEN****02-07-2019* Pago: 813*Saldo: 0*Reporte: TODO BIEN**
                                    )

                                [1] => Array
                                    (
                                        [cuenta] => 2172
                                        [0] => 2172
                                        [nombre] => EZPERANZA MARCELO SINECIO
                                        [1] => EZPERANZA MARCELO SINECIO
                                        [telefono] => 427 593 34 01
                                        [2] => 427 593 34 01
                                        [dias] => 28
                                        [3] => 28
                                        [grado] => EMPRESARIA
                                        [4] => EMPRESARIA
                                        [credito] => 2500
                                        [5] => 2500
                                        [estado] => REACTIVAR
                                        [6] => REACTIVAR
                                        [latitud_fija] => 20.4379060153793
                                        [7] => 20.4379060153793
                                        [longitud_fija] => -99.94742208072816
                                        [8] => -99.94742208072816
                                        [adeudo_cargo] => 0
                                        [9] => 0
                                        [piezas_cargo] => 0
                                        [10] => 0
                                        [importe_cargo] => 0
                                        [11] => 0
                                        [fecha_vence_cargo] => 13-08-2019
                                        [12] => 13-08-2019
                                        [puntos_disponibles] => 300
                                        [13] => 300
                                        [reporte_agente] => REACTIVAR EN 15 DIAS
                                        [14] => REACTIVAR EN 15 DIAS
                                        [reporte_administracion] => 0
                                        [15] => 0
                                        [mercancia_cargo] => 0
                                        [16] => 0
                                        [total_pagos] => **27-08-2019* Pago: 0*Saldo: 0*Reporte: REACTIVAR EN 15 DIAS****13-08-2019* Pago: 1396*Saldo: 0*Reporte: REACTIVAR EN 15 DIAS****30-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****16-07-2019* Pago: 822*Saldo: 0*Reporte: TODO BIEN****02-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES**
                                        [17] => **27-08-2019* Pago: 0*Saldo: 0*Reporte: REACTIVAR EN 15 DIAS****13-08-2019* Pago: 1396*Saldo: 0*Reporte: REACTIVAR EN 15 DIAS****30-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****16-07-2019* Pago: 822*Saldo: 0*Reporte: TODO BIEN****02-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES**
                                    )

                                [2] => Array
                                    (
                                        [cuenta] => 2174
                                        [0] => 2174
                                        [nombre] => ANA LAURA MENDOZA SUAREZ
                                        [1] => ANA LAURA MENDOZA SUAREZ
                                        [telefono] => 266 61 72
                                        [2] => 266 61 72
                                        [dias] => 14
                                        [3] => 14
                                        [grado] => SOCIA
                                        [4] => SOCIA
                                        [credito] => 2400
                                        [5] => 2400
                                        [estado] => ACTIVO
                                        [6] => ACTIVO
                                        [latitud_fija] => 20.439199939147645
                                        [7] => 20.439199939147645
                                        [longitud_fija] => -99.89563303688809
                                        [8] => -99.89563303688809
                                        [adeudo_cargo] => 0
                                        [9] => 0
                                        [piezas_cargo] => 9
                                        [10] => 9
                                        [importe_cargo] => 1968
                                        [11] => 1968
                                        [fecha_vence_cargo] => 27-08-2019
                                        [12] => 27-08-2019
                                        [puntos_disponibles] => 350
                                        [13] => 350
                                        [reporte_agente] => TODO BIEN
                                        [14] => TODO BIEN
                                        [reporte_administracion] => 0
                                        [15] => 0
                                        [mercancia_cargo] => 2-159-118 2-209-171 2-279-229 1-339-278 2-399-327 
                                        [16] => 2-159-118 2-209-171 2-279-229 1-339-278 2-399-327 
                                        [total_pagos] => **27-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****13-08-2019* Pago: 1145*Saldo: 0*Reporte: TODO BIEN****30-07-2019* Pago: 800*Saldo: 1145*Reporte: LIQUIDA EN 15 DIAS****16-07-2019* Pago: 850*Saldo: 0*Reporte: TODO BIEN****02-07-2019* Pago: 0*Saldo: 0*Reporte: QUE SU SUEGRA ESTA ENFERMA Y LA ESTA ATENDIENDO DICE MAMA QUE NO DEJO DINERO SE DEJA RECADO**
                                        [17] => **27-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****13-08-2019* Pago: 1145*Saldo: 0*Reporte: TODO BIEN****30-07-2019* Pago: 800*Saldo: 1145*Reporte: LIQUIDA EN 15 DIAS****16-07-2019* Pago: 850*Saldo: 0*Reporte: TODO BIEN****02-07-2019* Pago: 0*Saldo: 0*Reporte: QUE SU SUEGRA ESTA ENFERMA Y LA ESTA ATENDIENDO DICE MAMA QUE NO DEJO DINERO SE DEJA RECADO**
                                   )

                            )

                        [fechaClientesConsulta] => 27-08-2019
                    )

            )
         * 
         */   
        
        
        return json_encode($arrayClientesCompletos);
        //return json_encode($datos_clientes) . ',"fechaClientesConsulta":{"fecha":"' . $ultima_fecha2 . '"}';
        /*
         * 	
            0	
                    zona	"CANALEJAS"
                    clientes	
                        0	
                            0	"1146"
                            1	"ANA LAURA JUAREZ ARELLANO"
                            2	"55 39 60 97 72"
                            3	"28"
                            4	"EMPRESARIA"
                            5	"4000"
                            6	"ACTIVO"
                            7	"20.021389875920317"
                            8	"-99.66920361254584"
                            9	"0"
                            10	"13"
                            11	"2687"
                            12	"12-09-2019"
                            13	"0"
                            14	"TODO BIEN"
                            15	"0"
                            16	"1-159-0 1-279-0 1-159-0 4-299-239 2-309-247 1-339-271 2-369-295 1-459-376 "
                            17	"**29-08-2019* Pago: 0*Saldo: 0*Reporte: TODO BIEN****15-08-2019* Pago: 3099*Saldo: 0*Reporte: TODO BIEN****01-08-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES****18-07-2019* Pago: 2700*Saldo: 0*Reporte: TODO BIEN****04-07-2019* Pago: 0*Saldo: 0*Reporte: CUENTA DE MES**"
                            cuenta	"1146"
                            nombre	"ANA LAURA JUAREZ ARELLANO"
                            telefono	"55 39 60 97 72"
                            dias	"28"
                            grado	"EMPRESARIA"
                            credito	"4000"
                            estado	"ACTIVO"
                            latitud_fija	"20.021389875920317"
                            longitud_fija	"-99.66920361254584"
                            adeudo_cargo	"0"
                            piezas_cargo	"13"
                            importe_cargo	"2687"
                            fecha_vence_cargo	"12-09-2019"
                            puntos_disponibles	"0"
                            reporte_agente	"TODO BIEN"
                            reporte_administracion	"0"
                            mercancia_cargo	"1-159-0 1-279-0 1-159-0 4-299-239 2-309-247 1-339-271 2-369-295 1-459-376 "
                            total_pagos "**29-08-2019* Pago: 0*Sa…eporte: CUENTA DE MES**"
                        1	{…}
                        2	{…}
                        3	{…}
                        4	{…}
                        5	{…}
                        6	{…}
                        7	{…}
                        8	{…}
                        9	{…}
                        10	{…}
                        11	{…}
                        12	{…}
                        13	{…}
                    fechaClientesConsulta	"29-08-2019"
            1	
                    zona	"SAN JUAN DEL RIO"
                    clientes	
                        0	{…}
                        1	{…}
                        2	{…}
                        3	{…}
                        4	{…}
                        5	{…}
                        6	{…}
                        7	{…}
                        8	{…}
                        9	{…}
                        10	{…}
                        11	{…}
                        12	{…}
                        13	{…}
                    fechaClientesConsulta	"27-08-2019"
         */
        
    } 
    
    
    
    public function zonificacion_getZonificacion($name) {
        /*Obtenemos la zonificacion, que son las ccordenadas del perimetro
         * para esto solo es necesario el 
         * nombre de usuario, para saber que zona tiene asignada
         * por ejemplo A1, una vez obtenido esto se llama al metodo getIdZonaActual
         * el cual internamente averigua que dia es, y tambien que numero de semana
         * para retornar el nombre de la zona y consultarlo en la tabla de zonificacion
         * y retornamos el resultado con formato de JsonObjet
         */
        
        
        

        $rutaAsignada = $this->usuarios_app_kaliope_obtenerRutaAsignadaUsuario($name);
        $zona = $this->nombres_zonas_getIdZonaActual($rutaAsignada); //llamamos al metodo enviandole la ruta asignada que tenia el usuario por ejemplo A1
        
        
        

        $polilinea = $this->conexion->prepare(
                "SELECT coordenadas FROM zonificacion WHERE zona = '$zona'"
        );
        $polilinea->execute();
        $polilinea = $polilinea->fetchAll();


        if (!empty($polilinea)) {
            $coordenadas = trim($polilinea[0][0]);            //cortamos los espacios en blanco al inicio y final de la cadena
            return '{"zona":"' . $zona . '","zonificacion":"' . $coordenadas . '"}';
        } else {
            throw new Exception("No se encuentra zonificacion");
        }
    }           //quedara opsoleto porque solo permite trabajar con 1 rutas 21-11-2019
    public function zonificacion_getZonificacionDosRutas($name) {
        /*Obtenemos la zonificacion, que son las ccordenadas del perimetro
         * para esto solo es necesario el 
         * nombre de usuario, para saber que zona tiene asignada
         * por ejemplo A1, una vez obtenido esto se llama al metodo getIdZonaActual
         * el cual internamente averigua que dia es, y tambien que numero de semana
         * para retornar el nombre de la zona y consultarlo en la tabla de zonificacion
         * y retornamos el resultado con formato de JsonObjet
         */
        
        
        

        $rutaAsignada = $this->usuarios_app_kaliope_obtenerRutaAsignadaUsuario($name);
        $zona = $this->nombres_zonas_getIdZonaActualDosRutas($rutaAsignada); //llamamos al metodo enviandole la ruta asignada que tenia el usuario por ejemplo A1
        /*zona tiene esto
         * Array
            (
                [nombre] => PIEDRAS BLANCAS
                [nombre2] => SAN JUAN DEL RIO
            )
         * 
         */
        
        
       
        $arrayZonificaciones = array();
            
        foreach ($zona as $value) {
            
            if(!empty($value)){
                
                //primero obenemos las coordenadas que trazaran la polilinea en el telefono
                $polilinea = $this->conexion->prepare(
                        "SELECT coordenadas FROM zonificacion WHERE zona = '$value'"
                );
                $polilinea->execute();
                $polilinea = $polilinea->fetchAll();
                
                if (empty($polilinea)) {
                    throw new Exception("No se encuentra zonificacion");
                }
                
                $coordenadas = trim($polilinea[0][0]);            //cortamos los espacios en blanco al inicio y final de la cadena
                $arraytemporal = array(
                    "zona" => $value,
                    "zonificacion" => $coordenadas
                );
                array_push($arrayZonificaciones, $arraytemporal);
                                
            }
            
            
        }
        
        
           //     print_r($arrayZonificaciones);        
            /*
             * Array
                (
                    [0] => Array
                        (
                            [zona] => CANALEJAS
                            [zonificacion] => -99.6323495443894,19.93921032464321,0 -99.60848303176516,19.9479430714427,0 -99.59240270694212,19.95660140905689,0 -99.5751407982179,19.95659581871729,0 -99.52877487825697,19.99720081430345,0 -99.56509305729576,20.01590022179094,0 -99.5783381825041,20.02086692872206,0 -99.59716294841314,20.03425292013289,0 -99.60888307613377,20.04452049981353,0 -99.61991046589195,20.06078546332277,0 -99.62985801711589,20.06574325720041,0 -99.63869967277995,20.07157680717048,0 -99.66282677387721,20.0771827
                        )

                    [1] => Array
                        (
                            [zona] => SAN JUAN DEL RIO
                            [zonificacion] => -99.89717659228742,20.37502814621686,0 -99.87817863289942,20.43404142269898,0 -99.88849910583497,20.45004231623238,0 -99.95476702721507,20.49148390033696,0 -99.98413855211652,20.44735925623536,0 -100.0077545860647,20.41461869873617,0 -100.0289065842632,20.3799446837511,0 -100.0133382078995,20.35783191484072,0 -99.97663671220526,20.33929030040358,0 -99.94371403701467,20.35160342966244,0 -99.89717659228742,20.37502814621686,0
                        )

                )
             */
 
        
        return json_encode($arrayZonificaciones);
        //[{"zona":"CANALEJAS","zonificacion":"-99.6323495443894,19.93921032464321,0 -99.60848303176516,19.9479430714427,0 -99.59240270694212,19.95660140905689,0 -99.66282677387721,20.0771827"}
        //,{"zona":"SAN JUAN DEL RIO","zonificacion":"-99.89717659228742,20.37502814621686,0 -99.87817863289942,20.43404142269898,0 -99.88849910583497,20.45004231623238,0 -99.95476702721507,20.49148390033696,0 -99.98413855211652,20.44735925623536,0"}]
        /*
         * 	
            0	
                zona        "CANALEJAS"
                zonificacion	"-99.6323495443894,19.93921032464321,0 -99.60848303176516,19.9479430714427,0 -99.59240270694212,19.95660140905689,0 -99.5751407982179,19.95659581871729,0 -99.52877487825697,19.99720081430345,0 -99.56509305729576,20.01590022179094,0 -99.5783381825041,20.02086692872206,0 -99.59716294841314,20.03425292013289,0 -99.60888307613377,20.04452049981353,0 -99.61991046589195,20.06078546332277,0 -99.62985801711589,20.06574325720041,0 -99.63869967277995,20.07157680717048,0 -99.66282677387721,20.0771827"
            1	
                 zona       "SAN JUAN DEL RIO"
                 zonificacion	"-99.89717659228742,20.37502814621686,0 -99.87817863289942,20.43404142269898,0 -99.88849910583497,20.45004231623238,0 -99.95476702721507,20.49148390033696,0 -99.98413855211652,20.44735925623536,0 -100.0077545860647,20.41461869873617,0 -100.0289065842632,20.3799446837511,0 -100.0133382078995,20.35783191484072,0 -99.97663671220526,20.33929030040358,0 -99.94371403701467,20.35160342966244,0 -99.89717659228742,20.37502814621686,0"
        */

    }   

    
    
    
    /**
     * AQUI MOSTRAMOS UN USO DE LAS CONSULTAS O INSERSIONES POR ARRAY USANDO DOS PUNTOS(:)
     * @param type $arrayMensajesClientes
     * @param type $stringFechaHoraInicioSesion
     */
    public function cadenas_info_app_kaliope_insertaActualizaMensajesClientes ($arrayMensajesClientes,$stringFechaHoraInicioSesion){
        
        //https://diego.com.es/sentencias-preparadas-en-php
        //se puede usar PDO o MySqli aqui usamos una tecnica, en el metodo de abajo usamos otra para ver cual resulta mejor
        //este metodo funciona solo con la antigua tabla
    
    /* Primero buscamos si ya hay mensajes con ese usuario, fecha y ruta ingresados
     * si no hay entonces los ingresamos como nuevos, tambien guardamos la hora del inicio de sesion
     * porque si el usuario cierra sesion y vuelve a iniciarla, se cargara por defecto la misma zona
     * pero se borrara la cadena del movil, la cual inicara desde 0, entonces el servidor
     * cuando reciba los mensajes nuevos no los aceptara o encimara los nuevos mensajes con los
     * anteriores y habra perdida de informacion, Para eso guardaremos la fecha de incio de sesion, cuando el usuario cierre sesion y vuelva a inciar
     * esta hora sera diferente y con esto los mensajes se guardaran en un nuevo registro
     * pero si ya hay mensajes capturados significa que es una actualizacion
     * y actualizamos los registros de la tabla
     * 
     * el movil kaliope envia en fechaClientesConsulta, la fecha de los clientes que 
     * el servidor le envio cuando cargo los clientes, esta fecha corresponde al registro
     * ultima fecha que encuentra en los clientes el servidor
     * 
     * entonces el funcionamiento de este metodo es el siguiente
     * Cuando la app le envie datos al servidor, enviara los mensajes que antes se enviaban
     * por whats app a este metodo. 
     * En una tabla se guardaran los registros de los mensajes, pero si por ejemplo
     * anteriormente ya la app habia enviado mensajes, el metodo los buscara
     * y si ya hay mensajes los nuevos los actualizara, y actualizara la fecha de subida
     * de esta manera sabermos si la actualizaciond e los mensajes es reciente.
     * Tambien veremos que tan grande es la cadena que esta almacenada, y si la mas
     * nueva es mas grande entonces actualizamos, si no es mas grande la dejamos igual
     * 
     * Si no encuentra mensajes que concuerden con el usuario, con la fecha de los clientes,
     * y con la zona que se vio, entonces el metodo insertara los mensajes a la tabla.
     * 
     * Si no encuentra una fecha de inicio de sesion igual entonces registramos un nuevo registro
     * aunque el nombre de la zona y usuario sean los mismos
     * 
     * 
     */
    
    $fechaClientesRecibida = $arrayMensajesClientes['fechaClientesConsulta'];
    $userRecibido = $arrayMensajesClientes['usuario'];
    $zonaRecibida = $arrayMensajesClientes['zona'];
    $cadenaDatosRecibida = $arrayMensajesClientes['cadenaDatos'];
    $fechaActual = utilitarios_Class::fechaActualToText();
    
    
    
    //buscamos si existen registros previos con la misma fecha de los clientes, el mismo usuariom el mismo nombre de zona y la misma hora de inicio sesion
    $stringSQL = "SELECT * FROM cadenas_info_app_kaliope WHERE fecha_clientes_consulta = :fechaClientes AND usuario = :usuario AND zona = :zona AND fecha_hora_inicio_sesion=:fechaHora";    
    $consultaMensajes = $this->conexion->prepare($stringSQL, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    
    $consultaMensajes->execute(array(':fechaClientes'=>$fechaClientesRecibida, ':usuario'=>$userRecibido, ':zona'=> $zonaRecibida, ':fechaHora'=>$stringFechaHoraInicioSesion));
    //JAJAJJA YOS E QUE NO HABIA NECESIDAD PERO QUERIA VER COMO FUNCIONAVA LA MANERA DE HACER CONSULTAS EN LA PARTER DE ARRIBA CON ARRAYS
    
  
    
    
    
    $existenMensajesPrevios = $consultaMensajes->fetchAll();
    
    if(!empty($existenMensajesPrevios)){
        //si hay mensajes previos insertados entonces Analizamos la longitud de las variables
        //si la nueva cadena es mas grande que la que esta almacenada en la tabla entonces la actualizamos
        
        if (strlen($cadenaDatosRecibida) >= strlen($existenMensajesPrevios[0]['cadena_datos'])) {
                $SQL = "UPDATE cadenas_info_app_kaliope SET "
                        . "fecha_subida= '$fechaActual',"
                        . "cadena_datos='$cadenaDatosRecibida'"
                        . "WHERE usuario='$userRecibido'"
                        . "AND zona='$zonaRecibida'"
                        . "AND fecha_clientes_consulta='$fechaClientesRecibida'"
                        . "AND fecha_hora_inicio_sesion='$stringFechaHoraInicioSesion'";

                $this->conexion->prepare($SQL)->execute();
                //echo 'se actualizo una cadena existente';
            }
            
            
        }else{
        //si no se encuentra un registro en la tabla que concuerde significa que es un mensaje nuevo y lo guardamos
        $SQL = "INSERT INTO cadenas_info_app_kaliope (fecha_clientes_consulta, usuario, fecha_hora_inicio_sesion, zona, fecha_subida, cadena_datos) "
                . "VALUES ('$fechaClientesRecibida', '$userRecibido','$stringFechaHoraInicioSesion', '$zonaRecibida', '$fechaActual', '$cadenaDatosRecibida')";
        
        $this->conexion->prepare($SQL)->execute();
        
        //echo 'se inserto una nueva cadena';
                
    }
    
    
    
    
}

    /**
     * Aqui MOSTRAMOS EL USO DE LAS CONSULTAS O INSERSIONES POR ARRAY USANDO SIGNOS DE INTERROGACION (?)
     * @param type $fechaClientesConsulta1
     * @param type $fechaClientesConsulta2
     * @param type $zona1
     * @param type $zona2
     * @param type $mensajesClientes
     * @param type $fechaHoraInicioSesion
     * @param type $usuario
     */
    public function cadenas_info_app_kaliope_insertaActualizaMensajesClientes2Rutas ($fechaClientesConsulta1,$fechaClientesConsulta2,$zona1,$zona2,$mensajesClientes,$fechaHoraInicioSesion,$usuario){
        
        //https://diego.com.es/sentencias-preparadas-en-php
        //se puede usar PDO o MySqli aqui usamos una tecnica, en el metodo de abajo usamos otra para ver cual resulta mejor
        //este metodo funciona solo con la antigua tabla
    

    $fechaActual = utilitarios_Class::fechaActualToText();
    
      
    
    //buscamos si existen registros previos con la misma fecha de los clientes, el mismo usuariom el mismo nombre de zona y la misma hora de inicio sesion
    $consultaMensajes = $this->conexion->prepare("SELECT * FROM cadenas_info_app_kaliope WHERE fecha_clientes_consulta1 = ? AND fecha_clientes_consulta2 = ? AND usuario = ? AND zona1 = ? AND zona2 = ? AND fecha_hora_inicio_sesion= ?");
    
    
    //opcion uno usando bindParam y con el campo como numero segun la pagina
    //$consultaMensajes->bindParam(1, $fechaClientesRecibida1);
    //$consultaMensajes->bindParam(2, $fechaClientesRecibida2);
    //$consultaMensajes->bindParam(3, $userRecibido);
    //$consultaMensajes->bindParam(4, $zonaRecibida1);
    //$consultaMensajes->bindParam(5, $zonaRecibida2);
    //$consultaMensajes->bindParam(6, $stringFechaHoraInicioSesion);
    //$consultaMensajes->execute();
        
    
    
    
    //opcion 2 enviando los parametros directo en el execute como lo hacemos en android Studio se me hace mas comodo porque ni tienes que enumerar
    $consultaMensajes->execute(array($fechaClientesConsulta1,$fechaClientesConsulta2,$usuario,$zona1,$zona2,$fechaHoraInicioSesion));
    
    $existenMensajesPrevios = $consultaMensajes->fetchAll();
    //print_r($existenMensajesPrevios);
            
    //echo 'Tamaño de cadena recibida '.strlen($mensajesClientes) . '  Tamaño de cadena Almacenada '.strlen($existenMensajesPrevios[0]['cadena_datos']);

    
    
    if(!empty($existenMensajesPrevios)){
        //si hay mensajes previos insertados entonces Analizamos la longitud de las variables
        //si la nueva cadena es mas grande que la que esta almacenada en la tabla entonces la actualizamos
        
        if (strlen($mensajesClientes) >= strlen($existenMensajesPrevios[0]['cadena_datos'])) {
                $SQL = "UPDATE cadenas_info_app_kaliope SET "
                        . "fecha_subida= ?,"
                        . "cadena_datos= ? "
                        . "WHERE usuario= ? "
                        . "AND zona1 = ?"
                        . "AND zona2 = ?"
                        . "AND fecha_clientes_consulta1 = ? "
                        . "AND fecha_clientes_consulta2 = ? "
                        . "AND fecha_hora_inicio_sesion = ?";
                

                $this->conexion->prepare($SQL)->execute(array($fechaActual,$mensajesClientes,$usuario,$zona1,$zona2,$fechaClientesConsulta1, $fechaClientesConsulta2, $fechaHoraInicioSesion));
                //echo 'se actualizo una cadena existente';
            }
            
            
        }else{
        //si no se encuentra un registro en la tabla que concuerde significa que es un mensaje nuevo y lo guardamos
        $SQL = "INSERT INTO cadenas_info_app_kaliope (fecha_clientes_consulta1,fecha_clientes_consulta2, usuario, fecha_hora_inicio_sesion, zona1, zona2, fecha_subida, cadena_datos) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->conexion->prepare($SQL)->execute(array($fechaClientesConsulta1,$fechaClientesConsulta2,$usuario,$fechaHoraInicioSesion,$zona1,$zona2,$fechaActual,$mensajesClientes));
        
        //echo 'se inserto una nueva cadena';
                
    }
    
    
    
    
}


    public function cadenas_info_app_kaliope_insertaMensaje ($mensaje){
        
        //https://diego.com.es/sentencias-preparadas-en-php
        //se puede usar PDO o MySqli aqui usamos una tecnica, en el metodo de abajo usamos otra para ver cual resulta mejor
        //este metodo funciona solo con la antigua tabla
    
    /* Primero buscamos si ya hay mensajes con ese usuario, fecha y ruta ingresados
     * si no hay entonces los ingresamos como nuevos, tambien guardamos la hora del inicio de sesion
     * porque si el usuario cierra sesion y vuelve a iniciarla, se cargara por defecto la misma zona
     * pero se borrara la cadena del movil, la cual inicara desde 0, entonces el servidor
     * cuando reciba los mensajes nuevos no los aceptara o encimara los nuevos mensajes con los
     * anteriores y habra perdida de informacion, Para eso guardaremos la fecha de incio de sesion, cuando el usuario cierre sesion y vuelva a inciar
     * esta hora sera diferente y con esto los mensajes se guardaran en un nuevo registro
     * pero si ya hay mensajes capturados significa que es una actualizacion
     * y actualizamos los registros de la tabla
     * 
     * el movil kaliope envia en fechaClientesConsulta, la fecha de los clientes que 
     * el servidor le envio cuando cargo los clientes, esta fecha corresponde al registro
     * ultima fecha que encuentra en los clientes el servidor
     * 
     * entonces el funcionamiento de este metodo es el siguiente
     * Cuando la app le envie datos al servidor, enviara los mensajes que antes se enviaban
     * por whats app a este metodo. 
     * En una tabla se guardaran los registros de los mensajes, pero si por ejemplo
     * anteriormente ya la app habia enviado mensajes, el metodo los buscara
     * y si ya hay mensajes los nuevos los actualizara, y actualizara la fecha de subida
     * de esta manera sabermos si la actualizaciond e los mensajes es reciente.
     * Tambien veremos que tan grande es la cadena que esta almacenada, y si la mas
     * nueva es mas grande entonces actualizamos, si no es mas grande la dejamos igual
     * 
     * Si no encuentra mensajes que concuerden con el usuario, con la fecha de los clientes,
     * y con la zona que se vio, entonces el metodo insertara los mensajes a la tabla.
     * 
     * Si no encuentra una fecha de inicio de sesion igual entonces registramos un nuevo registro
     * aunque el nombre de la zona y usuario sean los mismos
     * 
     * 
     */
    


    
    
            
            
        $SQL = "INSERT INTO cadenas_info_app_kaliope (cadena_datos) VALUES ('$mensaje')";
        
        $this->conexion->prepare($SQL)->execute();
        
        //echo 'se inserto una nueva cadena';
                
    
    
    
    
    
}


    public function cadenas_info_app_kaliope_consultaTodasLasCadenas(){
        /*
         * Consultamos las cadenas de la tabla en orden decendente para mostrar primero los ultimos registros ingresados osea los mas recientes
         */
        
        
            $consultaCadenas = $this->conexion->prepare(
                    "SELECT * FROM cadenas_info_app_kaliope ORDER BY id DESC LIMIT 100"
                    //LIMIT 100
                    );
            
            $consultaCadenas->execute();
            $resultados = $consultaCadenas->fetchAll();
            
            //print_r($resultados);
            
            
            /*
             * 
             * Array(
    [0] => Array
        (
            [id] => 1355
            [0] => 1355
            [fecha_clientes_consulta1] => 19-12-2019
            [1] => 19-12-2019
            [fecha_clientes_consulta2] => 20-12-2019
            [2] => 20-12-2019
            [usuario] => Luisda
            [3] => Luisda
            [fecha_hora_inicio_sesion] => 19-12-2019 00:07:25
            [4] => 19-12-2019 00:07:25
            [zona1] => CANALEJAS
            [5] => CANALEJAS
            [zona2] => TARIMORO
            [6] => TARIMORO
            [fecha_subida] => 11:6:38 19-12-2019
            [7] => 11:6:38 19-12-2019
            [cadena_datos] => ?
                                CANALEJAS
                                ?
            [8] => ?
                    CANALEJAS
                    ?
        )

    [1] => Array
        (
            [id] => 1354
            [0] => 1354
            [fecha_clientes_consulta1] => 19-12-2019*16-12-201
            [1] => 19-12-2019*16-12-201
            [fecha_clientes_consulta2] => 
            [2] => 
            [usuario] => Luisda
            [3] => Luisda
            [fecha_hora_inicio_sesion] => 19-12-2019 00:07:25
            [4] => 19-12-2019 00:07:25
            [zona1] => CANALEJAS*TARIMORO*
            [5] => CANALEJAS*TARIMORO*
            [zona2] => 0
            [6] => 0
            [fecha_subida] => 10:31:16 19-12-2019
            [7] => 10:31:16 19-12-2019
            [cadena_datos] => ?
                            CANALEJAS
                            ?
            [8] => ?
                        CANALEJAS
                        ?
        )

             *              */
            
            
   
            
            return $resultados;
    }
    
    public function cadenas_info_app_kaliope_consultaCadenaPorRuta(){
        /*
         * Consultamos las cadenas de la tabla en orden decendente para mostrar primero los ultimos registros ingresados osea los mas recientes
         */
        
        
            $consultaCadenas = $this->conexion->prepare(
                    "SELECT * FROM cadenas_info_app_kaliope ORDER BY id DESC LIMIT 100"
                    //LIMIT 100
                    );
            
            $consultaCadenas->execute();
            $resultados = $consultaCadenas->fetchAll();
            
            //print_r($resultados);
            
            
            /*
             * 
             * Array(
    [0] => Array
        (
            [id] => 1355
            [0] => 1355
            [fecha_clientes_consulta1] => 19-12-2019
            [1] => 19-12-2019
            [fecha_clientes_consulta2] => 20-12-2019
            [2] => 20-12-2019
            [usuario] => Luisda
            [3] => Luisda
            [fecha_hora_inicio_sesion] => 19-12-2019 00:07:25
            [4] => 19-12-2019 00:07:25
            [zona1] => CANALEJAS
            [5] => CANALEJAS
            [zona2] => TARIMORO
            [6] => TARIMORO
            [fecha_subida] => 11:6:38 19-12-2019
            [7] => 11:6:38 19-12-2019
            [cadena_datos] => ?
                                CANALEJAS
                                ?
            [8] => ?
                    CANALEJAS
                    ?
        )

    [1] => Array
        (
            [id] => 1354
            [0] => 1354
            [fecha_clientes_consulta1] => 19-12-2019*16-12-201
            [1] => 19-12-2019*16-12-201
            [fecha_clientes_consulta2] => 
            [2] => 
            [usuario] => Luisda
            [3] => Luisda
            [fecha_hora_inicio_sesion] => 19-12-2019 00:07:25
            [4] => 19-12-2019 00:07:25
            [zona1] => CANALEJAS*TARIMORO*
            [5] => CANALEJAS*TARIMORO*
            [zona2] => 0
            [6] => 0
            [fecha_subida] => 10:31:16 19-12-2019
            [7] => 10:31:16 19-12-2019
            [cadena_datos] => ?
                            CANALEJAS
                            ?
            [8] => ?
                        CANALEJAS
                        ?
        )

             *              */
            
            
   
            
            return $resultados;
    }




     public function nombres_zonas_getIdZona($numeroSemana, $rutaAsignada, $nombreDeDiaEnglish) {

        
        $consultarNombre = $this->conexion->prepare(
                "SELECT nombre FROM nombres_zonas WHERE semana= '$numeroSemana' AND ruta='$rutaAsignada' AND dia= '$nombreDeDiaEnglish'"
                );
        $consultarNombre->execute();
        $resultado = $consultarNombre->fetchAll();
              
        
       

        if (empty($resultado)) {
            echo "    Error de inicio de sesion no existe ruta asignada para el dia: $nombreDeDiaEnglish, de la semana: $numeroSemana, para la ruta: $rutaAsignada     ";
        } else {
            return $resultado[0][0];
        }
    } //quedara opsoleto porque solo permite trabajar con 1 rutas 21-11-2019
     public function nombres_zonas_getIdZonaDosRutas($numeroSemana, $rutaAsignada, $nombreDeDiaEnglish) {

        
        $consultarNombre = $this->conexion->prepare(
                "SELECT nombre, nombre2 FROM nombres_zonas WHERE semana= '$numeroSemana' AND ruta='$rutaAsignada' AND dia= '$nombreDeDiaEnglish'"
                );
        $consultarNombre->execute();
        $resultado = $consultarNombre->fetchAll();
        $resultado = $consultarNombre->fetchAll();
        //print_r($resultado);
        
        /*
         * Array
        (
            [0] => Array
            (
            [nombre] => PIEDRAS BLANCAS
            [0] => PIEDRAS BLANCAS
            [nombre2] => SAN JUAN DEL RIO
            [1] => SAN JUAN DEL RIO
            )

        )
         */
              
        
       

        if (empty($resultado)) {
            echo "    Error de inicio de sesion no existe ruta asignada para el dia: $nombreDeDiaEnglish, de la semana: $numeroSemana, para la ruta: $rutaAsignada     ";
        } else {
            return array_unique($resultado[0]);
            /*
             * Array
            (
                [nombre] => PIEDRAS BLANCAS
                [nombre2] => SAN JUAN DEL RIO
            )
             */
        }
    }   

     public function nombres_zonas_getIdZonaActual($rutaAsignada) {
        date_default_timezone_set('America/Mexico_City');
        $numeroSemana = $this->getSemanaKaliope();       
        $nombreDeDiaEnglish = date("l");

        $consultarNombre = $this->conexion->prepare(
                "SELECT nombre FROM nombres_zonas WHERE semana= '$numeroSemana' AND ruta='$rutaAsignada' AND dia= '$nombreDeDiaEnglish'"
                );
        $consultarNombre->execute();
        $resultado = $consultarNombre->fetchAll();

        if (empty($resultado)) {
            echo "    Error de inicio de sesion no existe ruta asignada para el dia: $nombreDeDiaEnglish, de la semana: $numeroSemana, para la ruta: $rutaAsignada     ";
        } else {
            return $resultado[0][0];;
        }
    } //quedara opsoleto porque solo permite trabajar con 1 rutas 21-11-2019
     public function nombres_zonas_getIdZonaActualDosRutas($rutaAsignada) {
        date_default_timezone_set('America/Mexico_City');
        $numeroSemana = $this->getSemanaKaliope();       
        $nombreDeDiaEnglish = date("l");

        $consultarNombre = $this->conexion->prepare(
                "SELECT nombre, nombre2 FROM nombres_zonas WHERE semana= '$numeroSemana' AND ruta='$rutaAsignada' AND dia= '$nombreDeDiaEnglish'"
                );
        $consultarNombre->execute();
        $resultado = $consultarNombre->fetchAll();
        //print_r($resultado);
        
        /*
         * Array
        (
            [0] => Array
            (
            [nombre] => PIEDRAS BLANCAS
            [0] => PIEDRAS BLANCAS
            [nombre2] => SAN JUAN DEL RIO
            [1] => SAN JUAN DEL RIO
            )

        )
         */

        if (empty($resultado)) {
            echo "    Error de inicio de sesion no existe ruta asignada para el dia: $nombreDeDiaEnglish, de la semana: $numeroSemana, para la ruta: $rutaAsignada     ";
        } else {
            return array_unique($resultado[0]);
            /*
             * Array
            (
               [nombre] => CANALEJAS
                [nombre2] => SAN JUAN DEL RIO
            )
             */
        }
    }
    
     public function nombres_zonas_validarRuta($rutaPorValidar){
         /*este metodo valida la ruta por ejemplo A1 que exista en la tabla
          * para al momento de ingresar un nuevo usuario, se escriba correctamente la ruta
          */
         
         $validar = $this->conexion->prepare(
                 "SELECT DISTINCT ruta FROM nombres_zonas WHERE ruta='$rutaPorValidar'"
                 );
         $validar->execute();
         $resultados = $validar->fetchAll();
         
         //print_r($resultados);
         
         if(empty($resultados)){
             throw new Exception("No existe un nombre de ruta <h4> $rutaPorValidar </h4> verifique que escribio correctamente la ruta");
         }
         
     }
     
     public function nombres_zonas_consultaRutasExistentes(){
         /*este metodo consulta las rutas que existen 
          * para por ejemplo llenar un select con las rutas que el usuario puede elegir
          */
         
         $rutas = $this->conexion->prepare(
                 "SELECT DISTINCT ruta FROM nombres_zonas"
                 );
         $rutas->execute();
         $resultados = $rutas->fetchAll();
         
         //print_r($resultados);
         
         return $resultados;
         
     }
     
     
     
     
     
     
     
     
     public function getSemanaKaliope() {
         
         /*
          * este metodo se encarga de retornar la semana kaliope actual, 
          * automaticamente con la fecha del sistema.
          */
         
        
        date_default_timezone_set('America/Mexico_City');
        $semanaActual = date("W"); //obtenemos el numero de semana del año, cambian cada lunes, algunos años tienen 53 semanas en promedio 52;
        //echo "El numero de semana del año en curso segun la fecha del sistema es: $semanaActual" . '<br>';
        $anoEnCurso = date("Y");
        //echo "El año en curso es: $anoEnCurso";

       
                 
            
            
            
            
             //volvemos a consultar al final la base de datos para devolver el numero de semana
            $statament = $this->conexion->prepare(
                    "SELECT semana_kaliope FROM week_number WHERE numero_semana=$semanaActual AND ano=$anoEnCurso"                    
            );
            $statament->execute();            
            $statament = $statament->fetchAll();
            $statament = $statament[0];
            //print_r($statament);            
            

            return $statament['semana_kaliope'];
        }
        
     public function obtenerSemanaKaliopePorSemanaAno($numeroSemana,$year) {
         
         /*
          * este metodo se encarga de retornar la semana kaliope actual, 
          * consultando con el numero de semana y el año enviado
          * pro ejemplo podriamos consultar en el futuro que semana kaliope es en la semana 32 del año 2020
          */
         
        
        date_default_timezone_set('America/Mexico_City');
        //echo "El numero de semana enviado es: $numeroSemana" . '<br>';        
        //echo "El año enviado es: $year";

       
                 
            
            
            
            
             //volvemos a consultar al final la base de datos para devolver el numero de semana
            $statament = $this->conexion->prepare(
                    "SELECT semana_kaliope FROM week_number WHERE numero_semana=$numeroSemana AND ano=$year"                    
            );
            $statament->execute();            
            $statament = $statament->fetchAll();
            $statament = $statament[0];
            //print_r($statament);            
            

            return $statament['semana_kaliope'];
        }
     
     public function obtenerSemanaKaliopePorFecha($StringFechaDDMMYYYY) {
         
         /*
          * este metodo se encarga de retornar la semana kaliope actual, 
          * consultanda con la fecha en texto con formato dd-mm-yyyy 
          * pro ejemplo podriamos consultar en el futuro que semana kaliope es para la fecha 19-08-2020 y el sistema retornaria semana kaliope 2
          */
         
        
       
        $fecha = strtotime($StringFechaDDMMYYYY);       
        $numeroSemana = date("W", $fecha);        
        $year = date("Y",$fecha);
        
        echo "la fecha es: ". date("d.m.y",$fecha) ."<br>";
        echo "el numero de semana es: $numeroSemana <br>";
        echo "El año es: $year <br>";        
        echo "El dia es: ". date("l",$fecha) ."<br>";
        
             //volvemos a consultar al final la base de datos para devolver el numero de semana
            $statament = $this->conexion->prepare(
                    "SELECT semana_kaliope FROM week_number WHERE numero_semana=$numeroSemana AND ano=$year"                    
            );
            $statament->execute();            
            $statament = $statament->fetchAll();
            $statament = $statament[0];
            //print_r($statament);            
            

            return $statament['semana_kaliope'];
        }
        
     
     
        
        
        
     
        
        
     
        public function movimientos_inventarios_sucursales_bitacora_insertarBitacora
            ($propietario, $nombreCompleto, $usuarioReviso, $nombreCompletoReviso,$usuarioSucursal,
                $fechaRealizado, $horaRealizado, $totalPiezas, $tipoMovimiento, $totalImporte,
                $almacenExistenciasAntes, $almacenExistenciasDespues, $propietarioExistenciasAntes, $propietarioExistenciasDespues , $propietarioVersionDespues, 
                $almacenVersionDespues, $jsonPiezas, $enviadoAlMovil, $horaDeEnvioAlMovil){
            
            
            $this->conexion->prepare(
                    "INSERT INTO movimientos_inventarios_sucursales_bitacora"
                    . "(propietario, nombre_completo, usuario_reviso, nombre_completo_reviso,"
                    . " usuario_sucursal, fecha_realizado, hora_realizado, total_piezas, tipo_movimiento,"
                    . " total_importe,"
                    . " almacen_existencias_antes, almacen_existencias_despues, propietario_existencias_antes, propietario_existencias_despues,"
                    . " propietario_version_despues, almacen_version_despues, jsonPiezas, enviado_al_movil, hora_de_envio_al_movil) "
                    . "VALUES('$propietario', '$nombreCompleto', '$usuarioReviso', '$nombreCompletoReviso','$usuarioSucursal',"
                    . " '$fechaRealizado', '$horaRealizado', '$totalPiezas', '$tipoMovimiento', '$totalImporte',"
                    . " '$almacenExistenciasAntes', '$almacenExistenciasDespues','$propietarioExistenciasAntes','$propietarioExistenciasDespues', '$propietarioVersionDespues',"
                    . " '$almacenVersionDespues', '$jsonPiezas', '$enviadoAlMovil','$horaDeEnvioAlMovil')"
                    )->execute();
            
        }
        
        public function movimientos_inventarios_sucursales_bitacora_finalizarMovimientoSucursal($id, $propietarioExistenciasAntes, $propietarioExistenciasDespues, $propietarioVersionDespues){
            /*in this metod we will finalice the movement, it is going to update the fields
                with the pcs before that the movement, after, the new version and the most important part
             it's going to put the time of update and will change the value of the   enviado_al_movil */
            
            $horaDeAfectado = utilitarios_Class::dameFecha_dd_mm_aaaa_ToText()."  ". utilitarios_Class::horaActual_hh_mm_ss_ToText();

            
            $actualizar = $this->conexion->prepare(                
                        "UPDATE movimientos_inventarios_sucursales_bitacora SET "
                        . "propietario_existencias_antes= '$propietarioExistenciasAntes',"
                        . "propietario_existencias_despues = '$propietarioExistenciasDespues',"
                        . "propietario_version_despues= '$propietarioVersionDespues',"
                        . "enviado_al_movil= '1',"
                        . "hora_de_envio_al_movil = '$horaDeAfectado'"
                        . "WHERE id='$id'");
                $actualizar->execute(); 
            
        }
        
        public function movimientos_inventarios_sucursales_bitacora_consultarTodosLosMovimientos(){
            
            $consulta = $this->conexion->prepare(
                    "SELECT * FROM movimientos_inventarios_sucursales_bitacora ORDER BY id DESC LIMIT 200"
                    );
            $consulta->execute();
            $resultados = $consulta->fetchAll();
            //print_r($resultados);
            
            /*
             * Array
                (
                    [0] => Array
                        (
                            [id] => 1
                            [0] => 1
                            [propietario] => Cruz
                            [1] => Cruz
                            [nombre_completo] => Eduardo Cruz No se que mas
                            [2] => Eduardo Cruz No se que mas
                            [usuario_reviso] => Ramiro
                            [3] => Ramiro
                            [nombre_completo_reviso] => Ramiro Guadalupe Ramirez Padilla
                            [4] => Ramiro Guadalupe Ramirez Padilla
                            [usuario_sucursal] => Atlacomulco
                            [5] => Atlacomulco
                            [fecha_realizado] => 20-8-2019
                            [6] => 20-8-2019
                            [hora_realizado] => 15:36:11
                            [7] => 15:36:11
                            [total_piezas] => 3
                            [8] => 3
                            [tipo_movimiento] => E
                            [9] => E
                            [total_importe] => 1458
                            [10] => 1458
                            [almacen_existencias_antes] => -46
                            [13] => -46
                            [almacen_existencias_despues] => -49
                            [14] => -49
                            [propietario_existencias_antes] => 13
                            [15] => 13
                            [propietario_existencias_despues] => 13
                            [16] => 13            
                            [propietario_version_despues] => 13
                            [17] => 13
                            [almacen_version_despues] => 21
                            [18] => 21
                            [jsonPiezas] => [{"Codigo":"699","Cantidad":"2"},{"Codigo":"329","Cantidad":"1"}]
                            [19] => [{"Codigo":"699","Cantidad":"2"},{"Codigo":"329","Cantidad":"1"}]
             *              [enviado_al_movil] => 0
                            [20] => 0
             *              [hora_de_envio_al_movil] => 
                            [21] =>
                        )

                )
             */
            
            return $resultados;
        }
        
        public function movimientos_inventarios_sucursales_bitacora_consultarMovimientoPorId($id){
            
            $consulta = $this->conexion->prepare(
                    "SELECT * FROM movimientos_inventarios_sucursales_bitacora WHERE id='$id'"
                    );
            $consulta->execute();
            $resultados = $consulta->fetchAll();
            //print_r($resultados);
            
            /*
             * Array
                (
                    [0] => Array
                        (
                         
                            [id] => 1
                            [0] => 1
                            [propietario] => Cruz
                            [1] => Cruz
                            [nombre_completo] => Eduardo Cruz No se que mas
                            [2] => Eduardo Cruz No se que mas
                            [usuario_reviso] => Ramiro
                            [3] => Ramiro
                            [nombre_completo_reviso] => Ramiro Guadalupe Ramirez Padilla
                            [4] => Ramiro Guadalupe Ramirez Padilla
                            [usuario_sucursal] => Atlacomulco
                            [5] => Atlacomulco
                            [fecha_realizado] => 20-8-2019
                            [6] => 20-8-2019
                            [hora_realizado] => 15:36:11
                            [7] => 15:36:11
                            [total_piezas] => 3
                            [8] => 3
                            [tipo_movimiento] => E
                            [9] => E
                            [total_importe] => 1458
                            [10] => 1458
                            [almacen_existencias_antes] => -46
                            [13] => -46
                            [almacen_existencias_despues] => -49
                            [14] => -49
                            [propietario_existencias_antes] => 13
                            [15] => 13
                            [propietario_existencias_despues] => 13
                            [16] => 13            
                            [propietario_version_despues] => 13
                            [17] => 13
                            [almacen_version_despues] => 21
                            [18] => 21
                            [jsonPiezas] => [{"Codigo":"699","Cantidad":"2"},{"Codigo":"329","Cantidad":"1"}]
                            [19] => [{"Codigo":"699","Cantidad":"2"},{"Codigo":"329","Cantidad":"1"}]
             *              [enviado_al_movil] => 0
                            [20] => 0
             *              [hora_de_envio_al_movil] => 
                            [21] =>
                        
                        )

                )
             */
            
            //enviamos solo la dimencion 0 del array, dejando claro que solo habra un movimiento de respuesta
            
            return $resultados[0];
        }        
        
        public function movimientos_inventarios_sucursales_bitacora_consultarMovimientosNoEnviados($propietario){
            
            $consulta = $this->conexion->prepare(
                    "SELECT * FROM movimientos_inventarios_sucursales_bitacora WHERE propietario='$propietario' AND enviado_al_movil = '0'"
                    );
            $consulta->execute();
            $resultados = $consulta->fetchAll();
            //print_r($resultados);
            
            /*
             * Array
                (
                    [0] => Array
                        (
                         
                            [id] => 1
                            [0] => 1
                            [propietario] => Cruz
                            [1] => Cruz
                            [nombre_completo] => Eduardo Cruz No se que mas
                            [2] => Eduardo Cruz No se que mas
                            [usuario_reviso] => Ramiro
                            [3] => Ramiro
                            [nombre_completo_reviso] => Ramiro Guadalupe Ramirez Padilla
                            [4] => Ramiro Guadalupe Ramirez Padilla
                            [usuario_sucursal] => Atlacomulco
                            [5] => Atlacomulco
                            [fecha_realizado] => 20-8-2019
                            [6] => 20-8-2019
                            [hora_realizado] => 15:36:11
                            [7] => 15:36:11
                            [total_piezas] => 3
                            [8] => 3
                            [tipo_movimiento] => E
                            [9] => E
                            [total_importe] => 1458
                            [10] => 1458
                            [almacen_existencias_antes] => -46
                            [13] => -46
                            [almacen_existencias_despues] => -49
                            [14] => -49
                            [propietario_existencias_antes] => 13
                            [15] => 13
                            [propietario_existencias_despues] => 13
                            [16] => 13            
                            [propietario_version_despues] => 13
                            [17] => 13
                            [almacen_version_despues] => 21
                            [18] => 21
                            [jsonPiezas] => [{"Codigo":"699","Cantidad":"2"},{"Codigo":"329","Cantidad":"1"}]
                            [19] => [{"Codigo":"699","Cantidad":"2"},{"Codigo":"329","Cantidad":"1"}]
             *              [enviado_al_movil] => 0
                            [20] => 0
             *              [hora_de_envio_al_movil] => 
                            [21] =>
                        
                        )
             * 
             *          [1] => Array
                        (
                         
                            [id] => 1
                            [0] => 1
                            [propietario] => Cruz
                            [1] => Cruz
                            [nombre_completo] => Eduardo Cruz No se que mas
                            [2] => Eduardo Cruz No se que mas
                            [usuario_reviso] => Ramiro
                            [3] => Ramiro
                            [nombre_completo_reviso] => Ramiro Guadalupe Ramirez Padilla
                            [4] => Ramiro Guadalupe Ramirez Padilla
                            [usuario_sucursal] => Atlacomulco
                            [5] => Atlacomulco
                            [fecha_realizado] => 20-8-2019
                            [6] => 20-8-2019
                            [hora_realizado] => 15:36:11
                            [7] => 15:36:11
                            [total_piezas] => 3
                            [8] => 3
                            [tipo_movimiento] => E
                            [9] => E
                            [total_importe] => 1458
                            [10] => 1458
                            [almacen_existencias_antes] => -46
                            [13] => -46
                            [almacen_existencias_despues] => -49
                            [14] => -49
                            [propietario_existencias_antes] => 13
                            [15] => 13
                            [propietario_existencias_despues] => 13
                            [16] => 13            
                            [propietario_version_despues] => 13
                            [17] => 13
                            [almacen_version_despues] => 21
                            [18] => 21
                            [jsonPiezas] => [{"Codigo":"699","Cantidad":"2"},{"Codigo":"329","Cantidad":"1"}]
                            [19] => [{"Codigo":"699","Cantidad":"2"},{"Codigo":"329","Cantidad":"1"}]
             *              [enviado_al_movil] => 0
                            [20] => 0
             *              [hora_de_envio_al_movil] => 
                            [21] =>
                        
                        )

                )
             * 
             */
            
            //enviamos solo la dimencion 0 del array, dejando claro que solo habra un movimiento de respuesta
            
            return $resultados;
        }
        
        public function movimientos_inventarios_sucursales_bitacora_ponerEnviadoAlMovil($propietario){
        /*
         * Creamos este metodo para poner todos los movimientos de almacen de la tabla a enviado al movil, marcando la fecha de cuando se envio
         * obiamente se pondran absolutamente todos los movimientos del propietario que esten como 0 en enviado al movil para de esta manera
         * no se vuelvan a enviar estos movimientos cuando el celuar pregunte si hay movimientos de almacen que aun no le llegan
         * , porque cuando el servidor
         * le envia los movimientos del propietario, le envia todos lso que haya en 0, por lo tanto no importa si ponemos todos los que esten en 0 a 1
         */
        
        $horaDeEnvioAlMovil = utilitarios_Class::dameFecha_dd_mm_aaaa_ToText()."  ". utilitarios_Class::horaActual_hh_mm_ss_ToText();
        
        $actualizaVersion = $this->conexion->prepare(
                        "UPDATE movimientos_inventarios_sucursales_bitacora SET enviado_al_movil = '1', hora_de_envio_al_movil = '$horaDeEnvioAlMovil' WHERE propietario='$propietario' AND enviado_al_movil= '0'"
                );
                $actualizaVersion->execute();
    }
    
        public function movimientos_inventarios_sucursales_bitacora_consultarUsuariosConMovimientos(){
            
            $consulta = $this->conexion->prepare(
                    "SELECT DISTINCT propietario FROM movimientos_inventarios_sucursales_bitacora ORDER BY propietario ASC"
                    );
            $consulta->execute();
            $resultados = $consulta->fetchAll();
            //print_r($resultados);
            
            /*
             * Array
(
    [0] => Array
        (
            [propietario] => Angel
            [0] => Angel
        )

    [1] => Array
        (
            [propietario] => Carlitos
            [0] => Carlitos
        )

    [2] => Array
        (
            [propietario] => Cruz
            [0] => Cruz
        )

    [3] => Array
        (
            [propietario] => David
            [0] => David
        )

    [4] => Array
        (
            [propietario] => Eduardo
            [0] => Eduardo
        )

    [5] => Array
        (
            [propietario] => Elihu
            [0] => Elihu
        )

    [6] => Array
        (
            [propietario] => Erick
            [0] => Erick
        )

    [7] => Array
        (
            [propietario] => Esteban
            [0] => Esteban
        )

    [8] => Array
        (
            [propietario] => Gustavo
            [0] => Gustavo
        )

    [9] => Array
        (
            [propietario] => Hector
            [0] => Hector
        )

    [10] => Array
        (
            [propietario] => Juan
            [0] => Juan
        )

    [11] => Array
        (
            [propietario] => Mendez
            [0] => Mendez
        )

    [12] => Array
        (
            [propietario] => Oswaldo
            [0] => Oswaldo
        )

    [13] => Array
        (
            [propietario] => Ramiro
            [0] => Ramiro
        )

    [14] => Array
        (
            [propietario] => Uriel
            [0] => Uriel
        )

)
             */
            
            return $resultados;
        }
        
        public function movimientos_inventarios_sucursales_bitacora_consultarSucursal(){
            
            $consulta = $this->conexion->prepare(
                    "SELECT DISTINCT usuario_sucursal FROM movimientos_inventarios_sucursales_bitacora ORDER BY usuario_sucursal ASC"
                    );
            $consulta->execute();
            $resultados = $consulta->fetchAll();
            //print_r($resultados);
            
            /*
 Array
(
    [0] => Array
        (
            [usuario_sucursal] => Atlacomulco
            [0] => Atlacomulco
        )

    [1] => Array
        (
            [usuario_sucursal] => Queretaro
            [0] => Queretaro
        )

    [2] => Array
        (
            [usuario_sucursal] => Morelia
            [0] => Morelia
        )

)
             */
            
            return $resultados;
        }
        
        public function movimientos_inventarios_sucursales_bitacora_consultarFechasMovimientos(){
            
            $consulta = $this->conexion->prepare(
                    "SELECT DISTINCT fecha_realizado FROM movimientos_inventarios_sucursales_bitacora ORDER BY fecha_realizado DESC"
                    );
            $consulta->execute();
            $resultados = $consulta->fetchAll();
            //print_r($resultados);
            
            /*
Array
(
    [0] => Array
        (
            [fecha_realizado] => 27-8-2019
            [0] => 27-8-2019
        )

    [1] => Array
        (
            [fecha_realizado] => 26-8-2019
            [0] => 26-8-2019
        )

    [2] => Array
        (
            [fecha_realizado] => 23-8-2019
            [0] => 23-8-2019
        )

    [3] => Array
        (
            [fecha_realizado] => 22-8-2019
            [0] => 22-8-2019
        )

    [4] => Array
        (
            [fecha_realizado] => 21-8-2019
            [0] => 21-8-2019
        )

    [5] => Array
        (
            [fecha_realizado] => 20-8-2019
            [0] => 20-8-2019
        )

)
             */
            
            return $resultados;
        }
        
        public function movimientos_inventarios_sucursales_bitacora_consultarMovimientosPorFiltro($propietario){
            
            $consulta = $this->conexion->prepare(
                    "SELECT * FROM movimientos_inventarios_sucursales_bitacora WHERE propietario='$propietario' ORDER BY id DESC"
                    );
            $consulta->execute();
            $resultados = $consulta->fetchAll();
            //print_r($resultados);
            
            
            
            return $resultados;
        }
        
        
        
        
        
        
        
        
        
        
        
       
        
        public function datos_gps_recibidos_directo_insertarRegistro($datos){
              $this->conexion->prepare(
                "INSERT INTO datos_gps_recibidos_directo (informacion)"
                . " VALUES ('$datos')"
                )->execute();
        }


        
        
        
        
        
        
        
     //IMPORTANTE ESTOS METODOS LOS USAMOS SOLO UNA VEZ PARA POBLAR COMPLETAMENTE LA TABLA DE WEEK_NUMBER
     //SOLO SE NECESITA LLAMAR A LA FUNCION week_number_llenarTablaRangoDeAños ENVIAR EL RANGO DE AÑOS POR EJEMPLO
        //DEL 2019 AL 2050, enviarle con que semana kaliope empezara la primera semana del año inicial
        //por ejemplo si se le envia 1, la semana kaliope del la primer semana del año 2019 sera la 1 y de ahi comensara
        //a cambiar la siguiente semana sera 2, despues la semana 3 del año sera 1, la 4 sera denuevo 2, 
        //si se le pone como inicial semana 2, la semana 1 del año 2019 sera la 2, la semana 2 sera la 1, la 3 semana 2 la 4 semana 1 etc.
     public function week_number_llenarTablaRangoDeAños($anoInicial, $anoFinal, $semanaKaliopeInicialDeSecuencia) {
         
        for ($year = $anoInicial; $year <= $anoFinal; $year++) {
            echo "el año $year tiene " . utilitarios_Class::cuantasSemanasTieneUnAno($year) . " semanas <br>";
        }

        for ($year = $anoInicial; $year <= $anoFinal; $year++) {
            $semanaInicialPorInsertar = $this->consultarUltimaSemanaKaliopeEnTabla();

            //si en la tabla no hay ningun registro previo tomamos uno que el usuario puso por default
            //este solo lo tomara por primera vez cuanod no hay ningun registro en la tabla, despues tomara 
            //como valor inicial del año consultando la ultima semana kaliope inserdata en la tabla
            if (empty($semanaInicialPorInsertar)) {
                $semanaInicialPorInsertar = 1;
            } else {

                /*
                 * si hay informacion en la tabla entonces si la ultima en la tabla es semana 1 le sumamos 1 para que el siguiete año
                 * inicie es semana 2, si la ultima semana registrada es 2 entonces le quitamos 1 para que la primer semana del siguiente año sea 1
                 */
                if ($semanaInicialPorInsertar == 1) {
                    $semanaInicialPorInsertar += 1;
                } else {
                    $semanaInicialPorInsertar -= 1;
                }
            }



            $this->llenarSemanaKaliopeAño($year, $semanaInicialPorInsertar);
        }
    }
     private function llenarSemanaKaliopeAño($year,$semanaKaliopeInicial){
         //llenamos las semanas de todo el año por ejemplo desde el 2019 al 2050
         
         //$semanaPorInsertar = 1; 
         /*
          * esta la puedes cambiar para que conicida con la semana que quieras, por ejemplo ahorita es la semana 32 del 2019 como es la primera vez
          * que voy a llenar la tabla yo necesito que esta semana sea la 2, si yo posiera el valor de arriba en 2 significa que la primer semana del año empezara en 2
          *  cuando el metodo comience a insertar las
          * semanas desde la primer semana del año al llegar a mi semana 32 quedaria semana 1, entonces yo le coloco como valor inicial 1, para que al llegar a mi
          * semana toque la semana 2. para ver eso imprimi los echos antes de insertar los datos;
          */
         
         $semanaPorInsertar = $semanaKaliopeInicial;
         /*
          * le pasamos como parametro cual sera la primer semana kaliope en el año, lo que haremos por ejemplo
          * es una ves que se incerto en la tabla todas las semanas del año 2019 la ultima semana la 52 es semana 2kaliope cuando se inserte el siguiente
          * año del 2020 consultaremos en la tabla cual es la ultima semana registrada, esto dire auqe la semana ultima registrada fue la 2, por lo tanto 
          * sabremos que la primer semana del 2020 iniciara en semana 1 y eso le pasaremos como parametro en $semana inicial. Porque por ejemplo el año 2020 tiene 
          * 53 semanas, lo cual haria que en lugar de acabar en la semana 2 acaber con la 1, y el siguiente año tendria que iniciar en semana 2
          */
         
         $semanasTotalDelAño = utilitarios_Class::cuantasSemanasTieneUnAno($year);
         
         
         //recorremos las semanas de todo el año desde la semana 1 hasta la ultima semana para anexar los registros a la tabla
         for ($semana = 1; $semana <= $semanasTotalDelAño; $semana++) {
             
             
             echo "la semana $semana del año $year es la semana kaliope numero: $semanaPorInsertar <br>";
             //insertamos la semana en la tabla weeknumber
             
             $this->conexion->prepare("INSERT INTO week_number(semana_kaliope,numero_semana,ano) VALUES('$semanaPorInsertar','$semana','$year')")->execute(); 
             
             //cambiamos la siguiente semana por insertar
             if($semanaPorInsertar==2){
                 $semanaPorInsertar=1;
             }else{
                 $semanaPorInsertar=2;
             }
                 
             
         }
         
         
         
         
         
     }    
     private function consultarUltimaSemanaKaliopeEnTabla(){
         
         $statament = $this->conexion->prepare(
                /*
                  consultamos el ultimo registro ingresado, PARA QUE EL ULTIMO REGISTRO DEVUELTO SEA EL DE MAYOR id
                  es decir la ultima semana ingresada a la tabla
                  dfs
                 */

                "SELECT * FROM week_number WHERE id = (SELECT MAX(id) FROM week_number)"
                //"SELECT * FROM week_number ORDER BY id DESC"
        );
        $statament->execute();
        $resultados = $statament->fetchAll();
        //print_r($resultados);
         /*
          * (
        [0] => Array
            (
                [id] => 52
                [0] => 52
                [semana_kaliope] => 2
                [1] => 2
                [numero_semana] => 52
                [2] => 52
                [ano] => 2019
                [3] => 2019
            )

        )

          */
        
        //tomamos solo el valor que nos interesa del resultado
        return $resultados[0]['semana_kaliope'];
     }
     
     
     
     
     
     
     
    
     
     
     

}
