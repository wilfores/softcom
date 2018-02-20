<?php
include("../filtro.php");
include("../conecta.php");
include("script/functions.inc");
include("script/cifrar.php");
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

if (!empty($_POST['nombre_entidad']))
{
  //$ssql = "select * from entidades where entidades_cod_institucion='$cod_institucion' and entidades_entidad_nombre LIKE '%$_POST[nombre_entidad]%' order by entidades_entidad_nombre";
    
  $ssql = "select * from departamento where departamento_descripcion_dep LIKE '%$_POST[nombre_entidad]%' order by departamento_descripcion_dep";
  
}
else
{
    if (!empty($_POST['sigla_entidad']))
	{
     //$ssql = "select * from entidades where entidades_cod_institucion='$cod_institucion' and entidades_entidad_sigla LIKE '%$_POST[sigla_entidad]%' order by entidades_entidad_sigla";
	 
	      $ssql = "select * from departamento where departamento_sigla_dep LIKE '%$_POST[sigla_entidad]%' order by departamento_sigla_dep";		
	}
	else
	{
	  $ssql = "select * from departamento order by departamento_descripcion_dep";
	}
}
$res=mysql_query($ssql,$conn);
?>
<br>
<div align="center"><b>LISTA DE UNIDADES</b></div>
<br>

<center>
<div style="overflow:auto; width:400px; height:150px; align:left;">
<table border="1" cellpadding="1" cellspacing="1" bgcolor="">
<tr bgcolor="#3E6BA3" style="color:#FFFFFF">
<td align="center"><span class="fuente_normal"><b>Unidad</b></span></td>
<td align="center"><span class="fuente_normal"><b>Sigla</b></span></td>
<!--<td align="center"><span class="fuente_normal"><b>Eliminar</b></span></td>-->
</tr>
<?php
$resaltador=0;
while($row=mysql_fetch_array($res))
{
     if ($resaltador==0)
	  {
       echo "<tr class=truno style=color:#000066>";
	   $resaltador=1;
      }
	  else
	  {
       echo "<tr class=trdos>";
   	   $resaltador=0;
	  }
	  
	  $val11=cifrar($row["departamento_cod_departamento"]);
	  $val12=cifrar($row["departamento_descripcion_dep"]);
?>
<td>
<a href="listado_unidad_usuario.php?id=<?php echo $val11;?>&des=<? echo $val12;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true"><?php echo "<font color=#000066>$row[departamento_descripcion_dep]</font>";?></a>
</td>
<td>
<a href="listado_unidad_usuario.php?id=<?php echo $val11;?>&des=<? echo $val12;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true"><?php echo "<font color=#000066>$row[departamento_sigla_dep]</font>";?></a>
</td>
<?php
}
?>
</table>
</div>
</center>
<br>
<CENTER><a href="busca_unidad.php"><span class="fuente_normal"><b>[REGRESAR]</b></span></a></CENTER>
