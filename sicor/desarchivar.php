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

<?php
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
							and derivardoc_estado = 'A' ", $conn);
	$reccod = mysql_fetch_array($buscacodd);
	if ($reccod['derivardoc_cod'] != ''){
		$desar = mysql_query("update derivardoc set derivardoc_estado = 'P' where derivardoc_hoja_ruta = '$hru'
							and derivardoc_cod = '$reccod[derivardoc_cod]' ", $conn);
	}
	else{
		$buscacodr = mysql_query ("select registrodoc1_id from registrodoc1 where registrodoc1_hoja_ruta = '$hru'
									and registrodoc1_situacion = 'A' ", $conn);
		$reccodr = mysql_fetch_array($buscacodr);
		$desar = mysql_query("update registrodoc1 set registrodoc1_situacion = 'P' where registrodoc1_hoja_ruta = '$hru'
							and registrodoc1_id = '$reccodr[registrodoc1_id]'", $conn);
	}
	$eliarch = mysql_query("delete from archivados where archivados_hoja_ruta = '$hru' ", $conn);
	
	echo "<BR><center><h2> LA HOJA DE RUTA ".$hru." HA SIDO DESARCHIVADA </h2></center>";
?>
<?php $conn = Desconectarse();?>
	<script language='javascript' type='text/javascript' >
		function redirecciona (){
			document.location.replace('listado_archivados.php');
		}
		setTimeout(redirecciona,4000);
	</script>
<?php
include("final.php");
?>