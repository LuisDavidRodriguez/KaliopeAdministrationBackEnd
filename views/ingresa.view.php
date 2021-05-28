<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Bienvenido a Kaliope</title>
	<link href="https://fonts.googleapis.com/css?family=Cousine" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>

	<div class="ingreso">
    
    <img src="img/Logo Kaliope.png" alt="logo kaliope" width="100%">
    
    <br>
    <br>
    

    <h1>Bienvenido a kaliope</h1>
    
    <br>
    <br>
    
	<h2>Por favor ingresa tu usuario y contraseña:</h2>
	
	<form action= "ingresa.php" method="POST"
>
	
	<input type="text" id="usuario" name="usuario" placeholder="Usuario">
	
	<input type="password" id="contrasena" name="contrasena" placeholder="Contraseña">
	
	<input type="submit" name="enviar" class="boton" value="Aceptar" >
	
	<?php if(!empty($errores)): ?>
       <div class="error">
          <ul>
              <?php echo $errores; ?>
          </ul>
       </div>
    <?php endif; ?>
        
    </form>

	</div>

</body>
</html>