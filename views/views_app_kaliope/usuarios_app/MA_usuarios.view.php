<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Usuarios App Kaliope</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Lista de todos los usuarios de la app Kaliope</h1>
        
        
        
        <a href="../MAIN_menu_sistemas_kaliope.view.php"><-Menu Anterior</a>
        <br> <br><br> <br>
        
        
         <a href="nuevo_usuario_mostrar.php">Agregar Nuevo Usuario</a>
        
        <br> <br> <br> <br> <br> <br> 
        
        <form>            
            
            
            
            
            
            
            <?php for ($index = 0; $index < count($datosUsuarios); $index++):;?>

                Nombre Completo: <input type="text" name="nombre <?php echo $index;?>" value="<?php echo $datosUsuarios[$index]['nombre_empleado'];?>" placeholder= "el nombre del usuario" size="20" readonly="true"/>           

                Usuario: <input type="text" name="usuario <?php echo $index;?>" value="<?php echo $datosUsuarios[$index]['usuario'];?>" placeholder= "el nombre del usuario" readonly="true"/>

                Password: <input type="text" name="password <?php echo $index;?>" value="<?php echo $datosUsuarios[$index]['password'];?>" placeholder= "el nombre del usuario" readonly="true"/>

                Codigo Pulsera: <input type="text" name="pulsera <?php echo $index;?>" value="<?php echo $datosUsuarios[$index]['codigo_empleado_pulsera'];?>" placeholder= "el nombre del usuario" readonly="true"/>

                Ruta Asignada: <input type="text" name="rutaAsignada <?php echo $index;?>" value="<?php echo $datosUsuarios[$index]['ruta_asignada'];?>" placeholder= "el nombre del usuario" readonly="true"/>

                Autorizado: <input type="text" name="autorizado <?php echo $index;?>" value="<?php echo $datosUsuarios[$index]['autorizado'];?>" placeholder= "el nombre del usuario" readonly="true"/>  
                
                <!--Creamos su boton para editar el usuario y le enviamos como parametro el usuario del array-->
                <a href="editar_usuario_mostrar.php?usuario=<?php echo $datosUsuarios[$index]['usuario']; ?>">Editar</a>
                &nbsp&nbsp&nbsp&nbsp
                <a href="eliminar_usuario.php?usuario=<?php echo $datosUsuarios[$index]['usuario']; ?>&eliminar=0">Eliminar</a>
                <br>
                <br>
                
                
                
            
            <?php endfor; ?>
                
            
            
        </form>
         
    </body>
</html>
