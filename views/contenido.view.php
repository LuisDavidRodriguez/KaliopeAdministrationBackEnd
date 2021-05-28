<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Cousine" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="css/estilos.contenido.view.css">
    <title>Mostrando Clientes</title>
</head>

<body>

    
<div class="contenedor">

<a href="cerrar.php" class="botonCerrar">Cerrar sesion</a>
<a href="selecciona_ruta.php" class="botonSelecciona">Selecciona ruta</a>
<a href="importar_datos.php" class="botonImportarDatos">Importar datos</a>
<a href="importar_clientes.php" class="botonImportarClientes">Importar clientes</a>
<a href="ingresar_cliente.php?zona=<?php echo $zona?>&fecha=<?php echo $fecha?>" class="botonIngresar">Ingresar cliente</a>
<a href="exportar_datos.php?zona=<?php echo $zona?>&fecha=<?php echo $fecha?>" class="botonExportar">Exportar datos</a>
<a href="representar_mapa.php?zona=<?php echo $zona?>&fecha=<?php echo $fecha?>&vehiculo=<?php echo $vehiculo[0]['vehiculo']?>" class="botonExportar">Ver Mapa</a>

<input type="text" readonly="readonly" name="zona" value="<?php echo $zona?>" title="Zona">
<input type="text" readonly="readonly" name="fecha" value="<?php echo $fecha?>" title="Fecha">



<form action="guardar.php" method="POST">

<!-- Formulario: * DATOS DEL VEHICULO * Muestra los Datos del vehiculos -->
<div class="datos_vehiculo">

<legend>Datos del Vehiculo</legend>

    <input type="text" legend="Folio" readonly="readonly" name="folio_vehiculo" value="<?php echo $vehiculo[0]['folio'];?>" title="FOLIO"> 
    
    Vehiculo:<input type="text" name="vehiculo" value="<?php echo $vehiculo[0]['vehiculo'];?>" title="VEHICULO">

    Combustible dia:<input type="text" name="gasolina" value="<?php echo $vehiculo[0]['gasolina'];?>" title="GASOLINA">

    Km inicial:<input type="text" name="kilometraje_inicial" value="<?php echo $vehiculo[0]['kilometraje_inicial'];?>" title="KILOMETRAJE INICIAL">
    
    Km final:<input type="text" name="kilometraje_final" value="<?php echo $vehiculo[0]['kilometraje_final'];?>" title="KILOMETRAJE FINAL">
    <br/>
    Km recorrido<input type="text" readonly="readonly" name="kilometraje_recorrido" value="<?php echo $vehiculo[0]['kilometraje_recorrido'];?>" title="KILOMETRAJE RECORRIDO">
    
    Gasolina mañana:<input type="text" readonly="readonly" name="gasolina_manana" value="<?php echo $vehiculo[0]['gasolina_manana'];?>" title="GASOLINA MAÑANA">

    Gas mañana:<input type="text" readonly="readonly" name="gas_lp_manana" value="<?php echo $vehiculo[0]['gas_lp_manana'];?>" title="GAS LP MAÑANA">

</div>
<!-- Formulario: * DATOS DEL VEHICULO * Muestra los Datos del vehiculos -->

<!-- Formulario: * DATOS DEL INVENTARIO * Muestra los Datos del inventario -->
<div class="datos_mercancia">

<legend>Datos del Inventario</legend>

<input type="text" readonly="readonly" name="folio_inventario" value="<?php echo $inventario[0]['folio'];?>" title="FOLIO">

Pz iniciales:<input type="text" name="piezas_iniciales" value="<?php echo $inventario[0]['piezas_iniciales'];?>" title="PIEZAS INICIALES">

Salidas:<input type="text" name="salidas" value="<?php echo $inventario[0]['salidas'];?>" title="SALIDAS">

<input type="text" name="importe_salidas" value="<?php echo $inventario[0]['importe_salidas'];?>" title="IMPORTE SALIDAS">

<input type="text" name="descripcion_salidas" value="<?php echo $inventario[0]['descripcion_salidas'];?>" title="DESCRIPCION SALIDAS">

Entradas:<input type="text" name="entradas" value="<?php echo $inventario[0]['entradas'];?>" title="ENTRADAS">

<input type="text" name="importe_entradas" value="<?php echo $inventario[0]['importe_entradas'];?>" title="IMPORTE ENTRADAS">

