<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");
include("script/config.inc");
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

$cod_institucion=$_SESSION["institucion"];

$rss=mysql_query($sqlres,$conn);
if (empty($_POST['pagar_dom'])) 
{
	 ?>
				<script language='JavaScript'> 
					window.self.location="listado_libro.php"
				</script>
	<?php
	exit();
}

$_SESSION["codigo_libro_reg"]=array_reverse($_POST['pagar_dom']);

   
?>
<script language="JavaScript">
function Retornar()
{
	document.recepcion.action="listado_libro.php";
	document.recepcion.submit();
}
</script>
<p class="fuente_titulo">
<br>
<center><b>Posici&oacute;n de Impresion del Libro de Registro</b></center></p></center>
<center>
<form name="imprimir" action="imprime_libroregistro.php" method="POST" target="_blank">
<table width="23%" cellspacing="5" cellpadding="5" border="0">
<tr class="border_tr3">
<td align="center" colspan="2">
<br><div><b>IMPRESI&Oacute;N EN LA HOJA</b></div><br>
	<input type="radio" name="position" value="1" checked>&nbsp;&nbsp;Posicion 1<br>
	<!--<input type="radio" name="position" value="2">&nbsp;&nbsp;Posicion 2 <br>
	<input type="radio" name="position" value="3">&nbsp;&nbsp;Posicion 3 <br>
	<input type="radio" name="position" value="4">&nbsp;&nbsp;Posicion 4 <br>
	<input type="radio" name="position" value="5">&nbsp;&nbsp;Posicion 5 <br>
	<input type="radio" name="position" value="6">&nbsp;&nbsp;Posicion 6 <br>-->
	
</td>
</tr>
<tr>
<td align=center colspan="2">
    <input type="submit" name="ver_imprimir" value="Imprimir" class="boton">

</td></tr>
</table>
</form>
<br>
<a href="listado_libro.php" class="enlace_normal">[..Volver]</a>

<br><br>
</center>
<?php
include("final.php");
?>
