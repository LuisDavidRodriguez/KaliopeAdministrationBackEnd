

 
 
 
 
 
 
 
 
 <!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Intercambiar Inventarios</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Intercambia el inventario de un agente con el de otro </h1> 
        
        
        <!--Botones de uso general -->
        <a href="MAIN_mostrar_inventarios.php"><-Menu Anterior</a>
        <br> <br><br> <br>
        
        <h4>Esta funcion le ayudara a rotar los inventarios entre usuarios, para las rotaciones que hay de agentes entre las sucursales<br>
        por ejemplo, Juan rota de queretaro hacia atlacomulco, y Uriel rota de atlacomulco hacia queretaro<br>
        entonces el inventario de juan lo tomara uriel, y el de uriel lo tomara juan.
        para ello basta con seleccionar ambos usuarios y sus inventarios rotaran.
        </h4>
        <h4>Observaciones:</h4>
        <h4>-Los usuarios que seleccione deberna ser diferentes</h4>
        <h4>-Las opciones que se muestran son los inventarios que existen, si no encuentra una opcion es porque no hay inventario para el usuario que necesita, primero cree un inventario</h4>
        <h4>-Deslice la pagina hacia abajo para que encuentre el boton de continuar</h4>

        <br><br><br><br>
       
        
        <form action="intercambiar_inventario_afectar_inventario.php" method="POST">     
            
            <!--El dato del propietario llega desde el archivo modificar_inventario.php-->            
                             
                                      
                    
                    
                    <h3>Intercambiar el inventario de
                    
                    <select name="propietario1" title="Usuario1">               
                    </h3>    
                        
                        <?php foreach ($arrayPropietarios_existentes as $propietario):;?>
                        
                        <option> 
                        <?php echo $propietario['propietario']?>                            
                        </option>
                        
                        
                        <?php endforeach;?>
                        
                        
            
                    </select>
                    
                    
                    
                    <h3>Por el de:</h3>
                    
                    Propietario 2: <select name="propietario2" title="Usuario2">               
                        
                        
                        <?php foreach ($arrayPropietarios_existentes as $propietario):;?>
                        
                        <option> 
                        <?php echo $propietario['propietario']?>                            
                        </option>                        
                        
                        <?php endforeach;?>
                        
                        
            
                    </select>
                    
            
            
                    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
                    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
                    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
                    
                    <input type="submit" name="continuar" value="Continuar"/>
            
        </form>
    </body>
</html>







