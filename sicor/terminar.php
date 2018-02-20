<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("script/functions.inc");
include("script/cifrar.php");
$hruta=descifrar($_GET['hr1']);

echo "$hruta <br>";
/*
if(!is_numeric($sel_derivar))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
    exit;
}
*/
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

$gestion = date("Y");
$aux = 0;
$cod_institucion = $_SESSION["institucion"];


if (isset($_POST['grabar']))
 {
	
	if(empty($_POST['descripcion_final']))
	{ 
	 $aux=1;
     $alert_final=1; 	
	}
	
	if(empty($_POST['archivado']))
	{ 
	 $aux=1;
     $alert_arch=1; 	
	}
	
	
	if ($aux == 0)
	{
      $fecha_salida=date("Y-m-d H:i:s");	
	  mysql_query("update seguimiento set 
	  seguimiento_estado='T',
	  seguimiento_tipo='D',
	  seguimiento_descripcion_final='$_POST[descripcion_final]',
	  seguimiento_archivado='$_POST[archivado]',
	  seguimiento_fecha_salida='$fecha_salida' 
	  where seguimiento_codigo_seguimiento='$sel_derivar'",$conn);	    
	?>
		<script language="JavaScript">
	    //window.self.location="recepcion_lista.php";
		</script>
	<?php	
	  }
} //en if isset grabar

if (isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="menu2.php";
    </script>
<?php
}
?>
<br>

<?php
if ($aux == 0)
{
echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>Salida de Correspondencia</b></div></p>";
} else 
{ echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b> !!! ERROR DATOS NO VALIDOS !!!</b></div></p>";
}

?>
<center>

<table width="80%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="enviar">
<tr class="border_tr3">
<td><span class="fuente_normal">Hoja de Ruta</td>

<td>

<?php
$ssql3="SELECT * FROM seguimiento WHERE '$sel_derivar'= seguimiento_codigo_seguimiento";
$rss3=mysql_query($ssql3,$conn);
$row3=mysql_fetch_array($rss3);
//echo $row3["seguimiento_hoja_ruta"];
echo "$hruta";
?>



</td>
</tr>


<?php
$respi=mysql_query("select * from ingreso where '$row3[seguimiento_nro_registro]' = ingreso_nro_registro AND ingreso_cod_institucion='$cod_institucion'",$conn);
if($roww=mysql_fetch_array($respi))
{
$descripcion=$roww["ingreso_referencia"];
$hoja_tipo=$roww["ingreso_hoja_ruta_tipo"];
}
?>

<tr class="border_tr3">
<td><span class="fuente_normal">Tipo de Hoja de Ruta</td>
<td>
<?php
if ($hoja_tipo=='i')
{
	echo "Externo";
}
else
{
	echo "Interno";
}
?>

</td></tr>

<tr class="border_tr3">
<td><span class="fuente_normal">Referencia</td>
<td>
<?php
echo $descripcion;
?>

</td></tr>


<tr class="border_tr3"><td><span class="fuente_normal">Fecha y Hora de Salida</td> 
<td><?php echo date("Y-m-d H:i:s");?>
</td>
</tr>


<tr class="border_tr3">
<td><span class="fuente_normal">Proveido</td>
<td>
<textarea name="descripcion_final" class="caja_texto" cols="60" rows="2">
<?php
if (isset($aux))
{
echo $_POST['descripcion_final'];
}
?>
</textarea>
 <?php Alert($alert_final);?>
</td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal">Archivado en</td>
<td>
<textarea name="archivado" class="caja_texto" cols="60" rows="2">
<?php
if (isset($aux))
{
echo $_POST['archivado'];
}
?>
</textarea>
 <?php Alert($alert_arch);?>
</td>
</tr>
<tr>
<td align="center" colspan="2">
<input type="submit" name="grabar" value="Aceptar" class="boton" />
<input type="submit" name="cancelar" value="Cancelar" class="boton"/></td></tr>
</form>
</table>
</center>
<br>
<?php
include("final.php");
?>