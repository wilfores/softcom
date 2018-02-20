<?php
include("filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("conecta.php");
$codigo_bg=$_SESSION["codigo"];
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
echo $codigo_bg;
echo $_POST['titulo'];
echo $_REQUEST['titulo'];
echo $_SESSION['titulo'];
mysql_query("UPDATE usuario SET  usuario_titulo='$_POST[titulo]' WHERE  usuario_cod_usr='$codigo_bg'",$conn);

?>
<script>
//window.self.location="menu.php";
</script>

