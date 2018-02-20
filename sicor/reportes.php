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
<script language="JavaScript">
<!-- 
function Retornar()
{
  document.enviar.action="principal.php";
  document.enviar.submit();
}
-->
</script>
<center>
<br>
<p class="fuente_titulo">
<span class="fuente_normal">
<center><b>REPORTE DINAMICO DE CORRESPONDENCIA</b></center>
<br>
<form name="enviar" method="post" action="listadoreporte.php">
<table width="60%" cellspacing="2" cellpadding="2" border="0">

<tr class="border_tr3">
<td width="45%" align="right"> <span class="fuente_normal"><b>Fecha Inicial</b></span>
<input name="fechaini" type="text" class="fuente_caja_texto" size="10" id="dateArrival1">
<img src="images/calendar.gif" onClick="popUpCalendar(this,enviar.dateArrival1,'yyyy-mm-dd');" alt="Calendario" />
<br />
</td>
<td width="55%" colspan="2" align="left"> <span class="fuente_normal"><b>Fecha Final</b></span>
<input name="fechafin" type="text" class="fuente_caja_texto" size="10" id="dateArrival">
<img src="images/calendar.gif" onClick="popUpCalendar(this,enviar.dateArrival,'yyyy-mm-dd');" alt="Calendario" />
</td>
</tr>

<tr class="border_tr3">
<td colspan="3" align="center">
<b><span class="fuente_normal">Texto a Buscar:</span></b> 
<input  type="text" name="revisar" class="fuente_caja_texto" size="30" />
</td>
</tr>

<tr class="border_tr3">
  <td colspan="3" align="center" ><span class="fuente_subtitulo"></span>
    <select name="clase" class="caja_texto">
      <option value="por_pendientes">Pendientes de la Institucion</option>
      <option value="por_terminados">Terminados de la Institucion</option>
      <?php
	  echo "<option value=\"por_funcionariop\">Funcionario(Tareas Pendientes)</option><br>";
	  echo "<option value=\"por_funcionariot\">Funcionario(Tareas Concluidas)</option><br>";
	  echo "<option value=\"por_departamentop\">Departamento Pendientes</option>";
	  echo "<option value=\"por_departamentot\">Departamento Concluidos</option>";

?>
      <option value="por_eremitente">Entidad Remitente</option>
      <option value="por_premitente">Remitente</option>
      <option value="por_ingreso">Ventanilla</option>
    </select>
  </td>
</tr>

<tr>
<td align="center" colspan="6">
<br>
<input type="submit" name="buscar" value="Buscar" class="boton"/>
<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();"/>
</td>
</tr>
</table>
</form>
</center>


<?php
include("final.php");
?>