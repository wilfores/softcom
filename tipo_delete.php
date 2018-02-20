<?php
include("filtro_adm.php");
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
$elementos = count($sel_corresp);

// esto es nuevo
for($i=0; $i< $elementos; $i++){

mysql_query("DELETE FROM clasecorrespondencia WHERE clasecorrespondencia_codigo_clase_corresp='$sel_corresp[$i]'",$conn); 

} //end for
//mysql_close($conn);
?>
<script>
window.self.location="tipo_documento.php";			
</script>		

