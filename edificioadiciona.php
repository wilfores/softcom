<?php
include("filtro.php");
include("conecta.php");
include("inicio.php");
include("sicor/script/functions.inc");
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
$error=0;
if (isset($_POST['enviar']))
{
    if (empty($_POST['nombresito']))
	{
      $error=1;
	  $alert_nombre=1;
    }
   
   if (empty($_POST['siglaed']))
	{
      $error=1;
	  $alert_sigla=1;
    }
	
		if(empty($_POST['ciudad']))
	{
	  $error=1;
	  $alert_ciudad=1; 
  	}
	

	if ($error == 0)
	{
       $var=$_SESSION["institucion"];
        mysql_query("insert into edificio(edificio_descripcion_ed,edificio_cod_institucion,edificio_sigla_ed,edificio_ciudad)values('$_POST[nombresito]','$var','$_POST[siglaed]','$_POST[ciudad]') ",$conn);
		?>
			<script language='JavaScript'> 
				window.self.location="edificio.php"
			</script> 
		<?php
	}
}

if (isset($_POST['cancelar']))
{
?>
			<script language='JavaScript'> 
				window.self.location="edificio.php"
			</script>
<?php
}

?>

<center>
<br>
<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
ADICION DE EDIFICIOS
</P>
<?php
if ($error != '0')
{
echo "<center><font size=2pt color=red>!!! ERROR DATOS NO VALIDOS !!!</font></center>";
}
?>
<table>
<form method="post">
<tr class="truno">
<td><SPAN class="fuente_subtitulo">Sigla del Edificio:</td>
<td><input class="fuente_caja_texto" type="text" name="siglaed" value="<?php echo $_POST['siglaed'];?>">
<?php Alert($alert_sigla); ?>
</td>
</tr>
<tr class="truno">
<td><SPAN class="fuente_subtitulo">Nombre del Edificio:</td>
<td>
<input class="fuente_caja_texto" type="text" name="nombresito" value="<?php echo $_POST['nombresito'];?>">
<?php Alert($alert_nombre); ?>
</td>
</tr>
<tr class="truno">
<td><SPAN class="fuente_subtitulo">Ciudad del Edificio:</td>
<td>
   <select class="fuente_caja_texto" name="ciudad">
        <option value="">Seleccione Ciudad</option>
  <?php
   echo "<option value='La Paz'>La Paz</option>";
   echo "<option value='Cochabamba'>Cochabamba</option>";
   echo "<option value='Oruro'>Oruro</option>";
   echo "<option value='Beni'>Beni</option>";
   echo "<option value='Pando'>Pando</option>";
   echo "<option value='El Alto'>El Alto</option>";
   echo "<option value='Chuquisaca'>Chuquisaca</option>";
   echo "<option value='Potosi'>Potosi</option>";
   echo "<option value='Tarija'>Tarija</option>";               
   echo "<option value='Santa Cruz'>Santa Cruz</option>";
   ?>
  </select>
     <?php Alert($alert_ciudad);?>  


</td>
</tr>
<tr>
</tr>
<tr>
<td colspan="2" align="center">
	<br>
	<input class="boton" type="submit" name="enviar" value="Enviar">
	<input class="boton" type="submit" name="cancelar" value="Cancelar">
</td>
</tr>
</form>
</table>
<br>
</center>
<?php
include("final.php");
?>
