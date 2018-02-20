<?php
include("filtro.php");
$titulopagina="EV";
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
//$ssql="SELECT a.*,b.inst_descripcion AS inst_descripcion_depende FROM institucion a INNER JOIN institucion b ON a.inst_codigo_depende = b.Cod_Institucion";
$ssql="SELECT * FROM instituciones";
$rss=mysql_query($ssql,$conn);
?>

<script language="JavaScript">
function BorraValor() {
	document.lista.check_inst.value = '';
}

function CopiaValor(objeto) {
	document.lista.sel_inst.value = objeto.value;
}

function Adicionar_inst(){
	document.lista.action="institucionnuevo.php";
	document.lista.submit();
}
function Eliminar_inst(){
if (document.lista.sel_inst.value!=""){
    if (confirm('Está; Seguro(a) de Eliminar éste Registro?')){
		document.lista.action="institucioneliminar.php";
		document.lista.submit();
		}
	}
}
function Modificar_inst(){
if (document.lista.sel_inst.value!=""){
	document.lista.action="institucioneditar.php";
	document.lista.submit();
	}
}
</script>


<TABLE WIDTH="95%" BORDER="0" CELLSPACING="1" CELLPADDING="0"
HEIGHT="10" class="parrafo_general">
  <TR>
    <TD HEIGHT="10" COLSPAN="3">
	<B><P class="fuente_titulo_principal"><SPAN class="fuente_normal"><CENTER><BR>ADMINISTRACION DE INSTITUCIONES
	</CENTER><BR></B>
    </TD> 
  </TR>
  <TR>
    <TD HEIGHT="10" COLSPAN="3" bgcolor="#eeeeee">
	<P class="parrafo_titulo"><SPAN class="fuente_subtitulo"><B>LISTA DE INSTITUCIONES</B><BR>
    </TD> 
  </TR>
  <TR>
    <TD HEIGHT="10" COLSPAN="3" bgcolor="#eeeeee" align="top">

<FORM NAME="lista" METHOD="POST">
<TABLE WIDTH="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0"
HEIGHT="10" ALIGN="center">
  <TR>
    <TD WIDTH="5%" HEIGHT="10" COLSPAN="1" bgcolor="#eeeeee">
	<CENTER><INPUT class="boton1" NAME="BOTON" TYPE="reset" VALUE="*" onclick="javascript:BorraValor();"></CENTER>
    </TD> 
    <TD WIDTH="15%" HEIGHT="10" COLSPAN="1" bgcolor="#eeeeee">
    <SPAN class="fuente_subtitulo"><B><CENTER>Codigo</CENTER></B></TD>
	<TD WIDTH="20%" HEIGHT="10" COLSPAN="1" bgcolor="#eeeeee">
    <SPAN class="fuente_subtitulo"><B><CENTER>Sigla</CENTER></B></TD> 
	<TD WIDTH="30%" HEIGHT="10" COLSPAN="1" bgcolor="#eeeeee">
    <SPAN class="fuente_subtitulo"><B><CENTER>Institucion</CENTER></B></TD> 
	<TD WIDTH="30%" HEIGHT="10" COLSPAN="1" bgcolor="#eeeeee">
    <SPAN class="fuente_subtitulo"><B><CENTER>Dependencia</CENTER></B></TD> 

  </TR>
</table>

<div style="overflow:auto; width:98%; height:200px; align:left;">

<TABLE WIDTH="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0"
HEIGHT="10" ALIGN="center">
<?php
if(!empty($rss)){


while($row = mysql_fetch_array($rss)) {
?>
    <TR>
    <TD WIDTH="5%" HEIGHT="10" COLSPAN="1" bgcolor="#EFEBE3">
	<INPUT TYPE="checkbox" value="<?php echo $row["Cod_Institucion"];?>" name="cod_inst[]" onclick="javascript:CopiaValor(this);">
	</TD>
	<TD WIDTH="15%" HEIGHT="10" COLSPAN="1" bgcolor="#EFEBE3">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		&nbsp;&nbsp;&nbsp; <?php echo $row["Cod_Institucion"];?>
	</TD> 
    <TD WIDTH="20%" HEIGHT="10" COLSPAN="1" bgcolor="#EFEBE3">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		&nbsp;&nbsp;&nbsp; <?php echo $row["Sigla_inst"];?>
	</TD>    
	<TD WIDTH="30%" HEIGHT="10" COLSPAN="1" bgcolor="#EFEBE3">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		&nbsp;&nbsp;&nbsp; <?php echo $row["Descripcion_inst"];?>
	</TD>
    <TD WIDTH="30%" HEIGHT="10" COLSPAN="1" bgcolor="#EFEBE3">
	
	<?php
	$var=$row["Dependencia_inst"];
	$resp=mysql_query("select * from instituciones where Cod_Institucion='$var'",$conn);
	if ($insti=mysql_fetch_array($resp)) 
	{
	?>
	
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		&nbsp;&nbsp;&nbsp; <?php echo $insti["Descripcion_inst"];?>
	<?php
	}
	?>
	</TD>

  </TR>
<?php
}  // fin while
mysql_free_result($rss);
} //fin empty
mysql_close($conn);
?>
</TABLE>
</div>
    </TD> 
  </TR>
  <TR>
	<TD align="center" COLSPAN="5">
	<INPUT TYPE="hidden" name="sel_inst">
	<INPUT class="boton" TYPE="submit" NAME="BOTON" VALUE="Adicionar" onClick="Adicionar_inst();" >
	<INPUT class="boton" TYPE="submit" NAME="BOTON" VALUE="Modificar" onclick="Modificar_inst();">
	<INPUT class="boton" TYPE="submit" NAME="BOTON" VALUE="Eliminar" onclick="Eliminar_inst();">
	<INPUT class="boton" TYPE="submit" NAME="BOTON" VALUE="Salir">
	</TD>
</FORM>
  </TR>
</TABLE>




<?php
include("final.php");
?>
