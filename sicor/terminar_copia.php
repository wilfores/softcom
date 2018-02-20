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

 $sel_derivar=descifrar($_GET['datos']);
   if(!is_numeric($sel_derivar))
    {
        echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
        exit;
    }


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

$gestion = strftime("%Y");
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
	 if($camb_gest==2013)
	{
		$conn = Conectarse();
	}
	if($camb_gest==2014)
	{
		$conn = Conectarse2();
	}

  mysql_query("update correspondenciacopia set
  correspondenciacopia_estado='T',
  correspondenciacopia_tipo='D',
  correspondenciacopia_descripcion_final='$_POST[descripcion_final]',
  correspondenciacopia_archivado='$_POST[archivado]',
  correspondenciacopia_fecha_salida='$_POST[fecha_salida]' 
  where correspondenciacopia_codigo_copia='$_POST[codigo_seguimiento]'",$conn);	    
?>
    <script language="JavaScript">
   window.self.location="miscopias.php";
    </script>
<?php
  }
} //en if isset grabar

if (isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="miscopias.php";
    </script>
<?php
}
?>
<script>

<!-- 
function Combo()
{
  document.derivar.action="derivar.php";
  document.derivar.submit();
}

function Retornar()
{
  document.enviar.action="recepcion_lista.php";
  document.enviar.submit();
}
--->
</script>

<br>

<?php if ($aux == 0){
echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>Salida de Correspondencia/COPIA</b></div></p>";
} else 
{ echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b>!!! ERROR DATOS NO VALIDOS !!!</b></div></p>";
}?>
<center>

<table width="80%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="enviar">
<tr class="border_tr3">
<td><span class="fuente_normal">Hoja de Ruta</td>

<td>

<?php
$ssql3="SELECT * FROM correspondenciacopia WHERE '$sel_derivar'=correspondenciacopia_codigo_copia";
$rss3=mysql_query($ssql3,$conn);
$row3=mysql_fetch_array($rss3);
echo $row3["correspondenciacopia_hoja_ruta"];
?>
<input type="hidden" name="sel_derivar" value="<?php echo $sel_derivar;?>" />
<input type="hidden" name="cod_institucion" value="<?php echo $cod_institucion;?>" />

</td></tr>


<?php
$respi=mysql_query("select * from ingreso where '$row3[correspondenciacopia_nro_registro]' = ingreso_nro_registro AND ingreso_cod_institucion='$cod_institucion'",$conn);
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
	echo "Interno";
}
else
{
	echo "Externo";
}
?>
<input type="hidden" name="sel_derivar" value="<?php echo $sel_derivar;?>" />
</td></tr>

<tr class="border_tr3">
<td><span class="fuente_normal">Referencia</td>
<td>
<?php
echo $descripcion;
?>
<input type="hidden" name="sel_derivar" value="<?php echo $sel_derivar;?>" />
</td></tr>


<tr class="border_tr3"><td><span class="fuente_normal">Fecha y Hora de Salida</td> 
<td><?php echo date("Y-m-d")." ".date("H:i:s");?>
<input type="hidden" name="fecha_salida" value="<?php echo date("Y-m-d")." ".date("H:i:s");?>">
<input type="hidden" name="dpto_remite" value="<?php echo $row3["correspondenciacopia_cod_departamento"];?>">
<input type="hidden" name="remitente" value="<?php echo $row3["correspondenciacopia_destinatario"];?>">
<input type="hidden" name="hoja_ruta" value="<?php echo $row3["correspondenciacopia_hoja_ruta"];?>">
<input type="hidden" name="nro_registro" value="<?php echo $row3["correspondenciacopia_nro_registro"];?>">
<input type="hidden" name="codigo_seguimiento" value="<?php echo $row3["correspondenciacopia_codigo_copia"];?>">
</td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal">Proveido</td>
<td>
<textarea name="descripcion_final" class="caja_texto" cols="60" rows="2"><?php $descripcion_final?></textarea>
<?php Alert($alert_final);?>
</td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal">Archivado en</td>
<td>
<textarea name="archivado" class="caja_texto" cols="60" rows="2"><?php echo $archivado;?></textarea>
 <?php Alert($alert_arch);?>
</td>
</tr>

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