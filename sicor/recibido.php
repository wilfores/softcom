<?php
include("../filtro.php");
?>
<?php
//include("inicio.php");
?>
<?php
include("../conecta.php");
include("script/functions.inc");
include("script/cifrar.php");

$codigo_seguimiento=descifrar($_GET['datos']);
if(!is_numeric($codigo_seguimiento))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
    exit;
}
$aux = 0;

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

if (isset($_POST['aceptar']))
	{
    if ($aux == 0) 
	  {
			$rss1 = mysql_query("SELECT * FROM seguimiento WHERE '$codigo_seguimiento'=seguimiento_codigo_seguimiento",$conn);
			if($row1 = mysql_fetch_array($rss1))
			{
			$hoja=$row1["seguimiento_nro_registro"];
			}
	$fecha_rec=date("Y-m-d H:i:s");
	
	mysql_query("UPDATE seguimiento SET seguimiento_tipo='R',seguimiento_fecha_recibida='$fecha_rec' WHERE seguimiento_codigo_seguimiento='$codigo_seguimiento'",$conn);
	
	mysql_query("UPDATE ingreso SET ingreso_estado='R' WHERE ingreso_nro_registro='$hoja'" ,$conn);    	
	  }	
	?>
		<script language="JavaScript">
		window.self.location="recepcion_lista.php";
		</script>        
	<?php	  
	} 



	if(isset($_POST['cancelar']))
	{
	?>
		<script language="JavaScript">
		window.self.location="recepcion_lista.php";       
		</script>
	<?php	  
	}

$ssql = "SELECT * FROM seguimiento WHERE '$codigo_seguimiento'=seguimiento_codigo_seguimiento";
$rss = mysql_query($ssql, $conn);
$row = mysql_fetch_array($rss);
?>
<br>
<div align="center"><span class="fuente_titulo"><b>Recepci&oacute;n de Documento</b></div>
<br>
<center>
<table width="40%" cellpadding="2" cellspacing="2" border="0" style="font-size: 8pt;" bgcolor="#BCCFEF">
<form method="POST">
<tr class="border_tr3"><td width="40%"><span class="fuente_normal">HOJA DE RUTA</td>
<td>
<span class="fuente_normal">
<?php 
$hoja = $row["seguimiento_hoja_ruta"]; 
echo $hoja;
?>
</td>
</tr>

<tr class="border_tr3">
<td width="40%">
<span class="fuente_normal">FECHA DE RECEPCI&Oacute;N
</td>
<td>
<span class="fuente_normal">
<?php echo date("Y-m-d H:i:s");?>
</td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal">REFERENCIA
</td>
<td><span class="fuente_normal">
<?php
$rss_ingreso = mysql_query("SELECT * FROM ingreso WHERE '$row[seguimiento_cod_institucion]'=ingreso_cod_institucion AND '$row[seguimiento_nro_registro]'=ingreso_nro_registro",$conn);
if ($row_ingreso = mysql_fetch_array($rss_ingreso))
	{
		echo $row_ingreso["ingreso_referencia"];
		$adjunto_correspondencia=$row_ingreso["ingreso_adjunto_correspondencia"];
		$guardar_tipo=$row_ingreso["ingreso_hoja_ruta_tipo"];
	}
?>
</td>
</tr>

<tr class="border_tr3">
<td>
<span class="fuente_normal">REMITENTE</td>
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
<td>
<span class="fuente_normal">ENTIDAD REMITENTE</td>
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
?>
</td>
</tr>

<tr class="border_tr3">
<td>
<span class="fuente_normal">FECHA PLAZO</td>
<td>
<span class="fuente_normal">
<?php 
if (empty($row["seguimiento_fecha_plazo"])) {
   echo "0"   ;
} else {
  echo $row["seguimiento_fecha_plazo"];
}
?></td>
</tr>

<tr class="border_tr3">
<td>
<span class="fuente_normal">FECHA DE DESPACHO</td>
<td><span class="fuente_normal">
<?php echo $row["seguimiento_fecha_deriva"];?>
</td>
</tr>

<tr class="border_tr3">
<td>
<span class="fuente_normal">INSTRUCCI&Oacute;N
</td>
<td>
<span class="fuente_normal">
<?php
$instruccion = $row["seguimiento_codigo_instruccion"];
$rss2 = mysql_query("SELECT * FROM instruccion WHERE '$instruccion'=instruccion_codigo_instruccion",$conn);
$row2 = mysql_fetch_array($rss2);
echo $row2["instruccion_instruccion"]
?></td></tr>

<tr class="border_tr3">
<td>
<span class="fuente_normal">OBSERVACIONES
</td>
<td>
<span class="fuente_normal"><?php echo $row["seguimiento_observaciones"];?>
</td>
</tr>
	<?php
	if($adjunto_correspondencia !="")
	{
	?>
	<tr class="border_tr3">
	<td><span class="fuente_normal">DOCUMENTO ADJUNTO</td>
	<td><span class="fuente_normal">
	<a href="<?php echo $adjunto_correspondencia;?>" target="_blank"><b>[Ver Adjunto]</b></a>
	</td></tr>
	<?php
	}	
	?>
<tr>
	<td colspan="2" align="center">
		<br>
     	<input type="submit" name="aceptar" value="Aceptar" class="boton" />
		<!--<input type="submit" name="cancelar" value="Cancelar" class="boton" />-->
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
    <a href="hoja_ruta123.php" target="_blank">Imprimir Hoja de Ruta</a>
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
    <a href="hoja_recepcion123.php" target="_blank">Hoja de Recepcion</a>
	</td>
</tr>
</table>
</center>
</form>

<?php
//include("final.php");
?>

