<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rutas_Class
 *
 * @author david
 */
class rutas_Class {
    //put your code here
    
    
    
    private $conexion;

    public function __construct() {

        try {
            //realizamos la conexion a la base de datos
            $this->conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
        } catch (PDOException $e) {
            echo "Error" . $e->getMessage();
        }
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
            return $resultado[0][0];
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
        
        date_default_timezone_set('America/Mexico_City');
        $semanaActual = date("W"); //obtenemos el numero de semana del año, cambian cada lunes, algunos años tienen 53 semanas en promedio 52;
        //echo "El numero de semana del año en curso segun la fecha del sistema es: $semanaActual" . '<br>';

       
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
        //print_r($statament);

        $numeroDeSemanaEnTabla = $resultados[0]['numero_semana'];
        $semanaKaliope = $resultados [0] ['semana_kaliope'];
        /*
         * ahora revisamos si el numero de semana actual es igual al ultimo que esta ingresado en la tabla entonces
          retornamos el numero de semana 1 o 2 en curso
         * si en la tabla se registro por ejemplo en la semana 30, y ahorita estamos en la semana 30
         * entonces se usa el registro de la tabla, que seria la semanaKaliope
         */

        if ($semanaActual == $numeroDeSemanaEnTabla) {            
            return $semanaKaliope;
        } else {
            
                         
            /*si la semana actual es 31 y en la tabla la ultima registrada es la 30 entonces
             * vamos a ingresar en la tabla una nueva semana kaliope, donde se registrara
             * la semana actual y se convertira a semanaKaliope, si en la tabla la semana 30
             * tenia como semanaKaliope 2 entonces la semana 31 sera semana kaliope 1,
             * despues para la semana 32 la semanaKaliope sera 2 y asi hasta finalizar el año
             */
            
            
            
            //operador ternario if para resumir en una sola linea el if, si la semana n la tabla es igual a 1 entonces la nueva semana incertada sera la dos, si es 2 entonces la nueva insertada sera 1
                $semanaParaInsertar = ($semanaKaliope == 1) ? 2 : 1;


                /*
                 * si ya es una nueva semana, corroboramos que sea solo un 1 mayor a la anterior, 
                 *para evitar que la fecha del servidor en alguna ocacion este mal 
                 *y aumente 2 o 3 semanas de una sola vez
                 */
                if ($semanaActual == $numeroDeSemanaEnTabla + 1) {
                    $setNumberWeek = $this->conexion->prepare(
                            "INSERT INTO week_number (semana_kaliope, numero_semana) VALUES ('$semanaParaInsertar','$semanaActual')"
                    )->execute();                    
                    //echo 'Se ha insertado una nueva semana kaliope normalmente <br>';
                }

                /*
                 * ahora cuando sea un nuevo año la semana cambiara desde el 52 o 53 dependiendo del año, al numero 01, es decir la primera semana del año
                 * para ese caso insertamos la nueva semana
                 */

                if ($semanaActual == 01 && $numeroDeSemanaEnTabla == 52 || $numeroDeSemanaEnTabla == 53) {
                    //operador ternario if para resumir en una sola linea el if, si la semana n la tabla es igual a 1 entonces la nueva semana incertada sera la dos, si es 2 entonces la nueva insertada sera 1


                    $setNumberWeek = $this->conexion->prepare(
                            "INSERT INTO week_number (semana_kaliope, numero_semana) VALUES ('$semanaParaInsertar','$semanaActual')"
                    )->execute();
                    //echo 'Nuevo año, se a insertado una nueva semana kaliope con nuevo año <br>';
                }

            }
            
            
            
            
            
             //volvemos a consultar al final la base de datos para devolver el numero de semana
            $statament = $this->conexion->prepare(
                    "SELECT * FROM week_number WHERE id = (SELECT MAX(id) FROM week_number)"
                    //"SELECT * FROM week_number ORDER BY id DESC"
            );
            $statament->execute();            
            $statament = $statament->fetchAll();
            $statament = $statament[0];
            //print_r($statament);

            return $statament['semana_kaliope'];
        }
      
    

  

        
    
    
}
