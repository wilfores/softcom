<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$codigo_usuario=$_SESSION["cargo_asignado"];
$camb_gest=$_SESSION["camb_gest"];
//$conn = Conectarse();
if($camb_gest==2013)
{
	$conn = Conectarse();
}
if($camb_gest==2014)
{
	$conn = Conectarse2();
}
if($camb_gest==2015)
{
	$conn = Conectarse3();
}
unset($_SESSION[logo_pie]);
unset($_SESSION[logo_cabecera]);
?>
<?php
$valor_recibido = descifrar($_GET[valor]);
if(!is_numeric($valor_recibido))
{
    echo "!!! INTENTO DE MANIPULACION DEL SISTEMA !!!";
    exit;
}
$sql_valor = mysql_query("SELECT * FROM registroarchivo
                           WHERE registroarchivo_codigo = '$valor_recibido'",$conn);
if($fila_archivo = mysql_fetch_array($sql_valor))
{
?>   
<center>
    <?php
    $sql_consulta_doc = mysql_query("SELECT documentos_descripcion FROM documentos
                                     WHERE documentos_id = '$fila_archivo[registroarchivo_tipo]'",$conn);
            if($fila_tipo = mysql_fetch_array($sql_consulta_doc))
            {
                echo "<br /><span class=fuente_titulo><b>".$fila_tipo["documentos_descripcion"]."</b></span><br /><br />";
            }
            mysql_free_result($sql_consulta_doc);
    ?>
<table border="0" cellpadding="0" cellspacing="2" align="center" width="80%">
<tr>
   <td align="center" colspan="2" class="border_tr2">
    <?php
    echo "<span class='fuente_titulo'><b>";
    echo "<center>CITE:" . $fila_archivo["registroarchivo_hoja_interna"] . "</center></b></span>";
    ?>
   </td>
</tr>
<tr class="border_tr3">
    <td align="right" class="border_tr2">
        <b>PARA:</b>
    </td>
    <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
        <?php
        echo "<tr><td bgcolor=\"#EFEBE3\" width=\"300\">";
        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo
                         FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                         AND a.derivaciones_estado = 'P'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo "<br />".$fila_para["usuario_nombre"];
            echo "<br /> <b>(".$fila_para["cargos_cargo"].")</b>";
        }
        echo "</td></tr>";
        mysql_free_result($rss_consulta);
        ?>
        </table>
        </td>
        </tr>
        <?php
        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                         AND a.derivaciones_estado = 'V'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        if(mysql_num_rows($rss_consulta) > 0)
        {
        ?>

        <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>VIA:</b>
        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
        <?php
        echo "<tr><td bgcolor=\"#EFEBE3\" width=\"300\">";
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo "<br />".$fila_para["usuario_nombre"];
            echo "<br /> <b>(".$fila_para["cargos_cargo"].")</b>";
        }
        echo "</td></tr>";
        ?>
        </table>
        </td>
        </tr>
        <?php
      }
      mysql_free_result($rss_consulta);
      ?>
      <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>DE:</b>
        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
         echo "<tr><td bgcolor=\"#EFEBE3\" width=\"300\">";

        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                         AND a.derivaciones_estado = 'D'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo "<br />".$fila_para["usuario_nombre"];
            echo "<br /> <b>(".$fila_para["cargos_cargo"].")</b>";
        }
        echo "</td></tr>";
        mysql_free_result($rss_consulta);
        ?>
        </table>
        </td>
        </tr>
        <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>REF.:</b>
        </td>
        <td>
            <?php echo $fila_archivo["registroarchivo_referencia"];?>
        </td>
        </tr>
        <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>FECHA.:</b>
        </td>
        <td>
            <?php echo $fila_archivo["registroarchivo_fecha_pdf"];?>
        </td>
        </tr>
        <tr class="border_tr3">
        <td class="border_tr2" align="right">
            <b>ADJUNTOS:</b>
        </td>
        <td align="left"  valign="top" colspan="2">
            <?php
            $conexion_sql = mysql_query("SELECT * FROM adjunto
                                         WHERE adjunto_id='$valor_recibido'",$conn);
            while($fila_adjunto = mysql_fetch_array($conexion_sql))
            {
                $archivo_enviar = cifrar($fila_adjunto["adjunto_archivo"]);
            ?>
            <a href="<?php echo $fila_adjunto["adjunto_archivo"];?>" target="_blank" class="enlace_normal">
                <img src="images/archivo.jpeg" width="12" height="14" alt="Archivo" />
                &nbsp;&nbsp;<?php echo $fila_adjunto["adjunto_nombre"];?>
            </a>
            &nbsp;&nbsp;&nbsp;
            <?php
                echo "<br /><br />";
            }
            ?>
        </td>
        </tr>
        </table>
        <br />
         <a href="imprimir_borrar.php?valor=<?php echo $_GET[valor];?>" class="boton" target="_blank">
         &nbsp; <b>Imprimir</b> &nbsp;
        </a>
</center>
<?php
}
?>

