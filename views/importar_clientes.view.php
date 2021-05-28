<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Importar Clientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <h1>Importar clientes</h1>
    <h3>Por favor ingresa la cadena de texto:</h3>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='POST' >
        <p><textarea name="datos" rows="30" cols="100" placeholder='Por favor ingresa el codigo'></textarea></p>
        <p><input type="submit" name="enviar_informacion" value='Enviar Datos'></p>
        
    </form>
</body>
</html>