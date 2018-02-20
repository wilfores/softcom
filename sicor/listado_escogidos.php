<?php 
include("../conecta.php");
include("script/functions.inc");
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

if(isset($_POST['eliminar']))
{
$valeli=$_POST['tipo_doc'];
//echo "$valeli";
$res1=mysql_query("delete from temp1 where temp1_cod_mio='$codigo' and temp1_cod_para='$valeli'",$conn);
mysql_fetch_array($res1);
}
?>

<meta content="5;URL=listado_escogidos.php" http-equiv="REFRESH"> 
<?php
$res=mysql_query("select * from temp1 where temp1_cod_mio='$codigo' order by temp1_nom",$conn);

?>
<table border="1" cellpadding="1" cellspacing="1" align="center">
<?
while($row=mysql_fetch_array($res))
{
?>
<tr style="font-size:9px" class="border_tr3">	
	<form action="" method="post">
	<input type="hidden" name="tipo_doc" value="<?=$row[1];?>" />
	<td><? echo "$row[2]"; ?></td>
	<td><? echo "$row[3]"; ?></td>
	<td><? echo "$row[4]"; ?></td>
	<td align="center">		
		<input style="font-size:9px; color:blue;" type="submit" value="Eliminar" name="eliminar"/>
	</td>
	</form>
</tr>
<?
}
?>
</table>
</meta>





