<?php
include("filtro_adm.php");
?>
<?php
include("inicio.php");
include("sicor/script/functions.inc");
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
$ssql = "SELECT * FROM instruccion";
$rss = mysql_query($ssql,$conn);
?>
<?php
if(isset($_POST['adicionar']))
{
?>
<script  language="javascript">
window.self.location="instruccion_nuevo.php";
</script>
<?php
}

if (isset($_POST['eliminar']))
{   $var=$_POST['sel_corresp'];
	$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
	  mysql_query("DELETE FROM instruccion WHERE instruccion_codigo_instruccion='$var[$i]'",$conn); 
	} 
	?>
	<script language="javascript">
	window.self.location="instrucciones.php";
	</script>
<?php
}

if(isset($_POST['cancelar']))
{
?>
<script language="javascript">
window.self.location="menu.php";
</script>  
<?php
}
?>
<br>
<center>
<table border="0" cellpadding="2" cellspacing="2" width="50%">
<form method="POST" name="instruccion">
<tr class="border_tr2">
<td align="center" width="5%">*</td>
<td align="center" width="65%">DESCRIPCI&Oacute;N</td></tr>
<?php
$resaltador=0;
while($row=mysql_fetch_array($rss))
{
		  if ($resaltador==0)
			  {
				   echo "<tr class=trdos>";
				   $resaltador=1;
			  }
			  else
			  {
				   echo "<tr class=truno>";
				   $resaltador=0;
			  }

	echo "<td class=\"border_tr\"><input type=\"checkbox\" name=\"sel_corresp[]\" value=".$row["instruccion_codigo_instruccion"]."></td>";
	echo "<td class=\"border_tr\">&nbsp;".$row["instruccion_instruccion"]."</td>";
	echo "</tr>";
} 
?>
<tr><td colspan="3" align="center">
<input type="submit" name="adicionar" value="Adicionar" class="boton" />
&nbsp;<input type="submit" name="eliminar" value="Eliminar" class="boton" />
&nbsp;<input type="submit" name="cancelar" value="Cancelar" class="boton" />
</td></tr>
</table>
</form>
</center>


<?php
include("final.php");
?>