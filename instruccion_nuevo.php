<?php
include("filtro_adm.php");
?>
<?php
include("inicio.php");
include("sicor/script/functions.inc");
include("conecta.php");

$cod_institucion = $_SESSION["institucion"];
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

$aux = 0;

if (isset($_POST['enviar'])) {
   if ($_POST['descripcion'] == "") {
	 $aux = 1;
	 $descri = 1;
   }

  if ($aux == 0) {
    //$conn = Conectarse();
	$ssql = "INSERT INTO  instruccion(instruccion_instruccion) 
	VALUES ('$_POST[descripcion]')";
	mysql_query($ssql, $conn);
	
?>
    <script language="JavaScript">
    window.self.location="instrucciones.php";
    </script>
<?php	
   }
} //en if isset enviar

if(isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="tipo_documento.php";
    </script>
<?php
}
?>
<br>
<?php if ($aux == 0){
echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>AGREGAR INSTRUCCION</b></div></p>";
} else 
{ echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b>VERIFICAR DATOS</b></div></p>";
}?>
<center>
<table width="60%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="documento">

<tr class="border_tr3"><td><span class="fuente_normal">Descripcion</td>
<td><input type="text" name="descripcion" value="" maxlength="50" size="30" />
<?php if ($descri == 1) {
    echo "<img src=\"images/eliminar.gif\" border=0>";
   }?>
</td></tr>

<tr>
<td align="center" colspan="2">
	<input type="submit" name="enviar" value="Aceptar" class="boton" />
	<input type="submit" name="cancelar" value="Cancelar" class="boton">
</td>
</tr>
</form>
</table>
</center>
<br>

<?php
include("final.php");
?>