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

$ssql="SELECT * FROM departamento where departamento_cod_institucion='$instituto'";
$rss=mysql_query($ssql,$conn);

?>
<?php
if(isset($_POST['adicionar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="departamentonuevo.php"
			</script>
		<?php
}
$var=$_POST['cod_dep'];
$sel_inst1=$var[0];//para ver si con modificaciones no seleccionamos nada
if(isset($_POST['modificar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="departamentoeditar.php?sel_inst=<?php echo $var[0];?>"
			</script>
		<?php
}
//eliminacion de registros
if(isset($_POST['eliminar']))
{
$var2=$_POST['cod_dep'];
$elementos = count($var2);
for($i=0; $i< $elementos; $i++){
mysql_query("DELETE FROM departamento WHERE departamento_cod_departamento='$var2[$i]'",$conn) or die("El Registro no Existe");
}
		?>
			<script language='JavaScript'> 
				window.self.location="departamento.php"
			</script>
		<?php
}
?>
	
<center>	
<TABLE WIDTH="75%" BORDER="0" CELLSPACING="2" CELLPADDING="0" HEIGHT="10" class="parrafo_general" align="center">
  <TR>
    <TD HEIGHT="10" COLSPAN="3" align="center">
	<P class="parrafo_titulo"><SPAN class="fuente_normal"><B>LISTADO DE UNIDADES</B><BR>
    </TD> 
  </TR>
  <TR>
</table>

<div style="overflow:auto; width:90%; height:500px; align:center;">
<FORM NAME="lista" METHOD="POST">
<TABLE WIDTH="90%" BORDER="0" CELLSPACING="2" CELLPADDING="0" HEIGHT="10" >
  <TR>
    <TD WIDTH="2%" HEIGHT="10" COLSPAN="1" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><CENTER>*</CENTER></TD> 
    <TD WIDTH="5%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><SPAN ><B><CENTER>C&Oacute;DIGO</CENTER></B></TD>
	<TD WIDTH="10%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><SPAN ><B><CENTER>SIGLA</CENTER></B></TD>
	<!--<TD WIDTH="15%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><SPAN ><B><CENTER>EDIFICIO</CENTER></B></TD>     -->
	<TD WIDTH="20%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><SPAN ><B><CENTER>UNIDAD</CENTER></B></TD> 
	<TD WIDTH="20%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><SPAN ><B><CENTER>UNIDAD QUE DEPENDE</CENTER></B></TD>    
   	<!--<TD WIDTH="20%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><SPAN ><B><CENTER>INST. QUE DEPENDE</CENTER></B></TD>-->
	<TD WIDTH="20%" bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><SPAN ><B><CENTER></CENTER></B></TD>
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
    
    <TD WIDTH="2%" align="center">
	<INPUT type="checkbox" value="<?php echo $row["departamento_cod_departamento"];?>" name="cod_dep[]">
    </TD>
    
	<TD WIDTH="5%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		&nbsp;&nbsp;&nbsp; <?php echo $row["departamento_cod_departamento"];?>
	</TD> 
    
    <TD WIDTH="10%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		&nbsp;&nbsp;&nbsp; <?php echo $row["departamento_sigla_dep"];?>
	</TD>    
    <!--
	 <TD WIDTH="15%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
	<?php
	$buscar="SELECT * FROM edificio WHERE edificio_cod_edificio='$row[departamento_cod_edificio]'";
	$rssaux = mysql_query($buscar, $conn);
	if ($rowed=mysql_fetch_array($rssaux))
	{
	echo $rowed["edificio_sigla_ed"];
	}
	?>
	</TD>-->
    
	<TD WIDTH="20%">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
<?php echo $row["departamento_descripcion_dep"];?>
	</TD>
    
    <TD WIDTH="20%" >
	
	<?php
	$var=$row["departamento_dependencia_dep"];
	$resp=mysql_query("select * from departamento where departamento_cod_departamento='$var'",$conn);
	if ($insti=mysql_fetch_array($resp)) 
	{
	?>
    <P class="parrafo_normal"><SPAN class="fuente_normal">
<?php echo $insti["departamento_descripcion_dep"];?>
		
	<?php
	}
	?>
	</TD>
   <!-- 
    <TD WIDTH="20%" align="center">
	<?php
	$var=$row["departamento_cod_institucion"];
	$resp=mysql_query("select * from instituciones where instituciones_cod_institucion='$var'",$conn);
	if ($insti=mysql_fetch_array($resp)) 
	{
	?>
    <P class="parrafo_normal"><SPAN class="fuente_normal">
    <?php echo $insti["instituciones_sigla_inst"];?>
		
	<?php
	}
	?>
	</TD>
	-->
	

    <TD WIDTH="20%" align="center">
	<!--<INPUT class="boton" TYPE="submit" VALUE="Adicionar" name="adicionar">-->
	<INPUT class="boton" TYPE="submit" VALUE="Modificar" name="modificar" >
	<INPUT class="boton" TYPE="submit" VALUE="Eliminar" name="eliminar" >
	</TD>

  </TR>
<?php
}  // fin while
if (($num_pag-1)>0)
{
echo "<a href=departamento.php?pagina=".($num_pag-1)."><Anterior</a>";
}
} //fin empty
mysql_close($conn);
?>
</div>
</FORM>
</TABLE>
</center>
<?php
include("final.php");
?>
