<?php
include("filtro.php");
include("conecta.php");
include("inicio.php");
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
$instituto=$_SESSION["institucion"];
$ssql="SELECT * FROM instituciones order by instituciones_cod_institucion";
$rss=mysql_query($ssql,$conn);
?>

<?php
$var=$_POST['cod_dep'];
$sel_inst1=$var[0];
if(isset($_POST['modificar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="institucioneditar.php?sel_inst=<?php echo encryto($var[0]);?>"
			</script>
		<?php
}

if(isset($_POST['eliminar']))
{
$var2=$_POST['cod_dep'];
$elementos = count($var2);
for($i=0; $i< $elementos; $i++)
{ 
mysql_query("DELETE FROM instituciones WHERE instituciones_cod_institucion='$var2[$i]'",$conn) or die("El Registro no Existe");
}
		?>
			<script language='JavaScript'> 
				window.self.location="institucion.php"
			</script>
		<?php
}
?>
<?php
if(isset($_POST['adicionar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="institucionnuevo.php"
			</script>
		<?php
}
?>

<center>
<table align="center" WIDTH="965" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="parrafo_general">
  <tr>
    <td HEIGHT="10" COLSPAN="3">
	<B><SPAN class="fuente_normal"><CENTER>ADMINISTRACION DE INSTITUCIONES
	</CENTER><BR></B>
    </td> 
  </tr>
  
  <tr>
    <td HEIGHT="10" COLSPAN="3" bgcolor="#FF9900" align="center">
	<P class="parrafo_titulo"><SPAN class="fuente_subtitulo"><B>LISTA DE INSTITUCIONES</B><BR>
    </td> 
  </tr>

  <tr>

    <TD COLSPAN="3" bgcolor="#d3daed" align="top">

<FORM NAME="lista" METHOD="POST">
<table width="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0">
  <TR>

    <TD WIDTH="10%" bgcolor="#6C6CA7"><SPAN class="fuente_subtitulo"><B><CENTER>C&Oacute;DIGO</CENTER></B></TD>
	<TD WIDTH="30%" bgcolor="#6C6CA7"><SPAN class="fuente_subtitulo"><B><CENTER>DESCRIPCI&Oacute;N</CENTER></B></TD> 
	<TD WIDTH="30%" bgcolor="#6C6CA7"><SPAN class="fuente_subtitulo"><B><CENTER>SIGLA</CENTER></B></TD>
	<TD WIDTH="30%" bgcolor="#6C6CA7"><SPAN class="fuente_subtitulo"><B><CENTER>DOMINIO</CENTER></B></TD>     
	    
  </TR>
</table>

<div style="overflow:auto; width:100%; height:100px; align:left;">

<TABLE WIDTH="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0" >

<?php
$resaltador=0;
if(!empty($rss))
{

while($row = mysql_fetch_array($rss)) 
{
 		  if ($resaltador==0)
			  {
				   echo "<tr class=trdos >";
				   $resaltador=1;
			  }
			  else
			  {
				   echo "<tr class=truno >";
				   $resaltador=0;
			  }
?>

    <TD WIDTH="10%" align="center">
	<INPUT TYPE="checkbox" value="<?php echo $row["instituciones_cod_institucion"];?>" name="cod_dep[]">
	</TD>
	<TD WIDTH="30%">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
<?php echo $row["instituciones_descripcion_inst"];?>
	</TD> 
	<TD WIDTH="30%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
<?php echo $row["instituciones_sigla_inst"];?>
	</TD>
	<TD WIDTH="30%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
<?php echo $row["instituciones_dominio"];?>
	</TD>     
	
  </TR>
<?php
 }  // fin while

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
