<?php
include("filtro.php");
?>
<?php
$titulopagina="EV";
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
if (isset($codusuario))
{
  $elementos = 1;
  $cod_usuario[]= $codusuario;	
}
else
{
   $elementos = count($cod_usuario);
}


for($i=0; $i < $elementos; $i++)
{
	$result=mysql_query("SELECT * FROM usuario where usuario_cod_usr='$cod_usuario[$i]'",$conn);
	if ($row=mysql_fetch_array($result))
	{
	$eliminar=$row["usuario_username"];
	$elimincc=$row["usuario_cod_usr"];
	echo system("rm -rf /var/spool/mail/$eliminar",$result); 
	echo system("rm -rf /var/www/html/virtual/disco/usuarios/$eliminar",$result); 
	echo system("rm -rf /var/www/html/squirrelmail/data/$eliminar@*.*",$result); 
	}
	mysql_query("DELETE FROM usuario WHERE usuario_cod_usr='$elimincc'",$conn) or die("El Registro no Existe");
}
mysql_close($conn);
?>
<script>
	window.self.location="adminusuarios.php";
</script>		
