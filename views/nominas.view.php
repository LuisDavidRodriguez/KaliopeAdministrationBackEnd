<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Cousine" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="css/estilos.nominas.view.css">
    <title>Mostrando Clientes</title>
</head>

<body>

    
<div class="contenedor">

<a href="cerrar.php" class="botonCerrar">Cerrar sesion</a>
<a href="selecciona_agente.php" class="botonSeleccionaAgente">Selecciona agente</a>
<a href="selecciona_ruta.php" class="botonSeleccionaRuta">Selecciona ruta</a>
<input type="text" readonly="readonly" name="agente" value="<?php echo $agente?>" title="Agente">
<input type="text" readonly="readonly" name="fecha" value="<?php echo $semana?>" title="Semana">



<form action="guardar_nomina.php" method="POST">

<!-- Formulario: * DATOS DEL DIA LUNES * -->
<div class="datos_dia">

<legend>LUNES</legend>

    Zona:<input type="text" name="zona_lunes" value="<?php echo $datos['zona_lunes']?>" title="Zona"> 
    
    Fecha:<input type="text" name="fecha_lunes" value="<?php echo $datos['fecha_lunes'];?>" title="Fecha">

    Cobro:<input type="text" name="cobro_lunes" value="<?php echo $datos['cobro_lunes'];?>" title="Cobro">

    Nuevas:<input type="text" name="nuevas_lunes" value="<?php echo $datos['nuevas_lunes'];?>" title="Nuevas">
    
    Lios:<input type="text" name="lios_lunes" value="<?php echo $datos['lios_lunes'];?>" title="Lios">

    Sobrante:<input type="text" name="sobrante_lunes" value="<?php echo $datos['sobrante_lunes'];?>" title="Sobrante combustible">

    Adelanto:<input type="text" name="adelantos_lunes" value="<?php echo $datos['adelantos_lunes'];?>" title="Adelantos">
    
    Gasolina:<input type="text" name="gasolina_lunes" value="<?php echo $datos['gasolina_lunes'];?>" title="Gasolina">
    
    Gasto:<input type="text" name="gastos_lunes_1" value="<?php echo $datos['gastos_lunes_1'];?>" title="Gastos">

    <input type="text" name="concepto_lunes_1" value="<?php echo $datos['concepto_lunes_1'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_lunes_2" value="<?php echo $datos['gastos_lunes_2'];?>" title="Gastos">

    <input type="text" name="concepto_lunes_2" value="<?php echo $datos['concepto_lunes_2'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_lunes_3" value="<?php echo $datos['gastos_lunes_3'];?>" title="Gastos">

    <input type="text" name="concepto_lunes_3" value="<?php echo $datos['concepto_lunes_3'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_lunes_4" value="<?php echo $datos['gastos_lunes_4'];?>" title="Gastos">

    <input type="text" name="concepto_lunes_4" value="<?php echo $datos['concepto_lunes_4'];?>" title="Concepto Gastos">

    Total:<input readonly="readonly" type="text" name="total_lunes" value="<?php echo $datos['total_lunes'];?>" title="Total">

</div>
<!-- Formulario: * DATOS DEL DIA LUNES * -->

<!-- Formulario: * DATOS DEL DIA MARTES * -->
<div class="datos_dia">

