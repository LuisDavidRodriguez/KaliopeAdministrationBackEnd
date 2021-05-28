
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Movimientos de inventarios en sucursales</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>
    <body>
        
        
            
        <h1>Usuarios con movimientos registrados</h1> 
        
        <!--Botones de uso general -->
        <a href="../MAIN_mostrar_inventarios.php"><-Menu Anterior</a>
        <br> <br><br> <br> &nbsp
        
        
        
        
        
        
        <form action="MAIN_movimientos_inventarios_mostrar.php" method="POST">
            
            <select name="filtroPropietario">   
            
                    <option selected >sinFiltro</option>  
                    
                        
                        <?php foreach ($arrayUsuariosConMovimientos as $propietario):;?>                   
                    
                    
                    <option <?php echo ($filtroDePropietario==$propietario['propietario'])?"selected":""; ?> >
                        <?php echo $propietario['propietario']?>
                    </option>
                        
                        
                        <?php endforeach;?>       
                        
                        
            
                    </select>
            
           <!--
            
            <select name="filtroSucursal">   
            
                    <option selected >sinFiltro</option>  
                        
                        <?php foreach ($arraySucursales as $sucursal):;?>                   
                    
                    
                        <option <?php echo ($filtroDeSucursal==$sucursal[0])?"selected":""; ?>>
                             <?php echo $sucursal[0]?>
                        </option>
                        
                        
                        <?php endforeach;?>                    
                        
            
                    </select>
            
            
            
            
                        <select name="filtroFecha">   
            
                    <option selected >sinFiltro</option>  
                        
                        <?php foreach ($arrayFiltroDeFechas as $fecha):;?>                   
                    
                    
                        <option <?php echo ($arrayFiltroDeFechas==$fecha[0])?"selected":""; ?>>
                             <?php echo $fecha[0]?>
                        </option>
                        
                        
                        <?php endforeach;?>                    
                        
            
                    </select>
            
            -->
            
            
            
            
            
            <p><input type="submit" name="enviar" value='filtrar'></p>
        </form>
        
        
        
       
       
        
        
        
       
        <br> <br><br>
        <form >     
            
            <!--Filtrar para la vista-->
            

            <!--El $arrayTodosLosMovimientos llega desde el archivo MAIN_movimientos_inventarios_mostrar-->
            Propietario__________Nombre completo______Sucursal___________Fecha______________Hora_______________Total pz_______________Tipo_____________enviado_____________hora <br>
            <?php for ($index = 0; $index < count($arrayTodosLosMovimientos); $index++) :; ?>

                <input type="text" name="nombre" value="<?php echo $arrayTodosLosMovimientos[$index]['propietario'] ?>" readonly="true"/>           

                <input type="text" name="nombreCompleto" value="<?php echo $arrayTodosLosMovimientos[$index]['nombre_completo'] ?>" readonly="true"/>

                <input type="text" name="sucursal" value="<?php echo $arrayTodosLosMovimientos[$index]['usuario_sucursal'] ?>" readonly="true" />

                <input type="text" name="fecha" value="<?php echo $arrayTodosLosMovimientos[$index]['fecha_realizado'] ?>" readonly="true" />
                
                <input type="text" name="hora" value="<?php echo $arrayTodosLosMovimientos[$index]['hora_realizado'] ?>" readonly="true" />
                
                <input type="text" name="totalPz" value="<?php echo $arrayTodosLosMovimientos[$index]['total_piezas'] ?>" readonly="true" />
                
                <input type="text" name="tipo" value="<?php echo $arrayTodosLosMovimientos[$index]['tipo_movimiento'] ?>" readonly="true" />
                
                <input type="text" name="enviado" value="<?php echo $arrayTodosLosMovimientos[$index]['enviado_al_movil'] ?>" readonly="true" />
                
                <input type="text" name="hora" value="<?php echo $arrayTodosLosMovimientos[$index]['hora_de_envio_al_movil'] ?>" readonly="true" />


                <!--Creamos el link que enviara a ver el detalle del movimiento, y le enviamos por get el parametro del id-->
                <a href="mostrar_detalle.php?id=<?php echo $arrayTodosLosMovimientos[$index]['id'] ?>">Mostrar Detalle</a>
                
                <br><br> 

            <?php endfor; ?>


            <br> 
            <br> 
            <br> 



        </form>
    </body>
</html>