
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Detalle de movimiento</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>
    <body>
        
        
            
        <h1>Detalle del Movimiento</h1> 
        
        <!--Botones de uso general -->
        <a href="MAIN_movimientos_inventarios_mostrar.php"><-Menu Anterior</a>
        <br> <br>
        
        
        
        


                Propietario:<input type="text" name="nombre" value="<?php echo $arrayDetalleMovimiento['propietario'] ?>" readonly="true"/>       
                <br>
                Nombre completo:<input type="text" name="nombreCompleto" value="<?php echo $arrayDetalleMovimiento['nombre_completo'] ?>" readonly="true"/>
                <br>
                Usuario que Reviso:<input type="text" name="sucursal" value="<?php echo $arrayDetalleMovimiento['usuario_reviso'] ?>" readonly="true" />
                <br>
                Nombre quien reviso:<input type="text" name="sucursal" value="<?php echo $arrayDetalleMovimiento['nombre_completo_reviso'] ?>" readonly="true" />
                <br>
                Usurio Sucursal:<input type="text" name="sucursal" value="<?php echo $arrayDetalleMovimiento['usuario_sucursal'] ?>" readonly="true" />                
                <br><br>
                
                Fecha:<input type="text" name="fecha" value="<?php echo $arrayDetalleMovimiento['fecha_realizado'] ?>" readonly="true" />
                <br>
                Hora:<input type="text" name="hora" value="<?php echo $arrayDetalleMovimiento['hora_realizado'] ?>" readonly="true" />                
                <br>
                Tipo:<input type="text" name="tipo" value="<?php echo $arrayDetalleMovimiento['tipo_movimiento'] ?>" readonly="true" />
                <br>
                Enviado al Movil:<input type="text" name="tipo" value="<?php echo $arrayDetalleMovimiento['enviado_al_movil'] ?>" readonly="true" />
                <br>
                Hora de envio:<input type="text" name="tipo" value="<?php echo $arrayDetalleMovimiento['hora_de_envio_al_movil'] ?>" readonly="true" />
                <br><br> 
                
                <!--
                Propietario existencias Antes:<input type="text" name="tipo" value="<?php echo $arrayDetalleMovimiento['propietario_existencias_antes'] ?>" readonly="true" />
                <br>
                Propietario existencias Despues:<input type="text" name="tipo" value="<?php echo $arrayDetalleMovimiento['propietario_existencias_despues'] ?>" readonly="true" />
                <br>
                -->
                Propietario version despues:<input type="text" name="tipo" value="<?php echo $arrayDetalleMovimiento['propietario_version_despues'] ?>" readonly="true" />
                <br><br>
                Almacen existencias antes:<input type="text" name="tipo" value="<?php echo $arrayDetalleMovimiento['almacen_existencias_antes'] ?>" readonly="true" />
                <br>
                Almacen existencias despues:<input type="text" name="tipo" value="<?php echo $arrayDetalleMovimiento['almacen_existencias_despues'] ?>" readonly="true" />
                <br>
                Almacen version despues:<input type="text" name="tipo" value="<?php echo $arrayDetalleMovimiento['almacen_version_despues'] ?>" readonly="true" />

                <br><br><br><br>


            <!--El $arrayTodosLosMovimientos llega desde el archivo MAIN_movimientos_inventarios_mostrar-->
            Codigo_____________Piezas <br>
            <?php for ($index = 0; $index < count($arrayDetalleMovimientoPiezas); $index++) :; ?>

                <input type="text" name="nombre" value="<?php echo $arrayDetalleMovimientoPiezas[$index]['Codigo'] ?>" readonly="true"/>           

                <input type="text" name="nombreCompleto" value="<?php echo $arrayDetalleMovimientoPiezas[$index]['Cantidad'] ?>" readonly="true"/>
                
                <br> 

            <?php endfor; ?>
                
                <br>
                Importe:<input type="text" name="tipo" value="<?php echo $arrayDetalleMovimiento['total_importe'] ?>" readonly="true" />
                               
                Piezas:<input type="text" name="totalPz" value="<?php echo $arrayDetalleMovimiento['total_piezas'] ?>" readonly="true" />


            <br> 
            <br> 
            <br> 



        
    </body>
</html>