<legend>MARTES</legend>

    Zona:<input type="text" name="zona_martes" value="<?php echo $datos['zona_martes']?>" title="Zona"> 
    
    Fecha:<input type="text" name="fecha_martes" value="<?php echo $datos['fecha_martes'];?>" title="Fecha">

    Cobro:<input type="text" name="cobro_martes" value="<?php echo $datos['cobro_martes'];?>" title="Cobro">

    Nuevas:<input type="text" name="nuevas_martes" value="<?php echo $datos['nuevas_martes'];?>" title="Nuevas">
    
    Lios:<input type="text" name="lios_martes" value="<?php echo $datos['lios_martes'];?>" title="Lios">

    Sobrante:<input type="text" name="sobrante_martes" value="<?php echo $datos['sobrante_martes'];?>" title="Sobrante combustible">

    Adelanto:<input type="text" name="adelantos_martes" value="<?php echo $datos['adelantos_martes'];?>" title="Adelantos">
    
    Gasolina:<input type="text" name="gasolina_martes" value="<?php echo $datos['gasolina_martes'];?>" title="Gasolina">
    
    Gasto:<input type="text" name="gastos_martes_1" value="<?php echo $datos['gastos_martes_1'];?>" title="Gastos">

    <input type="text" name="concepto_martes_1" value="<?php echo $datos['concepto_martes_1'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_martes_2" value="<?php echo $datos['gastos_martes_2'];?>" title="Gastos">

    <input type="text" name="concepto_martes_2" value="<?php echo $datos['concepto_martes_2'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_martes_3" value="<?php echo $datos['gastos_martes_3'];?>" title="Gastos">

    <input type="text" name="concepto_martes_3" value="<?php echo $datos['concepto_martes_3'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_martes_4" value="<?php echo $datos['gastos_martes_4'];?>" title="Gastos">

    <input type="text" name="concepto_martes_4" value="<?php echo $datos['concepto_martes_4'];?>" title="Concepto Gastos">

    Total:<input readonly="readonly" type="text" name="total_martes" value="<?php echo $datos['total_martes'];?>" title="Total">

</div>
<!-- Formulario: * DATOS DEL DIA MARTES * -->

<!-- Formulario: * DATOS DEL DIA MIERCOLES * -->
<div class="datos_dia">

<legend>MIERCOLES</legend>

    Zona:<input type="text" name="zona_miercoles" value="<?php echo $datos['zona_miercoles']?>" title="Zona"> 
    
    Fecha:<input type="text" name="fecha_miercoles" value="<?php echo $datos['fecha_miercoles'];?>" title="Fecha">

    Cobro:<input type="text" name="cobro_miercoles" value="<?php echo $datos['cobro_miercoles'];?>" title="Cobro">

    Nuevas:<input type="text" name="nuevas_miercoles" value="<?php echo $datos['nuevas_miercoles'];?>" title="Nuevas">
    
    Lios:<input type="text" name="lios_miercoles" value="<?php echo $datos['lios_miercoles'];?>" title="Lios">

    Sobrante:<input type="text" name="sobrante_miercoles" value="<?php echo $datos['sobrante_miercoles'];?>" title="Sobrante combustible">

    Adelanto:<input type="text" name="adelantos_miercoles" value="<?php echo $datos['adelantos_miercoles'];?>" title="Adelantos">
    
    Gasolina:<input type="text" name="gasolina_miercoles" value="<?php echo $datos['gasolina_miercoles'];?>" title="Gasolina">
    
    Gasto:<input type="text" name="gastos_miercoles_1" value="<?php echo $datos['gastos_miercoles_1'];?>" title="Gastos">

    <input type="text" name="concepto_miercoles_1" value="<?php echo $datos['concepto_miercoles_1'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_miercoles_2" value="<?php echo $datos['gastos_miercoles_2'];?>" title="Gastos">

    <input type="text" name="concepto_miercoles_2" value="<?php echo $datos['concepto_miercoles_2'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_miercoles_3" value="<?php echo $datos['gastos_miercoles_3'];?>" title="Gastos">

    <input type="text" name="concepto_miercoles_3" value="<?php echo $datos['concepto_miercoles_3'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_miercoles_4" value="<?php echo $datos['gastos_miercoles_4'];?>" title="Gastos">

    <input type="text" name="concepto_miercoles_4" value="<?php echo $datos['concepto_miercoles_4'];?>" title="Concepto Gastos">

    Total:<input readonly="readonly" type="text" name="total_miercoles" value="<?php echo $datos['total_miercoles'];?>" title="Total">

</div>
<!-- Formulario: * DATOS DEL DIA MIERCOLES * -->

