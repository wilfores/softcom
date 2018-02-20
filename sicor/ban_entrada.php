<link rel="stylesheet" type="text/css" href="script/ventanita.css">
<?php
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");

$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
//echo "$cargo_unico";
$sw=0;
$gestion=$_SESSION["gestion"];
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

	if (!isset($_GET['orden']))
	{
            $orden = "seguimiento_fecha_deriva";
	}
	else
	{
            $orden=$_GET['orden'];
	}
        
$ssql="SELECT * FROM seguimiento
       WHERE '$cargo_unico'= seguimiento_destinatario
       AND (seguimiento_tipo='A' OR seguimiento_tipo='R')
       AND seguimiento_estado='P' ORDER BY ".$orden." DESC";
$rss=mysql_query($ssql,$conn);


?>

<STYLE type="text/css"> 
    A:link {text-decoration:none;color:#FFFFFF;} 
    A:visited {text-decoration:none;color:#CEDCEA;} 
    A:active {text-decoration:none;color:#FFFFFF;} 
    A:hover {text-decoration:underline;color:#DDE5EE;} 
</STYLE>

<style>
c { white-space: pre; }
</style> 

<script language="JavaScript">
function CopiaValor(objeto) {
	document.recepcion.sel_derivar.value = objeto.value;
}

function Retornar()
{
	document.recepcion.action="principal.php";
	document.recepcion.submit();
}
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=450,height=300");
}
</script>

<center>
<table cellspacing="2" cellpadding="2" border="1" style="font-size:8pt;" width="90%" bordercolor="#FFFFFF">
	<tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#3E6BA3">
		<!--<td align="center"></td>-->
		<td align="center">Prioridad</td>
		<td align="center">Hoja de Ruta</td>
		<td align="center">Fecha de Recepcion</td>
		<td align="center">Referencia</td>
		<td align="center">Remitente</td>
		<td align="center"></td>
	</tr>
	<?
	
  if (($_SESSION["cargo"] == "Ventanilla") or  ($_SESSION["cargo"]=="Secretaria"))
  { $s_dep_s="select cargos_dependencia from cargos where cargos_id='$cargo_unico'";
	$r_dep_s = mysql_query($s_dep_s, $conn);
	$row_dep=mysql_fetch_array($r_dep_s);
	$cod_dep=$row_dep[0];
	
	$sql_ent = "SELECT * FROM registrodoc1 WHERE '$cod_dep'=registrodoc1_para and registrodoc1_estado='SR' and registrodoc1_situacion='P' and registrodoc1_cc='E' and registrodoc1_asociar<>'si' ORDER BY registrodoc1_fecha_recepcion DESC";
	$rs_ent = mysql_query($sql_ent, $conn);
	 $resaltador=0;
	while ($row_ent = mysql_fetch_array($rs_ent)) 
	{  
		$doc_arch=cifrar($row_ent['registrodoc1_hoja_ruta']);
		
		$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_ent[registrodoc1_de]'";
		$rs_usu= mysql_query($sql_usu, $conn);
		$nom_usu=mysql_fetch_array($rs_usu);
		
		if ($resaltador==0)
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php

		   $resaltador=0;
		  }
	?>	

		<td align="center"><?php if($row_ent['registrodoc1_prioridad']=='A') echo'<img src="images/alta.gif"/>';
								 if($row_ent['registrodoc1_prioridad']=='M') echo'<img src="images/media.gif"/>';
								 if($row_ent['registrodoc1_prioridad']=='B') echo'<img src="images/baja.gif"/>';	
		?></td>
		<td align="center"><?php echo $row_ent['registrodoc1_hoja_ruta'];?></td>
		<td align="center"><?php echo $row_ent['registrodoc1_fecha_elaboracion'];?></td>
		<td align="center"><? echo $row_ent['registrodoc1_referencia'];?></td>
		<td align="center"><? echo $nom_usu[2];?></td>
		<td colspan="4" align="center">		
		<a href="recepcionar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Recepcionar</a>
		</td>		
	</tr>
	

	<? 
	}
	
	$sql_ent2 = "SELECT * FROM registrodoc1 WHERE '$cargo_unico'=registrodoc1_para and registrodoc1_situacion='P'and registrodoc1_cc='E' and registrodoc1_asociar<>'si' ORDER BY registrodoc1_fecha_recepcion DESC";
	$rs_ent2 = mysql_query($sql_ent2, $conn);
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
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   $resaltador=0;
		  }	
	?>	

		<td align="center"><?php if($row_ent2['registrodoc1_prioridad']=='A') echo'<img src="images/alta.gif"/>';
								 if($row_ent2['registrodoc1_prioridad']=='M') echo'<img src="images/media.gif"/>';
								 if($row_ent2['registrodoc1_prioridad']=='B') echo'<img src="images/baja.gif"/>';	
		?></td>
		<td align="center"><?php echo $row_ent2['registrodoc1_hoja_ruta'];?></td>
		<td align="center"><?php echo $row_ent['registrodoc1_fecha_elaboracion'];?></td>
		<td align="center"><? echo $row_ent2['registrodoc1_referencia'];?></td>
		<td align="center"><? echo $nom_usu2[2];?></td>
		<td colspan="4" align="center">
		<? 
		if($row_ent2['registrodoc1_estado']=='R'){
		?>
		<?
		}
		else
		{
		?>
		<a href="recepcionar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Recepcionar</a>	
		<?
		}
		?>
		</td>		
	</tr>

	<? 
	}
	
	$sql_derv = "SELECT * FROM derivardoc WHERE '$cargo_unico'=derivardoc_para and derivardoc_situacion='SR'";
	$rs_derv = mysql_query($sql_derv, $conn);
	while ($row_derv = mysql_fetch_array($rs_derv)) 
	{ 
		
		$doc_arch=cifrar($row_derv['derivardoc_hoja_ruta']);
				
		$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_derv[derivardoc_de]'";
		$rs_usu= mysql_query($sql_usu, $conn);
		$nom_usu=mysql_fetch_array($rs_usu);
			
		$sql_ent1 = "SELECT * FROM registrodoc1 WHERE '$row_derv[derivardoc_hoja_ruta]'=registrodoc1_hoja_ruta";
		$rs_ent1 = mysql_query($sql_ent1, $conn);
		$row_ent1 = mysql_fetch_array($rs_ent1);
		
		if ($resaltador==0)
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   $resaltador=0;
		  }		
		?>	
		<td align="center"><?php if($row_derv['derivardoc_prioridad']=='A') echo'<img src="images/alta.gif"/>';
								 if($row_derv['derivardoc_prioridad']=='M') echo'<img src="images/media.gif"/>';
								 if($row_derv['derivardoc_prioridad']=='B') echo'<img src="images/baja.gif"/>';	
		?></td>
		<td align="center"><?php echo $row_derv['derivardoc_hoja_ruta'];?></td>
		<td align="center"><?php echo $row_derv['derivardoc_fec_derivacion'];?></td>
		<td align="center"><? echo $row_derv['derivardoc_proveido'];?></td>
		<td align="center"><? echo $nom_usu[2];?></td>
		<td align="center">
		<a href="recepcionar_doc_derivado.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top" onMouseMove="window.status='Hola, no me ves';" onMouseOut="window.status='';">Recepcionar</a>
		</td>
	</tr>
	<? 
	
	}
	
  }
  else
  {
  
	$sql_ent = "SELECT * FROM registrodoc1 WHERE '$cargo_unico'=registrodoc1_para and registrodoc1_estado='SR' and registrodoc1_situacion='P' and registrodoc1_cc='E' and registrodoc1_asociar<>'si' ORDER BY registrodoc1_fecha_recepcion DESC";
	$rs_ent = mysql_query($sql_ent, $conn);
	while ($row_ent = mysql_fetch_array($rs_ent)) 
	{  
		$doc_arch=cifrar($row_ent['registrodoc1_hoja_ruta']);
		
		$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_ent[registrodoc1_de]'";
		$rs_usu= mysql_query($sql_usu, $conn);
		$nom_usu=mysql_fetch_array($rs_usu);
		
		if ($resaltador==0)
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   $resaltador=0;
		  }
	?>	

		<td align="center"><?php if($row_ent['registrodoc1_prioridad']=='A') echo'<img src="images/alta.gif"/>';
								 if($row_ent['registrodoc1_prioridad']=='M') echo'<img src="images/media.gif"/>';
								 if($row_ent['registrodoc1_prioridad']=='B') echo'<img src="images/baja.gif"/>';	
		?></td>
		<td align="center"><?php echo $row_ent['registrodoc1_hoja_ruta'];?></td>
		<td align="center"><?php echo $row_ent['registrodoc1_fecha_elaboracion'];?></td>
		<td align="center"><? echo $row_ent['registrodoc1_referencia'];?></td>
		<td align="center"><? echo $nom_usu[2];?></td>
		<td align="center">
		<a href="recepcionar_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Recepcionar</a>
		</td>
	</tr>
	
	<? 
	}
	
	$sql_derv = "SELECT * FROM derivardoc WHERE '$cargo_unico'=derivardoc_para and derivardoc_situacion='SR'";
	$rs_derv = mysql_query($sql_derv, $conn);
	while ($row_derv = mysql_fetch_array($rs_derv)) 
	{ 
		
		$doc_arch=cifrar($row_derv['derivardoc_hoja_ruta']);
				
		$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_derv[derivardoc_de]'";
		$rs_usu= mysql_query($sql_usu, $conn);
		$nom_usu=mysql_fetch_array($rs_usu);
			
		$sql_ent1 = "SELECT * FROM registrodoc1 WHERE '$row_derv[derivardoc_hoja_ruta]'=registrodoc1_hoja_ruta";
		$rs_ent1 = mysql_query($sql_ent1, $conn);
		$row_ent1 = mysql_fetch_array($rs_ent1);
		
		if ($resaltador==0)
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   $resaltador=0;
		  }		
		?>	
		<td align="center"><?php if($row_derv['derivardoc_prioridad']=='A') echo'<img src="images/alta.gif"/>';
								 if($row_derv['derivardoc_prioridad']=='M') echo'<img src="images/media.gif"/>';
								 if($row_derv['derivardoc_prioridad']=='B') echo'<img src="images/baja.gif"/>';	
		?></td>
		<td align="center"><?php echo $row_derv['derivardoc_hoja_ruta'];?></td>
		<td align="center"><?php echo $row_derv['derivardoc_fec_derivacion'];?></td>
		<td align="center"><? echo $row_ent1['registrodoc1_referencia'];?></td>
		<td align="center"><? echo $nom_usu[2];?></td>
		<td align="center">
		<a href="recepcionar_doc_derivado.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top" onMouseMove="window.status='Hola, no me ves';" onMouseOut="window.status='';">Recepcionar</a>
		</td>
	</tr>

	<? 
	
	}
	
	}/*fin de else*/
	?>

</table>
</center>
