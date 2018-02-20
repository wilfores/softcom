<?php
include("../filtro.php");
?>
<html>
<title>Entidades Acreditada</title>
<link rel="stylesheet" type="text/css" href="script/estilos2.css" title="estilos2" />
<script> 
function cerrarse(){ 
window.close() 
} 
</script> 

<body>
<br>
<p class="fuente_titulo"><span class="fuente_normal">
<center><B>Entidades Acreditadas</B>
<br>
<br>

<table size=0>
<form name="entidad" method="post" action="busca_funcionario.php">
<tr class="border_tr3">
<td>
Nombre Departamento
</td>
<td valign"middle">
<input class="caja_texto" type="text" name="nombre_entidad">
<br>
</td>
</tr>
<tr class="border_tr3">
<td align="center" colspan="2">
	<br>
<input type="submit" name="buscar" class="boton" value="Buscar"/>
</td>
</tr>
</table>
</form>
<center>
<br>
<br>
<form> 
<input type=button value="Cerrar" onClick="cerrarse()"> 
</form>
</center>
</body>
</html>
</center>