<?php
include("../filtro.php");
include("../conecta.php");
include("cifrar.php");
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
  $ssql = "select * from entidades where entidades_cod_institucion='$cod_institucion' and entidades_entidad_nombre LIKE '%$_POST[nombre_entidad]%' order by entidades_entidad_nombre";
}
else
{
    if (!empty($_POST['sigla_entidad']))
	{
     $ssql = "select * from entidades where entidades_cod_institucion='$cod_institucion' and entidades_entidad_sigla LIKE '%$_POST[sigla_entidad]%' order by entidades_entidad_sigla";	
	}
	else
	{
	  $ssql = "select * from entidades where entidades_cod_institucion='$cod_institucion' order by entidades_entidad_nombre";
	}
}
$res=mysql_query($ssql,$conn);
?>
<br>
<div class="fuente_normal" align="center"><b>LISTA DE INSTITUCIONES</b></div>
<br>

<center>
<div style="overflow:auto; width:98%; height:150px; align:left;">
<table border="1" cellpadding="1" cellspacing="1">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
<td align="center"><span class="fuente_normal"><b>Institucion</b></span></td>
<td align="center"><span class="fuente_normal"><b>Sigla</b></span></td>
<td align="center"><span class="fuente_normal"><b>Eliminar</b></span></td>
<?php
while($row=mysql_fetch_array($res))
{
?>
<tr style="color:#003366; font-size:10px">
<td >
<?php
$nombre_ent=$row["entidades_entidad_nombre"];
echo "<a href=\"#\" style=\"color:#003366\" onclick=\"window.opener.document.enviar.entidad_remite.value='$nombre_ent';window.opener.document.enviar.entidad_remite2.value='$nombre_ent';self.close();\">";
echo $row["entidades_entidad_nombre"];
?>
</a>
</td>
<td>
<?php
$nombre_ent=$row["entidades_entidad_nombre"];
echo "<a href=\"#\" style=\"color:#003366\"  onclick=\"window.opener.document.enviar.entidad_remite.value='$nombre_ent';window.opener.document.enviar.entidad_remite2.value='$nombre_ent';self.close();\">";
echo $row["entidades_entidad_sigla"];
?>
</a>
</td>
<td align="center">
<a href="elientidad.php?codigoeli=<?php echo $row["entidades_entidad_codigo"];?>">
<img src="../images/eliminar.png">
</a>
</td>
<?php
}
?>

</table>
</div>
</center>
<CENTER><a href="busca_entidad.php"><span class="fuente_normal"><b>[volver..]</b></span></a></CENTER>
