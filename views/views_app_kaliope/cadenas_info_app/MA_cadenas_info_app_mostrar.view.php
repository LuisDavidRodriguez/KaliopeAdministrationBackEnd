
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Cadenas Recibidas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>
    <body>
        
        
            
        <h1>Todas Las Cadenas Registradas</h1> 
        
        <!--Botones de uso general -->
        <a href="../MAIN_menu_sistemas_kaliope.view.php"><-Menu Anterior</a>
        <br> <br>

       
        <br> <br><br> 
        <form >     

            <!--El array datos finales llega desde el archivo mostrar_inventario.php-->
            id_________________Fecha inicio sesion_____Usuario_________Fecha Consulta1__________Zona1__________Fecha Consulta2__________Zona2_________fechaActualizacion_____Cadena <br>
            
            <?php for ($index = 0; $index < count($cadenasInfoApp); $index++) :; ?>

                <input type="text" name="id" value="<?php echo $cadenasInfoApp[$index]['id'] ?>" readonly="true"/>        
                
                <input type="text" name="fechaSesion" value="<?php echo $cadenasInfoApp[$index]['fecha_hora_inicio_sesion'] ?>" readonly="true" />

                
                <input type="text" name="usurio" value="<?php echo $cadenasInfoApp[$index]['usuario'] ?>" readonly="true" />

                <input type="text" name="fechaClientes" value="<?php echo $cadenasInfoApp[$index]['fecha_clientes_consulta1'] ?>" readonly="true"/>
                
                <input type="text" name="zona" value="<?php echo $cadenasInfoApp[$index]['zona1'] ?>" readonly="true"/>           
                
                <input type="text" name="fechaClientes" value="<?php echo $cadenasInfoApp[$index]['fecha_clientes_consulta2'] ?>" readonly="true"/>
                
                <input type="text" name="zona" value="<?php echo $cadenasInfoApp[$index]['zona2'] ?>" readonly="true"/>     

                <input type="text" name="actualizacion" value="<?php echo $cadenasInfoApp[$index]['fecha_subida'] ?>" readonly="true"/>
                
                <textarea type="text" name="cadena" readonly="" rows="2" cols="80" ><?php echo $cadenasInfoApp[$index]['cadena_datos'] ?></textarea>

                
                <br><br> 

            <?php endfor; ?>


            <br> 
            <br> 
            <br> 



        </form>
    </body>
</html>