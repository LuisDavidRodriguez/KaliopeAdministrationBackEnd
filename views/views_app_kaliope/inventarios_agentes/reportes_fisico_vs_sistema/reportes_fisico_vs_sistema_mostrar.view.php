
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Reportes Fisico vs Sistema</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            

            
            .cadenaClass{
                width: 300px;
                
            }
                        
            
        </style>
        
    </head>
    <body>
        <h1>Reportes de comparaciones existentes</h1> 
        
        <!--Botones de uso general -->
        <a href="../MAIN_mostrar_inventarios.php"><-Menu Anterior</a>
        <br> <br><br> <br>
        
        
        <form action="reportes_fisico_vs_sistema_mostrar.php" method="POST">
            
            <select name="filtroPropietario">   
            
                    <option selected >sinFiltro</option>  
                    
                        
                        <?php foreach ($arrayPropietariosConFisicoVsSistema as $propietario):;?>                   
                    
                    
                    <option <?php echo ($filtroDePropietario==$propietario['propietario'])?"selected":""; ?> >
                        <?php echo $propietario['propietario']?>
                    </option>
                        
                        
                        <?php endforeach;?>       
                        
                        
            
                    </select>
   
            
            
            
            
            
            <p><input type="submit" name="enviar" value='filtrar'></p>
        </form>
        
        
       
        <br> <br><br> <br>
            
            
            <!--El array todos los reportes llega desde reportes_fisico_vs_sistema_mostrar.php-->
            Propietario___________Nombre Completo_____Fecha Realizado_____Hora Realizado______Importe Diferencias___Piezas Diferencias <br>
                <?php for ($index = 0; $index < count($arrayTodosLosReportes); $index++) :;?>
             
                    <input type="text" name="propietario" value="<?php echo $arrayTodosLosReportes[$index]['propietario']   ?>" readonly="true"/>           

                    <input type="text" name="nombreCompleto" value="<?php echo $arrayTodosLosReportes[$index]['nombre_completo']   ?>" readonly="true"/>

                    <input type="text" name="fecha" value="<?php echo $arrayTodosLosReportes[$index]['fecha_realizado']   ?>" readonly="true" />

                    <input type="text" name="hora" value="<?php echo $arrayTodosLosReportes[$index]['hora_realizado']   ?>" readonly="true" />
                    
                    <input type="text" name="importe" value="<?php echo $arrayTodosLosReportes[$index]['importe_dif']   ?>" readonly="true" />
                    
                    <input type="text" name="piezas" value="<?php echo $arrayTodosLosReportes[$index]['piezas_dif']   ?>" readonly="true" />
                    
                    <input type="text" class="cadenaClass" title="cadena1" name="cadena" value="<?php echo $arrayTodosLosReportes[$index]['cadena']   ?>" readonly="true" />
                    
                    
                    <!--Creamos el link que enviara a ver el detalle del reporte, y le enviamos por get el parametro del nombre de la cadena que se mostrara 
                    usamos el enconde porque si pasamos la cadena directa asi como se recupera de la base de datos, como viene con caracteres que se usan en HTML
                    el pripio link interpreta esos caracteres, y se daña la informacion que llega al documento. funciono pero cuando aumente la longitud de la cadena 
                    no se envia marca error de servidor
                    
                    mejor enviamos el propietario y en el documento lo volvemos a consultar a la base de datos pero solo la cadea
                    lO PEGAMOS SIN TABULADORES A LA IZQUIERDA PARA EVITAR EL CARACTER %20 QUE SE ENVIA EN LA URL
                    -->
<a href="reportes_fisico_vs_sistema_mostrar_detalle.php?
propietario=<?php echo $arrayTodosLosReportes[$index]['propietario']?>
&fecha=<?php echo $arrayTodosLosReportes[$index]['fecha_realizado']?>
&hora=<?php echo $arrayTodosLosReportes[$index]['hora_realizado']?>
">Mostrar Detalle del Reporte</a>
                    
                    
                    
                   
                    
                    <br> <br> 
                
                <?php endfor ;?>
                   
            
                <br> 
                <br> 
                <br> 
            
            
        
    </body>
</html>