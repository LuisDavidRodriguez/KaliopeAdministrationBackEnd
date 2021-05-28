<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Cousine" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="css/estilos.vehiculos.view.css">
    <title>Mostrando Clientes</title>
</head>

<body>

    
<div class="contenedor">

<a href="cerrar.php" class="botonCerrar">Cerrar sesion</a>
<a href="selecciona_vehiculo.php" class="botonSeleccionaUnidad">Selecciona unidad</a>
<a href="selecciona_ruta.php" class="botonSeleccionaRuta">Selecciona ruta</a>
<input id="datos" type="text" readonly="readonly" name="agente" value="<?php echo $unidad?>" title="Unidad">

<form action="guardar_vehiculos.php" method="POST">

<legend>Datos de la Unidad</legend>
<input id="folio" type="text" name="folio" value="<?php echo $datos_unidad['folio']?>" title="Folio" readonly="readonly">
<input id="unidad" type="text" name="unidad" value="<?php echo $datos_unidad['unidad']?>" title="Numero de unidad" readonly="readonly">
Marca <input type="text" name="marca_unidad" value="<?php echo $datos_unidad['marca_unidad']?>" title="Marca del Vehiculo">
Modelo <input type="text" name="modelo" value="<?php echo $datos_unidad['modelo']?>" title="Modelo del Vehiculo">
Año <input type="text" name="ano" value="<?php echo $datos_unidad['ano']?>" title="Año del Vehiculo">
Color <input type="text" name="color" value="<?php echo $datos_unidad['color']?>" title="Color Original">
Placas <input type="text" name="placas" value="<?php echo $datos_unidad['placas']?>" title="Placas del vehiculo">
No. Serie <input id="serie" type="text" name="numero_serie" value="<?php echo $datos_unidad['numero_serie']?>" title="Numero de Serie">
Seguro <input type="text" name="seguro" value="<?php echo $datos_unidad['seguro']?>" title="Aseguradora">
Poliza <input type="text" name="poliza" value="<?php echo $datos_unidad['poliza']?>" title="Poliza cobertura">
<br>
Lugar <input type="text" name="lugar" value="<?php echo $datos_unidad['lugar']?>" title="Lugar de compra">
Descripcion <input id="descripcion" type="text" name="descripcion" value="<?php echo $datos_unidad['descripcion']?>" title="Color Original">
Costo <input type="text" name="costo" value="<?php echo $datos_unidad['costo']?>" title="Costo vehiculo">
Km Actual <input type="text" name="km_actual" value="<?php echo $datos_unidad['km_actual']?>" title="Kilometraje actual" readonly="readonly">
<br>

