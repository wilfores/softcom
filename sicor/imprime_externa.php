<?php
include("../filtro.php");
include("script/functions.inc");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$nom_usuario=$_SESSION["cargo_asignado"];
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
<html>
<head>
<title>Imprime Hoja de Ruta</title>
<link rel="stylesheet" type="text/css" href="../script/estilos2.css">
<script language="JavaScript">
 function imprimir() {
    window.print()
 }
</script>
</head>
<body onLoad="imprimir();">
<?php
$imp=str_replace ("\\","",$_POST['imp']); 
$respi=mysql_query($_POST['imp'],$conn);
?>
<br>
<p>
<font size="2" color="#000000"><center><b>CORRESPONDENCIA EXTERNA ENCONTRADA</b></center></p></center></font>

<table width="100%" cellspacing="1" cellpadding="1" border="1" style="font-size:9px">
<tr>
<td width="10%" align="center"><span class="fuente_normal">Hoja Externa</td>
<td width="10%" align="center"><span class="fuente_normal">Fecha y Hora de Elaboracion</td>
<td width="20%" align="center"><span class="fuente_normal">Destinatario</td>
<td width="20%" align="center"><span class="fuente_normal">Referencia</td>
<td width="15%" align="center"><span class="fuente_normal">Archivo</td>

</tr>

<?php

 while($row=mysql_fetch_array($respi))
{
?>
<tr>
<td align="left" width="10%"><b><?php echo $row["hojaexterna_hoja"];?></b></td>
<td align="center" width="10%">
<?php echo $row["hojaexterna_fecha"]." ".$row["hojaexterna_hora"];?>
</td>
<td align="left" width="20%">
<?php
echo $row["hojaexterna_destinatario"];
echo "<br>";
echo "<b>".$row["hojaexterna_cargo"]."</b>";
?>
</td>
<td width="20%">
<?php echo $row["hojaexterna_referencia"];?>
</td>


    
<td align="center" width="15%">
<b>
<?php 

      	$valor_clave=$row["hojaexterna_generador"];
		$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
		if($fila_clave=mysql_fetch_array($conexion))
		{
			$valor_cargo=$fila_clave["cargos_id"];
			$carguillo=$fila_clave["cargos_cargo"];
			$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
			if($fila_cargo=mysql_fetch_array($conexion2))
			{
			echo $fila_cargo["usuario_nombre"]."<br>".$carguillo;
			}
		}
?>
</b>
</td>    
</tr>
<?php
}   

mysql_close($conn);
?>
</table>
</center>
</body>
</html>
