<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Llenar Inventario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <h1>Inserta el inventario</h1>
    <!--Volver al menu anterior -->
        <a href="MAIN_mostrar_inventarios.php"><-Menu Anterior</a>
    <h4>Esta funcion le ayudara a afectar un inventario masivamente, por ejemplo si se acaba de crear el inventario y esta en 0 y el inventario que se tiene<br>
        esta en formato de texto, por ejemplo el que la app kaliope exporta solo pege la cadena aqui, y el inventario se llenara en automatico</h4>
    El formato es un texto, primero el codigo separado por coma despues la cantidad de piezas, entre cada producto debe venir un salto de linea ejemplo:<br>
    29,3<br>
    399,4<br>
    459,5<br>
    399,5<br>
    acepta valores negativos y en 0 como:<br>
    399,-10<br>
    229,0
    <br>
    puede repetir codigos en diferentes renglones:<br>
    139,5<br>
    139,2
    <br>
    Los codigos deberan de existir en el inventario del usuario, si no, no se cargara nada del archivo de texto al inventario
    <br>
    <br>
    
    
    <!--Se recibe directamente el valor del usuario en este archivo para no crear un independiente php-->
   
    <form action="llenar_inventariotxt_afectar.php" method='POST' >
        El inventario que se afectara masivamente es del usuario:
        <input type="text" name="propietario" value="<?php $propietario = $_GET['propietario']; echo $propietario;?>" readonly="true"> <br>         
        <p><textarea name="cadena" rows="30" cols="100" placeholder='Por favor ingresa el inventario'></textarea></p>
        <p><input type="submit" name="enviar" value='Enviar Datos'></p>
        
    </form>
</body>
</html>