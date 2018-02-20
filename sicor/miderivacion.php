<?php
include("../filtro.php");
?>
<?php
//include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
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
$respi=mysql_query("SELECT * FROM seguimiento,ingreso
                    WHERE seguimiento.seguimiento_destinatario='$cargo_unico'
                    AND seguimiento.seguimiento_cod_institucion='$cod_institucion'
                    AND ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
                    AND ingreso.ingreso_cod_institucion='$cod_institucion'
                    AND seguimiento.seguimiento_tipo='D'",$conn);
?>
<STYLE type="text/css"> 
    A:link {text-decoration:none;color:#FFFFFF;} 
    A:visited {text-decoration:none;color:#CEDCEA;} 
    A:active {text-decoration:none;color:#FFFFFF;} 
    A:hover {text-decoration:underline;color:#DDE5EE;} 
</STYLE>
<br>
<p class="fuente_titulo"><span class="fuente_normal">
<center><b>Correspondencia Derivada o Finalizada</b></center></p></center>
<div style="overflow:auto; width:100%; height:400px%; align:left;">
<table width="100%" cellspacing="1" cellpadding="1" border="1" >
<tr class="border_tr2" style="font-size: 8pt;" bgcolor="#BCCFEF">
<td width="10%" align="center"><span class="fuente_normal">Hoja Ruta</td>
<td width="20%" align="center"><span class="fuente_normal">Entidad Remitente</td>
<td width="15%" align="center"><span class="fuente_normal">Remitente</td>
<td width="7%" align="center"><span class="fuente_normal">Tipo</td>
<td width="10%" align="center"><span class="fuente_normal">Fecha de Ingreso</td>
<td width="15%" align="center"><span class="fuente_normal">Referencia</td>
<td width="5%" align="center"><span class="fuente_normal">Accion</td>
</tr>

<?php
$resaltador=0;
 while($row=mysql_fetch_array($respi))
{
	if ($resaltador==0)
		  {
		       echo "<tr class=truno bgcolor=#E3E8EC style=font-size:7pt;>";
			   $resaltador=1;
	      }
		  else
		  {
			   echo "<tr class=trdos style=font-size:7pt;>";
		   	   $resaltador=0;
		  }
?>
<td align="center" width="10%">
	<?php 
		echo $row["ingreso_hoja_ruta"];
		
	?>
</td>
<?php
$nro_registro=$row["ingreso_nro_registro"];
$ssql2 = "SELECT * FROM ingreso WHERE '$nro_registro'=ingreso_nro_registro and ingreso_cod_institucion='$cod_institucion'";
$rss2 = mysql_query($ssql2,$conn);
$row2=mysql_fetch_array($rss2);

$hoja_ruta_tipo = $row2["ingreso_hoja_ruta_tipo"];
  echo "<td align=\"left\" width=\"20%\">";

if ($hoja_ruta_tipo == "e") {
  echo $row2["ingreso_entidad_remite"];
  $tipo_hoja = "Externo";
} else {
  $tipo_hoja = "Interno";
  $depart = $row2["ingreso_cod_departamento"];
  $ssqlnew = "SELECT * FROM departamento WHERE '$depart'=departamento_cod_departamento";
  $rssnew = mysql_query($ssqlnew,$conn);
  $rownew = mysql_fetch_array($rssnew);
  echo $rownew["departamento_descripcion_dep"];
  mysql_free_result($rssnew);
}
echo "</td>";
?>
</td>
<td align="left" width="15%">
<?php 
if ($clase == "por_funcionariop" OR $clase == "por_departamento" OR $clase == "por_funcionariot")
{
	$valor_clave=$row["seguimiento_destinatario"];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
		$valor_cargo=$fila_clave["cargos_id"];
		$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
		if($fila_cargo=mysql_fetch_array($conexion2))
		{
		echo $fila_cargo["usuario_nombre"];
		}
	}  
  
} else 
{  
 if ($hoja_ruta_tipo=="i")
 { 
	$valor_clave=$row["ingreso_remitente"];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
		$valor_cargo=$fila_clave["cargos_id"];
		$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
		if($fila_cargo=mysql_fetch_array($conexion2))
		{
		echo $fila_cargo["usuario_nombre"];
		}
	}
 }
else
  { echo $row["ingreso_remitente"];
  }	
} 
 
?></td>
<td align="center" width="7%"><?php echo $tipo_hoja;?></td>
<td align="center" width="10%"><?php echo $row2["ingreso_fecha_ingreso"];?></td>
<?php mysql_free_result($rss2);?>
<td align="left" width="15%">
<?php 
	echo $row["ingreso_referencia"];
	$historia = cifrar($row["ingreso_nro_registro"]);
?>
</td>
<td width="5%" align="center" bgcolor="#660000"><a href="historia.php?historia=<?php echo $historia; ?>" class="botonte">&nbsp;Ver&nbsp;</a></td>
</tr>
<?php
}   
mysql_close($conn);
?>
</table>
</div>
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<!--
<form action="principal.php" method="get">
<input type="submit" name="cancelar" value="Cancelar" class="boton" />
</form>
-->
</td>
</tr>
</table>
<?php
//include("../final.php");
?>


