<?php include("../filtro.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Imprime Hoja de Ruta</title>
<link rel="stylesheet" type="text/css" href="../script/estilos2.css">
<script language="JavaScript">
 function imprimir() {
    window.print()
 }
</script>
<style type="text/css">
<!--
.Estilo1 {font-family: Arial}
.Estilo4 {font-family: "Times New Roman", Times, serif; font-size: 10px; }
.Estilo5 {font-family: "Times New Roman", Times, serif}
.Estilo9 {font-family: "Times New Roman", Times, serif; font-weight: bold; }
-->
</style>
</head>
<body onLoad="imprimir();">
<?php
include("script/cifrar.php");
include("../conecta.php");
include("script/functions.inc");
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
$nro_registro=descryto($imprimeh);


//logo institucional
$institucion = $_SESSION["institucion"];
$ssqli = "SELECT * FROM instituciones WHERE '$institucion'=Cod_Institucion";
$rssi = mysql_query($ssqli, $conn);
$rowi = mysql_fetch_array($rssi);


//logo y cabecera
$logo = $rowi["logo"];
$cabecera = $rowi["membrete"];

$sql = "SELECT * FROM departamento WHERE '$unidad_destino'=Cod_Departamento";
$res = mysql_query($sql,$conn);
$filas = mysql_fetch_array($res);
$unidad_destino = $filas["Descripcion_dep"];

$ssql = "SELECT * FROM ingreso WHERE '$nro_registro'=nro_registro";
$rss = mysql_query($ssql,$conn);
$row=mysql_fetch_array($rss);

if ($row["hoja_ruta_tipo"] == "e") {
  $tipo = "EXTERNA";
} else {
  $tipo = "INTERNA";
}
?>

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="50%">

    
</td>
<td width="50%" valign="middle" align="right">
<table width="100%">
 <tr class="border_tr">
    <td colspan="3" valign="top">
	<table width="100%">
         <tr>
		 <td width="50%" class="border_table_imp"><span class="fuente_normal">Cuarto Destinatario:</span></td>
   	     <td width="50%" class="border_table_imp"><span class="fuente_normal">Fecha:</span></td>
		 </tr>
	     <tr>
		 <td width="50%" class="border_table_imp"><span class="fuente_normal">Nombre:</span></td>
   	     <td width="50%" class="border_table_imp"><span class="fuente_normal">Cargo:</span></td>
		 </tr>
	</table>	</td>
  </tr>
  <tr class="border_tr">
    <td colspan="3" valign="top" class="border_tr"><span class="fuente_normal"><b>Instrucci&oacute;n: </b></span></td>
    </tr>
	<tr>
    <td colspan="3" valign="top" >
	  <table width="100%">
	  		<tr>
	
				<td width="45%" align="left"><span class="fuente_normal">Informe</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Para su Conocimiento</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Investigar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Citar a Reunión</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Efectue Seguimiento</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Coordinar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Responder</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Reuni&oacute;n en mi despacho</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Circularizar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Archivar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Proceder seg&uacute;n lo establecido</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Prepare respuesta para mi Firma</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Elaborar Resoluci&oacute;n y/o Documentos</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Acudir en mi Representaci&oacute;n</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			
			
			<tr>
				<td width="100%" colspan="4" class="border_tr"><span class="fuente_normal">Otros (Describir)</b></span></td>
			</tr>
			
			<tr>
				<td  width="100%" colspan="4" class="border_table_imp" align="center">                  
				<br>
					<hr width="95%">			
					<hr width="95%">

					<br>
					<hr width="20%" >			
					Firma			</td>
	     	</tr>
	  </table>
	</td>
    </tr>
	 <tr class="border_tr">
    <td colspan="3" valign="top">
	<table width="100%">
         <tr>
		 <td width="50%" class="border_table_imp"><span class="fuente_normal">Quinto Destinatario:</span></td>
   	     <td width="50%" class="border_table_imp"><span class="fuente_normal">Fecha:</span></td>
		 </tr>
	     <tr>
		 <td width="50%" class="border_table_imp"><span class="fuente_normal">Nombre:</span></td>
   	     <td width="50%" class="border_table_imp"><span class="fuente_normal">Cargo:</span></td>
		 </tr>
	</table>	</td>
  </tr>
  <tr class="border_tr">
    <td colspan="3" valign="top" class="border_tr"><span class="fuente_normal"><b>Instrucci&oacute;n: </b></span></td>
    </tr>
	<tr>
    <td colspan="3" valign="top" >
	  <table width="100%">
	  		<tr>
	
				<td width="45%" align="left"><span class="fuente_normal">Informe</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Para su Conocimiento</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Investigar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Citar a Reunión</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Efectue Seguimiento</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Coordinar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Responder</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Reuni&oacute;n en mi despacho</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Circularizar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Archivar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Proceder seg&uacute;n lo establecido</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Prepare respuesta para mi Firma</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Elaborar Resoluci&oacute;n y/o Documentos</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Acudir en mi Representaci&oacute;n</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			
			
			<tr>
				<td width="100%" colspan="4" class="border_tr"><span class="fuente_normal">Otros (Describir)</b></span></td>
			</tr>
			
			<tr>
				<td  width="100%" colspan="4" class="border_table_imp" align="center">                  
				<br>
					<hr width="95%">			
					<hr width="95%">

					<br>
					<hr width="20%" >			
					Firma			</td>
	     	</tr>
	  </table>
	</td>
    </tr>
 <tr class="border_tr">
    <td colspan="3" valign="top">
	<table width="100%">
         <tr>
		 <td width="50%" class="border_table_imp"><span class="fuente_normal">Sexto Destinatario:</span></td>
   	     <td width="50%" class="border_table_imp"><span class="fuente_normal">Fecha:</span></td>
		 </tr>
	     <tr>
		 <td width="50%" class="border_table_imp"><span class="fuente_normal">Nombre:</span></td>
   	     <td width="50%" class="border_table_imp"><span class="fuente_normal">Cargo:</span></td>
		 </tr>
	</table>	</td>
  </tr>
  <tr class="border_tr">
    <td colspan="3" valign="top" class="border_tr"><span class="fuente_normal"><b>Instrucci&oacute;n: </b></span></td>
    </tr>
	<tr>
    <td colspan="3" valign="top" >
	  <table width="100%">
	  		<tr>
	
				<td width="45%" align="left"><span class="fuente_normal">Informe</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Para su Conocimiento</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Investigar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Citar a Reunión</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Efectue Seguimiento</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Coordinar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Responder</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Reuni&oacute;n en mi despacho</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Circularizar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Archivar</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Proceder seg&uacute;n lo establecido</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Prepare respuesta para mi Firma</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			<tr>
				<td width="45%" align="left"><span class="fuente_normal">Elaborar Resoluci&oacute;n y/o Documentos</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
	    		<td width="45%" align="left"><span class="fuente_normal">Acudir en mi Representaci&oacute;n</span></td>
				<td width="5%" class="border_table_imp">&nbsp;</td>
			</tr>
			
			
			<tr>
				<td width="100%" colspan="4" class="border_tr"><span class="fuente_normal">Otros (Describir)</b></span></td>
			</tr>
			
			<tr>
				<td  width="100%" colspan="4" class="border_table_imp" align="center">                  
				<br>
					<hr width="95%">			
					<hr width="95%">

					<br>
					<hr width="20%" >			
					Firma			</td>
	     	</tr>
	  </table>
	</td>
    </tr>


</table>
</td>
</tr>
</table>
</body>
</html>
