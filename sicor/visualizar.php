<?php
include("../filtro.php");
?>
<?php
include("../conecta.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
/*include("inicio.php");*/

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

$codigo_seguimiento = descifrar($_GET['datosv']);


$ssql = "SELECT * FROM seguimiento WHERE '$codigo_seguimiento'=seguimiento_codigo_seguimiento";
$rss = mysql_query($ssql, $conn);
$row = mysql_fetch_array($rss);
$unidad1=$row["seguimiento_dpto_remite"];
$unidad2=$row["seguimiento_remitente"];
?>
<br>
<div align="center"><span class="fuente_titulo"><b>DESCRIPCI&Oacute;N DE CORRESPONDENCIA</b></div>
<br>
<center>

<table width="40%" cellpadding="2" cellspacing="2" border="0" bgcolor="#BCCFEF" style="font-size:10px;">
<form method="POST" name="aceptar" action="recepcion_lista.php">
<tr class="border_tr3">
<td width="40%"><span class="fuente_normal">HOJA DE RUTA</td>
<td><span class="fuente_normal"><?php echo $row["seguimiento_hoja_ruta"];?></td>
</tr>

<tr class="border_tr3">
<td width="40%"><span class="fuente_normal">FECHA DE RECEPCI&Oacute;N</td>
<td><span class="fuente_normal">
<?php echo date("Y-m-d")." ".date("H:i:s");?>
</td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal">REFERENCIA</td>
<td><span class="fuente_normal">
<?php
$rss_ingreso = mysql_query("SELECT * FROM ingreso WHERE '$row[seguimiento_cod_institucion]'=ingreso_cod_institucion AND '$row[seguimiento_nro_registro]'=ingreso_nro_registro",$conn);
if ($row_ingreso = mysql_fetch_array($rss_ingreso))
	{
		echo $row_ingreso["ingreso_referencia"];
		$adjunto_correspondencia=$row_ingreso["ingreso_adjunto_correspondencia"];
		$guardar_tipo=$row_ingreso["ingreso_hoja_ruta_tipo"];
                $numero_hoja_ruta=$row_ingreso["ingreso_numero_cite"];
	}
?></td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal">REMITENTE</td>
<td>
<span class="fuente_normal">
<?php
if ($guardar_tipo=='e' AND $row["seguimiento_fecha_plazo"]== NULL )
{
	if ($row["seguimiento_dpto_remite"]==0)
	{
	echo $row["seguimiento_remitente"];
	}
	else
	{
		$valor_clave=$row["seguimiento_remitente"];
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
}
else
{ 
    $valor_clave=$row["seguimiento_remitente"];
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
?>
</td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal">ENTIDAD REMITENTE</span></td>
<td><span class="fuente_normal">
<?php 
if ($row["seguimiento_dpto_remite"]==0) {
  echo "Ventanilla";
} else {
    $departamento = $row["seguimiento_dpto_remite"];
    $record = mysql_query("SELECT * FROM departamento WHERE '$departamento'=departamento_cod_departamento",$conn);
    $filita = mysql_fetch_array($record);
    echo $filita["departamento_descripcion_dep"];
}
?></span></td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal">FECHA PLAZO</span></td>
<td><span class="fuente_normal">
<?php 
if (empty($row["seguimiento_fecha_plazo"])) {
   echo "0";
}else {
   echo $row["seguimiento_fecha_plazo"];
}
?></span></td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal">FECHA DE DESPACHO</td>
<td><span class="fuente_normal"><?php echo $row["seguimiento_fecha_deriva"];?></td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal">INSTRUCCI&Oacute;N</td>
<td><span class="fuente_normal"><?php
if (empty($row["seguimiento_codigo_instruccion"])) {
  echo "Revisar";
}else {
$instruccion = $row["seguimiento_codigo_instruccion"];
$rss2 = mysql_query("SELECT * FROM instruccion WHERE '$instruccion'=instruccion_codigo_instruccion",$conn);
$row2 = mysql_fetch_array($rss2);
echo $row2["instruccion_instruccion"];
}
?></td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal">OBSERVACIONES</span></td>
<td><span class="fuente_normal"><?php echo $row["seguimiento_observaciones"];?></span></td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal">DOCUMENTO ADJUNTO</span></td>
<td><span class="fuente_normal">
<?php
if($guardar_tipo=='e')
{
    if($adjunto_correspondencia !="")
	{
	?>

	<a href="<?php echo $adjunto_correspondencia;?>" target="_blank" class="enlace_normal"><b>[Ver Adjunto]</b></a>
	<?php
	}
}
else
{
    ?>

	<a href="archivo_adjunto.php?valor=<?php echo cifrar($numero_hoja_ruta);?>">
                <img src="images/documentos.png" border="0" alt="archivo" />
        </a>
	
<?php
}
?>
</span>
</td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal">IMPRIMIR HOJA POSTERIOR</span></td>
<td><span class="fuente_normal">
    <a href="imprime_posterior.php?imprimeh=<?php echo cifrar($row["seguimiento_nro_registro"]);?>" target="_blank" class="enlace_normal">
        <b>[imprimir Hoja Posterior]</b></a>
</span></td>
</tr>
<!--
<tr>
<td colspan="2" align="center"><br>
<input type="submit" name="aceptar" value="Volver" class="boton"/>
</td>
</tr>
-->
</table>
</center>
</form>

<?php
include("final.php");
?>