<input type="text" name="descripcion_entradas" value="<?php echo $inventario[0]['descripcion_entradas'];?>" title="DESCRIPCION ENTRADAS">

Total:<input type="text" readonly="readonly" name="total_piezas" value="<?php echo $inventario[0]['total_piezas'];?>" title="TOTAL">

Entregadas:<input type="text" readonly="readonly" name="piezas_entregadas" value="<?php echo $entregadas;?>" title="PIEZAS ENTREGADAS">

Devueltas:<input type="text" readonly="readonly" name="piezas_devueltas" value="<?php echo $devolucion;?>" title="PIEZAS DEVUELTAS">

Pz finales:<input type="text" readonly="readonly" name="piezas_finales" value="<?php echo $piezas_finales;?>" title="PIEZAS FINALES">

Cuentas:<input type="text" readonly="readonly" name="clientes_totales" value="<?php echo $clientes_totales;?>" title="CLIENTES TOTALES">

Nuevas:<input type="text" readonly="readonly" name="nuevas" value="<?php echo $clientes_nuevos;?>" title="NUEVAS">

Cobro:<input type="text" readonly="readonly" name="nuevas" value="<?php echo $cobro;?>" title="COBRO">

</div>
<!-- Formulario: * DATOS DEL INVENTARIO * Muestra los Datos del inventario -->

    <?php $i=0; ?>

    <?php foreach ($datos_clientes as $dato):;?>

     <?php $i=$i+1; ?>

        <div class="formulario">

            <!-- Formulario: * DATOS DEL CLIENTE * Muestra los Datos del cliente -->
            <div class="datos_cliente">

                <legend>Datos del Cliente</legend>

                <input type="text" readonly="readonly" name="folio<?php echo $i; ?>" value="<?php echo $dato['folio'];?>" title="Folio">

                <input type="text" name="zona<?php echo $i; ?>" value="<?php echo $dato['zona'];?>" title="Zona">
                
                <input type="text" name="cuenta<?php echo $i; ?>" value="<?php echo $dato['cuenta'];?>" title="Cuenta">

                <input type="text" name="nombre_cliente<?php echo $i; ?>" value="<?php echo $dato['nombre'];?>" title="Nombre">

                <input type="text" name="telefono<?php echo $i; ?>" value="<?php echo $dato['telefono'];?>" title="Telefono">


                <select name="grado<?php echo $i; ?>" title="Grado">

                    <option <?php if ($dato['grado'] == 'VENDEDORA') {
                            echo 'selected';
                    }else{echo '';}?>>VENDEDORA</option>


                    <option <?php if ($dato['grado'] == 'SOCIA') {
                            echo 'selected';
                    }else{echo '';}?>>SOCIA</option>


                    <option <?php if ($dato['grado'] == 'EMPRESARIA') {
                            echo 'selected';
                    }else{echo '';}?>>EMPRESARIA</option>

                </select>

                <input type="text" name="credito<?php echo $i; ?>" value="<?php echo $dato['credito'];?>" title="Credito">

                <select name="dias<?php echo $i; ?>" title="Tiempo">

                    <option <?php if ($dato['dias'] == '14') {
                            echo 'selected';
                    }else{echo '';}?>>14</option>

                    <option <?php if ($dato['dias'] == '28') {
                            echo 'selected';
                    }else{echo '';}?>>28</option>

                    </select>
               
                    <select name="estado<?php echo $i; ?>" title="Estado">

                    <option <?php if ($dato['estado'] == 'ACTIVO') {
                            echo 'selected';
                    }else{echo '';}?>>ACTIVO</option>

                    <option <?php if ($dato['estado'] == 'REACTIVAR') {
                            echo 'selected';
                    }else{echo '';}?>>REACTIVAR</option>

                    <option <?php if ($dato['estado'] == 'LIO') {
                            echo 'selected';
                    }else{echo '';}?>>LIO</option>

                    <option <?php if ($dato['estado'] == 'PROSPECTO') {
                            echo 'selected';
                    }else{echo '';}?>>PROSPECTO</option>

                    <option <?php if ($dato['estado'] == 'BAJA') {
                            echo 'selected';
                    }else{echo '';}?>>BAJA</option>

                </select>

                    
                <input type="text" name="observaciones<?php echo $i; ?>" value="<?php echo $dato['observaciones'];?>" title="Observaciones">

                <input type="text" name="latitud_fija<?php echo $i; ?>" value="<?php echo $dato['latitud_fija'];?>" title="Latitud Fija">

                <input type="text" name="longitud_fija<?php echo $i; ?>" value="<?php echo $dato['longitud_fija'];?>" title="Longitud Fija">

                <input type="text" name="latitud<?php echo $i; ?>" value="<?php echo $dato['latitud'];?>" title="Latitud del movimiento">

                <input type="text" name="longitud<?php echo $i; ?>" value="<?php echo $dato['longitud'];?>" title="Longitud del movimiento">

            </div>
            <!-- Formulario: * DATOS DEL CLIENTE * Muestra los Datos del cliente -->


            <!-- Formulario: * PUNTOS * Muestra el banco de puntos del cliente -->
            <div class="puntos">

                <legend>Puntos</legend>

                <input type="text" name="puntos_disponibles<?php echo $i; ?>" value="<?php echo $dato['puntos_disponibles']?>" title="Puntos Disponibles">

                <input type="text" name="puntos_entregados<?php echo $i; ?>" value="<?php echo $dato['puntos_entregados']?>" title="Puntos Entregados">

                <input type="text" name="puntos_cambiados<?php echo $i; ?>" value="<?php echo $dato['puntos_cambiados']?>" title="Puntos Cambiados">

                <input type="text" name="puntos_restantes<?php echo $i; ?>" value="<?php echo $dato['puntos_restantes']?>" title="Puntos Restantes">


            </div>
            <!-- Formulario: * PUNTOS * Muestra el banco de puntos del cliente -->


            <!-- Formulario: * A CARGO DEL CLIENTE * Muestra la mercancia acargo -->
            <div class="a_cargo">

                <legend>Mercancia a Cargo</legend>

                <input type="text" name="piezas_cargo<?php echo $i; ?>" value="<?php echo $dato['piezas_cargo'];?>" title="Piezas a Cargo">

                <input type="text" name="importe_cargo<?php echo $i; ?>" value="<?php echo $dato['importe_cargo'];?>" title="Importe a Cargo">

                <input type="text" name="adeudo_cargo<?php echo $i; ?>" value="<?php echo $dato['adeudo_cargo'];?>" title="Adeudo a Cargo">

                <input type="text" name="hora_cargo<?php echo $i; ?>" value="<?php echo $dato['hora_cargo']?>" title="Hora de Cargo">             

                <input type="text" name="fecha_cargo<?php echo $i; ?>" value="<?php echo $dato['fecha_cargo'];?>" title="Fecha de Cargo">

                <input type="text" name="fecha_vence_cargo<?php echo $i; ?>" value="<?php echo $dato['fecha_vence_cargo'];?>" title="Vencimiento del Cargo">

                <input type="text" name="mercancia_cargo<?php echo $i; ?>" value="<?php echo $dato['mercancia_cargo'];?>" id="mercanciaCargo" title="<?php echo 'Mercancia a cargo: ' . $dato['mercancia_cargo'];?>">

            </div>
            <!-- Formulario: * A CARGO DEL CLIENTE * Muestra la mercancia acargo -->
        

            <!-- Formulario: * MOVIMIENTOS * Muestra la movimientos del cliente -->
            <div class="movimientos">

                <legend>Movimientos Generados</legend>
                
                <input type="text" name="pz_devueltas<?php echo $i; ?>" value="<?php echo $dato['pz_devueltas']?>" title="Piezas Devueltas">

                <input type="text" name="importe_devolucion<?php echo $i; ?>" value="<?php echo $dato['importe_devolucion']?>" title="Importe Devolucion">

                <input type="text" name="cierre<?php echo $i; ?>" value="<?php echo $dato ['cierre']?>" title="Cierre">

                <input type="text" name="pago_cierre<?php echo $i; ?>" value="<?php echo $dato['pago_cierre']?>" title="Pago">

                <input type="text" name="pago_adeudo<?php echo $i; ?>" value="<?php echo $dato['pago_adeudo']?>" title="Pago de Adeudo">

                <input type="text" name="pago_otro<?php echo $i; ?>" value="<?php echo $dato['pago_otro']?>" title="Pago otro">

                <input type="text" name="pago_dif_regalo<?php echo $i; ?>" value="<?php echo $dato['pago_dif_regalo']?>" title="Diferencia de Regalo">

                <input type="text" name="total_pagos<?php echo $i; ?>" value="<?php echo $dato['total_pagos']?>" title="Total de Pagos">

                <input type="text" name="mercancia_devuelta<?php echo $i; ?>" value="<?php echo $dato['mercancia_devuelta']?>" id="mercanciaDevuelta" title="<?php echo 'Mercancia devuelta: ' . $dato['mercancia_devuelta']?>">

            </div>
            <!-- Formulario: * MOVIMIENTOS * Muestra la movimientos del cliente -->


            <!-- Formulario: * ENTREGADO * Muestra la mercancia entregada -->
            <div class="entregado">


                <legend>Mercancia Entregada</legend>

                <input type="text" name="piezas_entregadas<?php echo $i; ?>" value="<?php echo $dato['piezas_entregadas']?>" title="Piezas Entregadas">

                <input type="text" name="importe_entregado<?php echo $i; ?>" value="<?php echo $dato['importe_entregado']?>" title="Importe">

                <input type="text" name="adeudo<?php echo $i; ?>" value="<?php echo $dato['adeudo']?>" title="Adeudo">

                <input type="text" name="fecha_vencimiento<?php echo $i; ?>" value="<?php echo $dato['fecha_vencimiento']?>" title="Vencimiento">

                <input type="text" name="hora<?php echo $i; ?>" value="<?php echo $dato['hora']?>" title="Hora Movimiento">

                <input type="text" name="fecha_entrega<?php echo $i; ?>" value="<?php echo $dato['fecha_entrega']?>" title="Fecha de Entrega">
                                
                <input type="text" name="reporte_agente<?php echo $i; ?>" value="<?php echo $dato['reporte_agente']?>" id="reporteAgente" title="<?php echo 'Reporte del agente: ' . $dato['reporte_agente']?>">
                
                <input type="text" name="historial<?php echo $i; ?>" value="<?php echo $dato['historial']?>" title="historial">

                <input type="text" name="mercancia_entregada<?php echo $i; ?>" value="<?php echo $dato['mercancia_entregada']?>" id="mercanciaEntregada" title="<?php echo 'Mercancia Entregada: ' . $dato['mercancia_entregada']?>">

                <input type="text" name="reporte_administracion<?php echo $i; ?>" value="<?php echo $dato['reporte_administracion']?>" id="observacionesAdministracion" title="<?php echo 'Observaciones administracion: ' . $dato['reporte_administracion']?>">

                <div class="firmaVoz">
                <label>
                    <input type="radio" name="firma_voz<?php echo $i; ?>" value = "SI" title="Firma de voz"<?php if ($dato['firma_voz'] == 'SI') {echo 'checked';}?>> SI
                </label>
                <label>
                    <input type="radio" name="firma_voz<?php echo $i; ?>" value="NO" title="Firma de voz"<?php if ($dato['firma_voz'] == 'NO') {echo 'checked';}?>> NO
                </label>
                </div>

                <div class="revisada">
                <label class="radio">SI
                <input type="radio" name="revisada<?php echo $i; ?>" value = "SI" title="Revisar"<?php if ($dato['revisada'] == 'SI') {echo 'checked';}?>>
                <span class="check"></span>
                </label>
                <label class="radio2">NO 
                    <input type="radio" name="revisada<?php echo $i; ?>" value="NO" title="Revisar"<?php if ($dato['revisada'] == 'NO') {echo 'checked';}?>>
                    <span class="check2"></span>
                </label>
                </label>
                </div>

                
            </div>
            <!-- Formulario: * ENTREGADO * Muestra la mercancia entregada -->
        </div>
   
    <?php endforeach; ?>

    <input type="submit" name="enviar" value="Guardar" class="botonGuardar">

</form>         


    <!-- Barra de Fechas *Muestra las fechas* -->
    <div class="barra_fechas">

        <ul>
            <li><a href="#">&laquo;</a></li> 

            <?php foreach ($datos_fecha as $fechas):?>

            <li 
            <?php if ($fecha == $fechas['fecha']){echo 'class="active"';}?>
            ><a href="?<?php echo'zona=' . $zona ?>&fecha=<?php echo $fechas['fecha'] ?>"><?php echo $fechas['fecha'] ?></a>
            </li>

            <?php endforeach ?>
    
            <li><a href="#">&raquo;</a></li>
        </ul>

    </div>
    <!-- Barra de Fechas *Muestra las fechas* -->

</div>
</body>
</html>

