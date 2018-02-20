<?php
include("../filtro.php");
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");

$cod_institucion=$_SESSION["institucion"];
$codigo_usuario=$_SESSION["codigo"];
$codigo=$_SESSION["cargo_asignado"];
$depto=$_SESSION["departamento"];
$fecha_hoy = date("Y-m-d");
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

$t_doc="";
$n_cit="";

if($_POST["t_doc"])
{
	$t_doc=$_POST["t_doc"];
}else{
	if($_GET["t_doc"])
	{
		$t_doc=$_GET["t_doc"];
	}
	//**
//	$tdoc = "_";
	//**
}
if($_POST["n_cit"])
{
	$n_cit=$_POST["n_cit"];
}else{
	if($_GET["n_cit"])
	{
		$n_cit=$_GET["n_cit"];
	}
}

?>
<script type="text/javascript" src="jquery/jquery.js"></script>
<script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
});
</script>
<style type="text/css">
.botonExcel{cursor:pointer;}
</style>

<br>
<p class="fuente_titulo">
<center><b style=" font-size:18px">LISTADO DE CITES</b></center></p>
<center>
<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
<p>Exportar a Excel  <img src="images/icono_excel.jpg" class="botonExcel" /></p>
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>

<form name="formfiltro" action="librocites.php" method="POST">
	Nro de cite: <input type="text" name="n_cit" value="<?php echo $n_cit; ?>" size=5>
    &nbsp; &nbsp;
	Tipo de Documento: <select name="t_doc" style="width:150px">
    <option value="<?php echo $t_doc; ?>"><?php echo $t_doc; ?></option>
    <?php
		$respss=mysql_query("select documentocargo_doc, documentos_descripcion, documentos_sigla 
								from documentocargo, documentos 
								where documentocargo_doc=documentos_id 
								group by documentos_descripcion
								order by documentos_descripcion",$conn);
		while($rowass=mysql_fetch_array($respss))
		{
				echo " <option value='".$rowass['documentos_descripcion']."'>"; 
				echo $rowass["documentos_descripcion"];
				echo "</option>";
		}
	?>
      </select>
    <input type="submit" value="Buscar" class="boton">
    &nbsp; &nbsp;  
      
    <input type="button"  value="Ver Todo" class="boton" onClick="window.location='librocites.php'">
</form>
<!--  style="font-size:9px; color:blue;"-->
</center>

<table width="90%" cellspacing="1" cellpadding="1" border="0" align="center" id="Exportar_a_Excel">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
	<td width="25%" align="center"><span >No Cite</td>
	<td width="25%" align="center"><span >Fecha Elaboracion</td>
	<td width="25%" align="center"><span >Elaborado por</td>
	<td width="25%" align="center"><span >Tipo Doc</td>
	
</tr>
<!--<meta content="5;URL=listado_de_mi2.php" http-equiv="REFRESH">-->
<?php
echo "<form name='miform'>";
$slista="select registrodoc1_id, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_de, documentos_descripcion,
				usuario_nombre
				from registrodoc1, documentos, usuario
				where registrodoc1_depto = '$depto'
				and registrodoc1_de=usuario_ocupacion
				and registrodoc1_doc=documentos_sigla 
				and registrodoc1_tipo = 'INTERNO' ";

if($t_doc!=""){
$slista = $slista. "and documentos_descripcion like '%$t_doc%' ";
}
if($n_cit!=""){
$slista = $slista. "and registrodoc1_cite like '%/$n_cit/%' ";
}
$slista = $slista. "group by registrodoc1_cite ORDER BY registrodoc1_fecha_elaboracion DESC ";

$rslista=mysql_query($slista,$conn);

$resaltador=0;
$indice=1;
 while($rwlista=mysql_fetch_array($rslista))
 {
	 $doc_arch=cifrar($rwlista["registrodoc1_hoja_ruta"]);
	 $doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
		
	 $doc_rem = $rwlista["registrodoc1_de"];
     if ($resaltador==0)
	  {
       echo "<tr class=truno>";
	   $resaltador=1;
      }
	  else
	  {
       echo "<tr class=trdos>";
   	   $resaltador=0;
	  } 
?>
    
    <td align="center"><?php echo $rwlista["registrodoc1_cite"];?>
    </td>
    
    <td align="center"><?php echo $rwlista["registrodoc1_fecha_elaboracion"];?>
    </td>

    <td align="center"><?php echo $rwlista["usuario_nombre"];?></td>
    
    </td>
    
    
    <td align="center"><?php echo $rwlista["documentos_descripcion"];?></td>
    
    </tr>
    <?php
}
	?>
</form>
</table>
</center>
</meta>
<?php
include("final.php");
?>
