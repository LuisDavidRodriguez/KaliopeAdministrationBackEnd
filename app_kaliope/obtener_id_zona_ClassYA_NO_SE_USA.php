<?php
include_once 'week_number_Class.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of obtener_id_zona_class
 *
 * @author david
 */
class obtener_id_zona_Class {
    //put your code here
    private $zonasJson;
    private $arrayZonas;
    
    public function __construct() {
        
        
        
        $this->zonasJson = '{                            
                    "1":{     
                        "A1":{"Monday":"ACAMBAY","Tuesday":"SAN JUAN DEL RIO","Wednesday":"PIEDRAS BLANCAS","Thursday":"CANALEJAS","Friday":"CIUDAD HIDALGO","Saturday":"ACAMBAY","Sunday":"ACAMBAY"},
                        "A2":{"Monday":"SOLIS","Tuesday":"CONTEPEC","Wednesday":"DIOS PADRE","Thursday":"TLALPUJAHUA","Friday":"ANGANGEO","Saturday":"","Sunday":""},
                        "A3":{"Monday":"CHAPA DE MOTA","Tuesday":"ALMOLOYA","Wednesday":"EL ORO","Thursday":"SAN LUCAS","Friday":"VILLA VICTORIA","Saturday":"","Sunday":""},
                        "A4":{"Monday":"VILLA DE ALLENDE","Tuesday":"EL PALMITO","Wednesday":"TEMOAYA","Thursday":"IXTLAHUACA","Friday":"POLOTITLAN","Saturday":"","Sunday":""},
                        "Q1":{"Monday":"TARIMORO","Tuesday":"EL JARAY","Wednesday":"SAN CLEMENTE","Thursday":"SALVATIERRA","Friday":"JERECUARO","Saturday":"","Sunday":""},
                        "Q2":{"Monday":"PUERTO BLANCO","Tuesday":"LOS RODRIGUEZ","Wednesday":"APAPATARO","Thursday":"SAN JOSE ITURBIDE","Friday":"CHIQUIMEQUILLAS","Saturday":"","Sunday":""},
                        "Q3":{"Monday":"EMPALME ESCOBEDO","Tuesday":"APASEO EL GRANDE","Wednesday":"CELAYA","Thursday":"TLACOTE","Friday":"CORONEO","Saturday":"","Sunday":""},
                        "Q4":{"Monday":"SAN LUIS DE LA PAZ","Tuesday":"CORREGIDORA","Wednesday":"SANTA MARIA DEL REFUGIO","Thursday":"SAN PABLO TOLIMAN","Friday":"QUERETARO","Saturday":"","Sunday":""},
                        "M1":{"Monday":"TACAMBARO","Tuesday":"SAN JUANICO","Wednesday":"PURUANDIRO","Thursday":"TZINTZUNTZAN","Friday":"TZITZIO","Saturday":"","Sunday":""},
                        "M2":{"Monday":"CHERAN","Tuesday":"PANINDICUARO","Wednesday":"JESUS DEL MONTE","Thursday":"ARIO DE ROSALES","Friday":"TARIMBARO","Saturday":"","Sunday":""},
                        "M3":{"Monday":"TORREON NUEVO","Tuesday":"VILLA JIMENEZ","Wednesday":"PURUARAN","Thursday":"ALVARO OBREGON","Friday":"ZIRAHUEN","Saturday":"","Sunday":""},
                        "M4":{"Monday":"PARACHO","Tuesday":"SANTIAGO UNDAMEO","Wednesday":"TINGAMBATO","Thursday":"COENEO","Friday":"CHARO","Saturday":"","Sunday":""}
                    },

                    "2":{
                        "A1":{"Monday":"AMEALCO","Tuesday":"TUPATARO","Wednesday":"JIQUIPILCO","Thursday":"MAYORAZGO","Friday":"LAJORDANA","Saturday":"","Sunday":""},
                        "A2":{"Monday":"TEMASCALCINGO","Tuesday":"SECTOR","Wednesday":"JILOTEPEC","Thursday":"JERAHUARO","Friday":"ACAMBARO","Saturday":"","Sunday":"TEMASCALCINGO"},
                        "A3":{"Monday":"HUIMILPAN","Tuesday":"SAN JOSE DEL RINCON","Wednesday":"ATLACOMULCO","Thursday":"HUICHAPAN","Friday":"SAN SEBASTIAN","Saturday":"","Sunday":""},
                        "A4":{"Monday":"JOCOTITLAN","Tuesday":"SOYANIQUILPAN","Wednesday":"SAN FELIPE","Thursday":"ACULCO","Friday":"PEDRO ESCOBEDO","Saturday":"","Sunday":""},
                        "Q1":{"Monday":"LOS CUES","Tuesday":"PARACUARO","Wednesday":"VILLA BERNAL","Thursday":"COLON","Friday":"APASEO EL ALTO","Saturday":"","Sunday":""},
                        "Q2":{"Monday":"LA GOTERA","Tuesday":"LA TRINIDAD","Wednesday":"EZEQUIEL MONTES","Thursday":"CIENEGUILLAS","Friday":"BARTOLOME AGUA CALIENTE","Saturday":"","Sunday":""},
                        "Q3":{"Monday":"MORALES","Tuesday":"VILLAGRAN","Wednesday":"TEQUISQUIAPAN","Thursday":"SAN MIGUEL","Friday":"JUVENTINO ROSAS","Saturday":"","Sunday":""},
                        "Q4":{"Monday":"OBRAJUELOS","Tuesday":"LA MONCADA","Wednesday":"JURIQUILLA","Thursday":"COYOTILLOS","Friday":"SAN MIGUEL OCTOPAN","Saturday":"","Sunday":""},
                        "M1":{"Monday":"ZINAPECUARO","Tuesday":"PATZCUARO","Wednesday":"CAPACUARO","Thursday":"HUANIQUEO","Friday":"CHILCHOTA","Saturday":"","Sunday":""},
                        "M2":{"Monday":"PEDERNALES","Tuesday":"CHUCANDIRO","Wednesday":"QUERENDARO","Thursday":"SANTA CLARA DEL COBRE","Friday":"SANTA FE DE LA LAGUNA","Saturday":"","Sunday":""},
                        "M3":{"Monday":"TARETAN","Tuesday":"CUTO DEL PORVENIR","Wednesday":"ZACAPU","Thursday":"LAGUNILLAS","Friday":"CORTIJO","Saturday":"","Sunday":""},
                        "M4":{"Monday":"URUAPAN","Tuesday":"QUIROGA","Wednesday":"SANTA FE DE LA LABOR","Thursday":"VILLA MADERO","Friday":"ERONGARICUARO","Saturday":"","Sunday":""}
                    }
                 }';
        