<!-- Formulario: * DATOS DEL DIA JUEVES * -->
<div class="datos_dia">

<legend>JUEVES</legend>

    Zona:<input type="text" name="zona_jueves" value="<?php echo $datos['zona_jueves']?>" title="Zona"> 
    
    Fecha:<input type="text" name="fecha_jueves" value="<?php echo $datos['fecha_jueves'];?>" title="Fecha">

    Cobro:<input type="text" name="cobro_jueves" value="<?php echo $datos['cobro_jueves'];?>" title="Cobro">

    Nuevas:<input type="text" name="nuevas_jueves" value="<?php echo $datos['nuevas_jueves'];?>" title="Nuevas">
    
    Lios:<input type="text" name="lios_jueves" value="<?php echo $datos['lios_jueves'];?>" title="Lios">

    Sobrante:<input type="text" name="sobrante_jueves" value="<?php echo $datos['sobrante_jueves'];?>" title="Sobrante combustible">

    Adelanto:<input type="text" name="adelantos_jueves" value="<?php echo $datos['adelantos_jueves'];?>" title="Adelantos">
    
    Gasolina:<input type="text" name="gasolina_jueves" value="<?php echo $datos['gasolina_jueves'];?>" title="Gasolina">
    
    Gasto:<input type="text" name="gastos_jueves_1" value="<?php echo $datos['gastos_jueves_1'];?>" title="Gastos">

    <input type="text" name="concepto_jueves_1" value="<?php echo $datos['concepto_jueves_1'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_jueves_2" value="<?php echo $datos['gastos_jueves_2'];?>" title="Gastos">

    <input type="text" name="concepto_jueves_2" value="<?php echo $datos['concepto_jueves_2'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_jueves_3" value="<?php echo $datos['gastos_jueves_3'];?>" title="Gastos">

    <input type="text" name="concepto_jueves_3" value="<?php echo $datos['concepto_jueves_3'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_jueves_4" value="<?php echo $datos['gastos_jueves_4'];?>" title="Gastos">

    <input type="text" name="concepto_jueves_4" value="<?php echo $datos['concepto_jueves_4'];?>" title="Concepto Gastos">

    Total:<input readonly="readonly" type="text" name="total_jueves" value="<?php echo $datos['total_jueves'];?>" title="Total">

</div>
<!-- Formulario: * DATOS DEL DIA JUEVES * -->

<!-- Formulario: * DATOS DEL DIA VIERNES * -->
<div class="datos_dia">

<legend>VIERNES</legend>

    Zona:<input type="text" name="zona_viernes" value="<?php echo $datos['zona_viernes']?>" title="Zona"> 
    
    Fecha:<input type="text" name="fecha_viernes" value="<?php echo $datos['fecha_viernes'];?>" title="Fecha">

    Cobro:<input type="text" name="cobro_viernes" value="<?php echo $datos['cobro_viernes'];?>" title="Cobro">

    Nuevas:<input type="text" name="nuevas_viernes" value="<?php echo $datos['nuevas_viernes'];?>" title="Nuevas">
    
    Lios:<input type="text" name="lios_viernes" value="<?php echo $datos['lios_viernes'];?>" title="Lios">

    Sobrante:<input type="text" name="sobrante_viernes" value="<?php echo $datos['sobrante_viernes'];?>" title="Sobrante combustible">

    Adelanto:<input type="text" name="adelantos_viernes" value="<?php echo $datos['adelantos_viernes'];?>" title="Adelantos">
    
    Gasolina:<input type="text" name="gasolina_viernes" value="<?php echo $datos['gasolina_viernes'];?>" title="Gasolina">
    
    Gasto:<input type="text" name="gastos_viernes_1" value="<?php echo $datos['gastos_viernes_1'];?>" title="Gastos">

    <input type="text" name="concepto_viernes_1" value="<?php echo $datos['concepto_viernes_1'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_viernes_2" value="<?php echo $datos['gastos_viernes_2'];?>" title="Gastos">

    <input type="text" name="concepto_viernes_2" value="<?php echo $datos['concepto_viernes_2'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_viernes_3" value="<?php echo $datos['gastos_viernes_3'];?>" title="Gastos">

    <input type="text" name="concepto_viernes_3" value="<?php echo $datos['concepto_viernes_3'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_viernes_4" value="<?php echo $datos['gastos_viernes_4'];?>" title="Gastos">

    <input type="text" name="concepto_viernes_4" value="<?php echo $datos['concepto_viernes_4'];?>" title="Concepto Gastos">

    Total:<input readonly="readonly" type="text" name="total_viernes" value="<?php echo $datos['total_viernes'];?>" title="Total">

