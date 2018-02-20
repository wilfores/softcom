<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");

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

$hruta=descifrar($_GET['hr1']);

if (isset($_POST['enviar']))
{

	
   if($_POST['ber']=='si')
	{
	
	mysql_query("update registrodoc1 set registrodoc1_situacion='E' where '$hruta'=registrodoc1_cite",$conn);

    }
    ?>
  <script language="JavaScript">
    window.self.location="listado_de_mi2.php";
  </script>
    <?php
}
?>
<link rel="stylesheet" type="text/css" href="script/estilos2.css" title="estilos2" />
<br>
<br>
<div align="center" class="fuente_titulo_principal">DESEA ANULAR CITE? <br><br>
<? echo "$hruta";?>
</div>
<br>
<CENTER><table border="0">
<tr class="border_tr3">
<form method="post" >
<td>
<input type="hidden" name="codigoeli" value="<?php echo $_GET['codigoeli'];?>">
<input type="radio" name="ber" value="si">Si
<input type="radio" name="ber" value="no" checked>No
</td>
</tr>
<tr>
<td align="center">
<br>
<br>
<input type="submit" class="boton" name="enviar" value="Enviar">
</td>
</tr>
</form>
</table>
</CENTER>

