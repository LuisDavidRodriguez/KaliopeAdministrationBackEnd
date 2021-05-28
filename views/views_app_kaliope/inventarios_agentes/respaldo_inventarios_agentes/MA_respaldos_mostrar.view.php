
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
        
        
            
        <h1>Usuarios con inventario registrados</h1> 
        
        <!--Botones de uso general -->
        <a href="../MAIN_mostrar_inventarios.php"><-Menu Anterior</a>
        <br> <br><br> <br> &nbsp
       
        
        
        <br>
        
        <form action="MAIN_respaldos_mostrar.php" method="POST">
            
            <select name="filtroPropietario">   
            
                    <option selected >sinFiltro</option>  
                    
                        
                        <?php foreach ($arrayPropietariosConRespaldo as $propietario):;?>                   
                    
                    
                    <option <?php echo ($filtroDePropietario==$propietario['propietario'])?"selected":""; ?> >
                        <?php echo $propietario['propietario']?>
                    </option>
                        
                        
                        <?php endforeach;?>       
                        
                        
            
                    </select>
            
            &nbsp&nbsp
            
            <select name="filtroId">   
            
                    <option selected >sinFiltro</option>  
                        
                        <?php foreach ($arrayTodosLosId as $id):;?>                   
                    
                    
                        <option <?php echo ($filtroDeId==$id[0])?"selected":""; ?>>
                             <?php echo $id[0]?>
                        </option>
                        
                        
                        <?php endforeach;?>                    
                        
            
                    </select>
            
            
            
            
            
            <p><input type="submit" name="enviar" value='filtrar'></p>
        </form>
        
        
            
       
        
        
        
       
        <br> <br><br> <br><br> <br><br> <br>
        
         

            <!--El array datos finales llega desde el archivo mostrar_inventario.php-->
            Id___________________Propietario__________Version_____________Piezas Totales_________Importe Total____Hora envio de version___Hora de respaldo_______Json<br>
            <?php for ($index = 0; $index < count($arrayRegistrosPorMostrar); $index++) :; ?>
            
            

                <input id="Hola" type="text" name="nombre" value="<?php echo $arrayRegistrosPorMostrar[$index]['id'] ?>" readonly="true"/>           
                
                <input id="Hola" type="text" name="nombre" value="<?php echo $arrayRegistrosPorMostrar[$index]['propietario'] ?>" readonly="true"/>           

                <input type="text" name="existencias" value="<?php echo $arrayRegistrosPorMostrar[$index]['version'] ?>" readonly="true"/>

                <input type="text" name="importe" value="<?php echo $arrayRegistrosPorMostrar[$index]['piezas_totales'] ?>" readonly="true" />

                <input type="text" name="pulsera" value="<?php echo $arrayRegistrosPorMostrar[$index]['importe_total'] ?>" readonly="true" />
                
                <input type="text" name="importe" value="<?php echo $arrayRegistrosPorMostrar[$index]['hora_de_envio'] ?>" readonly="true" />

                <input type="text" name="pulsera" value="<?php echo $arrayRegistrosPorMostrar[$index]['hora_de_respaldo'] ?>" readonly="true" />
                
                <textarea type="text" name="cadena" readonly="" rows="1" cols="30" ><?php echo $arrayRegistrosPorMostrar[$index]['json_inventario'] ?></textarea>


                <!--Creamos el link que enviara a ver el detalle del inventario, y le enviamos por get el parametro del nombre de usuario-->
                <a href="detalle_del_respaldo.php?id=<?php echo $arrayRegistrosPorMostrar[$index]['id'] ?>">Mostrar Detalle</a>
                &nbsp&nbsp


                <br><br> 

            <?php endfor; ?>


            <br> 
            <br> 
            <br> 

    </body>
</html>