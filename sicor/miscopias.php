<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");
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

if (!isset($_GET['orden']))
	{
	  $orden = "correspondenciacopia_fecha_deriva";
	}
	else
	{
	$orden=$_GET['orden'];
	}


$ssql="SELECT * FROM correspondenciacopia WHERE '$cargo_unico'=correspondenciacopia_destinatario AND (correspondenciacopia_tipo='A' OR correspondenciacopia_tipo='R') AND correspondenciacopia_estado='P' AND correspondenciacopia_cod_institucion='$cod_institucion' ORDER BY ".$orden." DESC";
$rss=mysql_query($ssql,$conn);

?>
<STYLE type="text/css"> 
    A:link {text-decoration:none;color:#FFFFFF;} 
    A:visited {text-decoration:none;color:#CEDCEA;} 
    A:active {text-decoration:none;color:#FFFFFF;} 
    A:hover {text-decoration:underline;color:#DDE5EE;} 
</STYLE>
<script language="JavaScript">
function CopiaValor(objeto) {
	document.recepcion.sel_derivar.value = objeto.value;
}

function Retornar()
{
	document.recepcion.action="principal.php";
	document.recepcion.submit();
}
</script>
<br>
<p class="fuente_titulo"><span class="fuente_normal">
<center><b>RECEPCI&Oacute;N DE CORRESPONDENCIA/COPIA</b></center></p></center>

<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="1%" align="center"><span class="fuente_normal">*</td>
<td width="10%" align="center"><span class="fuente_normal"><a href="miscopias.php?orden=correspondenciacopia_hoja_ruta" style="color:#FFFFFF">Hoja de Ruta</a></td>
<td width="3%" align="center"><span class="fuente_normal">Adj</td>
<td width="11%" align="center"><span class="fuente_normal"><a href="miscopias.php?orden=correspondenciacopia_fecha_deriva" style="color:#FFFFFF">Fecha Derivacion</a></td>
<td width="15%" align="center"><span class="fuente_normal">Origen/Documento</td>
<td width="5%" align="center"><span class="fuente_normal">Tipo</td>
<td width="10%" align="center"><span class="fuente_normal"><a href="miscopias.php?orden=correspondenciacopia_remitente" style="color:#FFFFFF">Remitente</a></td>
<td width="15%" align="center"><span class="fuente_normal">Unidad/Remitente</td>
<td width="20%" align="center"><span class="fuente_normal">Observaciones</td>
<td colspan="2" align="center"><span class="fuente_normal">Accion</td>
</tr>
</table>
<DIV class=tableContainer id=tableContainer>
<div style="overflow:auto; width:100%; height:210px; align:left;">
<center>
<table width="100%" cellspacing="1" cellpadding="1" border="0">
<form name="recepcion" method="POST">
<?php
$resaltador=0;
if (!empty($rss)) 
{
 while($row=mysql_fetch_array($rss))
 {
	 $limite= $row["correspondenciacopia_fecha_plazo"];
	  if ($resaltador==0)
		  {
		       echo "<tr class=truno>";
			   $resaltador=1;
	      }
		  else
		  {
			   echo "<tr class=trdos>";
		   	   $resaltador=0;
		  }
?>
<td width="1%" align="center">
<?php
	switch ($row["correspondenciacopia_prioridad"])
		{
			case 'Alta':echo "<img src=images/alta.gif>";break;
			case 'Media':echo "<img src=images/media.gif>";break;
			case 'Baja':echo "<img src=images/baja.gif>";break;
		}
?>
</td>
<td align="left" width=10% valign=middle>
<?php 
$fechalimite_plazo=explode("-",$limite);

if (($limite >= date("Y-m-d")))

{
   echo "<img src=\"images/alerta.gif\" border=0 align=center/>";     
}
$datosv = encryto($row["correspondenciacopia_codigo_copia"]);
?>

<a href="visualizar_copia.php?datosv=<?php echo $datosv;?>" style="color:#184E93">
	<?php echo $row["correspondenciacopia_hoja_ruta"];?>
</a>
</td>

<?php
$nro_registro=$row["correspondenciacopia_nro_registro"];
$ssql2 = "SELECT * FROM ingreso WHERE '$nro_registro'=ingreso_nro_registro and '$cod_institucion'=ingreso_cod_institucion";
$rss2 = mysql_query($ssql2,$conn);
if(mysql_num_rows($rss2) > 0)
{
	$row2=mysql_fetch_array($rss2);
	$hoja_ruta_tipo = $row2["ingreso_hoja_ruta_tipo"];
?>
	
 <td width="3%" align="center"><span class="fuente_normal">
<?php
 if($hoja_ruta_tipo=="e")
   {
	if($row2["ingreso_adjunto_correspondencia"]!="")
	{
	?>
       <b><a href="<?php echo $row2["ingreso_adjunto_correspondencia"]; ?>" target="_blank"><img src="images/adjunto.jpg" border="0" /></a></b>
     
	<?php
	}
	else
	{
	?>
    &nbsp;
	<?php
	}
   }
   else
   {
   ?>
     <a href="archivo_adjunto.php?valor=<?php echo cifrar($row2["ingreso_numero_cite"]);?>">
        <img src="images/documentos.png" border="0" alt="archivo" />
     </a>  
   <?php
   }
   ?>
    </b></span></td>
<?php
}
?>
<td align="left" width="11%"><?php echo $row["correspondenciacopia_fecha_deriva"];?></td>
<?php
$nro_registro=$row["correspondenciacopia_nro_registro"];
$ssql2 = "SELECT * FROM ingreso WHERE '$nro_registro'=ingreso_nro_registro and '$cod_institucion'=ingreso_cod_institucion";
$rss2 = mysql_query($ssql2,$conn);
$row2=mysql_fetch_array($rss2);
$hoja_ruta_tipo = $row2["ingreso_hoja_ruta_tipo"];
  echo "<td align=\"left\" width=\"15%\">";

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
<td align="center" width="5%"><?php echo $tipo_hoja;?></td>
<td align="center" width="10%">
<?php 
	$valor_clave=$row["correspondenciacopia_remitente"];
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
?>
</td>
<?php mysql_free_result($rss2); ?>
<td align="left" width="15%"><?php 
$unidad_origen=$row["correspondenciacopia_dpto_remite"];
if ($unidad_origen == 0) 
	{
		 echo "ventanilla";
	}
	else
	{
		 $rsso = mysql_query("SELECT departamento_descripcion_dep FROM departamento WHERE '$unidad_origen'=departamento_cod_departamento",$conn);
		 $rowo = mysql_fetch_array($rsso);
		 echo $rowo["departamento_descripcion_dep"];
	}
?></td>
<td align="left" width="20%">

<?php 
	if (empty($row["correspondenciacopia_observaciones"])) 
	{
		  echo "&nbsp;"  ;
	}
		  echo $row["correspondenciacopia_observaciones"];
?>

</td>
<?php
$datos = cifrar($row["correspondenciacopia_codigo_copia"]);
if ($row["correspondenciacopia_tipo"]=="R") 
{
?>
	<td align="center"><a href="derivar_copia.php?datos=<?php echo $datos;?>" class="botonde" >Derivar</a></td>
    <td align="center"><a href="terminar_copia.php?datos=<?php echo $datos;?>" class="botonde" >Terminar</a></td>
   
    
 <?php
  } 
else
 {  
 ?>
<td align="center" colspan="2"><a href="recibir_copia.php?datos=<?php echo $datos;?>" class="botonre">&nbsp;Recepcionar&nbsp;</a></td>
<?php
 } ?>
</tr>
<?php
}   
}
?>
</table>
</center>
</div>
<br>
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<input type="hidden" name="sel_derivar">
<input type="reset" name="cancelar" value="Cancelar" onClick="Retornar();" class="boton" />
</td>
</tr>
</table>
</form>

</center>
<?php
include("../final.php");
?>