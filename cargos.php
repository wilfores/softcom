<?php
include("filtro.php");
include("conecta.php");
include("inicio.php");
include("sicor/script/functions.inc");
include("sicor/script/cifrar.php");
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
$ssql="SELECT * FROM cargos where cargos_cod_institucion='$_SESSION[institucion]' ORDER BY cargos_cod_depto ";
$rss=mysql_query($ssql,$conn);
?>
<?php
if(isset($_POST['Adicionar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="cargonuevo.php"
			</script>
		<?php
}
$var=$_POST['cod_dep'];
$sel_inst1=$var[0];
if(isset($_POST[Modificar]) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="cargoeditar.php?sel_inst=<?php echo encryto($var[0]);?>"
			</script>
		<?php
}
//eliminacion de registros
if(isset($_POST['Eliminar']))
{
$var2=$_POST['cod_dep'];
$elementos = count($var2);
for($i=0; $i< $elementos; $i++){
mysql_query("DELETE FROM cargos WHERE cargos_id='$var2[$i]'",$conn) or die("El Registro no Existe");
}
		?>
			<script language='JavaScript'> 
				window.self.location="cargos.php"
			</script>
		<?php
}
?>
<center>
<TABLE WIDTH="75%" BORDER="0" CELLSPACING="1" CELLPADDING="0"  align="center" class="parrafo_general">
  <TR>
    <TD HEIGHT="10" COLSPAN="3" align="center">
	<P class="parrafo_titulo"><SPAN class="fuente_normal"><B>LISTA DE CARGOS</B><BR>
    </TD> 
  </TR>
  <TR>
</table>
 
<div style="overflow:auto; width:90%; height:450px; align:center;">
<FORM NAME="lista" METHOD="POST">
<TABLE WIDTH="90%" BORDER="0" CELLSPACING="2" CELLPADDING="0" HEIGHT="10" ALIGN="center">
  <TR>
    <TD WIDTH="2%" HEIGHT="10" COLSPAN="1" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><CENTER>*</CENTER></TD> 
	<TD WIDTH="25%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11" align="center"><SPAN class="fuente_normal"><B><CENTER>DESCRIPCI&Oacute;N</CENTER></B></TD> 
	<TD WIDTH="25%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11" align="center"><SPAN class="fuente_normal"><B><CENTER>UNIDAD</CENTER></B></TD> 
	<TD WIDTH="30%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11" align="center"><SPAN class="fuente_normal"><B><CENTER>DEPENDENCIA</CENTER></B></TD> 
	<TD WIDTH="15%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11" align="center"><SPAN class="fuente_normal"><B><CENTER></CENTER></B></TD>
    <!--<TD WIDTH="20%" bgcolor="#eeeeee" align="center"><SPAN class="fuente_normal"><B><CENTER>EDIFICIO</CENTER></B></TD> 
     -->  
  </TR>

<?php
$resaltador=0;
if(!empty($rss)){

while($row = mysql_fetch_array($rss)) 
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
?>
   
    <TD WIDTH="2%">
	<INPUT TYPE="checkbox" value="<?php echo $row["cargos_id"];?>" name="cod_dep[]">
     </TD>
	<TD WIDTH="25%" align="left">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><?php echo $row["cargos_cargo"];?>
	</TD> 
    <?php
    $nombre_dep=$row["cargos_cod_depto"];
	$consulta1="SELECT * FROM departamento where departamento_cod_departamento='$nombre_dep'";
    $rss1=mysql_query($consulta1,$conn);
	if ($filas = mysql_fetch_array($rss1))
	{
	?>
	<TD WIDTH="25%" align="left">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><?php echo $filas["departamento_descripcion_dep"];?>
	</TD>
    <?php
	}
	?>
     
     <?php
    $nombre_dep=$row["cargos_cod_institucion"];
	$consulta3="SELECT * FROM departamento where  departamento_cod_departamento ='$filas[departamento_dependencia_dep]'";
    $rss3=mysql_query($consulta3,$conn);
	if ($filas3 = mysql_fetch_array($rss3))
	{
	
	?>
	<TD WIDTH="10%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><?php echo $filas3["departamento_descripcion_dep"];?>
	</TD>
    <?php
	}
	?>
     <?php
	 /*
    $nombre_dep=$row["cargos_edificio"];
	$consulta2="SELECT * FROM edificio where  edificio_cod_edificio ='$nombre_dep'";
    $rss2=mysql_query($consulta2,$conn);
	if ($filas2 = mysql_fetch_array($rss2))
	{
	?>
	<TD WIDTH="20%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><?php echo $filas2["edificio_sigla_ed"];?>
	</TD>
    <?php
	}*/
	?>
    <TD align="center" COLSPAN="5">
		<!--<INPUT class="boton" TYPE="submit" VALUE="Adicionar" name="Adicionar">
		<INPUT class="boton" TYPE="submit" VALUE="Eliminar" name="Eliminar" >-->
		<INPUT class="boton" TYPE="submit" VALUE="Modificar" name="Modificar" >

	</TD>
   </TR>
<?php
}  // fin while
mysql_free_result($rss);
} //fin empty
mysql_close($conn);
?>
</FORM>
</div>
</TABLE>
</center>
<?php
include("final.php");
?>
