<?php

/* 
 * en este archivo cuando el usuario precione el boton de eliminar 
 * comprobara si tiene un inventario asignado con piezas existentes
 * mostrara en pantalla si tiene inventario, y le pedira al usuario que 
 * lo pience dos veces.
 */


include_once '../../../app_kaliope/base_de_datos_Class.php';


$dataBase = new base_de_datos_Class();


//recogemos la variable que nos envia por get la pantalla anterior, la pagina anterior envia en eliminar un false
//por lo tanto mostrara la confirmacion para eliminar en el else de abajo.
$propietario = $_GET['usuario'];
$eliminar=$_GET['eliminar'];



//consultamos si el usuario tiene inventario asignado


$importeTotal = $dataBase->inventarios_agentes_consultarImporteTotalPropietario($propietario);
$piezasTotales = $dataBase->inventarios_agentes_consultarPiezasTotalesPropietario($propietario);

if ($importeTotal!=0|| $piezasTotales != 0){
    echo "<h2> Cuidado el usuario $propietario tiene un inventario con existencias registrado. <br> $piezasTotales pz con $$importeTotal de importe total</h2> <br><br>";
    echo "<h3> Para poder eliminar a este usuario primero debe realizar alguna de las siguientes opciones: <br><br>"
            . "1. Reasginar el inventario a otro propietario <br>"
            . "2. Mover el inventario hacia las casillas SinAsignar disponibles <br>"
            . "3. Eliminar el inventario completamente en el menu de inventarios </h3> <br><br>";
    
    echo "<a href=MAIN_usuarios_mostrar.php><-Volver al menu anterior</a>";
   
}else{
    
    if(!$eliminar){
            //pintamos los botones con echo para no crear una parte grafica
            echo"<h2>Se requiere confirmacion para eliminar el Usuario $propietario </h2>";
            echo"<h3>Deslice la pagina hacia abajo para encontrar el boton de confirmacion </h3>";
            echo "<a href=MAIN_usuarios_mostrar.php><-Volver al menu anterior</a>";         //añadir el boton volver atras
            echo"<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
            
            
            echo"<h4>¿Realmente quiere eliminar al usuario $propietario ? </h4>";
            echo "<a href=MAIN_usuarios_mostrar.php>No, regresar</a>";
            echo "<br><br>";
            echo "<a href=eliminar_usuario.php?usuario=$propietario&eliminar=1>Si</a> ";
            //al precionar el boton confirmar eliminacion nos colvera a enviar a esta paguina pero ahora
            //ya con el parametro eliminar verdadero por lo tanto procedemos a ejecutar lo del else 
    
    }else{
        //ya que el susuario confirmo la eliminacion entonces 
        $dataBase->usuarios_app_kaliope_eliminarUsuario($propietario);
        
       header('Location: MAIN_usuarios_mostrar.php');
       //enviamos al usuario al menu de usuarios
        
    }
    
    
    
}











