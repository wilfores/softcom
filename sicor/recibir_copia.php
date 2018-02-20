<?php
include("../filtro.php");
?>
<?php
include("../conecta.php");
include("script/functions.inc");
include("script/cifrar.php");
?>
<?php
include("inicio.php");

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

if(isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="miscopias.php";
    </script>
<?php	  
}
$aux = 0;
if (isset($_POST['aceptar']))
{
  if ($aux == 0)
	  {
		
		//$conn = Conectarse();
		if($camb_gest==2013)
		{
			$conn = Conectarse();
		}
		if($camb_gest==2014)
		{
			$conn = Conectarse2();
		}  
		mysql_query("UPDATE correspondenciacopia SET correspondenciacopia_tipo='R',correspondenciacopia_fecha_recibida='$_POST[fecha_rec]' WHERE correspondenciacopia_codigo_copia='$_POST[codigo_seguimiento]'",$conn);    
     }	
     ?>
    <script language="JavaScript">
    window.self.location="miscopias.php";
    </script>
<?php	  
}
else
{   
   $codigo_seguimiento=descifrar($_GET['datos']);
   if(!is_numeric($codigo_seguimiento))
    {
        echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
        exit;
    }
}

if (isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="miscopias.php";
    </script>
<?php	
}
$ssql = "SELECT * FROM correspondenciacopia WHERE '$codigo_seguimiento'=correspondenciacopia_codigo_copia";
$rss = mysql_query($ssql, $conn);
$row = mysql_fetch_array($rss);
?>
<br>
<div align="center"><span class="fuente_titulo"><b>Recepci&oacute;n de Correspondencia Copia</b></div>
<br>
<center>
<table width="60%" cellpadding="2" cellspacing="2" border="0">
<form method="POST" name="aceptar">
<tr class="border_tr3"><td width="40%"><span class="fuente_normal">Hoja de Ruta</td>
<td><span class="fuente_normal">
<?php 
$hoja = $row["correspondenciacopia_hoja_ruta"];
echo $hoja;?>
</td>
</tr>

<tr class="border_tr3"><td width="40%"><span class="fuente_normal">Fecha de Recepcion</td>
<td><span class="fuente_normal"><?php echo date("Y-m-d")." ".date("H:i:s");?></td></tr>
<input type="hidden" name="fecha_rec" value="<?php echo date("Y-m-d")." ".date("H:i:s");?>" />
<input type="hidden" name="codigo_seguimiento" value="<?php echo $codigo_seguimiento;?>" />

<tr class="border_tr3"><td><span class="fuente_normal">Referencia</td>
<td><span class="fuente_normal"><?php
$rss_ingreso = mysql_query("SELECT * FROM ingreso WHERE '$row[correspondenciacopia_cod_institucion]'=ingreso_cod_institucion AND '$row[correspondenciacopia_nro_registro]'=ingreso_nro_registro",$conn);
if ($row_ingreso = mysql_fetch_array($rss_ingreso))
	{
		echo $row_ingreso["ingreso_referencia"];
		$adjunto_correspondencia=$row_ingreso["ingreso_adjunto_correspondencia"];
		$tipo_correspodencia_ingresada=$row_ingreso["ingreso_tipo_correspondencia_ext"];
	}
?></td></tr>

<tr class="border_tr3"><td><span class="fuente_normal">Remitente</td>
<td><span class="fuente_normal"><?php
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
 </td></tr>

<tr class="border_tr3"><td><span class="fuente_normal">Entidad Remitente</td>
<td>
<span class="fuente_normal">
<?php 
if ($row["correspondenciacopia_dpto_remite"]==0) {
  echo "Ventanilla";
} else {
    $departamento = $row["correspondenciacopia_dpto_remite"];
    $record = mysql_query("SELECT * FROM departamento WHERE '$departamento'=departamento_cod_departamento",$conn);
    $filita = mysql_fetch_array($record);
    echo $filita["departamento_descripcion_dep"];
}
?>
</td>
</tr>

<tr class="border_tr3"><td><span class="fuente_normal">Fecha Plazo</td>
<td><span class="fuente_normal"><?php 
if (empty($row["correspondenciacopia_fecha_plazo"])) {
   echo "0"   ;
} else {
  echo $row["correspondenciacopia_fecha_plazo"];
}
?></td></tr>

<tr class="border_tr3"><td><span class="fuente_normal">Fecha de Despacho</td>
<td><span class="fuente_normal"><?php echo $row["correspondenciacopia_fecha_deriva"];?></td></tr>

<tr class="border_tr3"><td><span class="fuente_normal">Codigo de Instruccion</td>
<td><span class="fuente_normal"><?php
$instruccion = $row["correspondenciacopia_codigo_instruccion"];
$rss2 = mysql_query("SELECT * FROM instruccion WHERE '$instruccion'=instruccion_codigo_instruccion",$conn);
$row2 = mysql_fetch_array($rss2);
echo $row2["instruccion_instruccion"]
?></td></tr>

<tr class="border_tr3"><td><span class="fuente_normal">Observaciones</td>
<td><span class="fuente_normal"><?php echo $row["correspondenciacopia_observaciones"];?></td></tr>
<?php
	if($adjunto_correspondencia !="")
	{
	?>
	<tr class="border_tr3">
	<td><span class="fuente_normal">Documento Adjunto</td>
	<td><span class="fuente_normal">
	<a href="<?php echo $adjunto_correspondencia;?>" target="_blank"><b>[Ver Adjunto]</b></a>
	</td></tr>
	<?php
	}	
	?>

<tr>
	<td colspan="2" align="center">
		<br>
		<input type="hidden" name="hoja" value="<?php echo $hoja; ?>" >
		<input type="submit" name="aceptar" value="Aceptar" class="boton" />
		<input type="submit" name="cancelar" value="Cancelar" class="boton"/>
	</td>
</tr>
</table>
</center>
</form>
<?php
include("../final.php");
?>

