<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" type="text/css" href="css/estilos.selecciona_ruta.css">
    <title>Selecciona la Ruta</title>
</head>
<body>



<div class="contenedor">

<a href="cerrar.php" class="botonCerrar">Cerrar sesion</a>
<a href="selecciona_ruta.php" class="botonSelecciona">Selecciona ruta</a>
<a href="nuevo_agente.php" class="botonSelecciona">Agente nuevo</a>

<h1>AGENTES</h1>

<div class = "Ruta1">

<?php foreach ($agentes as $agente):;?>
	<form action="nominas.php">	
	<input type="submit" name="agente" value="<?php echo $agente['agente']?>" class='my.Button'>
	</form>
<?php endforeach; ?>
	

	
</div>