        $this->arrayZonas = json_decode($this->zonasJson,true); //parametro true para que los objetos devueltos sean convertidos a arrays asociativos
        //var_dump(json_decode($this->zonasJson,1));
        //print_r($arrayZonas);
    }
    
    
    
     public function getIdZona($numeroSemana, $rutaAsignada, $nombreDeDiaEnglish) {

        $valorRetorno = $this->arrayZonas[$numeroSemana][$rutaAsignada][$nombreDeDiaEnglish];

        if (empty($valorRetorno)) {
            echo "    Error de inicio de sesion no existe ruta asignada para el dia: $nombreDeDiaEnglish, de la semana: $numeroSemana, para la ruta: $rutaAsignada     ";
        } else {
            return $valorRetorno;
        }
    }
    
    

     public function getIdZonaActual($rutaAsignada) {
        date_default_timezone_set('America/Mexico_City');
        $numeroSemana = week_number_Class::getSemanaKaliope();        
        $nombreDeDiaEnglish = date("l");

        $valorRetorno = $this->arrayZonas[$numeroSemana][$rutaAsignada][$nombreDeDiaEnglish];

        if (empty($valorRetorno)) {
            echo "    Error de inicio de sesion no existe ruta asignada para el dia: $nombreDeDiaEnglish, de la semana: $numeroSemana, para la ruta: $rutaAsignada     ";
        } else {
            return $valorRetorno;
        }
    }    
    
    
    
    
    
    public function poblarBaseDatos (){
        //pobamos uan tabla desde el Json array
        print_r($this->arrayZonas);
        
        try {
            //realizamos la conexion a la base de datos
            $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
        } catch (PDOException $e) {
            echo "Error" . $e->getMessage();
        }
        
        $semanaNumero = 0;
        foreach ($this->arrayZonas as $semana) {
            $semanaNumero++;
            
            $rutaNumero = 0;
            $nombreRuta = "";
            foreach ($semana as $ruta) {
                $rutaNumero++;
                switch ($rutaNumero) {
                    case 1:
                        $nombreRuta = "A1";
                        break;
                    case 2:
                        $nombreRuta = "A2";
                        break;
                    case 3:
                        $nombreRuta = "A3";
                        break;
                    case 4:
                        $nombreRuta = "A4";
                        break;
                    case 5:
                        $nombreRuta = "Q1";
                        break;
                    case 6:
                        $nombreRuta = "Q2";
                        break;
                    case 7:
                        $nombreRuta = "Q3";
                        break;
                    case 8:
                        $nombreRuta = "Q4";
                        break;
                    case 9:
                        $nombreRuta = "M1";
                        break;
                    case 10:
                        $nombreRuta = "M2";
                        break;
                    case 11:
                        $nombreRuta = "M3";
                        break;
                    case 12:
                        $nombreRuta = "M4";
                        break;
                    
                }
                
                
                $diaNumero = 0;
                $nombreDia = "";
                foreach ($ruta as $dia) {
                    $diaNumero++;
                    
                    switch ($diaNumero) {
                        case 1:
                            $nombreDia = "Monday";
                            break;

                        case 2:
                            $nombreDia = "Tuesday";
                            break;
                        
                        case 3:
                            $nombreDia = "Wednesday";
                            break;
                        
                        case 4:
                            $nombreDia = "Thursday";
                            break;
                        
                        case 5:
                            $nombreDia = "Friday";
                            break;
                        
                        case 6:
                            $nombreDia = "Saturday";
                            break;
                        
                        case 7:
                            $nombreDia = "Sunday";
                            break;
                    }
                    
                    
                    $insertarRuta = $conexion->prepare(
                            "INSERT INTO nombres_zonas (semana, ruta, dia, nombre) VALUES ('$semanaNumero','$nombreRuta','$nombreDia','$dia')"                            
                            );
                    $insertarRuta->execute();
                    
                }
                
            }
            
        }
    }
    
  

}
