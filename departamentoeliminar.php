<?php
include("filtro.php");
include("inicio.php");
include("conecta.php");
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
$elementos = count($cod_dep);

for($i=0; $i< $elementos; $i++){
mysql_query("DELETE FROM departamento WHERE departamento_cod_departamento='$cod_dep[$i]'",$conn) or die("El Registro no Existe");
}

mysql_close($conn);
include("final.php");
?>
	<script>
	window.self.location="departamento.php";
	</script>		
