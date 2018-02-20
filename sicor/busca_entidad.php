<?php
include("../filtro.php");
?>
<html>
<title>Buscar entidad</title>
<link rel="stylesheet" type="text/css" href="script/estilos2.css" title="estilos2" />
<script> 
function cerrarse(){ 
window.close() 
} 
</script> 

<body>
<br>
<p class="fuente_titulo"><span class="fuente_normal">
<center><B>ADICIONAR ENTIDADES</B>
<br>


<table  border="1" cellpadding="1" cellspacing="1">
<form name="entidad" method="post" action="encuentra_entidades.php">
	<tr class="border_tr3">
		<td>
		Nombre
		</td>
		<td valign"middle">
		<input class="caja_texto" type="text" name="nombre_entidad" size="30">
		</td>
	</tr>

	<tr class="border_tr3">
		<td>
		Sigla
		</td>
		<td valign"middle">
		<input class="caja_texto" type="text" name="sigla_entidad" size="30">
		</td>
	</tr>

	<tr class="border_tr3">
		<td align="right" colspan="2">
		
			<table align="center">
			<tr>
			<td>
			<input type="submit" name="buscar" class="boton" value="Buscar"/>
			</form>
			</td>
			<td>
			<form method="post" action="adiciona_entidad.php">
			<input type="submit" name="adicionar" class="boton" value="Adicionar"/>
			</form>
			</td>
			</tr>
			</table>
		
		</td>
	</tr>
</table>

<center>
<br>
<form> 
<input type=button value="Cerrar" onClick="cerrarse()"> 
</form>
</center>

</body>
</html>
</center>