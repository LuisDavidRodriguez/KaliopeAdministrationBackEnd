<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Igresa un nuevo usuario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Ingresa un Usuario Nuevo</h1> 
        
        
        <!--Botones de uso general -->
        <a href="MAIN_usuarios_mostrar.php"><-Menu Anterior</a>
        <br> <br>     
        
        
        
        
        
        
        <form action="nuevo_usuario_guardar.php" method="POST">            
            
            
            
            
            
            
           

                Nombre Completo:<input type="text" name="nombre" value="" placeholder= "Nombre completo del trabajador" size="20"/>           
                <br> 
                Usuario:.................<input type="text" name="usuario" value="" placeholder= "Nombre de usuario unico" >
                <br> 
                Password:............. <input type="text" name="password" value="" placeholder= "Contraseña"/>
                <br> 
                Codigo Pulsera:.... <input type="text" name="pulsera" value="" placeholder= "El codigo de su pulsera"/>
                <br> 
                Ruta Asignada:..... <select name="rutaAsignada" title="Seleccione RUta">               
                        
                        
                    
                    <!--LLenamos el selector de la ruta con todas las rutas que existen
                        este array nos lo envia el archivo nuevo_usuario_mostrar.php
                    
                    -->
                        <?php foreach ($arrayRutasExistentes as $ruta):;?>
                        
                        <option>                            
                        <?php echo $ruta['ruta']?>                            
                        </option>                        
                        
                        <?php endforeach;?>
                        
                        
            
                    </select>
                <br> 
                
                
                Autorizado:........... <input type="text" name="autorizado" value="1" placeholder= "Solo 0 o 1" />  <br>     
            
                <br> 
                <br> 
                <br> 
            
            
            
            
            <input type="submit" name="btnGuardar" value="Guardar"/>
            
        </form>
        
        
        <h4>Observaciones:</h4>
        <h4>-Al ingresar un nuevo usuario se creara en automatico un inventario en 0 acorde con la lista de precios del sistema</h4>
        <h4>-La ruta asignada no debera estar en uso por otro usuario</h4>        
        <h4>-El campo autorizado es para bloquear el acceso del usuario a la app de Kaliope si se coloca en 0, cuando el trabajador inicie sesion, se le arrojara un mensaje de error, para autorizarlo colocar 1</h4>
        <h4>-Use los campos SinAsignar1,2,3,4 en la ruta, para crear el usuario y posteriormente en el campo de editar usuario dar orden a las rutas</h4>

        
    </body>
</html>
