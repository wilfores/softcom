<?php
include("../filtro.php");
?>
<link rel="stylesheet" type="text/css" href="script/estilos2.css" title="estilos2" />
<?php
include("../conecta.php");
include("cifrar.php");
include("script/functions.inc");
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
$cod_institucion=$_SESSION["institucion"];
$cod_usr=$_SESSION["codigo"];
?>
<script> 
function cerrarse(){ 
window.close() 
} 
</script> 
<center>
<p class=fuente_titulo>LISTADO DE DEPARTAMENTOS</p>
<table  border="0">
  <tr bgcolor="#eeeeee">
    <td class="fuente_subtitulo" align="center">&nbsp;&nbsp;<b>SIGLA DEL DEPARTAMENTO</b>&nbsp;&nbsp;</th>
    <td class="fuente_subtitulo" align="center">&nbsp;&nbsp;<b>NOMBRE DEL DEPARTAMENTO</b>&nbsp;&nbsp;</th>
  </tr>
<?php
if(!empty($nombre_entidad))
{
	$ssql_var="select * from departamento where departamento_cod_institucion='$cod_institucion' 
			   AND departamento_descripcion_dep like '%$nombre_entidad%' order by departamento_descripcion_dep ASC";
}
else
{
	$ssql_var="select * from departamento where departamento_cod_institucion='$cod_institucion' order by departamento_descripcion_dep ASC";
}
	$res=mysql_query($ssql_var,$conn);
		while  ($row=mysql_fetch_array($res))
			{
?>
	  <tr bgcolor="#EFEBE3">
    		<td>
		        <a href="funcionario_elige.php?unidad=<?php echo $row["departamento_cod_departamento"]; ?>"><?php echo "<span class=fuente_normal>".$row["departamento_sigla_dep"]."</span>";?>
                </a>
                </td>
		    <td>
			   <?php echo "<span class=fuente_normal>".$row["departamento_descripcion_dep"]."</span>";?>
			</td>
	  </tr>
<?php
}
?>
</table>
<br><br>
<center>
	<form> 
		<input type=button value="Cerrar" onclick="cerrarse()"> 
	</form>
</center>
<?php
include("final.php");
?>