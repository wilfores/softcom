<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$codigo_usuario=$_SESSION["codigo"];
$cargo_unico=$_SESSION["cargo_asignado"];
//unset($_SESSION["codigo_libro_reg"]);
$fecha_hoy = date("Y-m-d");

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

echo "$codigo_usuario<br>";
echo "$cargo_unico<br>";

$var=$_POST['lista_hr'];
$elementos = count($var);

$fecha_archida=date("Y-m-d H:i:s");

		//echo "$var[$i]<br>";
?>
<br>
<p class="fuente_titulo">
<center><b style=" font-size:18px">LISTADO PARA ARCHIVAR</b></center></p></center>
<?php /*?><?php */
$resp1=mysql_query("SELECT * FROM derivardoc WHERE derivardoc_para='$cargo_unico' and derivardoc_situacion='R' and derivardoc_estado='P' and derivardoc_realizado='H'",$conn);
while ($r_w1=mysql_fetch_array($resp1))
	{ 
		echo "$r_w1[derivardoc_hoja_ruta],  $r_w1[derivardoc_proveido]<br>";
		
		$query = "select max(archivados_id)from archivados";
		$result = mysql_query($query,$conn);
		$record = mysql_fetch_array($result);			
		$id_fact=$record[0]+1;/*obtiene el maximmo del id del documento*/
		echo "$id_fact";
		
		$insertar=" INSERT INTO `archivados` (`archivados_id`, `archivados_hoja_ruta`, `archivados_fecha_archivado`, `archivados_proveido`, `archivados_ubicacion`, `archivados_quien`) 
		VALUES ($id_fact,'$hr1','$fecha_archida','Archivado','$lugar',$cargo_unico)";
		$resul = mysql_query($insertar,$conn);
			
	}
?>

</center>
<?php
include("final.php");
?>