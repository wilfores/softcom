<?php 
include("filtro_adm.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("sicor/script/functions.inc");
include("sicor/script/cifrar.php");
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
$micod=256;
$codori=$micod;
$cont=0;
$vias=mysql_query("select * from cargos where cargos_dependencia='126'",$conn);
while ($rwvi=mysql_fetch_array($vias))
{
	//echo "$rwvi[cargos_id] $rwvi[cargos_cargo]<br>";
	
		$via=mysql_query("select * from via where via_su_codigo=$rwvi[cargos_id]",$conn);
		$rwv=mysql_fetch_array($via);
		if(($rwvi['cargos_id'] != $micod) && ($rwv['via_orden']!='0'))
		{	
			$cont=$cont+1;
			echo "$cont   $rwv[1]<br>";
			$micod=$rwvi['caros_id'];
		}
}

?>


