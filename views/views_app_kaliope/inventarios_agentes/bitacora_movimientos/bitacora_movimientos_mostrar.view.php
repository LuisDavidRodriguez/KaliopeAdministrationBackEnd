
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Bitacora Movimientos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Bitacoras de todas las modificaciones a inventarios</h1> 
        
        <!--Botones de uso general -->
        <a href="../MAIN_mostrar_inventarios.php"><-Menu Anterior</a>
        <br> <br><br> <br>
        
        
        
        <form action="bitacora_movimientos_mostrar.php" method="POST">
            
            <select name="filtroPropietario">   
            
                    <option selected >sinFiltro</option>  
                    
                        
                        <?php foreach ($arrayUsuariosConModificaciones as $propietario):;?>                   
                    
                    
                    <option <?php echo ($filtroDePropietario==$propietario['propietario'])?"selected":""; ?> >
                        <?php echo $propietario['propietario']?>
                    </option>
                        
                        
                        <?php endforeach;?>       
                        
                        
            
                    </select>
   
            
            
            
            
            
            <p><input type="submit" name="enviar" value='filtrar'></p>
        </form>
        
        
       
        <br> <br><br> <br>
            
            
            <!--El array todos los reportes llega desde reportes_fisico_vs_sistema_mostrar.php-->
            Propietario___________Administrador_______Motivo____________Fecha Realizado_______Hora Realizado______Entradas____________Salidas______________Existecias Antes_____Existencias Despues____Version Antes______Version Despues <br>
                <?php for ($index = 0; $index < count($arrayTodasLasBitacoras); $index++) :;?>
             
                    <input type="text" name="propietario" value="<?php echo $arrayTodasLasBitacoras[$index]['propietario']   ?>" readonly="true"/>           

                    <input type="text" name="nombreCompleto" value="<?php echo $arrayTodasLasBitacoras[$index]['administrador']   ?>" readonly="true"/>

                    <input type="text" name="fecha" value="<?php echo $arrayTodasLasBitacoras[$index]['motivo']   ?>" readonly="true" />

                    <input type="text" name="hora" value="<?php echo $arrayTodasLasBitacoras[$index]['fecha_realizado']   ?>" readonly="true" />
                    
                    <input type="text" name="importe" value="<?php echo $arrayTodasLasBitacoras[$index]['hora_realizado']   ?>" readonly="true" />
                    
                    <input type="text" name="piezas" value="<?php echo $arrayTodasLasBitacoras[$index]['entradas']   ?>" readonly="true" />
                    
                    <input type="text" name="piezas" value="<?php echo $arrayTodasLasBitacoras[$index]['salidas']   ?>" readonly="true" />
                    
                    <input type="text" name="piezas" value="<?php echo $arrayTodasLasBitacoras[$index]['existencias_antes']   ?>" readonly="true" />
                    
                    <input type="text" name="piezas" value="<?php echo $arrayTodasLasBitacoras[$index]['existencias_despues']   ?>" readonly="true" />
                    
                    <input type="text" name="piezas" value="<?php echo $arrayTodasLasBitacoras[$index]['version_antes']   ?>" readonly="true" />
                    
                    <input type="text" name="piezas" value="<?php echo $arrayTodasLasBitacoras[$index]['version_despues']   ?>" readonly="true" />
                    
                    

                    <!--Creamos el link que enviara a ver el detalle del reporte, y le enviamos por get el parametro del nombre de la cadena que se mostrara 
                    usamos el enconde porque si pasamos la cadena directa asi como se recupera de la base de datos, como viene con caracteres que se usan en HTML
                    el pripio link interpreta esos caracteres, y se daña la informacion que llega al documento. funciono pero cuando aumente la longitud de la cadena 
                    no se envia marca error de servidor
                    
                    mejor enviamos el propietario y en el documento lo volvemos a consultar a la base de datos pero solo la cadea
                    
                    PEGAMOS EL LINK A LA IZQUIERDA SIN TABULADORES PARA EVITAR LOS %20 QUE SE ENVIAN EN LA URL
                    -->
<a href="bitacora_movimientos_mostrar_detalle.php?
propietario=<?php echo $arrayTodasLasBitacoras[$index]['propietario']?>
&fecha=<?php echo $arrayTodasLasBitacoras[$index]['fecha_realizado']?>
&hora=<?php echo $arrayTodasLasBitacoras[$index]['hora_realizado']?>
">Mostrar Detalle del Reporte</a>
                    
                    
                    
                   
                    
                    <br> <br> 
                
                <?php endfor ;?>
                   
            
                <br> 
                <br> 
                <br> 
            
            
        
    </body>
</html>