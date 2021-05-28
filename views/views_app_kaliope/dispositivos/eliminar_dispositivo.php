<?php

/* 
 * en este archivo cuando el usuario precione el boton de eliminar 
 * solicitaremos una confirmacion, esta pantalla no necesita de una vista HTML
 * usamos solamente echos para simolar la vista
 */


include_once '../../../app_kaliope/base_de_datos_Class.php';


$dataBase = new base_de_datos_Class();


//recogemos la variable que nos envia por get la pantalla anterior, la pagina anterior envia en eliminar un false
//por lo tanto mostrara la confirmacion para eliminar en el else de abajo.
$id = $_GET['id'];
$eliminar=$_GET['eliminar'];


$informacionDispositivo = $dataBase->dispositivos_consultaDispositivoPorId($id);

    
    if(!$eliminar){
            //pintamos los botones con echo para no crear una parte grafica
            echo"<h2>Se requiere confirmacion para eliminar el dispositivo.</h2>";
            echo"Informacion del Dispositivo: <br>";
            echo"id: $informacionDispositivo[0] <br>";
            echo"Modelo: $informacionDispositivo[1] <br>";
            echo"uuid: $informacionDispositivo[2] <br>";
            echo"Autorizado: $informacionDispositivo[3] <br>";
            echo"Fecha de solicitud al servidor: $informacionDispositivo[4] <br>";
            echo"Comentarios: $informacionDispositivo[5] <br><br><br>";
            echo"Una ves eliminado este dispositivo si un usuario intenta iniciar sesion desde este dispositivo no lo permitira el sistema, <br>"
            . "al momento del intento de sesion se volvera a añadir el uuid a la tabla y tendra que autorizarse manualmente";
            echo"<h3>Deslice la pagina hacia abajo para encontrar el boton de confirmacion </h3>";
            echo "<a href=MAIN_mostrar_dispositivos.php><-Volver al menu anterior</a>";         //añadir el boton volver atras
            echo"<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
            
            
            echo"<h4>¿Realmente quiere eliminar al Dispositivo? </h4>";
            echo "<a href=MAIN_mostrar_dispositivos.php>No, regresar</a>";
            echo "<br><br>";
            echo "<a href=eliminar_dispositivo.php?id=$id&eliminar=1>Si</a> ";
            
            //al precionar el boton confirmar eliminacion nos colvera a enviar a esta paguina pero ahora
            //ya con el parametro eliminar verdadero por lo tanto procedemos a ejecutar lo del else 
    
    }else{
        //ya que el susuario confirmo la eliminacion entonces 
        $dataBase->dispositivos_eliminarDispositivoId($id);
        
       header('Location: MAIN_mostrar_dispositivos.php');
       //enviamos al usuario al menu de usuarios
        
    }
    
    
    












