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
    <a href="../MAIN_mostrar_inventarios.php"><-Menu Anterior</a>
        
        
        <!--Añadimos el boton de acceso directo a modificar inventario se abrira en una pestaña nueva, esto porque por ejemplo si al administrador le dictan un inventario
            al realizar la comparacion sale que le falta un pantalon, pero se acuerdan que se lo llevo el agente para uso personal entonces tendrian que regresar hasta el 
        menu principal para hacer la modificacion y pasaria que entonces se borraria de los input de esta vista lo que ya se haya capturado. en cambio con este boton
        nos abre una nueva penstaña donde podemos sacar ese pantalon y al terminar volver a generar el reporte-->
         <br><br>
         <a href="../modificar_inventario.php?propietario=<?php $propietario = $_GET['propietario']; echo $propietario;?>" target="_blank">Realizar una modificacion al inventario de sistema de ultimo momento</a>
            
        
        
    
    <!--Se recibe directamente el valor del usuario en este archivo para no crear un independiente php-->
   
    <form action="fisico_vs_sistema_reporte_mostrar.php" method='POST' >
        Capture las piezas fisicas del sistema:
        <input type="text" name="propietario" value="<?php $propietario = $_GET['propietario']; echo $propietario;?>" readonly="true"> <br>
        Notas___:<textarea type="text" name="motivoMovimiento" value="" rows="2" cols="60" ></textarea> <br>
        
        codigo______________Cantidad <br>
                    <input type="text" name="codigo1" value=""> <input type="text" name="cantidad1" value="" /> <br> 
                    <input type="text" name="codigo2" value=""> <input type="text" name="cantidad2" value="" /> <br> 
                    <input type="text" name="codigo3" value=""> <input type="text" name="cantidad3" value="" /> <br> 
                    <input type="text" name="codigo4" value=""> <input type="text" name="cantidad4" value="" /> <br> 
                    <input type="text" name="codigo5" value=""> <input type="text" name="cantidad5" value="" /> <br> 
                    <input type="text" name="codigo6" value=""> <input type="text" name="cantidad6" value="" /> <br> 
                    <input type="text" name="codigo7" value=""> <input type="text" name="cantidad7" value="" /> <br> 
                    <input type="text" name="codigo8" value=""> <input type="text" name="cantidad8" value="" /> <br> 
                    <input type="text" name="codigo9" value=""> <input type="text" name="cantidad9" value="" /> <br> 
                    <input type="text" name="codigo10" value=""> <input type="text" name="cantidad10" value="" /> <br> 
                    <input type="text" name="codigo11" value=""> <input type="text" name="cantidad11" value="" /> <br> 
                    <input type="text" name="codigo12" value=""> <input type="text" name="cantidad12" value="" /> <br> 
                    <input type="text" name="codigo13" value=""> <input type="text" name="cantidad13" value="" /> <br> 
                    <input type="text" name="codigo14" value=""> <input type="text" name="cantidad14" value="" /> <br> 
                    <input type="text" name="codigo15" value=""> <input type="text" name="cantidad15" value="" /> <br> 
                    <input type="text" name="codigo16" value=""> <input type="text" name="cantidad16" value="" /> <br> 
                    <input type="text" name="codigo17" value=""> <input type="text" name="cantidad17" value="" /> <br> 
                    <input type="text" name="codigo18" value=""> <input type="text" name="cantidad18" value="" /> <br> 
                    <input type="text" name="codigo19" value=""> <input type="text" name="cantidad19" value="" /> <br> 
                    <input type="text" name="codigo20" value=""> <input type="text" name="cantidad20" value="" /> <br> 
                    <input type="text" name="codigo21" value=""> <input type="text" name="cantidad21" value="" /> <br> 
                    <input type="text" name="codigo22" value=""> <input type="text" name="cantidad22" value="" /> <br> 
                    <input type="text" name="codigo23" value=""> <input type="text" name="cantidad23" value="" /> <br> 
                    <input type="text" name="codigo24" value=""> <input type="text" name="cantidad24" value="" /> <br> 
                    <input type="text" name="codigo25" value=""> <input type="text" name="cantidad25" value="" /> <br> 
                    <input type="text" name="codigo26" value=""> <input type="text" name="cantidad26" value="" /> <br> 
                    <input type="text" name="codigo27" value=""> <input type="text" name="cantidad27" value="" /> <br> 
                    <input type="text" name="codigo28" value=""> <input type="text" name="cantidad28" value="" /> <br> 
                    <input type="text" name="codigo29" value=""> <input type="text" name="cantidad29" value="" /> <br> 
                    <input type="text" name="codigo30" value=""> <input type="text" name="cantidad30" value="" /> <br> 
                    <input type="text" name="codigo31" value=""> <input type="text" name="cantidad31" value="" /> <br> 
                    <input type="text" name="codigo32" value=""> <input type="text" name="cantidad32" value="" /> <br> 
                    <input type="text" name="codigo33" value=""> <input type="text" name="cantidad33" value="" /> <br> 
                    <input type="text" name="codigo34" value=""> <input type="text" name="cantidad34" value="" /> <br> 
                    <input type="text" name="codigo35" value=""> <input type="text" name="cantidad35" value="" /> <br> 
                    <input type="text" name="codigo36" value=""> <input type="text" name="cantidad36" value="" /> <br> 
                    <input type="text" name="codigo37" value=""> <input type="text" name="cantidad37" value="" /> <br> 
                    <input type="text" name="codigo38" value=""> <input type="text" name="cantidad38" value="" /> <br> 
                    <input type="text" name="codigo39" value=""> <input type="text" name="cantidad39" value="" /> <br> 
                    <input type="text" name="codigo40" value=""> <input type="text" name="cantidad40" value="" /> <br> 
                    <input type="text" name="codigo41" value=""> <input type="text" name="cantidad41" value="" /> <br> 
                    <input type="text" name="codigo42" value=""> <input type="text" name="cantidad42" value="" /> <br> 
                    <input type="text" name="codigo43" value=""> <input type="text" name="cantidad43" value="" /> <br> 
                    <input type="text" name="codigo44" value=""> <input type="text" name="cantidad44" value="" /> <br> 
                    <input type="text" name="codigo45" value=""> <input type="text" name="cantidad45" value="" /> <br> 
                    <input type="text" name="codigo46" value=""> <input type="text" name="cantidad46" value="" /> <br> 
                    <input type="text" name="codigo47" value=""> <input type="text" name="cantidad47" value="" /> <br> 
                    <input type="text" name="codigo48" value=""> <input type="text" name="cantidad48" value="" /> <br> 
                    <input type="text" name="codigo49" value=""> <input type="text" name="cantidad49" value="" /> <br> 
                    <input type="text" name="codigo50" value=""> <input type="text" name="cantidad50" value="" /> <br> 
                    
                    
        
        <p><input type="submit" name="enviar" value='Enviar Datos'></p>
        
    </form>
    
    
    <h4>Observaciones:</h4>
                    <h4>-Puede dejar renglones intermedios en blanco</h4>
                    <h4>-Tenemos un limite de ingreso de datos impuesto por la longitud de caracteres que se puede enviar por get de 27 renglones, por favor tomar en cuenta en lo que lo corrigo</h4>
                    <h4>-Ya se hay 50 renglones arriba para añadir pero limitarce a 27 o 25 si no al continuar a afectar el inventario, no hara nada o marcara error</h4>
                    <h4>-Detodas maneras con 27 renglones esta bien, ningun inventario tiene 27 precios diferentes llegan entre 15 a 20</h4>

</body>
</html>