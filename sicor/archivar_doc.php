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

	
	/*if(empty($_POST['proveido']))
	{ 
	 $aux=1;
     $alert_final=1; 	
	}*/
	
	if(empty($_POST['lugar']))
	{ 
	 $aux=1;
     $alert_arch=1; 	
	}
	
	
	if ($aux == 0)
	{
	  echo "$hr1<br />";
	  echo "$prov<br />";
	  echo "$lugar<br />";	  
	  echo "$fecha_archida<br />";	
	  
	  	$query = "select max(archivados_id)from archivados";
		$result = mysql_query($query,$conn);
		$record = mysql_fetch_array($result);			
		$id_fact=$record[0]+1;/*obtiene el maximmo del id del documento*/
		echo "$id_fact";
		
		$insertar=" INSERT INTO `archivados` (`archivados_id`, `archivados_hoja_ruta`, `archivados_fecha_archivado`, `archivados_proveido`, `archivados_ubicacion`, `archivados_quien`) 
		VALUES ($id_fact,'$hr1','$fecha_archida','Archivado','$lug',$codigo)";
		$resul = mysql_query($insertar,$conn);
			  
	  mysql_query("update registrodoc1 set 
	  registrodoc1_situacion='A'
	  where registrodoc1_hoja_ruta='$hr1'
	  and registrodoc1_situacion='P'",$conn);
	  
	  $r_max = mysql_query("select max(derivardoc_n_derivacion)from derivardoc where derivardoc_hoja_ruta='$hr1'",$conn);
	  $rcor = mysql_fetch_array($r_max);	
	  $id_f=$rcor[0];/*obtiene el maximmo del id del documento*/
	  
	  mysql_query("update derivardoc set 
	  derivardoc_estado='A'
	  where derivardoc_hoja_ruta='$hr1'
	  and derivardoc_n_derivacion='$id_f'",$conn);
	  
	?>
		<script language="JavaScript">
	    window.self.location="menu3.php";
		</script>
	<?php	
	  }
} //en if isset grabar

if (isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
	//window.close();
   window.self.location="menu3.php";
    </script>
<?php
}
?>
<br>
<center><b style=" font-size:18px">Archivando Correspondencia</b></center></p></center>
<center>
<table width="600" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="enviar">
<input type="hidden" name="hr" value="<?php echo $hruta;?>">
<tr class="border_tr3">
	<td><span class="fuente_normal">Hoja de Ruta</td>
	<td style="font-size:15px"><strong>
	<?php
	echo $hruta;
	?></strong>
	</td>
</tr>
<?php

$verif_ext = explode ('-',$hruta);
//echo"$verif_ext[0]";

if($verif_ext['0']=='EXT')
{
$respi=mysql_query("select registrodoc1_referencia
					from registrodoc1 
					where '$hruta' = registrodoc1_hoja_ruta",$conn);
}
else{
$respi=mysql_query("select registrodoc1_referencia, documentos_descripcion 
					from registrodoc1, documentos 
					where '$hruta' = registrodoc1_hoja_ruta 
					and registrodoc1_doc=documentos_sigla",$conn);
}
$roww=mysql_fetch_array($respi);
?>
<tr class="border_tr3">
	<td><span class="fuente_normal">Tipo de Documento</td>
	<td><strong>
	<?php
	echo "$roww[documentos_descripcion]";
	?>
	</strong>
	</td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal">Referencia</td>
<td><strong>
<?php
echo "$roww[registrodoc1_referencia]";
?>
</strong>
</td>
</tr>


<tr class="border_tr3"><td><span class="fuente_normal">Fecha y Hora de Archivado:</td> 
<td><strong><?php echo date("Y-m-d H:i:s");?></strong>
</td>
</tr>

<!--
<tr class="border_tr3">
<td><span class="fuente_normal">Proveido</td>
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
-->
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