</div>
<!-- Formulario: * DATOS DEL DIA VIERNES * -->

<!-- Formulario: * DATOS DEL DIA SABADO * -->
<div class="datos_dia">

<legend>SABADO</legend>

    Zona:<input type="text" name="zona_sabado" value="<?php echo $datos['zona_sabado']?>" title="Zona"> 
    
    Fecha:<input type="text" name="fecha_sabado" value="<?php echo $datos['fecha_sabado'];?>" title="Fecha">

    Cobro:<input type="text" name="cobro_sabado" value="<?php echo $datos['cobro_sabado'];?>" title="Cobro">

    Nuevas:<input type="text" name="nuevas_sabado" value="<?php echo $datos['nuevas_sabado'];?>" title="Nuevas">
    
    Lios:<input type="text" name="lios_sabado" value="<?php echo $datos['lios_sabado'];?>" title="Lios">

    Sobrante:<input type="text" name="sobrante_sabado" value="<?php echo $datos['sobrante_sabado'];?>" title="Sobrante combustible">

    Adelanto:<input type="text" name="adelantos_sabado" value="<?php echo $datos['adelantos_sabado'];?>" title="Adelantos">
    
    Gasolina:<input type="text" name="gasolina_sabado" value="<?php echo $datos['gasolina_sabado'];?>" title="Gasolina">
    
    Gasto:<input type="text" name="gastos_sabado_1" value="<?php echo $datos['gastos_sabado_1'];?>" title="Gastos">

    <input type="text" name="concepto_sabado_1" value="<?php echo $datos['concepto_sabado_1'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_sabado_2" value="<?php echo $datos['gastos_sabado_2'];?>" title="Gastos">

    <input type="text" name="concepto_sabado_2" value="<?php echo $datos['concepto_sabado_2'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_sabado_3" value="<?php echo $datos['gastos_sabado_3'];?>" title="Gastos">

    <input type="text" name="concepto_sabado_3" value="<?php echo $datos['concepto_sabado_3'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_sabado_4" value="<?php echo $datos['gastos_sabado_4'];?>" title="Gastos">

    <input type="text" name="concepto_sabado_4" value="<?php echo $datos['concepto_sabado_4'];?>" title="Concepto Gastos">

    Total:<input readonly="readonly" type="text" name="total_sabado" value="<?php echo $datos['total_sabado'];?>" title="Total">

</div>
<!-- Formulario: * DATOS DEL DIA SABADO * -->

<!-- Formulario: * DATOS DEL DIA DOMINGO * -->
<div class="datos_dia">

