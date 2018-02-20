<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<link rel="stylesheet" type="text/css" href="script/ventanita.css">
<?php
include("../conecta.php");
include("script/functions.inc");
include("script/cifrar.php");
$hruta=descifrar($_GET['hr1']);
echo "$hruta <br />";
/*
$sel_derivar=descifrar($_GET['datos']);
if(!is_numeric($sel_derivar))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
    exit;
}*/

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

//echo "$cod_institucion<br />";

$codigo_usuario=$_SESSION["codigo"];
$codigo=$_SESSION["cargo_asignado"];

//echo "$codigo_usuario<br />";
//echo "$codigo<br />";

if (isset($_POST['grabar']))
 {
      $prov=$_POST['proveido'];
	  $lug=$_POST['lugar'];
	  $hr1=$_POST['hr'];
	  $fecha_archida=date("Y-m-d H:i:s");

	
	if(empty($_POST['proveido']))
	{ 
	 $aux=1;
     $alert_final=1; 	
	}
	
	/*if(empty($_POST['lugar']))
	{ 
	 $aux=1;
     $alert_arch=1; 	
	}*/
	
	
	if ($aux == 0)
	{
	  echo "$hr1<br />";
	  echo "$prov<br />";
	  echo "$lugar<br />";	  
	  echo "$fecha_archida<br />";	
	    
	  /*mysql_query("update registrodoc1 set 
	  registrodoc1_situacion='A'
	  where registrodoc1_hoja_ruta='$hr1'
	  and registrodoc1_situacion='P'",$conn);
	  
	  mysql_query("update derivardoc set 
	  derivardoc_estado='A'
	  where derivardoc_hoja_ruta='$hr1'",$conn);*/
	  
	?>
		<script language="JavaScript">
	    //window.self.location="menu2.php";
		</script>
	<?php	
	  }
} //en if isset grabar

if (isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
	//window.close();
   window.self.location="menu2.php";
    </script>
<?php
}
?>
<br>
<?php
if ($aux == 0)
{
echo "<p><div class=\"fuente_titulo\" align=\"center\" style=\"color:#993366;\"><b>Documentos Obervados</b></div></p>";
} else 
{ echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b> !!! ERROR DATOS NO VALIDOS !!!</b></div></p>";
}

$ssql3="SELECT * FROM seguimiento WHERE '$sel_derivar'= seguimiento_codigo_seguimiento";
$rss3=mysql_query($ssql3,$conn);
$row3=mysql_fetch_array($rss3);
echo $row3["seguimiento_hoja_ruta"];
?>
<center>

<table width="600" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="enviar">
<input type="hidden" name="hr" value="<? echo $hruta;?>">
<tr class="border_tr3">
	<td><span class="fuente_normal">Hoja de Ruta</td>
	<td>
	<?php
	echo $hruta;
	?>
	</td>
</tr>
<?php
$respi=mysql_query("select registrodoc1_referencia, documentos_descripcion 
					from registrodoc1, documentos 
					where '$hruta' = registrodoc1_hoja_ruta 
					and registrodoc1_doc=documentos_sigla",$conn);
$roww=mysql_fetch_array($respi);

?>
<tr class="border_tr3">
	<td><span class="fuente_normal">Tipo de Documento</td>
	<td>
	<?php
	echo "$roww[documentos_descripcion]";
	?>
	
	</td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal">Referencia</td>
<td>
<?php
echo "$roww[registrodoc1_referencia]";
?>

</td></tr>


<tr class="border_tr3"><td><span class="fuente_normal">Fecha y Hora de Archivado:</td> 
<td><?php echo date("Y-m-d H:i:s");?>
</td>
</tr>


<tr class="border_tr3">
<td><span class="fuente_normal">Descripcion de la Observacion</td>
<td>
<textarea name="proveido" class="caja_texto" cols="60" rows="2">
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
<!--
<tr class="border_tr3">
<td><span class="fuente_normal">Archivado en</td>
<td>
<textarea name="lugar" class="caja_texto" cols="60" rows="2">
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
-->
<tr>
<td align="center" colspan="2">
<input type="submit" name="grabar" value="Aceptar" class="boton" />
<input type="submit" name="cancelar" value="Cancelar" class="boton"/>
</td>
</tr>
</form>
</table>
</center>
<br>
<?php
include("final.php");
?>