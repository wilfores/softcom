<?php
include("../filtro.php");
include("../conecta.php");
include("cifrar.php");
$gestion=$_SESSION["gestion"];
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
<link rel="stylesheet" type="text/css" href="script/estilos2.css" title="estilos2" />

<?php
$cod_institucion=$_SESSION["institucion"];

$ssql = "SELECT * FROM clasecorrespondencia order by clasecorrespondencia_descripcion_clase_corresp";

$res=mysql_query($ssql,$conn);
?>
<script> 
function cerrarse(){ 
window.close() 
} 
</script>
<br>
<div class="fuente_normal" align="center"><b>LISTA DE DOCUMENTOS</b></div>
<br>

<center>
<div style="overflow:auto; width:98%; height:150px; align:left;">
<table border="1" cellpadding="1" cellspacing="1">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
<td align="center"><span class="fuente_normal"><b>Documento</b></span></td>
<td align="center"><span class="fuente_normal"><b>Sigla</b></span></td>
<td align="center"><span class="fuente_normal"><b>Eliminar</b></span></td>
<?php
while($row=mysql_fetch_array($res))
{
?>
<tr style="color:#003366; font-size:10px">
<td >
<?php
$nombre_doc=$row["clasecorrespondencia_descripcion_clase_corresp"];
echo "<a href=\"#\" style=\"color:#003366\" onclick=\"window.opener.document.enviar.descripcion_clase_corresp.value='$nombre_doc';self.close();\">";
echo $row["clasecorrespondencia_descripcion_clase_corresp"];
?>
</a>
</td>
<td>
<?php
$nombre_doc=$row["clasecorrespondencia_descripcion_clase_corresp"];
echo "<a href=\"#\" style=\"color:#003366\"  onclick=\"window.opener.document.enviar.descripcion_clase_corresp.value='$nombre_doc';self.close();\">";
echo $row["clasecorrespondencia_codigo_clase_corresp"];
?>
</a>
</td>
<td align="center">
<a href="eliminadoc.php?codigoeli=<?php echo $row["clasecorrespondencia_descripcion_clase_corresp"];?>">
<img src="../images/eliminar.png">
</a>
</td>
<?php
}
?>
</table>
</div>
</center>
<CENTER>
<table width="0" border="0" cellpadding="0">
  <tr>
    <td><form method="post" action="adicion_documento.php">
			<input type="submit" name="adicionar" class="boton" value="Adicionar"/>
			</form>
	</td>
    <td>
	<form> 
	<input type=button value="Cerrar" onClick="cerrarse()" class="boton"> 
	</form>
	</td>
  </tr>
</table>
</CENTER>