<legend>DOMINGO</legend>

    Zona:<input type="text" name="zona_domingo" value="<?php echo $datos['zona_domingo']?>" title="Zona"> 
    
    Fecha:<input type="text" name="fecha_domingo" value="<?php echo $datos['fecha_domingo'];?>" title="Fecha">

    Cobro:<input type="text" name="cobro_domingo" value="<?php echo $datos['cobro_domingo'];?>" title="Cobro">

    Nuevas:<input type="text" name="nuevas_domingo" value="<?php echo $datos['nuevas_domingo'];?>" title="Nuevas">
    
    Lios:<input type="text" name="lios_domingo" value="<?php echo $datos['lios_domingo'];?>" title="Lios">

    Sobrante:<input type="text" name="sobrante_domingo" value="<?php echo $datos['sobrante_domingo'];?>" title="Sobrante combustible">

    Adelanto:<input type="text" name="adelantos_domingo" value="<?php echo $datos['adelantos_domingo'];?>" title="Adelantos">
    
    Gasolina:<input type="text" name="gasolina_domingo" value="<?php echo $datos['gasolina_domingo'];?>" title="Gasolina">
    
    Gasto:<input type="text" name="gastos_domingo_1" value="<?php echo $datos['gastos_domingo_1'];?>" title="Gastos">

    <input type="text" name="concepto_domingo_1" value="<?php echo $datos['concepto_domingo_1'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_domingo_2" value="<?php echo $datos['gastos_domingo_2'];?>" title="Gastos">

    <input type="text" name="concepto_domingo_2" value="<?php echo $datos['concepto_domingo_2'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_domingo_3" value="<?php echo $datos['gastos_domingo_3'];?>" title="Gastos">

    <input type="text" name="concepto_domingo_3" value="<?php echo $datos['concepto_domingo_3'];?>" title="Concepto Gastos">
    
    Gasto:<input type="text" name="gastos_domingo_4" value="<?php echo $datos['gastos_domingo_4'];?>" title="Gastos">

    <input type="text" name="concepto_domingo_4" value="<?php echo $datos['concepto_domingo_4'];?>" title="Concepto Gastos">

    Total:<input readonly="readonly" type="text" name="total_domingo" value="<?php echo $datos['total_domingo'];?>" title="Total">

</div>
<!-- Formulario: * DATOS DEL DIA DOMINGO * -->



<!-- Formulario: * DATOS DE LA SEMANA * -->
<div class="datos_dia">

<legend>SEMANA</legend>

    Cobro:<input readonly="readonly" type="text" name="cobro_total" value="<?php echo $datos['cobro_total']?>" title="Cobro total"> 
    
    Nuevas:<input readonly="readonly" type="text" name="nuevas_totales" value="<?php echo $datos['nuevas_totales'];?>" title="Total nuevas">

    Lios:<input readonly="readonly" type="text" name="lios_totales" value="<?php echo $datos['lios_totales'];?>" title="Total lios">

</div>
<!-- Formulario: * DATOS DE LA SEMANA * -->


<!-- Formulario: * DATOS DE NOMINA * -->
<div class="datos_nomina">

