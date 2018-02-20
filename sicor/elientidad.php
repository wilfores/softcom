<?php
include("../filtro.php");
include("../conecta.php");
include("cifrar.php");
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
echo $_GET['codigoeli'];

if (isset($_POST['enviar']))
{


   if($_POST['ber']=='si')
	{
   mysql_query("delete from entidades where entidades_codigo='$_GET[codigoeli]'",$conn) or die("no se guerdoa");
    }
    ?>
  <script language="JavaScript">
    window.self.location="encuentra_entidades.php";
  </script>
    <?php
}
?>
<link rel="stylesheet" type="text/css" href="script/estilos2.css" title="estilos2" />
<br>
<br>
<div align="center" class="fuente_titulo_principal">DESEA ELIMINAR ESTA ENTIDAD?
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

