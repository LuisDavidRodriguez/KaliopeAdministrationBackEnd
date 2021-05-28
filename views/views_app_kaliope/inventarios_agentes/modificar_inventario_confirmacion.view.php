<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Confirmacion modificacion</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h2>Revisa 2 veces el movimiento que se va a realizar </h2> 
        
       
       
            
            <!--El dato del propietario llega desde el archivo confirmacion_modificar_inventario.php-->     
            
            <h4> se realizara el siguiente movimiento en el inventario de: </h4>
                             
                    Propietario___:<input type="text" name="nombre" value="<?php echo $propietario?>" readonly="true"/>    
                    <br> 
                    Administrador:<input type="text" name="administrador" value="<?php echo $administrador?>" readonly="true"/>
                    <br>
                    Motivo___:<textarea type="text" name="motivoMovimiento" readonly="" rows="2" cols="60" ><?php echo $motivoMovimiento;?></textarea>
                    <br>
                       
                     
                    <br> 
                    
                    
                    
                    <h3>Entradas al Inventario</h3>
                    
                    Codigo:-----------------------Cantidad:<br>
                    
                    <?php foreach ($arrayEntradas as $entradas):;?>
                    <input type="text" name="codigo" value="<?php echo $entradas['codigo']; ?>" readonly="true" /> <input type="text" name="cantidad" value="<?php echo $entradas['cantidad']; ?>" readonly="true" /> <br> 
                                     
                    <?php endforeach;?>                 
                    Piezas Entradas: <input type="text" name="entradasTotal" value="<?php echo $piezasTotalesEntradas; ?>" readonly="true"/>
                    <br>
                    
                     <h3>Salidas del Inventario</h3>
                    
                    Codigo:-----------------------Cantidad:<br>
                    
                    <?php foreach ($arraySalidas as $salidas):;?>
                    <input type="text" name="codigo" value="<?php echo $salidas['codigo']; ?>" readonly="true"/> <input type="text" name="cantidad" value="<?php echo $salidas['cantidad']; ?>" readonly="true"/> <br> 
                                     
                    <?php endforeach;?>                 
                    Piezas Salidas: <input type="text" name="cantidad" value="<?php echo $piezasTotalesSalidas ?>" readonly="true"/> <br> 
                    <br>
                    
                    
                    
                    
                    
                
                
                   
            
                    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
                    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
                    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
                
                
<!--Creamos el link que enviara a afectar el inventario, y le enviamos por get el parametro del nombre del propietario y los arrays de entradas y array de salidas

lO CREAMOS SIN TABULADORES A LA IZQUIERDA PARA EVITAR EL CARACTER %20 QUE SE ENVIA EN LA URL-->
<a href="modificar_inventario_afectar.php?
propietario=<?php echo $propietario;?>
&administrador=<?php echo $administrador;?>
&motivo=<?php echo $motivoMovimiento;?>
&entradas=<?php echo urlencode(serialize($arrayEntradas)) ;?>
&salidas=<?php echo urlencode(serialize($arraySalidas)) ;?>
                   
">Realizar Movimientos</a>
            

        


        
    </body>
</html>