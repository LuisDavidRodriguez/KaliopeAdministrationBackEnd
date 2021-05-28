<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of utilitarios_Class
 *
 * @author david
 */
class utilitarios_Class {
    //put your code here
    
    
    /**
     *Consulta la Hora y fecha actual del sistema, con el timezone "America/Mexico_City"
     * 
     * @return string fecha y hora en formato hh:mm:ss dd-MM-yyyy
     */
    public static function fechaActualToText() {
        date_default_timezone_set('America/Mexico_City');
        //funcion para obtener la fecha actual del sistema y retornarla como texto concatenado    
        $fechaSolicitud = getdate();
        //print_r ($fechaSolicitud);
        $fechaTexto = $fechaSolicitud["hours"] . ":" . $fechaSolicitud["minutes"] . ":" . $fechaSolicitud["seconds"] . " " . $fechaSolicitud["mday"] . "-" . $fechaSolicitud["mon"] . "-" . $fechaSolicitud["year"];
        //echo $fechaTexto;
        return $fechaTexto;
    }
    
    /**
     * Consulta la Hora y fecha actual del sistema, con el timezone "America/Mexico_City"
     * 
     * @return string fecha en formato dd-MM-yyyy
     */
    public static function dameFecha_dd_mm_aaaa_ToText() {
        date_default_timezone_set('America/Mexico_City');
        //funcion para obtener la fecha actual del sistema y retornarla como texto concatenado    
        $fechaSolicitud = getdate();
        //print_r ($fechaSolicitud);
        $fechaTexto = $fechaSolicitud["mday"] . "-" . $fechaSolicitud["mon"] . "-" . $fechaSolicitud["year"];
        //echo $fechaTexto;
        return $fechaTexto;
    }
    
    
    /**
     * Consulta la Hora y fecha actual del sistema, con el timezone "America/Mexico_City"
     * @return string en formato dd-MM-yyyy----hh:mm
     * 
     */
    public static function fechaActual_dd_mm_aaaa_hh_mmToText() {
        date_default_timezone_set('America/Mexico_City');
        //funcion para obtener la fecha actual del sistema y retornarla como texto concatenado    
        $fechaSolicitud = getdate();
        //print_r ($fechaSolicitud);
        $fechaTexto = $fechaSolicitud["mday"] . "-" . $fechaSolicitud["mon"] . "-" . $fechaSolicitud["year"]."----".$fechaSolicitud["hours"] . ":" . $fechaSolicitud["minutes"];
        //echo $fechaTexto;
        return $fechaTexto;
    }
    
    /**
     * Consulta la Hora actual del sistema, con el timezone "America/Mexico_City"
     * @return string hora en formato hh:mm:ss
     */
    public static function horaActual_hh_mm_ss_ToText() {
        date_default_timezone_set('America/Mexico_City');
        //funcion para obtener la fecha actual del sistema y retornarla como texto concatenado    
        $fechaSolicitud = getdate();
        //print_r ($fechaSolicitud);
        $fechaTexto = $fechaSolicitud["hours"] . ":" . $fechaSolicitud["minutes"] . ":" . $fechaSolicitud["seconds"];
        //echo $fechaTexto;
        return $fechaTexto;
    }
    
    
    
    /**
     * Regresa el numero de semana que esta en curso de un determinado año
     * @param int $year el año del cual quieres saber la semana
     * @return int el numero de semana en curso
     */
    public static function cuantasSemanasTieneUnAno($year) {
         //este codigo lo copiamos de aqui https://www.lawebdelprogramador.com/codigo/PHP/2558-Obtener-la-ultima-semana-de-un-ano.html
        //NO ME PREGUNTES COMO FUNCIONA PORQUE FUCK QUE NO LO SE XD EL CHISTE ES QUE
        //TE ENTREGA CUAL ES EL NUMERO TOTAL DE SEMANAS QUE TIENE UN AÑO POR EJEMPLO EL 2019 TIENE 52
        //PERO EL 2020 TIENE 53

        $date = new DateTime;



        //Establecemos la fecha segun el estandar ISO 8601 (numero de semana)

        $date->setISODate($year, 53);



        //Si estamos en la semana 53 devolvemos 53, sino, es que estamos en la 52

        if ($date->format("W") == "53")
            return 53;
        else
            return 52;
    }
    
    
    
    //lo puedes implementar facilmente en un bucle for
    /*
     * for($i=2000;$i<=2020;$i++)

        {

            echo "<br>".$i." - ".NumeroSemanasTieneUnAno($i);

        }
     */

    
    
    
    
    
}