<legend>NOMINA</legend>

    Folio:<input readonly="readonly" type="text" name="folio" value="<?php echo $datos['folio']?>" title="Folio"> 
    
    Semana:<input readonly="readonly" type="text" name="semana" value="<?php echo $datos['semana'];?>" title="Semana">

    Agente:<input readonly="readonly" type="text" name="agente" value="<?php echo $datos['agente'];?>" title="Agente">

    Pulcera:<input type="text" name="pulcera" value="<?php echo $datos['pulcera'];?>" title="Pulcera">

    <br/>
    
    Sueldo:<input type="text" name="sueldo_base" value="<?php echo $datos['sueldo_base'];?>" title="Sueldo base">

    Comiciones:<input type="text" name="porcentaje_comicion" value="<?php echo $datos['porcentaje_comicion'];?>" title="Porcentaje de Comiciones">

    <input readonly="readonly" type="text" name="comiciones" value="<?php echo $datos['comiciones'];?>" title="Comiciones">

    Bono Lios:<input type="text" name="porcentaje_lios" value="<?php echo $datos['porcentaje_lios'];?>" title="Porcentaje de Lios">

    <input readonly="readonly" type="text" name="bono_lios" value="<?php echo $datos['bono_lios'];?>" title="Bono Lios">

    Bono Nuevas:<input type="text" name="pago_nuevas" value="<?php echo $datos['pago_nuevas'];?>" title="Pago de Nuevas">

    <input readonly="readonly" type="text" name="bono_nuevas" value="<?php echo $datos['bono_nuevas'];?>" title="Bono Nuevas">

    <br/>

    Bono:<input type="text" name="bono1" value="<?php echo $datos['bono1'];?>" title="Bonos">
    
    <input type="text" name="descripcion_bono1" value="<?php echo $datos['descripcion_bono1'];?>" title="Descripcion Bono">

    Bono:<input type="text" name="bono2" value="<?php echo $datos['bono2'];?>" title="Bonos">
    
    <input type="text" name="descripcion_bono2" value="<?php echo $datos['descripcion_bono2'];?>" title="Descripcion Bono">
    
    <br/>

    Bono:<input type="text" name="bono3" value="<?php echo $datos['bono3'];?>" title="Bonos">
    
    <input type="text" name="descripcion_bono3" value="<?php echo $datos['descripcion_bono3'];?>" title="Descripcion Bono">

    Bono:<input type="text" name="bono4" value="<?php echo $datos['bono4'];?>" title="Bonos">
    
    <input type="text" name="descripcion_bono4" value="<?php echo $datos['descripcion_bono4'];?>" title="Descripcion Bono">


    <br/>

    Subtotal Nomina:<input readonly="readonly" type="text" name="subtotal" value="<?php echo $datos['subtotal'];?>" title="Subtotal Nomina">

    <br/>

    Total adelantos:<input readonly="readonly" type="text" name="total_adelantos" value="<?php echo $datos['total_adelantos'];?>" title="Total adelantos">

    <br/>

    Deuda:<input type="text" name="deuda1" value="<?php echo $datos['deuda1'];?>" title="Deuda pendiente">

    Descuento:<input type="text" name="descuento1" value="<?php echo $datos['descuento1'];?>" title="Descuento">

    <input type="text" name="concepto_descuento1" value="<?php echo $datos['concepto_descuento1'];?>" title="Concepto descuento">

    Adeudo restante:<input readonly="readonly" type="text" name="adeudo_restante1" value="<?php echo $datos['adeudo_restante1'];?>" title="Adeudo restante">

    <br/>

    Deuda:<input type="text" name="deuda2" value="<?php echo $datos['deuda2'];?>" title="Deuda pendiente">

    Descuento:<input type="text" name="descuento2" value="<?php echo $datos['descuento2'];?>" title="Descuento">

    <input type="text" name="concepto_descuento2" value="<?php echo $datos['concepto_descuento2'];?>" title="Concepto descuento">

    Adeudo restante:<input readonly="readonly" type="text" name="adeudo_restante2" value="<?php echo $datos['adeudo_restante2'];?>" title="Adeudo restante">

    <br/>
    
    Deuda:<input type="text" name="deuda3" value="<?php echo $datos['deuda3'];?>" title="Deuda pendiente">

    Descuento:<input type="text" name="descuento3" value="<?php echo $datos['descuento3'];?>" title="Descuento">

    <input type="text" name="concepto_descuento3" value="<?php echo $datos['concepto_descuento3'];?>" title="Concepto descuento">

    Adeudo restante:<input readonly="readonly" type="text" name="adeudo_restante3" value="<?php echo $datos['adeudo_restante3'];?>" title="Adeudo restante">

    <br/>

    Deuda:<input type="text" name="deuda4" value="<?php echo $datos['deuda4'];?>" title="Deuda pendiente">

    Descuento:<input type="text" name="descuento4" value="<?php echo $datos['descuento4'];?>" title="Descuento">

    <input type="text" name="concepto_descuento4" value="<?php echo $datos['concepto_descuento4'];?>" title="Concepto descuento">

    Adeudo restante:<input readonly="readonly" type="text" name="adeudo_restante4" value="<?php echo $datos['adeudo_restante4'];?>" title="Adeudo restante">

    <br/>
    
    Deuda:<input type="text" name="deuda5" value="<?php echo $datos['deuda5'];?>" title="Deuda pendiente">

    Descuento:<input type="text" name="descuento5" value="<?php echo $datos['descuento5'];?>" title="Descuento">

    <input type="text" name="concepto_descuento5" value="<?php echo $datos['concepto_descuento5'];?>" title="Concepto descuento">

    Adeudo restante:<input readonly="readonly" type="text" name="adeudo_restante5" value="<?php echo $datos['adeudo_restante5'];?>" title="Adeudo restante">

    <br/>
    
    Deuda:<input type="text" name="deuda6" value="<?php echo $datos['deuda6'];?>" title="Deuda pendiente">

    Descuento:<input type="text" name="descuento6" value="<?php echo $datos['descuento6'];?>" title="Descuento">

    <input type="text" name="concepto_descuento6" value="<?php echo $datos['concepto_descuento6'];?>" title="Concepto descuento">

    Adeudo restante:<input readonly="readonly" type="text" name="adeudo_restante6" value="<?php echo $datos['adeudo_restante6'];?>" title="Adeudo restante">

    <br/>
    

    % Ahorro:<input type="text" name="porcentaje_ahorro" value="<?php echo $datos['porcentaje_ahorro'];?>" title="Porcentaje ahorro">

    Ahorro:<input readonly="readonly" type="text" name="descuento_ahorro" value="<?php echo $datos['descuento_ahorro'];?>" title="Ahorro">

    <br/>

    Total Nomina:<input readonly="readonly" type="text" name="total_nomina" value="<?php echo $datos['total_nomina'];?>" title="Total Nomina">

    <br/>

    Disponible:<input type="text" name="caja_ahorros_disponible" value="<?php echo $datos['caja_ahorros_disponible'];?>" title="Caja de ahorros disponible">

    Incremento:<input type="text" readonly="readonly" name="incremento_caja_ahorro" value="<?php echo $datos['incremento_caja_ahorro'];?>" title="Incremento de caja de ahorro">

    Retiro:<input type="text" name="retiro_caja_ahorro" value="<?php echo $datos['retiro_caja_ahorro'];?>" title="Retiro de Caja">

    Concepto:<input type="text" name="concepto_retiro_caja_ahorro" value="<?php echo $datos['concepto_retiro_caja_ahorro'];?>" title="Concepto de Retiro">

    Total:<input type="text" readonly="readonly" name="total_caja" value="<?php echo $datos['total_caja'];?>" title="Total caja ahorros">

    <br/>

    <div class="bloqueo">
                
                Libre:<input type="radio" name="bloqueo" value="libre" title="Revisar" <?php if($datos['bloqueo'] == 'LIBRE'){echo 'checked';}?>>
    </div>

        Bloqueada:<input type="radio" name="bloqueo" value = "bloqueo" title="Revisar" <?php if($datos['bloqueo'] == 'BLOQUEO'){echo 'checked';}?>>
        Motivo:<input type="text" name="motivo" value="<?php echo $datos['motivo'];?>" title="Motivo del bloqueo">

</div>
<!-- Formulario: * DATOS DE NOMINA * Muestra los Datos de la nomina -->


    <div class="fecha_futura">
                Fecha futura:
                SI<input type="radio" name="copiar_hoja" value = "SI" title="Revisar">
                NO<input type="radio" name="copiar_hoja" value="NO" title="Revisar" checked>
    </div>

<input type="submit" name="enviar" value="Guardar" class="botonGuardar">

</form>         


    <!-- Barra de Fechas *Muestra las fechas* -->
    <div class="barra_fechas">

        <ul>
            

            <?php foreach ($datos_semana as $dato):?>

            <li 
            <?php if ($semana == $dato['semana']){echo 'class="active"';}?>
            ><a href="?<?php echo'agente=' . $agente ?>&semana=<?php echo $dato['semana'] ?>"><?php echo 'S-' . $dato['semana'] ?></a>
            </li>

            <?php endforeach ?>
    
            
        </ul>

    </div>
    <!-- Barra de Fechas *Muestra las fechas* -->

</div>
</body>
</html>