<?php
include("../filtro.php");
?>
<?php
include("../conecta.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("inicio.php");

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
$codigo_seguimiento = descifrar($_GET['datosv']);


$ssql = "SELECT documentos_descripcion,documentos_id FROM documentos";
$rss = mysql_query($ssql, $conn);
?>
<br>
<div align="center"><span class="fuente_titulo"><b>DESCRIPCI&Oacute;N DE DOCUMENTOS </b></div>
<br>

<form method="POST" name="aceptar" action="listadocumentosespecifico.php">
<table width="31%" border="0" align="center" cellpadding="2" cellspacing="2">
<tr class="border_tr3">
  <td height="38" colspan="3" align="center" bgcolor="#E6E4EF"><strong>SELECCIONAR EL TIPO DE DOCUMENTO A IMPRIMIR</strong></td>
  </tr>

<tr class="border_tr3">
  <td align="center" bgcolor="#D6E1F5">N&ordm;</td>
  <td bgcolor="#D6E1F5">Documento</td>
  <td align="center" bgcolor="#D6E1F5">Opcion</td>
</tr>

<?PHP 
$contador=1;
while($valor=mysql_fetch_array($rss))
{?>
<tr class="border_tr3">
  <td width="9%" align="center"><?PHP echo $contador?></td>
<td width="72%"><?PHP echo $valor[0]?></td>
<td width="19%" align="center"><span class="fuente_normal">
  <input name="valordocumento" type="radio" value="<?PHP echo $valor[1]?>" />
  <input name="controlcito" type="hidden"  value="1"/>
  </td>
</tr>
<?PHP 
$contador=$contador+1;
}?>

<tr>
<td colspan="3" align="center"><br>
<input type="submit" name="aceptar" value="Acaptar" class="boton"/></td>
</tr>
</table>
</form>

<?php
include("final.php");
?>

