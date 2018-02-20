<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");
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
$codigo=$_SESSION["cargo_asignado"];
$depto=$_SESSION["departamento"];

$hrasdoc=descifrar($_GET['hr1']);
echo "$hrasdoc";

?>
<link rel="stylesheet" href="jquery.mobile-1.0.min.css" /> 
<script src="jquery-1.7.1.min.js"></script>
<script src="jquery.mobile-1.0.min.js"></script>
<?php 
$cite='1245';

//$rs_cont = mysql_query("SELECT registrodoc1_cite FROM `registrodoc1` where registrodoc1_cite='$cite'", $conn);
if(mysql_fetch_array(mysql_query("SELECT registrodoc1_cite FROM `registrodoc1` where registrodoc1_cite='$cite'", $conn))) 
{
	echo "$cite";
}
else
{
	echo "NO SE ENCONTRO COINCIDENCIA";
}

?>

<br />
<br />
<?php
include("final.php");
?>

