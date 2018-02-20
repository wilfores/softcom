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
$instituto=$_SESSION["institucion"];
$ssql="SELECT * FROM edificio where edificio_cod_institucion='$instituto' order by edificio_descripcion_ed";
$rss=mysql_query($ssql,$conn);
?>

<?php
//esto es lo nuevo para los botones
if(isset($_POST['adicionar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="edificioadiciona.php"
			</script>
		<?php
}
$var=$_POST['cod_dep'];
$sel_inst1=$var[0];//para ver si con modificaciones no seleccionamos nada
if(isset($_POST['modificar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="edificioeditar.php?sel_inst=<?php echo $var[0];?>"
			</script>
		<?php
}
//eliminacion de registros
if(isset($_POST['eliminar']))
{
$var2=$_POST['cod_dep'];
$elementos = count($var2);
for($i=0; $i< $elementos; $i++)
{
mysql_query("DELETE FROM edificio WHERE edificio_cod_edificio='$var2[$i]'",$conn) or die("El Registro no Existe");
}
		?>
			<script language='JavaScript'> 
				window.self.location="edificio.php"
			</script>
		<?php
}
?>
<center>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0" HEIGHT="10" class="parrafo_general">
  <TR>
    <TD HEIGHT="10" COLSPAN="3">
	<B><SPAN class="fuente_normal"><CENTER><BR>ADMINISTRACION DE LOS EDIFICIOS DE LAS INSTITUCIONES
	</CENTER><BR></B>
    </TD> 
  </TR>
  
  <TR>
    <TD HEIGHT="10" COLSPAN="3" bgcolor="#eeeeee" align="center">
	<P class="parrafo_titulo"><SPAN class="fuente_subtitulo"><B>LISTA DE EDIFICIOS</B><BR>
    </TD> 
  </TR>
  <TR>

    <TD HEIGHT="10" COLSPAN="3" bgcolor="#d3daed" align="top">

<FORM NAME="lista" METHOD="POST">
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0" ALIGN="center">
  <TR>
    <TD WIDTH="5%" bgcolor="#eeeeee" align="left">
	<INPUT class="boton1" NAME="BOTON" TYPE="reset" VALUE="*">
   </TD> 
    <TD WIDTH="5%"  bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>C&Oacute;DIGO</CENTER></B></TD>
	<TD WIDTH="20%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>SIGLA</CENTER></B></TD> 
	<TD WIDTH="20%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>EDIFICIO</CENTER></B></TD> 
	<TD WIDTH="20%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>INSTITUCI&Oacute;N</CENTER></B></TD> 
	<TD WIDTH="10%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>CIUDAD</CENTER></B></TD> 
	    
  </TR>
</table>

<div style="overflow:auto; width:100%; align:left;">

<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">

<?php
$resaltador=0;
if(!empty($rss))
{
while($row = mysql_fetch_array($rss)) {

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
?>
    
    <TD WIDTH="5%" align="center">
	<INPUT TYPE="checkbox" value="<?php echo $row["edificio_cod_edificio"];?>" name="cod_dep[]">
	</TD>
	<TD WIDTH="5%"  align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		<?php echo $row["edificio_cod_edificio"];?>
	</TD> 
	<TD WIDTH="20%"  align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		<?php echo $row["edificio_sigla_ed"];?>
	</TD> 
	<TD WIDTH="20%"  >
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		<?php echo $row["edificio_descripcion_ed"];?>
	</TD> 
    <TD WIDTH="20%"   align="center">
	<?php
	$var=$row["edificio_cod_institucion"];
	$resp=mysql_query("Select * from instituciones where instituciones_cod_institucion='$var'",$conn);
	if ($insti=mysql_fetch_array($resp)) 
	{
	?>
    <P class="parrafo_normal"><SPAN class="fuente_normal">
    		<?php echo $insti["instituciones_descripcion_inst"];?>
	<?php
	}
	?>
	</TD>
    <TD WIDTH="10%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		<?php echo $row["edificio_ciudad"];?>
	</TD> 

  </TR>
<?php
}  // fin while
mysql_free_result($rss);
} //fin empty
mysql_close($conn);
?>
</TABLE>
<div>
    </TD> 
  </TR>
  <TR>
	<TD align="center" COLSPAN="5">
	<INPUT class="boton" TYPE="submit"  VALUE="Adicionar" name="adicionar">
	<INPUT class="boton" TYPE="submit"  VALUE="Modificar" name="modificar">
	<INPUT class="boton" TYPE="submit"  VALUE="Eliminar" name="eliminar">
   </TD>
</FORM>
  </TR>
</TABLE>
</center>
<?php
include("final.php");
?>
