<?php
include("filtro.php");
include("inicio.php");
include("conecta.php");
include("sicor/script/functions.inc");
include("sicor/script/cifrar.php");
$variable=descryto($_GET['sel_usuario']);
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
$ssql="SELECT * FROM usuario where usuario_cod_usr='$variable'";
$rss=mysql_query($ssql,$conn);
	if (!empty($rss)) 
	{
	while($row=mysql_fetch_array($rss))
	{
	$usuario=$row["usuario_cod_usr"];
	$depto=$row["usuario_cod_departamento"];
	$ocupacion=$row["usuario_ocupacion"];
	$fecha=date("Y-m-d")." ".date("H:i:s");
mysql_query("insert into liberar (liberar_cod_usr,liberar_fecha,liberar_depto,liberar_ocupacion)
VALUES ('$usuario','$fecha','$depto','$ocupacion')",$conn) or die ("No se Guardo el archivo");
	}
mysql_query("UPDATE usuario SET usuario_ocupacion='0',usuario_active='0' WHERE usuario_cod_usr='$variable'",$conn) or die("No se Guardo el Registro");
mysql_query("UPDATE miderivacion SET miderivacion_estado='0' WHERE miderivacion_su_codigo='$ocupacion'",$conn) or die("No se Guardo el Registro");	
mysql_query("UPDATE asignar SET asignar_estado='0' WHERE asignar_su_codigo='$ocupacion'",$conn) or die("No se Guardo el Registro");	
	
	?>
    <script language='JavaScript'> 
	window.self.location="adminusuarios.php"
	</script>
	<?php
    }
	?>
    

 
