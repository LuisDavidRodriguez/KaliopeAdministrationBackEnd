
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Reporte de inventario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>
    <body>
        <h1>Resultados de la comparacion</h1> 
        <h3>Por favor reviza la comparacion, para corregir lo fisico vuelva atras</h3> 
        
       
        <br> <br>
        
        Usuario: <?php echo $propietario?>
        <br>
        Nombre Completo: <?php echo $nombreCompletoPropietarioVista?>
        <br>
        Fecha Realizado: <?php echo $fechaCortaVista?>
        <br>
        Hora: <?php echo $horaVista?>
        <br><br>
        <h4> Notas: <?php echo $notas?> </h4>
        <br><br>
        
        Empresaria________________Existencias___________Fisicas____________Codigo___________Diferencias____________Importe
        <br>    
            
            <!--El array renglones para vista llega desde el archivo fisico_vs_sistema_reporte_mostrar.php-->
            
            <form method="POST" action="fisico_vs_sistema_afectar.php?propietario=<?php echo $propietario;?>
&nombreCompleto=<?php echo $nombreCompletoPropietarioVista;?>
&fecha=<?php echo $fechaCortaVista ;?>
&hora=<?php echo $horaVista ;?>
&existenciasTotalesSistema=<?php echo $existenciasTotalesSistemaVista ;?>
&totalPiezasFisicasCapturadas=<?php echo $totalPiezasFisicasCapturadasVista ;?>
&totalPiezasDiferencias=<?php echo $totalPiezasDiferenciasVista ;?>
&importeTotalDiferencias=<?php echo $importeTotalDiferenciasVista ;?>
&notas=<?php echo $notas ;?>">
            
                
                
                
            <?php $i=0; 
            foreach ($arrayRenglonesParaVista as $value):;?> 
                
            <input type="text" name="costoEmpr<?php echo $i;?>" value="<?php echo $value['empresaria']   ?>" readonly="true"/>

            <input type="text" name="existenciaSistema<?php echo $i;?>" value="<?php echo $value['existencia']   ?>" readonly="true" />    

            <input type="text" name="existenciafisica<?php echo $i;?>" value="<?php echo $value['existenciaFisica']   ?>" readonly="true" />
            
            <input type="text" name="codigo<?php echo $i;?>" value="<?php echo $value['codigo']   ?>" readonly="true"/>
            
            <input type="text" name="diferenciaPiezas<?php echo $i;?>" value="<?php echo $value['diferenciaPiezas']   ?>" readonly="true" />

            <input type="text" name="importeDiferencia<?php echo $i;?>" value="$<?php echo $value['importeDiferencia']   ?>" readonly="true" />
            
            <br>
            <br>
            <?php $i++; endforeach ;?>
            
            
            
            
                
            
            Total piezas Segun Sistema: <?php echo $existenciasTotalesSistemaVista?>
            <br>
            Total piezas Fisicas Capturadas: <?php echo $totalPiezasFisicasCapturadasVista?>
            <br><br>
            Diferencia de piezas: <?php echo ($totalPiezasDiferenciasVista>0)?"<h3>Sobran: $totalPiezasDiferenciasVista piezas</h3>" : "<h3>Faltan: $totalPiezasDiferenciasVista piezas</h3>";?>
                        
           <?php echo ($importeTotalDiferenciasVista!=0)?"<h2>Existen diferencias de importes!!!</h2>":""?>
            <!--
            Importe de Diferencia: <?php $importeTotalDiferenciasVista?>
            <br>
            ocultamos el importe de la diferencia para obligar al administrador a precionar el boton de balance porque si no 
            podria olvidarse de precionarlo y el inventairo no se afectaria, cuando se afecte el inventario en ese momento se mostrara el importe del faltante
            -->
            
            
           
            
            <br><br><br><br><br><br><br> <h2>Para conocer importe de la comparacion debe dar clic en finalizar inventario al final de la pagina<br>
            pero hagalo una ves que este seguro de finalizar la comparacion ya que no habra vuelta atras</h2>
            
            
            
            
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            
            <input type="submit" name="datos" value="Finalizar Captura de inventario">
            </form>  

    </body>
</html>