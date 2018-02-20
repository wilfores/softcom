<?php
include("../filtro.php");
?>
<?php
include("script/functions.inc");
include("../funcion.inc");
include("../conecta.php");
$gestion=$_SESSION["gestion"];
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
?>
<?php
    $valor_recibido = descifrar($_GET[identificador]);
    mysql_query("DELETE FROM adjunto WHERE adjunto_archivo = '$valor_recibido'",$conn);
?>
    <script language="JavaScript">
         window.self.location="pinforme_editar.php";
    </script>
<?php


?>