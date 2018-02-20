<?php
include("../filtro.php");
?>
<?php
/*include("inicio.php");*/
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
<table border="0" width="100%" cellscpacing="0" cellpadding="0">
<tr>
<td align="center">
<div class="fuente_normal"><b>CORRESPONDENCIA PERSONALIZADA</b></div>
</td>
</tr>

<tr>
<td valign="top" width="100%">
<br>
<center>
 <TABLE border="0" width="60%" cellspacing="2" cellpadding="2">
 <tr class="border_tr2">
 <td align="center" width="90%">OPCIONES</td>
 <td align="center" width="10%"></td>
 </tr>
<?php
$ssql="SELECT * FROM seguimiento WHERE '$cargo_unico'=seguimiento_destinatario AND (seguimiento_tipo='A' OR seguimiento_tipo='R') AND seguimiento_estado='P'";
$rss=mysql_query($ssql,$conn);
$contador1=mysql_num_rows($rss);
?>
 <TR class="truno" >
 <td width="95%"><a href="recepcion_lista.php" class="enlace_normal">CORRESPONDENCIA RECIENTE</a><strong style="color:#000099;"><?php echo " ( ".$contador1." PENDIENTES)";?></strong></td>
 <td><a href="recepcion_lista.php" class="enlace_normal">REVISAR</a></td>
 </TR>
<?php
$ssql="select * from seguimiento,ingreso where seguimiento.seguimiento_destinatario='$cargo_unico' and seguimiento.seguimiento_cod_institucion='$cod_institucion' and ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro and ingreso.ingreso_cod_institucion='$cod_institucion' and seguimiento.seguimiento_tipo='D'";
$rss=mysql_query($ssql,$conn);
$contador2=mysql_num_rows($rss);
?>
 <TR class="trdos" >
 <td><a href="miderivacion.php" class="enlace_normal">CORRESPONDIENTE DERIVADA</a><strong style="color:#000099;"><?php echo " ( ".$contador2." DERIVADOS O FINALIZADOS)";?></strong></td>
 <td><a href="miderivacion.php" class="enlace_normal">REVISAR</a></td>
 </TR>
<?php
$fecha_ult = date("Y-m-d");
$ssql="SELECT * FROM seguimiento WHERE '$cargo_unico'=seguimiento_destinatario AND (seguimiento_tipo='A' OR seguimiento_tipo='R') AND seguimiento_estado='P' AND seguimiento_fecha_plazo ='$fecha_ult' AND seguimiento_cod_institucion='$cod_institucion'";
$rss=mysql_query($ssql,$conn);
$contador3=mysql_num_rows($rss);
?> 
 <TR class="truno" >
 <td><a href="recepcion_hoy.php" class="enlace_normal">CORRESPONDENCIA CON FECHA PLAZO</a><strong style="color:#000099;"><?php echo " ( ".$contador3." PENDIENTES)";?></strong></td>
 <td><a href="recepcion_hoy.php" class="enlace_normal">REVISAR</a></td>
 </TR>
<?php
$ssql="SELECT * FROM correspondenciacopia WHERE '$cargo_unico'=correspondenciacopia_destinatario AND (correspondenciacopia_tipo='A' OR correspondenciacopia_tipo='R') AND correspondenciacopia_estado='P' AND correspondenciacopia_cod_institucion='$cod_institucion'";
$rss=mysql_query($ssql,$conn);
$contador4=mysql_num_rows($rss);
?>
 <TR class="trdos">
 <td><a href="miscopias.php" class="enlace_normal">CORRESPONDENCIA DERIVADA COMO COPIA</a><strong style="color:#000099;"><?php echo " ( ".$contador4." PENDIENTES)";?></strong> </td>
 <td><a href="miscopias.php" class="enlace_normal">REVISAR</a></td>
 </TR>
 </TABLE>
</center>
<br><br>
</td>
</tr>
</table>

<?php
/*include("final.php");*/
?>
