 <!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Crear inventario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Crear nuevo inventario</h1> 
        
        
        <!--Botones de uso general -->
        <a href="MAIN_mostrar_inventarios.php"><-Menu Anterior</a>
        <br> <br><br> <br>
        
       
        
        <form action="crear_inventario_afectar.php" method="POST">     
            
            <!--El dato del propietario llega desde el archivo modificar_inventario.php-->            
                             
                                      
                    
                    
                    <h3>Seleccione el usuario al cual se le asignara este nuevo inventario en 0, los precios del inventario se asignaran acorde con los productos existentes en el catalogo de precios</h3>
                    
                    Usuario: <select name="usuario" title="usuario">               
                        
                        
                        <?php foreach ($arrayUsuarios_existentes as $propietario):;?>
                        
                        <option> 
                        <?php echo $propietario['usuario']?>                            
                        </option>
                        
                        
                        <?php endforeach;?>
                        
                        
            
                    </select>
                    
                    
                    
                    
            
            
                    <br> <br>
                    
                    
                    <input type="submit" name="continuar" value="Continuar"/>
            
        </form>
        
        <br> <br> <br> <br>
        
        
        <h4>Observaciones:</h4>
                    <h4>-El usuario que seleccione no debera tener ningun otro inventario asignado</h4>
                    <h4>-Solo podra crear inventarios para los usuarios de la app que existan, si no encuentra su usuario primero debe crear un nuevo usuario</h4>
                    <h4>-Las casillas de SinPropietario1,2,3,4 le ayudaran a crear inventarios para posteriormente asignarlos a usuarios, usando la opcion de intercambiar inventario</h4>
                    
    </body>
</html>