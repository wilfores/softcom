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
include("../funcion.inc");
?>
<BR>
<?
	$dpto=$_SESSION["departamento"];
	$codigo_usuario=$_SESSION["codigo"];
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
	
	$hru = descifrar($_GET['hr1']);
		
	$buscacodd = mysql_query("select derivardoc_cod from derivardoc where derivardoc_hoja_ruta = '$hru' 
							and derivardoc_estado = 'TP' ", $conn);
	$reccod = mysql_fetch_array($buscacodd);
	$desar = mysql_query("update derivardoc set derivardoc_estado = 'P' where derivardoc_hoja_ruta = '$hru'
							and derivardoc_cod = '$reccod[derivardoc_cod]' ", $conn);

	echo "<center><h2> LA HOJA DE RUTA ".$hru." HA SIDO DESARCHIVADA </h2></center>";
?>
<?php $conn = Desconectarse();?>
	<script language='javascript' type='text/javascript' >
		function redirecciona (){
			document.location.replace('listado_trabajos_pend.php');
		}
		setTimeout(redirecciona,4000);
	</script>
<?php
include("final.php");
?>