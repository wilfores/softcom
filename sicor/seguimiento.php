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
<script>
<!--
function Retornar(){
  document.buscar.action="principal.php";
  document.buscar.submit();
}
function Ingresar(){
  if (document.buscar.clase.value=="por_pendientes")
  {
        document.buscar.action="encuentra.php";
        document.buscar.submit();
  } else 
  {
     if (document.buscar.busqueda.value != "")
	 {
       document.buscar.action="encuentra.php";
      document.buscar.submit();
     }
	
  }	
}
-->
</script>

<br>
<p class="fuente_titulo">
<center><b>BUSCAR CORRESPONDENCIA</b></center>
<br>
<center>

<form name="buscar" method="POST" action="encuentra.php">
<table width="75%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr3"><td> &nbsp;&nbsp; BUSCAR &nbsp;&nbsp;</td>
<td>&nbsp;&nbsp; <input type="text" name="busqueda" size="25" /> &nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;POR : 
  <select name="clase">
<?php
  echo "<option value=\"por_hoja\">Hoja de Ruta</option>";
  echo "<option value=\"por_pendientes\">Pendientes</option>";
  echo "<option value=\"por_referencia\">Referencia</option>";
  echo "<option value=\"por_cite\">Nro Cite</option>";    
  echo "<option value=\"por_funcionariop\">Funcionario(Tareas Pendientes)</option><br>";
  echo "<option value=\"por_funcionariot\">Funcionario(Tareas Concluidas)</option><br>";
  echo "<option value=\"por_departamento\">Departamento</option>";
  echo "<option value=\"por_fecha\">Fecha</option>";
  echo "<option value=\"por_eremitente\">Entidad Remitente</option>";
  echo "<option value=\"por_remitente\">Remitente</option>";
?>
  </select>  
  &nbsp;&nbsp;</td>
</tr>
<tr><td align="center" colspan="3">
<br>
<input type="submit" name="buscar" value="Buscar" class="boton"/>
</table>
</form>


<form name="buscar_fecha" method="POST" action="encuentra.php">
<table width="75%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr3">
<td> &nbsp;&nbsp; BUSCAR &nbsp;&nbsp;</td>
<td width="45%" align="right"> <span class="fuente_normal"><b>Fecha Inicial</b></span>
<input name="fechaini" type="text" class="fuente_caja_texto" size="10" id="dateArrival1">
<img src="images/calendar.gif" onClick="popUpCalendar(this,buscar_fecha.dateArrival1,'yyyy-mm-dd');" alt="Calendario" />
<br />
</td>
<td width="55%" colspan="2" align="left"> <span class="fuente_normal"><b>Fecha Final</b></span>
<input name="fechafin" type="text" class="fuente_caja_texto" size="10" id="dateArrival">
<img src="images/calendar.gif" onClick="popUpCalendar(this,buscar_fecha.dateArrival,'yyyy-mm-dd');" alt="Calendario" />
</td>
</tr>
<tr><td align="center" colspan="3">
<br>
<input type="submit" name="buscar_por_fecha" value="Buscar" class="boton"/>
</table>
</form>


<br><br>
<a href="principal.php" class="enlace_normal">[Volver]</a>
</center>
<br>
<?php
include("final.php");
?>