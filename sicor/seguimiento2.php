<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("../conecta.php");
?>
<br>
<p class="fuente_titulo">
<center><b>BUSCAR CORRESPONDENCIA EXTERNA</b></center>
<br>
<center>
<table width="40%" cellspacing="2" cellpadding="2" border="0">
<form name="buscar" method="POST" action="encuentra3.php">
<tr class="border_tr3">
<td width="45%" align="right"> <span class="fuente_normal"><b>Fecha Inicial</b></span>
<input name="fechaini" type="text" class="fuente_caja_texto" size="10" id="dateArrival1">
<img src="images/calendar.gif" onClick="popUpCalendar(this,buscar.dateArrival1,'yyyy-mm-dd');" alt="Calendario" />
<br />
</td>
<td width="55%" colspan="2" align="left"> <span class="fuente_normal"><b>Fecha Final</b></span>
<input name="fechafin" type="text" class="fuente_caja_texto" size="10" id="dateArrival">
<img src="images/calendar.gif" onClick="popUpCalendar(this,buscar.dateArrival,'yyyy-mm-dd');" alt="Calendario" />

</td>
</tr>


<tr class="border_tr3" align="right"><td>BUSCAR :</td>
<td align="left"><input type="text" name="busqueda" size="25" /></td>
</tr>
<tr class="border_tr3" align="right">
<td>POR : </td>
<td align="left">
  <select name="clase">
<?php
  echo "<option value=\"por_cite\">Nro. CITE</option>";
  echo "<option value=\"por_destinatario\">DESTINATARIO</option>";
  echo "<option value=\"por_cargo\">CARGO/INSTITUCION</option>";
  echo "<option value=\"por_fecha\">FECHA ELABORACION</option>";    
  echo "<option value=\"por_referencia\">REFERENCIA</option><br>";
?>
  </select>  
  &nbsp;&nbsp;</td>
</tr>
<tr><td align="center" colspan="3">
<br>
<input type="submit"  value="Buscar" class="boton" />
</table>
</form>
<br><br>
<a href="menu.php" class="enlace_normal">[Volver]</a>
</center>
<br>
<?php
include("final.php");
?>