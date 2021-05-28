
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Dispositivos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Dispositivos que corren una instancia de la app Kaliope</h1> 
        
        <!--Botones de uso general -->
        <a href="../MAIN_menu_sistemas_kaliope.view.php"><-Menu Anterior</a>
        <br> 
        
        
        
       
        <br>
             
            
            <!--El array datos finales llega desde el archivo mostrar_inventario.php-->
            id___________________Modelo_____________uuID______________Autorizado__________Fecha de solicitud____Comentarios<br>
                <?php for ($index = 0; $index < count($arrayTodosLosDispositivos); $index++) :;?>
             
                    <input type="text" name="id" value="<?php echo $arrayTodosLosDispositivos[$index]['id']   ?>" readonly="true"/>           

                    <input type="text" name="modelo" value="<?php echo $arrayTodosLosDispositivos[$index]['modelo_movil']   ?>" readonly="true"/>
                    
                    <input type="text" name="uuid" value="<?php echo $arrayTodosLosDispositivos[$index]['uuid']   ?>" readonly="true" />

                    <input type="text" name="autorizado" value="<?php echo $arrayTodosLosDispositivos[$index]['autorizado']   ?>" readonly="true" />
 
                    <input type="text" name="fecha" value="<?php echo $arrayTodosLosDispositivos[$index]['fecha_hora_solicitud']   ?>" readonly="true" />
                    
                    <input type="text" name="comentarios" value="<?php echo $arrayTodosLosDispositivos[$index]['comentarios']   ?>" readonly="true" />
                    
                    
                    <!--Creamos el link que enviara a editar el usuario, y le enviamos por get el parametro del nombre de usuario-->
                    &nbsp&nbsp
                    <a href="editar_dispositivo_mostrar.php?id=<?php echo $arrayTodosLosDispositivos[$index]['id']?>">Editar</a>
                    
                    &nbsp&nbsp
                    <!--Creamos el link que enviara a eliminar el usuario, y le enviamos por get el parametro el id y como eliminar false-->
                    <a href="eliminar_dispositivo.php?id=<?php echo $arrayTodosLosDispositivos[$index]['id']?>&eliminar=0">Eliminar</a>
                    
                    
                    
                    
                   
                    
                    <br>
                
                <?php endfor ;?>
                   
          
    </body>
</html>