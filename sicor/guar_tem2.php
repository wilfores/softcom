<?php 
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
$cod_usu=$_GET['hr1'];

/*
echo "$codigo<BR>";
echo "$cod_usu<BR>";
echo "$nomb<BR>";
echo "$cargo<BR>";
echo "$depto<BR>";
echo "esto se guardara en la tabla temporal";
*/

			$nomb=$_GET['val'];
			$cargo=$_GET['val1'];
			$depto1=$_GET['val2'];
			$cod_depto1=$_GET['val3'];

			$ssql2 = "INSERT INTO 
		  	temp2 (temp2_cod_mio,temp2_cod_para,temp2_nom,temp2_cargo,temp2_depto,temp2_x1,temp2_x2)
		 	VALUES ($codigo,$cod_usu,'$nomb','$cargo','$depto1','$cod_depto1','0')";
			mysql_query($ssql2,$conn);			
			?>
			<script language="JavaScript">
             	window.self.location="listado_comision.php";
            </script>		
           


