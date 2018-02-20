<link rel="stylesheet" type="text/css" href="script/ventanita.css">
<?php
include("../filtro.php");
//include("inicio.php");
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");
$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
//echo "$cargo_unico";
$fecha_ult = date("Y-m-d");
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
  /*
   if (!isset($_GET['orden']))
	{
	  $orden = "seguimiento_fecha_deriva";
	}
	else
	{
	$orden=$_GET['orden'];
	}
	
$ssql="SELECT * FROM seguimiento WHERE '$cargo_unico'=seguimiento_destinatario AND (seguimiento_tipo='A' OR seguimiento_tipo='R') AND seguimiento_estado='P' AND seguimiento_fecha_plazo ='$fecha_ult' AND seguimiento_cod_institucion='$cod_institucion' ORDER BY ".$orden." DESC";
$rss=mysql_query($ssql,$conn);
*/
?>
<STYLE type="text/css"> 
    A:link {text-decoration:none;color:#FFFFFF;} 
    A:visited {text-decoration:none;color:#CEDCEA;} 
    A:active {text-decoration:none;color:#FFFFFF;} 
    A:hover {text-decoration:underline;color:#DDE5EE;} 
</STYLE>
<script language="JavaScript">
function CopiaValor(objeto) {
	document.recepcion.sel_derivar.value = objeto.value;
}
function Retornar(){
	document.recepcion.action="principal.php";
	document.recepcion.submit();
	
}

</script>
<center>
<!--
<table width="90%" border="0">
	<tr bgcolor="#666666">
    	<td style="font-size: 11px; color:#FFFFFF"><strong>BANDEJA DE PENDIENTES&nbsp;&nbsp;&nbsp; HR :</strong> 
		<input type="text" id="entrada" size="12" />
        <a href="busq_recepcion_hoy.php" id="limp_ent" class="botonvent" style="background-color: black;" target="_self">Buscar</a>
		</td>
	</tr>
</table>-->

<table cellspacing="2" cellpadding="2" border="1" style="font-size:8pt;" width="90%" bordercolor="#FFFFFF">
	<tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#3E6BA3">
		<td align="center"></td>
		<td align="center">Doc. Adjuntos</td>
		<td align="center">Hoja de Ruta</td>
		<td align="center">Fecha de Derivacion</td>
		<td align="center">Referencia</td>
		<td align="center">Remitente</td>
		<td align="center"></td>
	</tr>
	<?
	
  if (($_SESSION["cargo"] == "Ventanilla") or  ($_SESSION["cargo"]=="Secretaria"))
  { /*genera la tabla de la secretaria y su menu*/
  	
	//echo "bandeja de la secretaria";
	$s_dep_s="select cargos_dependencia from cargos where cargos_id='$cargo_unico'";
	$r_dep_s = mysql_query($s_dep_s, $conn);
	$row_dep=mysql_fetch_array($r_dep_s);
	$cod_dep=$row_dep[0];
	
	$sql_ent2 = "SELECT * FROM registrodoc1 WHERE '$cargo_unico'=registrodoc1_para and registrodoc_situacion='P'";
	$rs_ent2 = mysql_query($sql_ent2, $conn);
	$resaltador=0;
	while ($row_ent2 = mysql_fetch_array($rs_ent2)) 
	{  
		$doc_arch=cifrar($row_ent2['registrodoc1_hoja_ruta']);
		
		$sql_usu2="SELECT * FROM usuario WHERE usuario_ocupacion='$row_ent2[registrodoc1_de]'";
		$rs_usu2= mysql_query($sql_usu2, $conn);
		$nom_usu2=mysql_fetch_array($rs_usu2);
		
		if ($resaltador==0)
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //<tr style=margin: 4px; border: 0px solid #cccccc; background-color:#BCC9E0; padding: 10px; font-size: 11px; color: #254D78; >
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //echo "<tr class=trdos2>";
		   $resaltador=0;
		  }
	?>	
	<!--<tr style="font-size: 8pt;">	-->	
		<td align="center"><?php if($row_ent2['registrodoc1_prioridad']=='A') echo'<img src="images/alta.gif"/>';
								 if($row_ent2['registrodoc1_prioridad']=='M') echo'<img src="images/media.gif"/>';
								 if($row_ent2['registrodoc1_prioridad']=='B') echo'<img src="images/baja.gif"/>';	
		?></td>
		
		<td align="center" >

		<a href="ver_doc_adjuntos.php?hr1=<?php echo $doc_arch;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true" target="_top">
<img src="images/arch_adj.png" border="0" onMouseOver="this.src='images/arch_adj1.png'" onMouseOut="this.src='images/arch_adj.png'"></a>

		</td>		
		<td align="center"><?php echo $row_ent2['registrodoc1_hoja_ruta'];?></td>
		<td align="center"><?php echo $row_ent2['registrodoc1_fecha_elaboracion'];?></td>
		<td align="center"><? echo $row_ent2['registrodoc1_referencia'];?></td>
		<td align="center"><? echo $nom_usu2[2];?></td>
		<td align="center">
		<? 
		if($row_ent2['registrodoc1_estado']=='R'){
		?>
			<table width="0" border="0" cellpadding="1">
			    <tr align="center"><td><a href="for_nuevo_doc2.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Responder</a></td></tr>
				<tr align="center"><td><a href="observadodoc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Observado</a></td></tr>
				<tr align="center"><td><a href="archivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Archivar .</a></td></tr>
			</table>
		<!--
		<a href="for_nuevo_doc2.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Responder</a><br/>
		<a href="observadodoc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Observado</a><br/>		
		<a href="archivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Archivar .</a>
		-->	
		<?
		}
		else
		{
		?>
		<!--<a href="recepcionar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Recepcionar</a>	-->
		<?
		}
		?>
		</td>
	</tr>
	
	<?php
	}
	
	//$sql_derv1 = "SELECT * FROM derivardoc WHERE '$cargo_unico'=derivardoc_para and derivardoc_situacion='R' and derivardoc_realizado='H' and derivardoc_estado='P'";
	$sql_derv1 = "SELECT * FROM derivardoc WHERE '$cargo_unico'=derivardoc_para and derivardoc_situacion='R' and derivardoc_estado='P'";
	
	$rs_derv1 = mysql_query($sql_derv1, $conn);
	$resaltador=0;
	while ($row_derv1 = mysql_fetch_array($rs_derv1)) 
	{ 

		$doc_arch=cifrar($row_derv1['derivardoc_hoja_ruta']);
				
		$sql_usu1="SELECT * FROM usuario WHERE usuario_ocupacion='$row_derv1[derivardoc_de]'";
		$rs_usu1= mysql_query($sql_usu1, $conn);
		$nom_usu1=mysql_fetch_array($rs_usu1);
			
		$sql_ent11 = "SELECT * FROM registrodoc1 WHERE '$row_derv1[derivardoc_hoja_ruta]'=registrodoc1_hoja_ruta";
		$rs_ent11 = mysql_query($sql_ent11, $conn);
		$row_ent11 = mysql_fetch_array($rs_ent11);
		if ($resaltador==0)
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //<tr style=margin: 4px; border: 0px solid #cccccc; background-color:#BCC9E0; padding: 10px; font-size: 11px; color: #254D78; >
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //echo "<tr class=trdos2>";
		   $resaltador=0;
		  }
		
		?>	
	<!--<tr style="font-size: 8pt;">	-->	
		<td align="center"><?php if($row_derv1['derivardoc_prioridad']=='A') echo'<img src="images/alta.gif"/>';
								 if($row_derv1['derivardoc_prioridad']=='M') echo'<img src="images/media.gif"/>';
								 if($row_derv1['derivardoc_prioridad']=='B') echo'<img src="images/baja.gif"/>';	
		?></td>
		<td align="center" >
								<a href="ver_doc_adjuntos.php?hr1=<?php echo $doc_arch;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true" target="_top">
<img src="images/arch_adj.png" border="0" onMouseOver="this.src='images/arch_adj1.png'" onMouseOut="this.src='images/arch_adj.png'"></a>

		</td>
		<td align="center"><?php echo $row_derv1['derivardoc_hoja_ruta'];?></td>
		<td align="center"><?php echo $row_derv1['derivardoc_fec_derivacion'];?></td>
		<td align="left"><? echo "<font color=#CC0000>Referencia.-</font> $row_ent11[registrodoc1_referencia]<br /><hr>"; 
							echo "<font color=#CC0000>Proveido.-</font> $row_derv1[derivardoc_proveido]"; ?></td>
		<td align="center"><? echo $nom_usu1[2];?></td>
		<td align="center">
		   <table width="0" border="0" cellpadding="1" align="center">
			  <tr align="center">
				<td><a href="derivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top" onMouseMove="window.status='Hola, no me ves';" onMouseOut="window.status='';">Derivar  .</a></td></tr>
				<tr align="center"><td><a href="for_nuevo_doc2.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Responder</a></td></tr>
				<tr align="center"><td><a href="observadodoc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Observado</a></td></tr>
				<tr align="center"><td><a href="archivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Archivar .</a></td></tr>
			</table>
		<!--
		<a href="derivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top" onMouseMove="window.status='Hola, no me ves';" onMouseOut="window.status='';">Derivar  .</a><br/>
		<a href="for_nuevo_doc2.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Responder</a><br/>
		<a href="observadodoc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Observado</a><br/>		
		<a href="archivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Archivar .</a>
		-->
		</td>
	</tr>
	
	<!--
	<tr bgcolor="#FFCC99">

	</tr>		
	-->
	<? 
	}/*fin de while*/
	
  }/*fin de if*/
  /*************************************************************************************************/
  /***************************TODA LA CORRESPONDENCIA DEL PERSONAL EN LOS ARCHIVOS REGISTRODOC1 Y DERIVARDOC*/
  /************************************************************************************************/
  else
  {
	$sql_ent = "SELECT * FROM registrodoc1 WHERE '$cargo_unico'=registrodoc1_para and registrodoc1_estado='R' and registrodoc1_situacion='P' and registrodoc1_cc='E'";
	$rs_ent = mysql_query($sql_ent, $conn);
	$resaltador=0;
	while ($row_ent = mysql_fetch_array($rs_ent)) 
	{  
		//$hr2=$row_ent['registrodoc_hoja_ruta']; 
		$doc_arch=cifrar($row_ent['registrodoc1_hoja_ruta']);
		
		$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_ent[registrodoc1_de]'";
		$rs_usu= mysql_query($sql_usu, $conn);
		$nom_usu=mysql_fetch_array($rs_usu);
		if ($resaltador==0)
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //<tr style=margin: 4px; border: 0px solid #cccccc; background-color:#BCC9E0; padding: 10px; font-size: 11px; color: #254D78; >
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //echo "<tr class=trdos2>";
		   $resaltador=0;
		  }
	?>	
	<!--<tr style="font-size: 8pt;">	-->	
		<td align="center"><?php if($row_ent['registrodoc1_prioridad']=='A') echo'<img src="images/alta.gif"/>';
								 if($row_ent['registrodoc1_prioridad']=='M') echo'<img src="images/media.gif"/>';
								 if($row_ent['registrodoc1_prioridad']=='B') echo'<img src="images/baja.gif"/>';	
		?></td>
		<td align="center" >
		<a href="ver_doc_adjuntos.php?hr1=<?php echo $doc_arch;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true" target="_top">
<img src="images/arch_adj.png" border="0" onMouseOver="this.src='images/arch_adj1.png'" onMouseOut="this.src='images/arch_adj.png'"></a>

		
		</td>
		<td align="center"><?php echo $row_ent['registrodoc1_hoja_ruta'];?></td>
		<td align="center"><?php echo $row_ent['registrodoc1_fecha_elaboracion'];?></td>
		<td align="center"><? echo $row_ent['registrodoc1_referencia'];?></td>
		<td align="center"><? echo $nom_usu[2];?></td>
		<td align="center">
			<table width="0" border="0" cellpadding="1" align="center">
			  <tr align="center">
				<td><a href="derivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top" onMouseMove="window.status='Hola, no me ves';" onMouseOut="window.status='';">Derivar  .</a></td></tr>
				<tr align="center"><td><a href="for_nuevo_doc2.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Responder</a></td></tr>
				<tr align="center"><td><a href="observadodoc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Observado</a></td></tr>
				<tr align="center"><td>		
				<? 
				if($row_ent['registrodoc1_situacion']!='A')
				{?>
				<a href="archivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Archivar .</a>
				<? }?>
				</td>
			  </tr>
			</table>
		<!--	
		<a href="derivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top" onMouseMove="window.status='Hola, no me ves';" onMouseOut="window.status='';">Derivar  .</a><br/>
		<a href="for_nuevo_doc2.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Responder</a><br/>
		<a href="observadodoc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Observado</a><br/>
		<? 
		if($row_ent['registrodoc1_situacion']!='A')
		{?>
		<a href="archivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Archivar .</a>
		<? }?>
		-->
		</td>
	</tr>
	<!--
	<tr bgcolor="#FFCC99">
	</tr>-->		

	<? 
	}/*fin de while registrodoc*/
	
	$sql_derv1 = "SELECT * FROM derivardoc WHERE '$cargo_unico'=derivardoc_para and derivardoc_situacion='R' and derivardoc_realizado='H' and derivardoc_estado='P'";
	$rs_derv1 = mysql_query($sql_derv1, $conn);
	$resaltador=0;
	while ($row_derv1 = mysql_fetch_array($rs_derv1)) 
	{ 

		$doc_arch=cifrar($row_derv1['derivardoc_hoja_ruta']);
				
		$sql_usu1="SELECT * FROM usuario WHERE usuario_ocupacion='$row_derv1[derivardoc_de]'";
		$rs_usu1= mysql_query($sql_usu1, $conn);
		$nom_usu1=mysql_fetch_array($rs_usu1);
			
		$sql_ent11 = "SELECT * FROM registrodoc1 WHERE '$row_derv1[derivardoc_hoja_ruta]'=registrodoc1_hoja_ruta";
		$rs_ent11 = mysql_query($sql_ent11, $conn);
		$row_ent11 = mysql_fetch_array($rs_ent11);
		if ($resaltador==0)
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //<tr style=margin: 4px; border: 0px solid #cccccc; background-color:#BCC9E0; padding: 10px; font-size: 11px; color: #254D78; >
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //echo "<tr class=trdos2>";
		   $resaltador=0;
		  }
		
		?>	
	<!--<tr style="font-size: 8pt;">	-->	
		<td align="center"><?php if($row_derv1['derivardoc_prioridad']=='A') echo'<img src="images/alta.gif"/>';
								 if($row_derv1['derivardoc_prioridad']=='M') echo'<img src="images/media.gif"/>';
								 if($row_derv1['derivardoc_prioridad']=='B') echo'<img src="images/baja.gif"/>';	
		?></td>
		<td align="center" >
								<a href="ver_doc_adjuntos.php?hr1=<?php echo $doc_arch;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true" target="_top">
<img src="images/arch_adj.png" border="0" onMouseOver="this.src='images/arch_adj1.png'" onMouseOut="this.src='images/arch_adj.png'"></a>

		</td>
		<td align="center"><?php echo $row_derv1['derivardoc_hoja_ruta'];?></td>
		<td align="center"><?php echo $row_derv1['derivardoc_fec_derivacion'];?></td>
		<td align="left"><? echo "<font color=#CC0000>Referencia.-</font> $row_ent11[registrodoc1_referencia]<br /><hr>"; 
							echo "<font color=#CC0000>Proveido.-</font> $row_derv1[derivardoc_proveido]"; ?></td>
		<td align="center"><? echo $nom_usu1[2];?></td>
		<td align="center">
			<table width="0" border="0" cellpadding="1">
			  <tr align="center">
				<td><a href="derivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top" onMouseMove="window.status='softcom';" onMouseOut="window.status='';">Derivar  .</a></td></tr>
				<tr align="center"><td><a href="for_nuevo_doc2.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Responder</a></td></tr>
				<tr align="center"><td><a href="observadodoc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Observado</a></td></tr>
				<tr align="center"><td><a href="archivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Archivar .</a></td>
			  </tr>
			</table>
<!--
		<a href="derivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top" onMouseMove="window.status='softcom';" onMouseOut="window.status='';">Derivar  .</a><br/>
		<a href="for_nuevo_doc2.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Responder</a><br/>
		<a href="observadodoc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Observado</a><br/>		
		<a href="archivar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Archivar .</a>
		-->
		</td>
	</tr>
	<!--
	<tr bgcolor="#FFCC99">
	</tr>-->		

	<? 
	
	}/*fin de while de derivardoc*/
	
	}/*fin de else*/
	?>

</table>
</center>

