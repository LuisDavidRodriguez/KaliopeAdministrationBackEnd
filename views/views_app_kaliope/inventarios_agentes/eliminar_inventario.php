<?php

/* 
 * en este archivo cuando el usuario precione el boton de eliminar 
 *eliminara por completo el inventario pero primero con confirmacion
 */


include_once '../../../app_kaliope/base_de_datos_Class.php';


$dataBase = new base_de_datos_Class();


//recogemos la variable que nos envia por get la pantalla anterior, la pagina anterior envia en eliminar un false
//por lo tanto mostrara la confirmacion para eliminar en el else de abajo.
$propietario = $_GET['propietario'];
$eliminar=$_GET['eliminar'];



//consultamos si el usuario tiene inventario asignado


$importeTotal = $dataBase->inventarios_agentes_consultarImporteTotalPropietario($propietario);
$piezasTotales = $dataBase->inventarios_agentes_consultarPiezasTotalesPropietario($propietario);


    
    if(!$eliminar){
            //pintamos los botones con echo para no crear una parte grafica
            echo"<h2>Se requiere confirmacion para eliminar el inventario del propietario $propietario tiene existencias $piezasTotales con un importe de: $$importeTotal </h2>";
            echo"<h3>Deslice la pagina hacia abajo para encontrar el boton de confirmacion </h3>";
            echo "<a href=MAIN_mostrar_inventarios.php><-Volver al menu anterior</a>";         //añadir el boton volver atras
            echo"<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
            
            
            echo"<h4>¿Realmente quiere eliminar el inventario del propietario $propietario ? tiene existencias $piezasTotales con un importe de: $$importeTotal </h4>";
            echo "<a href=MAIN_mostrar_inventarios.php>No, regresar</a>";
            echo "<br><br>";
            echo "<a href=eliminar_inventario.php?propietario=$propietario&eliminar=1'>Si</a> ";
            //al precionar el boton confirmar eliminacion nos colvera a enviar a esta paguina pero ahora
            //ya con el parametro eliminar verdadero por lo tanto procedemos a ejecutar lo del else 
    
    }else{
        //ya que el susuario confirmo la eliminacion entonces 
        $dataBase->inventarios_agentes_eliminaInventario($propietario);
        
       header('Location: MAIN_mostrar_inventarios.php');
       //enviamos al usuario al menu de usuarios
        
    }
    
    
    
