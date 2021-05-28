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
        
        
        
        <a href="MAIN_usuarios_mostrar.php"><-Menu Anterior</a>
        <br> <br><br> <br>
        
        
        <form  action="editar_usuario_guardar.php" method="POST" >            
            
            
            
            
            
            
                Nombre Completo: <input type="text" name="nombre" value="<?php echo $arrayDatosUsuario['nombre_empleado'];?>" placeholder= "el nombre del usuario"/>           

                Usuario: <input type="text" name="usuario" value="<?php echo $arrayDatosUsuario['usuario'];?>" placeholder= "el nombre del usuario" readonly="true" />

                Password: <input type="text" name="password" value="<?php echo $arrayDatosUsuario['password'];?>" placeholder= "el nombre del usuario" />

                Codigo Pulsera: <input type="text" name="pulsera" value="<?php echo $arrayDatosUsuario['codigo_empleado_pulsera'];?>" placeholder= "el nombre del usuario" />

                
                Ruta Asignada: <select name="rutaAsignada" title="Seleccione RUta">               
                        
                        
                    
                    <!--LLenamos el selector de la ruta con todas las rutas que existen
                        en el punto del option ingresamos un operador ternario para resumir el if, lo que haremos sera 
                    dejar como seleccionado la ruta que tiene asignado el usuario, porque si no solo cargaria las rutas existentes en el select
                    pero dejaria como seleccionada la primera de la lista, y no a la que el usuario ya tiene asignada
                    para esto en cada interacion del for, en el if se trata lo siguiente
                    si la ruta asignada que se rescata de la info del usuario por ejemplo si el usuario juan tiene la ruta A2
                    en la primera iteracion del bucle
                    la ruta que se rescata de la base de datos de rutas existentes
                    valdra A1 y como no son iguales no se colocara el selected, solo se añade como una opcion del selector
                    despues la siguiente iteracion la ruta es A2 que concuerda con la que el usuario tiene asignada por lo tanto se coloca el selected
                    y en las demas iteraciones cuando no concuerda solo se añaden los items.
                    
                    -->
                        <?php foreach ($arrayRutasExistentes as $ruta):;?>
                        
                        <option     <?php echo ($arrayDatosUsuario['ruta_asignada']==$ruta['ruta'])?'selected':'';?>    >
                            
                        <?php echo $ruta['ruta']?>                            
                        </option>                        
                        
                        <?php endforeach;?>
                        
                        
            
                    </select>
                

                Autorizado: <input type="text" name="autorizado" value="<?php echo $arrayDatosUsuario['autorizado'];?>" placeholder= "el nombre del usuario" />  
                
                
                <br> <br><br> <br>
            
            <input type="submit" name="Guardar Cambios" value="Guardar Cambios"/>
        </form>
        
        
        
        
        
        <h4>Observaciones:</h4>
        <h4>-El campo usuario no puede ser editado, si necesita modificarlo forsosamente tendra que eliminar el usuario y crearlo denuevo</h4>
        <h4>-La ruta asignada no debera estar en uso por otro usuario</h4>        
        <h4>-El campo autorizado es para bloquear el acceso del usuario a la app de Kaliope si se coloca en 0, cuando el trabajador inicie sesion, se le arrojara un mensaje de error, para autorizarlo colocar 1</h4>
        <h4>-Use los campos SinAsignar1,2,3,4 en la ruta, para acomodar las rutas de los usuarios acorde a lo que necesita</h4>

        <br><br><br><br>
         
    </body>
</html>
