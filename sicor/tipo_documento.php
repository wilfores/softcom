<?php
include("../filtro.php");
include("../conecta.php");
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
$ssql = "SELECT * FROM clase_correspondencia";
$rss = mysql_query($ssql,$conn);
?>
<script language="Javascript">
function CopiaValor(objeto) {
	document.tipo_documento.cod_corresp.value = objeto.value;
}

function Retornar(){
	document.tipo_documento.action="principal.php";
	document.tipo_documento.submit();
}

function Adicionar(){
	document.tipo_documento.action="tipo_nuevo.php";
	document.tipo_documento.submit();
}
function Eliminar(){
  if (document.tipo_documento.sel_corresp != ""){
   document.tipo_documento.action="tipo_delete.php";
   document.tipo_documento.submit();
  }
}
</script>
<br>
<center>
<table border="0" cellpadding="2" cellspacing="2" width="50%">
<form method="POST" name="tipo_documento">
<tr class="border_tr2">
<td align="center" width="5%">*</td>
<td align="center" width="10%">Codigo</td>
<td align="center" width="65%">Tipo Documento</td></tr>
<?php
while($row=mysql_fetch_array($rss)){
	echo "<tr>";
    echo "<td class=\"border_tr\"><input type=\"checkbox\" name=\"sel_corresp[]\" value=".$row["codigo_clase_corresp"]."></td>";
	echo "<td class=\"border_tr\">".$row["codigo_clase_corresp"]."</td>";
	echo "<td class=\"border_tr\">".$row["descripcion_clase_corresp"]."</td>";
	echo "</tr>";
} // while
?>
<tr><td colspan="3" align="center">
<input type="hidden" name="cod_corresp">
<input type="submit" name="adicionar" value="Adicionar" class="boton" onClick="Adicionar();" />
&nbsp;<input type="submit" name="eliminar" value="Eliminar" class="boton" onClick="Eliminar();" />
&nbsp;<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();" />
</td></tr>
</table>
</form>
</center>
<?php
include("final.php");
?>