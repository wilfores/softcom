<?php
include("filtro.php");
$titulopagina="EV";
?>
<?php
include("inicio.php");
?>
<?php
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
$result=mysql_query("SELECT count(*) as numero FROM usuario where usuario_username='$Username'",$conn);
$Lista=mysql_fetch_row($result);
if($Lista[0])
{
?>
<br>
<br>
<center>
<span class="fuente_subtitulo">
<b>Lo siento el <strong>Nombre de Usuario</strong> <?php echo strtoupper($Username);?> ya existe
<br>
Elija Otro Gracias..
</b>
<br>
</span>
<br>
<a href="usuarionuevo.php"><img src="images/atras.gif" alt="ATRAS" border=0/>
</a>

<br>
</center>
<?php
exit();
}

if (($_SESSION["adminvirtual"])=="adminlocal")
{
   $Cod_Institucion = $_SESSION["institucion"];
}

$User2=$Username."/";
$Email=$Username."@".$Dominio;
mysql_query("insert into usuario (usuario_cod_departamento,usuario_nombre,usuario_titulo,usuario_email,usuario_username,usuario_dominio,usuario_cod_nivel,usuario_password,usuario_cod_institucion,usuario_cargo,usuario_maildir,usuario_ocupacion,,usuario_carnet,usuario_carnet_ciudad)
VALUES ('$Cod_Departamento','$Nombre', '$Titulo','$Email','$Username', '$Dominio', '$Cod_Nivel', '$Username', '$Cod_Institucion','$car_codigo','$User2','$ocupacion','$ci','$ci_ciudad')",$conn) or die ("No se Guardo el archivo");

include("final.php");
?>
<script>
window.self.location="adminusuarios.php";
</script>