<legend>Mantenimiento Unidad</legend>

    <table>

    <tr>
    <th>Folio</th>
    <th>Unidad</th>
    <th>km Reparacion</th>
    <th>Fecha Reparacion</th>
    <th>Piezas cambiadas</th>
    <th>Marca</th>
    <th>Compra</th>
    <th>Taller</th>
    <th>Vida km</th>
    <th>Km cambio</th>
    <th>Fecha cambio</th>
    <th>Dias restantes</th>
    <th>Km restante</th>
    <th>Cambiado</th>
    </tr>
    <?php $i=0; ?>

    <?php foreach ($reparaciones_unidad as $reparacion):;?>
    <?php $i=$i+1; ?>
    <tr>
    <td><input id="folioReparacion" type="text" name="folio_reparacion<?php echo $i?>" value="<?php echo $reparacion[0]?>" title="Kilometraje de Reparacion" readonly="readonly"></td>
    <td><input id="unidadReparacion" type="text" name="unidad_reparacion<?php echo $i?>" value="<?php echo $reparacion[1]?>" title="Unidad de Reparacion" readonly="readonly"></td>
    <td><input id="kmReparacion" type="text" name="kilometraje<?php echo $i?>" value="<?php echo $reparacion[2]?>" title="Kilometraje de Reparacion"></td>
    <td><input id="fechaReparacion" type="text" name="fecha_mantenimiento<?php echo $i?>" value="<?php echo $reparacion[3]?>" title="Fecha de Reparacion"></td>
    <td><input id="piezasCambiadas" type="text" name="piezas_cambiadas<?php echo $i?>" value="<?php echo $reparacion[4]?>" title="Piezas cambiadas"></td>
    <td><input id="marca" type="text" name="marca<?php echo $i?>" value="<?php echo $reparacion[5]?>" title="Marca"></td>
    <td><input id="compra" type="text" name="compra<?php echo $i?>" value="<?php echo $reparacion[6]?>" title="Compra"></td>
    <td><input id="taller" type="text" name="lugar_servicio<?php echo $i?>" value="<?php echo $reparacion[7]?>" title="Taller de servicio"></td>
    <td><input id="km" type="text" name="km_vida<?php echo $i?>" value="<?php echo $reparacion[8]?>" title="Kilometraje vida de refaccion"></td>
    <td><input id="kmCambio" type="text" name="kilometraje_cambio<?php echo $i?>" value="<?php echo $reparacion[9]?>" title="Kilometraje de cambio" readonly="readonly"></td>
    <td><input id="fechaCambio" type="text" name="fecha_cambio<?php echo $i?>" value="<?php echo $reparacion[10]?>" title="Fecha de cambio"readonly="readonly"></td>
    <td><input id="diasRestantes" type="text" name="dias_restantes<?php echo $i?>" value="<?php echo $reparacion[11]?>" title="Dias restantes"readonly="readonly"></td>
    <td><input id="kmRestante" type="text" name="kilometraje_restantes<?php echo $i?>" value="<?php echo $reparacion[12]?>" title="Kilometraje restante"readonly="readonly"></td>
    <td><input <?php if($reparacion[13] == 'SI'){echo 'id="cambiado"';}else{echo 'id="reporte"';}?>type="text" name="reporte<?php echo $i?>" value="<?php echo $reparacion[13]?>" title="Reporte"></td>
    </tr>
    <?php endforeach; ?>

    </table>

    <div class="revisada">
                <label class="radio">Cambio aceite
                <input type="radio" name="nueva_reparacion" value = "cambio_aceite" title="Agregar reparacion">
                <span class="check"></span>
                </label>
                <label class="radio">Afinacion gas
                    <input type="radio" name="nueva_reparacion" value="afinacion_gas" title="Agregar reparacion">
                    <span class="check2"></span>
                </label>
                <label class="radio">Afinacion gasolina
                    <input type="radio" name="nueva_reparacion" value="afinacion_gasolina" title="Agregar reparacion">
                    <span class="check2"></span>
                </label>
                <label class="radio">Media afinacion
                    <input type="radio" name="nueva_reparacion" value="media_afinacion" title="Agregar reparacion">
                    <span class="check2"></span>
                </label>
                <label class="radio">Kit distribucion
                    <input type="radio" name="nueva_reparacion" value="kit_distribucion" title="Agregar reparacion">
                    <span class="check2"></span>
                </label>
                <label class="radio">Banda alternador
                    <input type="radio" name="nueva_reparacion" value="banda_alternador" title="Agregar reparacion">
                    <span class="check2"></span>
                </label>
                <br/>
                <label class="radio">Balatas delanteras
                    <input type="radio" name="nueva_reparacion" value="balatas_delanteras" title="Agregar reparacion">
                    <span class="check2"></span>
                </label>
                <label class="radio">Balatas traseras
                    <input type="radio" name="nueva_reparacion" value="balatas_traseras" title="Agregar reparacion">
                    <span class="check2"></span>
                </label>
                <label class="radio">Llantas
                    <input type="radio" name="nueva_reparacion" value="llantas" title="Agregar reparacion">
                    <span class="check2"></span>
                </label>
                <label class="radio">Nueva reparacion
                    <input type="radio" name="nueva_reparacion" value="nueva_reparacion" title="Agregar reparacion">
                    <span class="check2"></span>
                </label>     
    </div>

    <input type="submit" name="enviar" value="Guardar" class="botonGuardar">

    </form>

</div>
</body>
<!-- Formulario: * DATOS DEL DIA 1 * -->
