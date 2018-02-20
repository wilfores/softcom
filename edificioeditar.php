<?php
include("filtro.php");
include("conecta.php");
include("inicio.php");
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
$respi=mysql_query("select * from edificio where edificio_cod_edificio='$_GET[sel_inst]'",$conn);
$error=0;
if(isset($_POST['enviar']))
{
  if (empty($_POST['nombreedificio']))
	{
	  $error=1;
    }
 if (empty($_POST['siglaedificio']))
	{
	  $error=1;
    }

  if($error==0)
	{
  mysql_query("update edificio set edificio_descripcion_ed='$_POST[nombreedificio]',edificio_sigla_ed='$_POST[siglaedificio]',edificio_ciudad='$_POST[ciudad]' where edificio_cod_edificio='$_GET[sel_inst]'");
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
<br>

<center>
<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
MODIFICAR DATOS DEL EDIFICIO
</P>
<?php
if ($rowi=mysql_fetch_array($respi))
{
?>
<table bgcolor="#eeeeee">
<form action="" method="post">
<tr>
<td><SPAN class="fuente_subtitulo">Nombre del Edificio:</td>
<td><input class="fuente_caja_texto" type="text" name="nombreedificio" size="70" value="<?php echo $rowi["edificio_descripcion_ed"];?>">
<input type="hidden" name="sel_inst" value="<?php echo $rowi["edificio_cod_edificio"];?>">
</td>
</tr>
<tr>
<td><SPAN class="fuente_subtitulo">Sigla del Edificio:</td>
<td><input class="fuente_caja_texto" type="text" name="siglaedificio" value="<?php echo $rowi["edificio_sigla_ed"];?>">
<input type="hidden" name="sel_inst" value="<?php echo $rowi["edificio_cod_edificio"];?>">
</td>
</tr>


<TR>
<TD><SPAN class="fuente_subtitulo"><B>Ciudad:</B></TD> 
    <TD width="150" height="10" colspan="1">
   <select class="fuente_caja_texto" name="ciudad">
   <option value="">Seleccione CI</option>
        <option value="La Paz" <?php if($rowi["edificio_ciudad"]=='La Paz') { echo "selected";}?>>La Paz</option>
        <option value="Cochabamba" <?php if($rowi["edificio_ciudad"]=='Cochabamba') { echo "selected";}?>>Cochabamba</option>
        <option value="Santa Cruz" <?php if($rowi["edificio_ciudad"]=='Santa Cruz') { echo "selected";}?>>Santa Cruz</option>
        <option value="Oruro" <?php if($rowi["edificio_ciudad"]=='Oruro') { echo "selected";}?>>Oruro</option>
        <option value="Beni" <?php if($rowi["edificio_ciudad"]=='Beni') { echo "selected";}?>>Beni</option>
        <option value="Pando" <?php if($rowi["edificio_ciudad"]=='Pando') { echo "selected";}?>>Pando</option>
        <option value="El Alto" <?php if($rowi["edificio_ciudad"]=='El Alto') { echo "selected";}?>>El Alto</option>
        <option value="Chuquisaca" <?php if($rowi["edificio_ciudad"]=='Chuquisaca') { echo "selected";}?>>Chuquisaca</option>
        <option value="Potosi" <?php if($rowi["edificio_ciudad"]=='Potosi') { echo "selected";}?>>Potosi</option>
        <option value="Tarija" <?php if($rowi["edificio_ciudad"]=='Tarija') { echo "selected";}?>>Tarija</option>
   </select>
     </TD>
  </TR>




<tr>
<td>&nbsp;
</td>
</tr>

<tr>
<td></td>
<td>
<input class="BOTON" type="submit" name="enviar" value="Enviar" >
<input class="BOTON" type="submit" name="cancelar" value="Cancelar" >
</td>
</tr>
</form>
</table>
<br>
</center>

<?php
}
include("final.php");
?>
