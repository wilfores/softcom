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

$id=descifrar($_GET["id"]);
$descrip=descifrar($_GET["des"]);

?>
<br>
<div align="center" style="font-size:12px"><b>UNIDAD<br>
<?php echo "<font color=#FFFFFF>$descrip</font>"; ?>
</b></div>

<center>
<div style="overflow:auto; width:98%; height:150px; align:left;">
<div align="center"><b>LISTADO DE CARGOS Y USUARIOS</b></div>
<table border="1" cellpadding="1" cellspacing="1" bgcolor="">
<tr bgcolor="#3E6BA3" style="color:#FFFFFF">
<td align="center"><span class="fuente_normal"><b>CARGO</b></span></td>
<td align="center"><span class="fuente_normal"><b>USUARIO</b></span></td>
<!--<td align="center"><span class="fuente_normal"><b>Eliminar</b></span></td>-->
</tr>
<?php

$res=mysql_query("select cargos_cargo, usuario_nombre
from usuario, cargos
where cargos_cod_depto='$id'
and cargos_id=usuario_ocupacion
and usuario_active=1
order by cargos_id",$conn);
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

?>
<td>

<?php

$cargo=$row["cargos_cargo"];
$nombre=$row["usuario_nombre"];
echo "<a href=\"#\" onclick=\"window.opener.document.enviar.val1.value='$id';window.opener.document.enviar.val2.value='$descrip';window.opener.document.enviar.val3.value='$cargo';window.opener.document.enviar.val4.value='$nombre';self.close();\">";
echo "<font color=#000066>$row[cargos_cargo]</font>";

?>
</a>

</td>
<td>
<?php

$nombre_ent=$row["departamento_sigla_dep"];
echo "<a href=\"#\" onclick=\"window.opener.document.enviar.val1.value='$id';window.opener.document.enviar.val2.value='$descrip';window.opener.document.enviar.val3.value='$cargo';window.opener.document.enviar.val4.value='$nombre';self.close();\">";
echo "<font color=#000066>$row[usuario_nombre]</font>";

?>
</a>
</td>
<?php
}
?>
</table>
</div>
</center>
<br>
<CENTER><a href="encuentra_unidad.php"><span class="fuente_normal"><b>[REGRESAR]</b></span></a></CENTER>
