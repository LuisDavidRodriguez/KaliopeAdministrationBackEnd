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

<input type="text" readonly="readonly" name="zona" value="<?php echo $zona?>" title="Zona">
<input type="text" readonly="readonly" name="fecha" value="<?php echo $fecha?>" title="Fecha">
    
<div class="contenedor">

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

        <div class="formulario">

            <!-- Formulario: * DATOS DEL CLIENTE * Muestra los Datos del cliente -->
            <div class="datos_cliente">

                <legend>Datos del Cliente</legend>

                <input type="text" name="folio" value="<?php echo $fecha ?>" title="Folio" readonly="readonly">

                <input type="text" name="zona" value="<?php echo $zona ?>" title="Zona" readonly="readonly">
                
                <input type="text" name="cuenta" value="SN" title="Cuenta">

                <input type="text" name="nombre" value="0" title="Nombre">

                <input type="text" name="telefono" value="0" title="Telefono">


                <select name="grado" title="Grado">

                    <option>VENDEDORA</option>

                    <option>SOCIA</option>

                    <option>EMPRESARIA</option>

                </select>

                <input type="text" name="credito" value="1500" title="Credito">

                <select name="dias" title="Tiempo">

                    <option>14</option>

                    <option>28</option>
          
                </select>
               
                <select name="estado" title="Estado">

                    <option>ACTIVO</option>

                    <option>REACTIVAR</option>

                    <option>LIO</option>

                    <option selected>PROSPECTO</option>

                </select>

                    
                <input type="text" name="observaciones" value="0" title="Observaciones">

                <input type="text" name="latitud" value="0" title="Latitud">

                <input type="text" name="longitud" value="0" title="Longitud">

            </div>
            <!-- Formulario: * DATOS DEL CLIENTE * Muestra los Datos del cliente -->


            <!-- Formulario: * PUNTOS * Muestra el banco de puntos del cliente -->
            <div class="puntos">

                <legend>Puntos</legend>

                <input type="text" name="puntos_disponibles" value="0" title="Puntos Disponibles">

                <input type="text" name="puntos_entregados" value="0" title="Puntos Entregados">

                <input type="text" name="puntos_cambiados" value="0" title="Puntos Cambiados">

                <input type="text" name="puntos_restantes" value="0" title="Puntos Restantes">

            </div>
            <!-- Formulario: * PUNTOS * Muestra el banco de puntos del cliente -->


            <!-- Formulario: * A CARGO DEL CLIENTE * Muestra la mercancia acargo -->
            <div class="a_cargo">

                <legend>Mercancia a Cargo</legend>

                <input type="text" name="piezas_cargo" value="0" title="Piezas a Cargo">

                <input type="text" name="importe_cargo" value="0" title="Importe a Cargo">

                <input type="text" name="adeudo_cargo" value="0" title="Adeudo a Cargo">

                <input type="text" name="hora_cargo" value="0" title="Hora de Cargo">             

                <input type="text" name="fecha_cargo" value="0" title="Fecha de Cargo">

                <input type="text" name="fecha_vence_cargo" value="0" title="Vencimiento del Cargo">

                <input type="text" name="mercancia_cargo" value="0" id="mercanciaCargo" title="Mercancia a Cargo">

            </div>
            <!-- Formulario: * A CARGO DEL CLIENTE * Muestra la mercancia acargo -->
        

            <!-- Formulario: * MOVIMIENTOS * Muestra la movimientos del cliente -->
            <div class="movimientos">

                <legend>Movimientos Generados</legend>
                
                <input type="text" name="pz_devueltas" value="0" title="Piezas Devueltas">

                <input type="text" name="importe_devolucion" value="0" title="Importe Devolucion">

                <input type="text" name="cierre" value="0" title="Cierre">

                <input type="text" name="pago_cierre" value="0" title="Pago">

                <input type="text" name="pago_adeudo" value="0" title="Pago de Adeudo">

                <input type="text" name="pago_otro" value="0" title="Pago otro">

                <input type="text" name="pago_dif_regalo" value="0" title="Diferencia de Regalo">

                <input type="text" name="total_pagos" value="0" title="Total de Pagos">

                <input type="text" name="mercancia_devuelta" value="0" id="mercanciaDevuelta" title="Mercancia devuelta">

            </div>
            <!-- Formulario: * MOVIMIENTOS * Muestra la movimientos del cliente -->


            <!-- Formulario: * ENTREGADO * Muestra la mercancia entregada -->
            <div class="entregado">


                <legend>Mercancia Entregada</legend>

                <input type="text" name="piezas_entregadas" value="0" title="Piezas Entregadas">

                <input type="text" name="importe_entregado" value="0" title="Importe">

                <input type="text" name="adeudo" value="0" title="Adeudo">

                <input type="text" name="fecha_vencimiento" value="0" title="Vencimiento">

                <input type="text" name="hora" value="0" title="Hora Movimiento">

                <input type="text" name="fecha_entrega" value="0" title="Fecha de Entrega">
                                
                <input type="text" name="reporte_agente" value="0" id="reporteAgente" title="Reporte Agente">
                
                <input type="text" name="historial" value="0" title="historial">

                <input type="text" name="mercancia_entregada" value="0" id="mercanciaEntregada" title="Mercancia Entregada">

                <input type="text" name="reporte_administracion" value="0" id="observacionesAdministracion" title="Reporte Administracion">

                <div class="firmaVoz">
                <label>
                    <input type="radio" name="firma_voz" value = "SI" title="Firma de voz"> SI
                </label>
                <label>
                    <input type="radio" name="firma_voz" value="NO" title="Firma de voz"checked> NO
                </label>
                </div>

                <div class="revisada">
                <label class="radio">SI
                <input type="radio" name="revisada" value = "SI" title="Revisar">
                <span class="check"></span>
                </label>
                <label class="radio2">NO 
                    <input type="radio" name="revisada" value="NO" title="Revisar" checked>
                    <span class="check2"></span>
                </label>
                </label>
                </div>

                
            </div>
            <!-- Formulario: * ENTREGADO * Muestra la mercancia entregada -->
        </div>

    <input type="submit" name="enviar" value="Guardar" class="botonGuardar">

</form>         

</div>
</body>
</html>

