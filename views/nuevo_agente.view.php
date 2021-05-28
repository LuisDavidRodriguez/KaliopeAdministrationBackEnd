<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuevo agente</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='POST' >
    Nombre del Agente:<input type="text" name="nombre_agente" value="" title="introduce nombre del agente" required>
    Numero de Semana:<input type="text" name="numero_semana" value="" title="introduce el numero de semana" required>
    <input type="submit" name="enviar" value="Crear Agente">
    </form>
</body>
</html>