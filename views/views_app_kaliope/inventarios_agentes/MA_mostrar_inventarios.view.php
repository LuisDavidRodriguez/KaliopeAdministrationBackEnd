
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
        <a href="../MAIN_menu_sistemas_kaliope.view.php"><-Menu Anterior</a>
        <br> <br><br> <br> &nbsp
        
        <a class="botonImportarDatos" href="intercambiar_inventario_mostrar.php">Intercambiar Inventario</a>
        
        &nbsp&nbsp
        <a href="crear_inventario_mostrar.php">Crear Inventario</a>
        &nbsp&nbsp
        <a href="reportes_fisico_vs_sistema/reportes_fisico_vs_sistema_mostrar.php">Reportes de Fisico Vs Sistema</a>
        &nbsp&nbsp
        <a href="bitacora_movimientos/bitacora_movimientos_mostrar.php">Movimientos Bitacora</a>
        &nbsp&nbsp            
        <a href="movimientos_inventarios_sucursales/MAIN_movimientos_inventarios_mostrar.php">Movimientos Almacen</a>
        &nbsp&nbsp            
        <a href="respaldo_inventarios_agentes/MAIN_respaldos_mostrar.php">Respaldos</a>
        &nbsp&nbsp            
        <a href="actualizar_inventarios_con_lista_precios.html">Actualizar Lista Precios</a>
            
       
        
        
        
       
        <br> <br><br> <br><br> <br><br> <br>
        
         

            <!--El array datos finales llega desde el archivo mostrar_inventario.php-->
            Propietario____________Piezas Totales______Importe Total_____________Version_________Enviado Al Movil___Hora envio_________Recibido desde el movil<br>
            <?php for ($index = 0; $index < count($arrayDatosFinales); $index++) :; ?>

                <input id="Hola" type="text" name="nombre" value="<?php echo $arrayDatosFinales[$index]['propietario'] ?>" readonly="true"/>           

                <input type="text" name="existencias" value="<?php echo $arrayDatosFinales[$index]['existencias'] ?>" readonly="true"/>

                <input type="text" name="importe" value="<?php echo $arrayDatosFinales[$index]['importe'] ?>" readonly="true" />

                <input type="text" name="pulsera" value="<?php echo $arrayDatosFinales[$index]['version'] ?>" readonly="true" />
                
                <input type="text" name="importe" value="<?php echo $arrayDatosFinales[$index]['enviado_al_movil'] ?>" readonly="true" />

                <input type="text" name="pulsera" value="<?php echo $arrayDatosFinales[$index]['hora_de_envio_al_movil'] ?>" readonly="true" />
                
                <input type="text" name="pulsera" value="<?php echo $arrayDatosFinales[$index]['hora_sincronizado_desde_el_movil'] ?>" readonly="true" />


                <!--Creamos el link que enviara a ver el detalle del inventario, y le enviamos por get el parametro del nombre de usuario-->
                <a href="mostrar_detalle_inventario.php?propietario=<?php echo $arrayDatosFinales[$index]['propietario'] ?>">Mostrar Detalle</a>
                &nbsp&nbsp
                <!--Creamos el link que enviara a modificar inventario, y le enviamos por get el parametro del nombre de usuario-->
                <a href="modificar_inventario.php?propietario=<?php echo $arrayDatosFinales[$index]['propietario'] ?>">Modificar Inventario</a>
                &nbsp&nbsp
                <!--Creamos el link que enviara llenar el inventario  con archivo de texto y le enviamos por get el parametro del nombre de usuario-->
                <a href="llenar_inventariotxt.view.php?propietario=<?php echo $arrayDatosFinales[$index]['propietario'] ?>">LLenar inventario con TXT</a>
                &nbsp&nbsp
                <!--Creamos el link que enviara inventario Fisico vs existencias y le enviamos por get el parametro del nombre de usuario-->
                <a href="fisico_vs_sistema/fisico_vs_sistema_captura.view.php?propietario=<?php echo $arrayDatosFinales[$index]['propietario'] ?>&eliminar=0">FisicoVsSistema</a>
                &nbsp&nbsp
                <!--Creamos el link que enviara eliminar el inventario y le enviamos por get el parametro del nombre de usuario-->
                <a href="eliminar_inventario.php?propietario=<?php echo $arrayDatosFinales[$index]['propietario'] ?>&eliminar=0">Eliminar el inventario</a>




                <br><br> 

            <?php endfor; ?>


            <br> 
            <br> 
            <br> 

    </body>
</html>