<center>
<br><br>
<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="3%" align="center"><span class="fuente_normal">Tipo</span></td>
<td width="10%" align="center"><span class="fuente_normal">Remitente</span></td>
<td width="10%" align="center"><span class="fuente_normal">Destinatario</span></td>
<td width="10%" align="center"><span class="fuente_normal">Fecha Derivacion</span></td>
<td width="10%" align="center"><span class="fuente_normal">Fecha Recepcion</span></td>
<td width="15%" align="center"><span class="fuente_normal">Instruccion</span></td>
<td width="20%" align="center"><span class="fuente_normal">Observaciones</span></td>
<td width="10%" align="center"><span class="fuente_normal">Estado</span></td>
</tr>
<?php 
 $resaltador=0;
 $sql_consulta=mysql_query("SELECT * FROM derivaciones
                            WHERE derivaciones_hoja_interna='$valor_recibido'
			    AND derivaciones_id_derivacion > '0' ORDER BY
                            derivaciones_cod_seg ASC",$conn);
 while($filas=mysql_fetch_array($sql_consulta))
{  $aux=$filas["derivaciones_cod_usr"];
  if ($resaltador==0)
	  {
       echo "<tr class=truno>";
	   $resaltador=1;
      }
	  else
	  {
       echo "<tr class=trdos>";
   	   $resaltador=0;
	  }
?>
<?php 
$datos12=$filas["derivaciones_cod_usr"];
$consulta1="select * from usuario where usuario_ocupacion='$datos12'";
$nombre1=mysql_query($consulta1,$conn);
if($filon=mysql_fetch_array($nombre1))
{ $var11=$filon["usuario_nombre"];
  
  	$valor_clave=$filon["usuario_ocupacion"];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
	$var21=$fila_clave["cargos_cargo"];
	} 

}
?>
<?php 
$buscar=$filas["derivaciones_id_derivacion"];
$consulta_remi="select * from derivaciones where derivaciones_cod_seg='$buscar'";
$nombre_remi=mysql_query($consulta_remi,$conn);
if($remi=mysql_fetch_array($nombre_remi))
{ $rem1=$remi["derivaciones_cod_usr"];
$remi_fin="select * from usuario where usuario_ocupacion='$rem1'";
$remi_final=mysql_query($remi_fin,$conn);
if($final=mysql_fetch_array($remi_final))
{ $remi123=$final["usuario_nombre"];
  
  	$valor_clave=$final["usuario_ocupacion"];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
	$remi1234=$fila_clave["cargos_cargo"];
	} 

}
}
//aquirriba para 
?>
<?php
$ins=$filas["derivaciones_instruccion"];
$instruc="select * from instruccion where instruccion_codigo_instruccion='$ins'";
$instruc=mysql_query($instruc,$conn);
if($filon=mysql_fetch_array($instruc))
{
    $uno=$filon["instruccion_instruccion"];
}

?>

<td align="justify" width="3%"><?php echo $filas["derivaciones_tipo_derivacion"];?></td>
<td align="center" width="10%"><?php  echo $remi123."<br>"; echo "<b>".$remi1234."</b>"; ?></td>
<td align="center" width="10%"><?php  echo $var11."<br>";echo "<b>".$var21."</b>"; ?></td>
<td align="center" width="10%"><?php  echo $filas["derivaciones_fecha_derivacion"];?></td>
<td align="center" width="10%"><?php  echo $filas["derivaciones_fecha_recepcion"];?></td>
<td align="center" width="15%"><?php echo $uno;?></td>
<td align="center" width="30%"><?php echo $filas["derivaciones_proveido"];?></td>
<?php 
$consulta12="SELECT * FROM terminados where terminados_hoja_interna='$valor_recibido' AND terminados_cod_usr='$aux'";
$estadito=mysql_query($consulta12,$conn);
if(mysql_num_rows($estadito) > 0)
{
    $saca_estado=mysql_fetch_array($estadito);
    $numero_clave=$saca_estado["terminados_indicador"];
?>
    <td align="left" width="10%">
    <?php
	echo "<b>Finalizaci&oacute;n:</b><br>".$saca_estado["terminados_fechatermino"]."<br><br><b>Proveido:</b><br>".$saca_estado["terminados_descripcion_final"]."<br><br><b>Archivado en:</b><br>".$saca_estado["terminados_archivado"];
	?>
    
    </td>
  
    <?php
}
else
{
?>
<td align="center" width="10%">
<?php
$cone_estado="SELECT * FROM derivaciones WHERE derivaciones_hoja_interna='$valor_recibido'
              AND derivaciones_cod_usr='$aux'";
$estadofinal=mysql_query($cone_estado,$conn);
if($erow=mysql_fetch_array($estadofinal))
{//AND derivaciones_estado='P'
  echo $erow['derivaciones_situacion'];
}
mysql_free_result($estadofinal);
?>
</td>
<?php
}
mysql_free_result($estadito);
?>



<?php
 } 
?>
</tr>
</table>
<?php
mysql_close($conn);
?>
</table>
</center>
<br>
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<?php
$pagina_ori=$_SERVER['HTTP_REFERER'];
$posicion=strrpos($pagina_ori,"/");
$ir_pagina=substr($pagina_ori,$posicion+1);
$historia_en = $_GET['datos'];
?>
<br>
<form action="<?php echo $ir_pagina;?>" method="POST">
<div align="center">
<input type="submit" name="buscar" value="Retornar" class="boton" /></div>
</form>
</td>
</tr>
</table>
<?php
include("../final.php");
?>