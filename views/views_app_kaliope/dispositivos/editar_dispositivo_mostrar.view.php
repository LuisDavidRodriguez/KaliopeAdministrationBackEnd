<!DOCTYPE html>
<!--
Mostramos los datos del usuario consultado, con los datos posibles en edicion 
el boton submit enviara a guardar los datos
-->
<html>
    <head>
        <title>Editar Usuario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Editar Usuario</h1>
        
        
        
        <a href="MAIN_mostrar_dispositivos.php"><-Menu Anterior</a>
        <br> <br><br> <br>
        
        
        id_____________________Modelo_____________uuid____________Autorizado__FechaSolicitud_______Comentarios
        <form  action="editar_dispositivo_afectar.php" method="POST" >            
            
            
            
            
            
            
            <input type="text" name="id" value="<?php echo $arrayDatosDispositivo['id'];?>" readonly=""/>           

                <input type="text" name="modelo" value="<?php echo $arrayDatosDispositivo['modelo_movil'];?>" disabled="" />

                <input type="text" name="uuid" value="<?php echo $arrayDatosDispositivo['uuid'];?>" disabled=""/>

                &nbsp&nbsp&nbsp&nbsp
                <select name="autorizado">               
                        
                        
                    
                         <!--Usamos el operador ternario para poner como seleccionado el valor adecuado al select dependiendo -->                       
                        <option <?php echo ($arrayDatosDispositivo['autorizado']==1)?'selected':'';?>>                            
                            1
                        </option>                        
                        
                        <option <?php echo ($arrayDatosDispositivo['autorizado']==0)?'selected':'';?>>                            
                            0
                        </option>                         
                        
            
                    </select>
                
                &nbsp&nbsp&nbsp&nbsp
                
                <input type="text" name="fecha" value="<?php echo $arrayDatosDispositivo['fecha_hora_solicitud'];?>" disabled=""/>
                
                <input type="text" name="comentarios" value="<?php echo $arrayDatosDispositivo['comentarios'];?>"/>
                
                
                <br> <br><br> <br>
            
            <input type="submit" name="Guardar Cambios" value="Guardar Cambios"/>
        </form>
        
                

        <br><br><br><br>
         
    </body>
</html>
