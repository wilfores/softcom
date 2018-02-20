<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");
$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
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
?>
<br>
<table border="0" width="50%" align="center"S  cellscpacing="0" cellpadding="0">
<tr><td align="center">
<div class="fuente_normal"><b>CLASIFICACION DE ARCHIVOS</b></div>
</td></tr>
<tr><td valign="top" width="100%">
<br>
<center>

     <TABLE border="0" width="60%" cellspacing="2" cellpadding="2">
     <tr class="border_tr2">
     <td align="center" width="50%"><span class="fuente_normal">OPCIONES</td>
     <td align="center" width="10%">ACCIONES</td>
     </tr>
     
    <?php
    $ssql="select * from registroarchivo a, derivaciones b 
	   where a.registroarchivo_hoja_interna=b.derivaciones_hoja_interna 
	   AND b.derivaciones_cod_usr='$_SESSION[codigo]'
	   AND a.registroarchivo_tipo='INFORME'
	   AND b.derivaciones_estado='D' ORDER BY registroarchivo_codigo DESC";
    $rss=mysql_query($ssql,$conn);
    $contador1=mysql_num_rows($rss);
    ?>
     <TR class="truno" >
     <td width="50%"><a href="encuentra2.php"><span class="fuente_normal">INFORME</a><strong style="color:#000099;"><?php echo " ( ".$contador1." PENDIENTES)";?></strong></td>
     <td><a href="encuentra2.php"><span class="fuente_normal">Revisar</a></td>
     </TR>
     
    <?php
    $ssql="select * from registroarchivo a, derivaciones b 
	   where a.registroarchivo_hoja_interna=b.derivaciones_hoja_interna 
	   AND b.derivaciones_cod_usr='$_SESSION[codigo]'
	   AND a.registroarchivo_tipo='NOTA INTERNA'
	   AND b.derivaciones_estado='D' ORDER BY registroarchivo_codigo DESC";
    $rss=mysql_query($ssql,$conn);
    $contador2=mysql_num_rows($rss);
    ?>
     <TR class="trdos" >
     <td><a href="encuentra2.php"><span class="fuente_normal">NOTA INTERNA</a><strong style="color:#000099;"><?php echo " ( ".$contador2." PENDIENTES)";?></strong></td>
     <td><a href="encuentra2.php"><span class="fuente_normal">Revisar</a></td>  
     </TR>
     
    <?php
    $fecha_ult = date("Y-m-d");
    $ssql="select * from registroarchivo a, derivaciones b 
	   where a.registroarchivo_hoja_interna=b.derivaciones_hoja_interna 
	   AND b.derivaciones_cod_usr='$_SESSION[codigo]'
	   AND a.registroarchivo_tipo='MEMORANDUMS'
	   AND b.derivaciones_estado='D' ORDER BY registroarchivo_codigo DESC";
    $rss=mysql_query($ssql,$conn);
    $contador3=mysql_num_rows($rss);
    ?> 
     <TR class="truno" >
     <td><a href="encuentra2.php"><span class="fuente_normal">MEMORANDUM</a><strong style="color:#000099;"><?php echo " ( ".$contador3." PENDIENTES)";?></strong></td>
     <td><a href="encuentra2.php"><span class="fuente_normal">Revisar</a></td>
     </TR>
     
    <?php
    $ssql="select * from registroarchivo a, derivaciones b 
	   where a.registroarchivo_hoja_interna=b.derivaciones_hoja_interna 
	   AND b.derivaciones_cod_usr='$_SESSION[codigo]'
	   AND a.registroarchivo_tipo=''
	   AND b.derivaciones_estado='D' ORDER BY registroarchivo_codigo DESC";
    $rss=mysql_query($ssql,$conn);
    $contador4=mysql_num_rows($rss);
    ?>
     <TR class="trdos">
     <td><a href="encuentra2.php"><span class="fuente_normal">CIRCULARES</a><strong style="color:#000099;"><?php echo " ( ".$contador4." PENDIENTES)";?></strong> </td>
     <td><a href="encuentra2.php"><span class="fuente_normal">Revisar</a></td>
     </TR>
     </TABLE>
     
</center>
<br><br>
</td></tr>
</table>
<?php
include("final.php");
?>
