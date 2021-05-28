<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Detalle de Inventario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h2>Detalle del Inventario</h2> 
        
        
        
        <!--Botones de uso general -->
        <a href="MAIN_mostrar_inventarios.php"><-Menu Anterior</a>
        <br> <br><br> <br>
        
       
        
        <form action="" method="POST">     
            
            <!--El array $inventario llega desde el archivo mostrar_detalle_inventario.php-->
            Propietario:-------------------Codigo:--------------Vendedora:---------------Socia:-----------------------Empresaria:<br> <br> 
            
                <?php for ($index = 0; $index < count($detalleInventario); $index++) :;?>
             
                    <input type="text" name="nombre" value="<?php echo $detalleInventario[$index]['propietario'] ?>"  disabled=""/>           

                    <input type="text" name="codigo" value="<?php echo $detalleInventario[$index]['codigo'] ?>"  disabled=""/>


                    <input type="text" name="vendedora" value="<?php echo $detalleInventario[$index]['vendedora'] ?>"  disabled=""/>

                    <input type="text" name="socia" value="<?php echo $detalleInventario[$index]['socia'] ?>" disabled="" />

                    <input type="text" name="empresaria" value="<?php echo $detalleInventario[$index]['empresaria'] ?>"  disabled=""/>

                    Precio:<input type="text" name="precio" value="<?php echo $detalleInventario[$index]['precio']?>"  readonly="true"/>

                    Existencias:<input type="text" name="existencia" value="<?php echo $detalleInventario[$index]['existencia'] ?>" readonly="true"/>

                    <br> <br> 
                
                <?php endfor ;?>
                   
            
                <br> 
                <br> 
                <br> 
            
            
            
        </form>
    </body>
</html>