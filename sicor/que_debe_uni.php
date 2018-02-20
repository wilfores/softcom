<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("script/functions.inc");
include("script/cifrar.php");
include("../funcion.inc");
?>
	<link rel="stylesheet" type="text/css" href="../../css/estilos.css" />

<script language="JavaScript">
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=420,height=200");
}

function Retornar()
{
  document.enviar.action="recepcion_lista.php";
  document.enviar.submit();
}

</script>

<br>
<?
	$dpto=$_SESSION["departamento"];
	$codigo_usuario=$_SESSION["codigo"];
	
	//$conn = mysql_connect("localhost","root","12345");
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
	//$db= mysql_select_db("bd_softcom");
	//ahora averiguamos si nuestro dep tiene departamentos dependientes
	$sql2="select count(cargos_id) as total
		from cargos where cargos_dependencia = '$codigo_usuario'";
		$rs2 = mysql_query($sql2, $conn);
		$rw2 = mysql_fetch_array($rs2);
	//echo "<br> el total de departamentos dependientes es: ".$rw2["total"];
	echo "<center>";
//	if ($rw2["total"]>0){
?>
	<script language='javascript' type='text/javascript' >
	function navegar(){
		if (<?php echo $rw2["total"]?> >0){
			document.location.replace('muestra_depto.php?dpto=<?php echo $dpto ?>');
		}
		else{
			document.location.replace('muestra_usr.php?dpto=<?php echo $dpto."&usuario=".$codigo_usuario ?>');
		}
	}
	// nuevaestadistica.php
	function navegar2(){
			document.location.replace('nuevaestadistica.php');
	}
	</script>
	<input type=image src="images/docu.jpg" onclick="navegar2();">&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp
	<input type=image src="images/dept.jpg" onclick="navegar();">&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp
    <h2>Estadisticas por documento &nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp Estadisticas del departamento </h2>
<?php
include("final.php");
?>