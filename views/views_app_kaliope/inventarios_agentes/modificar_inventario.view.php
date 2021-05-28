<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Inventarios de los Agentes</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h2>Generar un movimiento para el inventario: </h2> 
        
        <!--Botones de uso general -->
        <a href="MAIN_mostrar_inventarios.php"><-Menu Anterior</a>
        <br> <br><br> <br>
        
       
        
        <form action="modificar_inventario_confirmacion.php" method="POST">     
            
            <!--El dato del propietario llega desde el archivo modificar_inventario.php-->            
                             
                    Propietario:<input type="text" name="nombre" value="<?php echo $propietario?>" readonly="true"/>
                    Administrador:<input type="text" name="administrador" value=""/>
                    Motivo___:<textarea type="text" name="motivoMovimiento" value="" rows="2" cols="60" ></textarea>                   
                    <br> 
                    <br> 
                    
                    
                    
                    <h1>Entradas al Inventario</h1>
                    
                    Codigo:-----------------------Cantidad:<br>
                    <input type="text" name="codigo1" value=""> <input type="text" name="cantidad1" value="" /> <br> 
                    <input type="text" name="codigo2" value=""> <input type="text" name="cantidad2" value="" /> <br> 
                    <input type="text" name="codigo3" value=""> <input type="text" name="cantidad3" value="" /> <br> 
                    <input type="text" name="codigo4" value=""> <input type="text" name="cantidad4" value="" /> <br> 
                    <input type="text" name="codigo5" value=""> <input type="text" name="cantidad5" value="" /> <br> 
                    <input type="text" name="codigo6" value=""> <input type="text" name="cantidad6" value="" /> <br> 
                    <input type="text" name="codigo7" value=""> <input type="text" name="cantidad7" value="" /> <br> 
                    <input type="text" name="codigo8" value=""> <input type="text" name="cantidad8" value="" /> <br> 
                    <input type="text" name="codigo9" value=""> <input type="text" name="cantidad9" value="" /> <br> 
                    <input type="text" name="codigo10" value=""> <input type="text" name="cantidad10" value="" /> <br> 
                    <input type="text" name="codigo11" value=""> <input type="text" name="cantidad11" value="" /> <br>
                    <input type="text" name="codigo12" value=""> <input type="text" name="cantidad12" value="" /> <br> 
                    <input type="text" name="codigo13" value=""> <input type="text" name="cantidad13" value="" /> <br> 
                    <input type="text" name="codigo14" value=""> <input type="text" name="cantidad14" value="" /> <br> 
                    <input type="text" name="codigo15" value=""> <input type="text" name="cantidad15" value="" /> <br> 
                    <input type="text" name="codigo16" value=""> <input type="text" name="cantidad16" value="" /> <br> 
                    <input type="text" name="codigo17" value=""> <input type="text" name="cantidad17" value="" /> <br> 
                    <input type="text" name="codigo18" value=""> <input type="text" name="cantidad18" value="" /> <br> 
                    <input type="text" name="codigo19" value=""> <input type="text" name="cantidad19" value="" /> <br> 
                    <input type="text" name="codigo20" value=""> <input type="text" name="cantidad20" value="" /> <br> 
                    <input type="text" name="codigo21" value=""> <input type="text" name="cantidad21" value="" /> <br> 
                    <input type="text" name="codigo22" value=""> <input type="text" name="cantidad22" value="" /> <br>
                    <input type="text" name="codigo23" value=""> <input type="text" name="cantidad23" value="" /> <br> 
                    <input type="text" name="codigo24" value=""> <input type="text" name="cantidad24" value="" /> <br> 
                    <input type="text" name="codigo25" value=""> <input type="text" name="cantidad25" value="" /> <br> 
                                     
                    
                    <br> 
                    
                    
                    <h1>Salidas del Inventario</h1>
                    
                    Codigo:-----------------------Cantidad:<br>
                    <input type="text" name="codigo1s" value=""> <input type="text" name="cantidad1s" value="" /> <br> 
                    <input type="text" name="codigo2s" value=""> <input type="text" name="cantidad2s" value="" /> <br> 
                    <input type="text" name="codigo3s" value=""> <input type="text" name="cantidad3s" value="" /> <br> 
                    <input type="text" name="codigo4s" value=""> <input type="text" name="cantidad4s" value="" /> <br> 
                    <input type="text" name="codigo5s" value=""> <input type="text" name="cantidad5s" value="" /> <br> 
                    <input type="text" name="codigo6s" value=""> <input type="text" name="cantidad6s" value="" /> <br> 
                    <input type="text" name="codigo7s" value=""> <input type="text" name="cantidad7s" value="" /> <br> 
                    <input type="text" name="codigo8s" value=""> <input type="text" name="cantidad8s" value="" /> <br> 
                    <input type="text" name="codigo9s" value=""> <input type="text" name="cantidad9s" value="" /> <br> 
                    <input type="text" name="codigo10s" value=""> <input type="text" name="cantidad10s" value="" /> <br> 
                    <input type="text" name="codigo11s" value=""> <input type="text" name="cantidad11s" value="" /> <br>
                    <input type="text" name="codigo12s" value=""> <input type="text" name="cantidad12s" value="" /> <br> 
                    <input type="text" name="codigo13s" value=""> <input type="text" name="cantidad13s" value="" /> <br> 
                    <input type="text" name="codigo14s" value=""> <input type="text" name="cantidad14s" value="" /> <br> 
                    <input type="text" name="codigo15s" value=""> <input type="text" name="cantidad15s" value="" /> <br> 
                    <input type="text" name="codigo16s" value=""> <input type="text" name="cantidad16s" value="" /> <br> 
                    <input type="text" name="codigo17s" value=""> <input type="text" name="cantidad17s" value="" /> <br> 
                    <input type="text" name="codigo18s" value=""> <input type="text" name="cantidad18s" value="" /> <br> 
                    <input type="text" name="codigo19s" value=""> <input type="text" name="cantidad19s" value="" /> <br> 
                    <input type="text" name="codigo20s" value=""> <input type="text" name="cantidad20s" value="" /> <br> 
                    <input type="text" name="codigo21s" value=""> <input type="text" name="cantidad21s" value="" /> <br> 
                    <input type="text" name="codigo22s" value=""> <input type="text" name="cantidad22s" value="" /> <br>
                    <input type="text" name="codigo23s" value=""> <input type="text" name="cantidad23s" value="" /> <br> 
                    <input type="text" name="codigo24s" value=""> <input type="text" name="cantidad24s" value="" /> <br> 
                    <input type="text" name="codigo25s" value=""> <input type="text" name="cantidad25s" value="" /> <br>
                                     
                    
                    <br>
                
                
                   
            
                <br> 
                <br> 
                <br> 
            
            
            
            
            <input type="submit" name="continuar" value="Continuar"/>
            
        </form>
    </body>
</html>